<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{

function paymentGateway() {
    $paymentGateway = PaymentGateway::first();

    // Make sure the key is exactly 32 bytes (256 bits) long
    $key = '12345678901234567890123456789012';  // Replace with your actual 32-byte key

    // Make sure the IV is exactly 16 bytes (128 bits) long
    $iv = '1234567890123456';  // Replace with your actual 16-byte IV

    $encryptedData = openssl_encrypt(json_encode($paymentGateway), 'aes-256-cbc', $key, 0, $iv);

    return response()->json([
        'status_code' => 200,
        'message' => 'Success',
        'paymentGateway' => $paymentGateway,
    ], 200);
}
}