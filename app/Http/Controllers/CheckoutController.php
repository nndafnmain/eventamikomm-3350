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
        $event->decrement('stock');

        // 5. Arahkan ke rute dummy halaman sukses sementara
        // (Akan kita ubah di pertemuan selanjutnya menuju Midtrans)
        return redirect('/')->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran.');
    }
}