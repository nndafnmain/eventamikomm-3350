<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/1', [EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/events', [EventController::class, 'indexAdmin'])->name('events.index');
// dan seterusnya...
});
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/tentang', function() {
//     return '<h1>Ini adalah halaman tentang aplikasi Event Hub</h1>';
// });

// Route::get('/kontak', function() {
//     return view('contact');
// });

// Route::get('/profile', function(){
//     return view('profile');
// });

// Route::get('/katalog', function(){
//     return view('katalog');
// });

// Route::get('/bantuan', function(){
//     return view('bantuan');
// });

// Route::get('/',)

