<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi (Dashboard Admin).
     */
    public function index()
    {
        // Mengambil transaksi terbaru dengan relasi event dan pagination 20 data per halaman
        $transactions = Transaction::with('event')
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Sinkronisasi status transaksi dari Midtrans API ke database lokal.
     */
    public function sync(Transaction $transaction)
    {
        // Konfigurasi Kredensial Environment Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;
        \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYHOST] = 0;
        \Midtrans\Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = 0;
        \Midtrans\Config::$curlOptions[CURLOPT_HTTPHEADER] = [];

        try {
            // Ambil status transaksi dari API Midtrans
            $midtransStatus = \Midtrans\Transaction::status($transaction->order_id);
            $trx_status = is_array($midtransStatus) ? ($midtransStatus['transaction_status'] ?? '') : ($midtransStatus->transaction_status ?? '');

            // Update status transaksi berdasarkan response status dari Midtrans
            if (in_array($trx_status, ['capture', 'settlement'])) {
                if ($transaction->status !== 'success') {
                    $transaction->update(['status' => 'success']);
                    $transaction->event->decrement('stock');
                }
                return back()->with('success', 'Status transaksi ' . $transaction->order_id . ' berhasil disinkronisasi: BERHASIL (Success / Settlement).');
            } elseif ($trx_status === 'pending') {
                return back()->with('info', 'Status transaksi ' . $transaction->order_id . ' di Midtrans masih PENDING.');
            } elseif (in_array($trx_status, ['deny', 'expire', 'cancel'])) {
                $transaction->update(['status' => 'failed']);
                return back()->with('warning', 'Status transaksi ' . $transaction->order_id . ' berhasil disinkronisasi: GAGAL / EXPIRED.');
            }

            return back()->with('info', 'Status transaksi ' . $transaction->order_id . ' di Midtrans: ' . strtoupper($trx_status));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal sinkronisasi status transaksi dari Midtrans: ' . $e->getMessage());
        }
    }
}