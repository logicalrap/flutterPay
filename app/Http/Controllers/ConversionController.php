<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ConversionController extends Controller
{

        //Currency Conversion

        public function ConvertAmount(Request $request)
        {
            $from = 'USD'; // Source currency (always USD)
            $to = $request->input('location'); // Target currency selected by the user
            $amount = $request->input('paymentAmount'); // Amount entered by the user

            // Make the API request to get exchange rate data
             $username='rapson305012185';
             $password='7tguuv782ns7166k2ir7dq4dn';

            $response = Http::withBasicAuth($username, $password)
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
