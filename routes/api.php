<?php

use App\Http\Controllers\Admin\CustomerNotificationController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CreditCheckController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerMobileAppAuditController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderRequestController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PriceCalculatorController;
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
        Route::patch('/notification/{notification}', [NotificationController::class, 'update'])->name('notification.update');
        Route::patch('/customers/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::get('/customers/{customer}/orders', [CustomerOrderController::class, 'show'])->name('customer.order.show');
        Route::post('/submit/request', [CustomerOrderController::class, 'submitRequest'])->name('customer.order.request');
        Route::post('/submit/loan/request', [CustomerOrderController::class, 'submitLoanRequest'])->name('customer.order.request');
        Route::get('/customers/{customer}/notifications', [CustomerNotificationController::class, 'show'])->name('customers.notifications.show');
        Route::get('customers/{customer}/requests', [OrderRequestController::class, 'index'])->name('customers.order-requests');
        Route::resource('branches', BranchController::class);
        Route::post('/document/upload', [DocumentController::class, 'store']);
        Route::post('/upload/document/s3', [DocumentController::class, 'uploadDocument']);
        Route::post('app/audit', [CustomerMobileAppAuditController::class, 'store']);
        Route::get('recent/activities', [CustomerMobileAppAuditController::class, 'recentActivity']);
        Route::get('credit-check-verification/{creditCheckerVerification}', [CreditCheckController::class, 'show']);
    });
    Route::prefix('otp')->group(function () {
        Route::post('send', [OtpController::class, 'sendOtp'])->name('otp.send');
    });
    Route::get('/customer/exists/{phone_number}', [AuthenticationController::class, 'customerExist']);
    Route::resource('price-calculators', PriceCalculatorController::class);
});
