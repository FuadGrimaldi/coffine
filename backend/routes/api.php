<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\UserControllerRev;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductDetailController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\PaymentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    // Protected routes go here
    Route::get('/user/profile', [UserControllerRev::class, 'getProfile']);
    Route::get('/user/orders', [OrderController::class, 'getOrderByUser']);
    Route::get('/user/cart', [CartController::class, 'getCart']);
    Route::post('/user/cart', [CartController::class, 'addToCart']);
    Route::delete('/user/cart/{id}', [CartController::class, 'removeFromCart']);
    Route::post('/user/order', [OrderController::class, 'createOrder']);
    Route::get('/user/history-payments', [PaymentController::class, 'getPaymentUser']);
    Route::Resource('/users', UserControllerRev::class);
    Route::Resource('/categories', CategoriesController::class);
    Route::Resource('/products', ProductController::class);
    Route::Resource('/product-detail', ProductDetailController::class);
    Route::Resource('/orders', OrderController::class);
    Route::Resource('/carts', CartController::class);
    Route::Resource('/payments', PaymentController::class);
});