<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return redirect('/payment/split');
});

Route::get('payment/split', [\App\Http\Controllers\PaymentController::class, 'getPayment']);
Route::post('payment/split', [\App\Http\Controllers\PaymentController::class, 'postPayment']);
