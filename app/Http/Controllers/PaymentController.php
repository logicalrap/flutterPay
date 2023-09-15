<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Transaction; // Import your Transaction model
use Illuminate\Support\Facades\Http;


use KingFlamez\Rave\Facades\Rave as Flutterwave;



class PaymentController extends Controller
{
    public function initialize()
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => 500,
            'email' => request()->email,
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('callback'),
            'customer' => [
                'email' => request()->email,
                "phone_number" => request()->phone,
                "name" => request()->name
            ],

            "customizations" => [
                "title" => 'Movie Ticket',
                "description" => "20th October"
            ]
        ];

        $payment = Flutterwave::initializePayment($data);



        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {

        $status = request()->status;

        //if payment is successful
        if ($status == 'successful') {
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            // Save the transaction data in the database using Eloquent
            $transaction = Transaction::create([
                'transaction_id' => $data['data']['id'],
                'tx_ref' => $data['data']['tx_ref'],
                'amount' => $data['data']['amount'],
                'currency' => $data['data']['currency'],
                'status' => $data['data']['status'],
                'customer_id' => $data['data']['customer']['id'],  // Add customer_id
                'customer_email' => $data['data']['customer']['email'],  // Add customer_email
                // ... add other relevant fields here
            ]);

            // Return a payment successful response to the user
            return response()->json(['message' => 'Payment successful']);

        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
        }
        else{
            //Put desired action/code after transaction has failed here
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }

      /////////////////
      ////////////////
      ///////////////
    //Mobile money transfer

    public function initiateMobileMoneyTransfer(Request $request)
    {
        $tx_ref = Flutterwave::generateReference();
        $order_id = Flutterwave::generateReference('momo');

        $data = [
            'amount' => $request->input('amount'),
            'email' => $request->input('email'),
            'redirect_url' => route('mobile.money.transfer.callback'),
            'phone_number' => $request->input('phone'),
            'tx_ref' => $tx_ref,
            'network' => 'MTN',
            'order_id' => $order_id,
        ];

        $charge = Flutterwave::payments()->momoZambia($data);

        if ($charge['status'] === 'success') {
            // Redirect to the charge url
            return redirect($charge['data']['redirect']);
        } else {
            // Handle error scenario
            return redirect()->back()->with('error', 'Payment initiation failed.');
        }
    }





    public function mobileMoneyTransferCallback(Request $request)
    {
        $resp = urldecode($request->input('resp'));
        $response = json_decode($resp, true); // Decoding as an associative array

        dd($response); // Add this line to see the decoded response

        // Rest of your code
        if ($response['status'] === 'success' && $response['data']['status'] === 'successful') {
            // Transaction is successful and verified
            // You can update your database or perform other actions here

            // For example, save the transaction details to the database
            Transaction::create([
                'transaction_id' => $response['data']['tx_ref'],
                'order_ref' => $response['data']['order_id'],
                'amount' => $response['data']['amount'],
                'currency' => $response['data']['currency'],
                'status' => $response['data']['status'],
                'customer_name' => $response['data']['customer']['name'],
                'customer_email' => $response['data']['customer']['email'],
                'customer_phone' => $response['data']['customer']['phone_number'],
                // ... other fields
            ]);

            // Return a response to the user
            return view('mobile-money-transfer-status', ['status' => 'success']);
        } else {
            // Transaction failed or verification failed
            // Handle the error scenario
            return view('mobile-money-transfer-status', ['status' => 'failed']);
        }
    }





        //Currency Conversion

    public function ConvertAmount(Request $request)
    {
        $from = 'USD'; // Source currency (always USD)
        $to = $request->input('location'); // Target currency selected by the user
        $amount = $request->input('paymentAmount'); // Amount entered by the user

        // Make the API request to get exchange rate data
        $response = Http::withBasicAuth('rapson305012185', '7tguuv782ns7166k2ir7dq4dn')
            ->get("https://xecdapi.xe.com/v1/convert_from.csv/?from=$from&to=$to&amount=$amount");

        if ($response->successful()) {
            $data = $response->body();

            // Split the CSV data into lines
            $lines = explode("\n", $data);
            //dd($lines);

            // Check if there are at least two lines in the CSV data
            if (count($lines) >= 2) {

                // Take the third line of data (index 1)
                $csvData = str_getcsv($lines[2]);

                // Check if the CSV data has enough elements
                if (count($csvData) >= 5) {
                    // Extract the conversion rate

                    $conversionRate = floatval($csvData[4]);
                    $conversionRate = round($conversionRate, 2); // Round to two decimal places


                    // Calculate the converted amount

                    //$convertedAmount = number_format($amount * $conversionRate, 2); // Format the converted amount
                    return "<strong>$to</strong> &nbsp;$conversionRate";

                }
            }
        }

        // Handle the API request error
        return 'Conversion failed. Please check your input.';
    }





}
