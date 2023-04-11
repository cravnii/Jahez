<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
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

Route::prefix('/restaurants')->group(function () {
    Route::get('/', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::post('/store', [RestaurantController::class,'store'])->name('restaurants.store');
    Route::get('/{restaurants}', [RestaurantController::class,'show'])->name('restaurants.show');
    Route::put('/{restaurants}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/{restaurants}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
});
    Route::prefix('/users')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{users}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{users}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{users}', [UserController::class, 'destroy'])->name('users.destroy');
});
    Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

});

