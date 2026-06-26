<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman formulir checkout untuk event tertentu.
     */
    public function create(Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        return view('checkout.create', compact('event', 'categories'));
    }

    /**
     * Memproses pembuatan transaksi baru (Submit Checkout).
     */
    /**
     * Memproses pembuatan transaksi baru (Submit Checkout).
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validasi Input Kredensial Pelanggan
        $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
        ]);

        // 2. Cegah Check-out Jika Tiket Habis
        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        // 3. Generate Kode TRX (Unik)
        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price + 5000; // Menambahkan biaya admin Rp 5.000

        // 4. Merekam Transaksi ke Database
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'Pending', // Status Awal
        ]);

        // Mengurangi stok tiket setelah transaksi berhasil dibuat
        // $event->decrement('stock');
        // --- INTEGRASI SNAP MIDTRANS ---

        // Konfigurasi Kredensial Environment Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // Mode Sandbox!
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        // \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        // \Midtrans\Config::$isProduction = false; // Mode Sandbox!
        // \Midtrans\Config::$isSanitized  = true;
        // \Midtrans\Config::$is3ds        = true;
        \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
        \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = 0;
        \Midtrans\Config::$curlOptions[CURLOPT_HTTPHEADER] = [];

        // Susun Paket Array Data Transaksi
        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ],
        ];

        try {
            // Perintah Tembak Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update rekaman kita bahwa transaksi terkait sudah memiliki id token pelunasan
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman antarmuka pembayaran final pelanggan
            return redirect()->route('checkout.payment', $transaction->order_id);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
                // 5. Arahkan ke rute dummy halaman sukses sementara
                // (Akan kita ubah di pertemuan selanjutnya menuju Midtrans)
                return redirect('/')->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran.');
     }




    public function payment($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();

        // Validasi status pembayaran asli dari Midtrans (Mencegah manipulasi URL)
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;

        try {
            // $midtransStatus = \Midtrans\Transaction::status($order_id);

            // Hanya ubah status menjadi sukses jika Midtrans mengonfirmasi pembayaran lunas
            // if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
            //     $transaction->update(['status' => 'success']);
            // }
            $midtransStatus = \Midtrans\Transaction::status($order_id);

            // Ambil nilai status dengan aman (mengantisipasi balasan berupa Object maupun Array)
            $trx_status = is_array($midtransStatus) ? ($midtransStatus['transaction_status'] ?? '') : ($midtransStatus->transaction_status ?? '');

            // Hanya ubah status menjadi sukses jika Midtrans mengonfirmasi pembayaran lunas
            if (in_array($trx_status, ['capture', 'settlement'])) {
                if ($transaction->status !== 'success') {
                    $transaction->update(['status' => 'success']);
                    $transaction->event->decrement('stock');
                }
            }
        } catch (\Exception $e) {
            // Jika error (transaksi tidak ada di Midtrans, koneksi terputus), kembalikan ke beranda
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }

    /**
     * Menangani callback notifikasi otomatis dari Midtrans.
     */
    public function notification(Request $request)
    {
        // 1. Ambil payload notifikasi
        $payload = $request->all();

        $order_id = $payload['order_id'] ?? null;
        $trx_status = $payload['transaction_status'] ?? null;
        $signature_key = $payload['signature_key'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;

        if (!$order_id) {
            return response()->json(['message' => 'Invalid order ID'], 400);
        }

        // 2. Validasi Signature Key
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $localSignature = hash("sha512", $order_id . $statusCode . $grossAmount . $serverKey);

        if ($localSignature !== $signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        // 3. Cari Transaksi
        $transaction = Transaction::where('order_id', $order_id)->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 4. Update status transaksi berdasarkan status dari Midtrans
        if (in_array($trx_status, ['capture', 'settlement'])) {
            if ($transaction->status !== 'success') {
                $transaction->update(['status' => 'success']);
                $transaction->event->decrement('stock');
            }
        } elseif (in_array($trx_status, ['deny', 'expire', 'cancel'])) {
            $transaction->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed successfully']);
    }
}