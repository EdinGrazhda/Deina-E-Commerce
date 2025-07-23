<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\DashboardController;

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

// Public API routes for e-commerce
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/categories', [CategoryApiController::class, 'index']);

// Order and payment routes
Route::post('/process-payment', [OrderApiController::class, 'processPayment']);
Route::post('/send-order-confirmation', [OrderApiController::class, 'sendOrderConfirmation']);

// Analytics routes (protected)
Route::get('/analytics', [DashboardController::class, 'getAnalyticsData']);

