<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\EventController as EventAdminController;

/*
|--------------------------------------------------------------------------
| Public / Customer Routes
|--------------------------------------------------------------------------
*/

// Home & Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Events (Menggunakan Route Parameter dinamis /{event} bukan hardcode /event/1)
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// Checkout Process
Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout/{event}', 'create')->name('checkout.create');
    Route::post('/checkout/{event}', 'store')->name('checkout.store');
});

// Statics / Informational Pages
Route::get('/tentang', function () {
    return '<h1>Ini adalah halaman tentang aplikasi Event Hub</h1>';
});
Route::get('/kontak', function () { return view('contact'); });
Route::get('/profile', function () { return view('profile'); });
Route::get('/katalog', function () { return view('katalog'); });
Route::get('/bantuan', function () { return view('bantuan'); });


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Redirect default Laravel login (jika user tidak terautentikasi) ke login admin
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->name('admin.')->group(function () {
    
    // Admin Authentication
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Protected Dashboard (Harus Lolos Middleware Auth & Admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Event Admin
        Route::resource('events', EventAdminController::class);
        
        // Laporan Transaksi Admin (Sudah dipindahkan ke dalam prefix admin)
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::post('transactions/{transaction}/sync', [TransactionController::class, 'sync'])->name('transactions.sync');
    });
});

Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])
    ->name('checkout.payment');

Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])
    ->name('checkout.success');

Route::post('/midtrans-notification', [CheckoutController::class, 'notification'])->name('midtrans.notification');