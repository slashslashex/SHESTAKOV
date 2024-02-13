<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
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

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'guest'], function () {

    Route::get('/signin', [LoginController::class, 'showLoginForm'])->name('signin');
    Route::post('/signin', [LoginController::class, 'login'])->name('signin');

    Route::view('/cart', redirect('signin'));
});

Route::group(['middleware' => 'auth'], function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    Route::post('/decrease-quantity/{productId}', [CartController::class, 'decreaseQuantity'])->name('decrease.quantity');
    Route::post('/increase-quantity/{productId}', [CartController::class, 'increaseQuantity'])->name('increase.quantity');

});
