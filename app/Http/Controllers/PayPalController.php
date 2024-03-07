<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nafezly\Payments\Classes\TapPayment;

class PayPalController extends Controller
{

    public function payWithTap(Request $request)
    {
        $user = User::find($request->id);
        $payment = new TapPayment();
        // $user = Auth::user();
        $response = $payment
            ->setUserFirstName($user->name)
            ->setUserLastName('1' . '-' . $user->id . '-' . $request->type)
            ->setUserEmail($user->email)
            ->setUserPhone($user->phone ?? "01113051656")
            ->setAmount($request->money)
            ->pay();
        // echo $response['redirect_url'];
        return redirect()->away($response['redirect_url']);
    }
    // dd($response);
    //output
    //[
    //    'payment_id'=>"", // refrence code that should stored in your orders table
    //    'redirect_url'=>"", // redirect url available for some payment gateways
    //    'html'=>"" // rendered html available for some payment gateways
    //]
    public function verifyWithTap(Request $request)
    {
        $payment = new TapPayment();
        $response = $payment->verify($request);
        $parts = explode("-", $response['process_data']['customer']['last_name']);

        // Use print_r to print array contents
        print_r($parts);
        $firstName = $parts[0]; // "hi"
        $middleName = $parts[1]; // "man"
        $lastName = $parts[2];  // cc
        if ($response['success'] == true) {
            $user = User::find($middleName);
            $user->subscription = $lastName;
            $user->subscription_at = now();
            $user->save();
            return response()->json("Payment completed successfully");
        }
        return response()->json("Payment failed");
        // echo $firstName;
        // dd($response);
        //output
        //[
        //    'success'=>true,//or false
        //    'payment_id'=>"PID",
        //    'message'=>"Done Successfully",//message for client
        //    'process_data'=>""//payment response
        //]
    }
}
