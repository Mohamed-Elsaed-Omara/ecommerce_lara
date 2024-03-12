<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\DealController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SlideController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('dashboard.dashboard');
});

Route::resource('/categories',CategoryController::class);
Route::resource('/products',ProductController::class);
Route::get('/remove-img{id}',[ProductController::class,'removeImg']);
Route::resource('/customers',UserController::class);
Route::resource('/orders',OrderController::class);
Route::resource('/deals',DealController::class);
Route::resource('/coupons',CouponController::class);
Route::resource('/slides',SlideController::class);
Route::get('slides-toggle/{id}',[SlideController::class,'toggleActive']);

