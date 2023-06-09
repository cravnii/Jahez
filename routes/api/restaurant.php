<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\Restaurant\Meal\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::prefix('/restaurants')->group(function () {
    Route::get('/', [RestaurantController::class, 'index'])->name('restaurants.index');
    Route::post('/store', [RestaurantController::class, 'store'])->name('restaurants.store');
    Route::get('/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');
    Route::put('/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
});

Route::prefix('/meals')->group(function () {
    Route::get('/', [MealController::class, 'index'])->name('meals.index');
    Route::post('/store', [MealController::class, 'store'])->name('meals.store');
    Route::get('/{meal}', [MealController::class, 'show'])->name('meals.show');
    Route::put('/{meal}', [MealController::class, 'update'])->name('meals.update');
    Route::delete('/{meal}', [MealController::class, 'destroy'])->name('meals.destroy');
});

Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::prefix('/users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


