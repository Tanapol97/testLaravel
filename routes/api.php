<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', App\Http\Controllers\ProductsController::class);
Route::post('/login', [App\Http\Controllers\ProductsController::class, 'login']);
Route::post('/register', [App\Http\Controllers\ProductsController::class, 'register']);
Route::post('/product', [App\Http\Controllers\ProductsController::class, 'createProduct']);
Route::post('/product/delete', [App\Http\Controllers\ProductsController::class, 'deleteProduct']);
Route::post('/product/update', [App\Http\Controllers\ProductsController::class, 'updateProduct']);

Route::resource('orders', App\Http\Controllers\OrderController::class);
Route::post('/order', [App\Http\Controllers\OrderController::class, 'createOrder']);
Route::post('/order/delete', [App\Http\Controllers\OrderController::class, 'deleteOrder']);
Route::post('/order/update', [App\Http\Controllers\OrderController::class, 'updateOrder']);