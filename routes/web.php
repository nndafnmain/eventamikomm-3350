<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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


