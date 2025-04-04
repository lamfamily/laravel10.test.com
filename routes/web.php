<?php

use App\Livewire\Counter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ECPayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
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

// ecpay test
Route::group(['prefix' => 'ecpay'], function() {
    Route::get('/test1', [ECPayController::class, 'test1']);
    Route::any('/test2', [ECPayController::class, 'test2']);

    Route::any('/order_success', [ECPayController::class, 'orderSuccess'])->name('ecpay.order_success');
    Route::any('/order_fail', [ECPayController::class, 'orderFail'])->name('ecpay.order_fail');

    Route::any('/return_call', [ECPayController::class, 'returnCall']);
    Route::any('/period_return_call', [ECPayController::class, 'periodReturnCall']);
    Route::any('/3d_order_result_call', [ECPayController::class, 'threeDOrderResultCall']);
    Route::any('/union_order_result_call', [ECPayController::class, 'unionOrderResultCall']);
});

Route::prefix('/test')->group(function() {
    Route::get('/test1', [TestController::class, 'test1']);
    Route::get('/test2', [TestController::class, 'test2']);
    Route::get('/test3', [TestController::class, 'test3']);
    Route::get('/test-applypay', [TestController::class, 'testApplypay']);
});

// for livewire
Route::get('/livewire-counter', Counter::class);


Route::resource('categories', CategoryController::class);
