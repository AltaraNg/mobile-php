<?php

use App\Http\Controllers\Admin\CustomerNotificationController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OrderRequestController;
use App\Http\Controllers\OtpController;
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

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/user', [AuthenticationController::class, 'user']);
            Route::get('/logout', [AuthenticationController::class, 'logout']);
        });
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/customers/{customer}/orders', [CustomerOrderController::class, 'show'])->name('customer.order.show');
        Route::post('/submit/request', [CustomerOrderController::class, 'submitRequest'])->name('customer.order.request');
        Route::get('/customers/{customer}/notifications', [CustomerNotificationController::class, 'show'])->name('customers.notifications.show');
        Route::get('customers/{customer}/requests', [OrderRequestController::class, 'index'])->name('customers.order-requests');
        Route::post('/document/upload', [DocumentController::class, 'store']);
    });
    Route::prefix('otp')->group(function () {
        Route::post('send', [OtpController::class, 'sendOtp'])->name('otp.send');
    });
});
