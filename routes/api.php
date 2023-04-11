<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::post('/restaurants/store', [RestaurantController::class,'store'])->name('restaurants.store');
Route::get('/restaurants/{restaurants}', [RestaurantController::class,'show'])->name('restaurants.show');
Route::put('/restaurants/{restaurants}', [RestaurantController::class, 'update'])->name('restaurants.update');
Route::delete('/restaurants/{restaurants}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{users}', [UserController::class, 'show'])->name('users.show');
Route::put('/users/{users}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{users}', [UserController::class, 'destroy'])->name('users.destroy');
