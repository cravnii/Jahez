<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('login/email', [LoginController::class, 'sendLoginEmail'])->name('login.email');

Route::get('/logout', [LoginController::class, 'logout']);






