<?php

use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\HomeController as WebsiteHomeController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Controllers\Website\ProductController;
use App\Http\Controllers\Website\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', WebsiteHomeController::class)/* ->middleware(['auth', 'verified']) */;

/* Route::get('/dash', function () {
    return view('dash');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::get('/check-user',[HomeController::class,'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('category/{id}',[CategoryController::class,'show']);

Route::get('product/{id}',[ProductController::class,'show']);
Route::post('product/{id}',[ProductController::class,'rating']);
Route::get('search-results',[ProductController::class,'search']);
Route::get('cart',[CartController::class,'showCart']);
Route::post('add-to-cart',[CartController::class,'addToCart']);
Route::post('remove-from-cart/{productId}',[CartController::class,'removeFromcart']);
Route::post('update-cart',[CartController::class,'updateCart']);
Route::post('apply-coupon',[CartController::class,'applyCoupon']);
Route::get('/check-out',[OrderController::class,'checkout']);
Route::post('/create-order',[OrderController::class,'store']);

Route::get('/profile',[UserController::class,'getProfile']);
Route::post('/profile',[UserController::class,'postProfile']);
Route::get('/orders',[UserController::class,'getOrder']);
Route::delete('orders/{id}',[OrderController::class,'deleteOrder']);
Route::get('/change-password',[UserController::class,'getchangePassword']);
Route::post('/change-password',[UserController::class,'postchangePassword']);


Route::get('auth/{provider}/redirect',[SocialLoginController::class,'redirectToAuth'])->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback',[SocialLoginController::class,'handleCallback'])->name('auth.socialite.handlecallback');
Route::get('auth/{provider}/user',[SocialController::class,'index']);

require __DIR__.'/auth.php';
