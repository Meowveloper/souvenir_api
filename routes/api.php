<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('authenticate')->group(function() {
    Route::post('update', [AuthController::class, 'update']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::post('login', [AuthController::class, 'authenticate']);
});

Route::prefix('customer')->group(function () {
    Route::get('list', [CustomerController::class, 'list']);
    Route::get('listWithOrders', [CustomerController::class, 'listWithOrders']);
    Route::post('create', [CustomerController::class, 'create']);
    Route::post('update', [CustomerController::class, 'update']);
});

Route::prefix('product')->group(function() {
    Route::get('list', [ProductController::class, 'list']);
    Route::get('listWithCategories', [ProductController::class, 'listWithCategories']);
    Route::post('create', [ProductController::class, 'create']);
    Route::post('update', [ProductController::class, 'update']);
    Route::post('delete', [ProductController::class, 'delete']);
});


Route::prefix('category')->group(function() {
    Route::get('list', [CategoryController::class, 'list']);
    Route::post('create', [CategoryController::class, 'create']);
});

Route::prefix('paymentType')->group(function() {
    Route::get('list', [PaymentTypeController::class, 'list']);
    Route::post('create', [PaymentTypeController::class, 'create']);
});

Route::prefix('order')->group(function() {
    Route::post('create', [OrderController::class, 'create']);
    Route::get('list', [OrderController::class, 'list']);
    Route::post('update', [OrderController::class, 'update']);
});
