<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
{public function index()
    {
        $filePath = storage_path('app/codes-all.csv');

        if (!File::exists($filePath)) {
            // Handle the case where the file does not exist
            return 'CSV file not found';
        }

        $countries = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Check if the row has both "Entity" and "AlphabeticCode" columns
                if (isset($data[0]) && isset($data[2])) {
                    $countries[] = [
                        'Entity' => $data[0],
                        'AlphabeticCode' => $data[2],
                    ];
                }
            }
            fclose($handle);
        }

        return view('welcome', compact('countries'));
    }


}
