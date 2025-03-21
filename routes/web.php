<?php

use App\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ECPayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MasterCardController;

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

Route::get('/', function () {
    // return view('welcome');
    return "hello laravel 10";
});

Route::get('/mastercard/test1', [MasterCardController::class, 'test1']);

Route::get('/payment/return/{check_code}', [PaymentController::class, 'return']);
Route::get('/payment/cancel/{check_code}', [PaymentController::class, 'cancel']);

Route::get('/ecpay/test1', [ECPayController::class, 'test1']);

Route::prefix('/test')->group(function() {
    Route::get('/test1', [TestController::class, 'test1']);
    Route::get('/test2', [TestController::class, 'test2']);
    Route::get('/test3', [TestController::class, 'test3']);
    Route::get('/test-applypay', [TestController::class, 'testApplypay']);
});

// for livewire
Route::get('/livewire-counter', Counter::class);
