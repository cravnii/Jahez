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


Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

    Route::prefix('/restaurants')->group(function () {
    Route::get('/', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::post('/store', [RestaurantController::class,'store'])->name('restaurants.store');
    Route::get('/{restaurant}', [RestaurantController::class,'show'])->name('restaurants.show');
    Route::put('/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
});

    Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

});

Route::prefix('/mails')->group(function () {
Route::get('/', [MailController::class, 'index'])->name('mails.index');
Route::post('/store', [MailController::class, 'send'])->name('mails.send');
Route::get('/{mail}', [MailController::class, 'show'])->name('mails.show');
Route::put('/{mail}', [MailController::class, 'update'])->name('mails.update');
Route::delete('/{mail}', [MailController::class, 'destroy'])->name('mails.destroy');
});

