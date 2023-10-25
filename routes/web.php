<?php


use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticationController::class, 'viewLoginPage'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('web-login');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/send',  [DashboardController::class, 'createMessage'])->name('send-message.create');
    Route::post('/dashboard/send', [DashboardController::class, 'sendMessage'])->name('send-message');
    Route::get('/dashboard/resend/{broadcast}', [DashboardController::class, 'resendMessage'])->name('resend-message');
    Route::get('/logout',  [AuthenticationController::class, 'logout'])->name('web-logout');
});


Route::get("/test/mail", function () {

    return view('emails.customer-loan-request')->with([]);
});