<?php
use App\Http\Controllers\PaymentController;


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
//Currency Conversion
Route::post('/convert-amount', [PaymentController::class, 'ConvertAmount']);



//////////////
Route::post('/pay', [PaymentController::class, 'initialize'])->name('pay');
Route::get('/rave/callback', [PaymentController::class, 'callback'])->name('callback');




Route::any('payment-page',[PaymentController::class,'index'])->name('payment');;

Route::get('callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

// Mobile money transfer
Route::post('/mobile-money-transfer', [PaymentController::class, 'initiateMobileMoneyTransfer'])->name('mobile.money.transfer');
Route::get('/mobile-money-transfer/callback', [PaymentController::class, 'mobileMoneyTransferCallback'])->name('mobile.money.transfer.callback');