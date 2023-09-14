<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flutterwave\Rave;


class CheckoutController extends Controller
{
    //
    public function index()
    {
        $amount = 1000;
        $currency = 'NGN';
        $payment_options = ['card', 'banktransfer'];
        $redirect_url = route('checkout.success');
        $meta = ['custom_field' => 'value'];

        $response = Rave::initialize(
            $amount,
            $currency,
            $payment_options,
            $redirect_url,
            $meta
        );

        if ($response->status == 'success') {
            return redirect($response->data['payment_url']);
        } else {
            return redirect()->back()->withErrors($response->message);
        }
    }

    public function success()
    {
        $transaction_id = request()->input('transaction_id');
        $response = Rave::verifyTransaction($transaction_id);

        if ($response->status == 'success') {
            return view('checkout.success');
        } else {
            return view('checkout.error');
        }
    }
}
