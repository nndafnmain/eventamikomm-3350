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
}