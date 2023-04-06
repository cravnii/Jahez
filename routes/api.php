<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/restaurants', [RestaurantsController::class, 'index'])->name('restaurants.index');
Route::post('/restaurants/store', [RestaurantsController::class,'store'])->name('restaurants.store');
Route::get('/restaurants/{restaurants}', [RestaurantsController::class,'show'])->name('restaurants.show');
Route::put('/restaurants/{restaurants}', [RestaurantsController::class, 'update'])->name('restaurants.update');
Route::delete('/restaurants/{restaurants}', [RestaurantsController::class, 'destroy'])->name('restaurants.destroy');


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
