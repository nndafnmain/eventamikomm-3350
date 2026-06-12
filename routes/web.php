<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as EventAdminController;

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', EventController::class);
    Route::resource('events', EventAdminController::class);
    // Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});

// Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); 

// Route::get('/events', [EventController::class, 'indexAdmin'])->name('events.index');
// dan seterusnya...
// });
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/tentang', function() {
    return '<h1>Ini adalah halaman tentang aplikasi Event Hub</h1>';
});

Route::get('/kontak', function() {
    return view('contact');
});

Route::get('/profile', function(){
    return view('profile');
});

Route::get('/katalog', function(){
    return view('katalog');
});

Route::get('/bantuan', function(){
    return view('bantuan');
});



// Route::get('/',)

