<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.register');
});

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::get('/register', function() {
    return view('auth.register');
})->middleware('guest');

Route::post('/register', Register::class)
    ->middleware('guest');

Route::post('login', Login::class);

Route::view('/home', 'home')
    ->name('home');

Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
