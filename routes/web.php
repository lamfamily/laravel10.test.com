<?php

use App\Http\Controllers\MasterCardController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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
