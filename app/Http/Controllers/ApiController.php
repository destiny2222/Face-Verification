<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function veriff(Request $request)
    {

        // $sharedSecretKey = 'abcdef12-abcd-abcd-abcd-abcdef012345';
        // $payload = '{"verification":{"callback":"https://veriff.com","person":{"firstName":"John","lastName":"Smith"},"document":{"type":"PASSPORT","country":"EE"},"vendorData":"unique id of the end-user","timestamp":"2016-05-19T08:30:25.597Z"}}';

        // $signature = hash_hmac('sha256', $payload, $sharedSecretKey);
        // $signature = strtolower($signature);

        // echo "X-HMAC-SIGNATURE: " . $signature . PHP_EOL;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-AUTH-CLIENT' => env('PUBLICABLE_KEY'),
            'X-HMAC-SIGNATURE' => env('X-HMAC-SIGNATURE'),
        ])->post(env('Base_Url') . '/v1/sessions/', [
            "verification" => [
                "callback" => "https://veriff.me",
                "person" => [
                    "firstName" => $request->input('firstName'),
                    "lastName" => $request->input('lastName'),
                    "idNumber" => $request->input('idNumber'),
                ],
                "document" => [
                    "number" => "B01234567",
                    "type" => "PASSPORT",
                    "country" => "EE",
                ],
                "address" => [
                    "fullAddress" => "Lorem Ipsum 30, 13612 Tallinn, Estonia",
                ],
                "vendorData" => "11111111",
            ],
        ]);
    }

    private function generateHmacSignature($payload, $sharedSecretKey)
    {
        // Generate HMAC-SHA256 signature
        $signature = hash_hmac('sha256', $payload, $sharedSecretKey);

        // Convert the signature to lowercase
        $signature = strtolower($signature);

        return $signature;
    }

    public function createVeriffSession(Request $request)
    {
        $baseUrl = 'https://stationapi.veriff.com/v1/';
        $apiKey = env('PUBLICABLE_KEY');
        $sharedSecretKey = env('SHARED_SECRET_KEY');

        $url = $baseUrl . 'sessions';

        $headers = [
            'X-AUTH-CLIENT' => $apiKey,
            'Content-Type' => 'application/json',
        ];

        // Your request payload
        $payload = [
            'verification' => [
                'callback' => 'https://veriff.com',
                'person' => [
                    'firstName' => 'John',
                    'lastName' => 'Smith',
                    'idNumber' => '123456789',
                ],
                'document' => [
                    'number' => 'B01234567',
                    'type' => 'PASSPORT',
                    'country' => 'EE',
                ],
                'address' => [
                    'fullAddress' => 'Lorem Ipsum 30, 13612 Tallinn, Estonia',
                ],
                'vendorData' => '11111111',
            ],
        ];

        // Add timestamp to payload
        $payload['verification']['timestamp'] = now()->toIso8601String();

        // Generate HMAC-SHA256 signature
        $signature = $this->generateHmacSignature(json_encode($payload), $sharedSecretKey);

        // Add signature to headers
        $headers['X-HMAC-SIGNATURE'] = $signature;

        // Make the API request
        $response = Http::withHeaders($headers)->post($url, $payload);

        // Handle the API response as needed
        return $response->json();
    }
}
