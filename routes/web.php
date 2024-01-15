<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Http;
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

Route::get('/', [ApiController::class, 'createVeriffSession']);

// Route::get('/', function () {
//     $response = Http::withHeaders([
//         'Content-Type' => 'application/json',
//         'X-AUTH-CLIENT'=> env('PUBLICABLE_KEY'),
//     ])->post(env('Base_Url') .'/v1/sessions/',[
//         "verification" => [
//             "callback" => "https://veriff.me",
//             "person" => [
//                 "firstName" => "John",
//                 "lastName" => "Smith",
//                 "idNumber" => "123456789",
//             ],
//             "document" => [
//                 "number" => "B01234567",
//                 "type" => "PASSPORT",
//                 "country" => "EE",
//             ],
//             "address" => [
//                 "fullAddress" => "Lorem Ipsum 30, 13612 Tallinn, Estonia",
//             ],
//             "vendorData" => "11111111",
//         ],
//     ]);
//     return $response;
// });
