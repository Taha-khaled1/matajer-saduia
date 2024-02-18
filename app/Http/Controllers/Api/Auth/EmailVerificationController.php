<?php

namespace App\Http\Controllers\Api\Auth;

use App\Traits\AuthTrait;
use App\Http\Controllers\Controller;

use App\Notifications\EmailverfyNotification;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmailVerificationController extends Controller
{
    use AuthTrait;
    public $otp;
   
    public function __construct()
    {
        // $this->middleware('auth'); // Ensure user is authenticated
        $this->otp = new Otp;
    }



    public function sendEmailverfyc(Request $request)
    {
        $email = $this->validateEmail($request->email);
        $user = $this->getUserByemail($email);

        if (!$user) {
            return response()->json(['message' => __('custom.user_not_found'),], 404);
        }

        $user->notify(new EmailverfyNotification());
        return response()->json(['message' => 'Success', 'status_code' => 200,], 200);
    }

    public function verifyCode(Request $request)
    {
        $email = $this->validateEmail($request->email);
        $otp2 = $this->otp->validate($email, $request->otp);
        if (!$otp2->status) {
            return response()->json(['message' => __('custom.email_verification_error'),'status_code' => 404], 404);
        }
        $user = $this->getUserByemail($email); 
        $token = $user->createToken('Laravel Sanctum')->plainTextToken;
        return response()->json(['token' => $token, 'message' => 'Success', 'status_code' => 200], 200);
    }

    public function verifyEmail(Request $request)
    {
        $email = $this->validateEmail($request->email);

       
        
        $otp2 = $this->otp->validate($email, $request->otp);
        
        if (!$otp2->status) {
            return response()->json(['message' =>__('custom.email_verification_error'),'status_code' => 404], 404);
        }
        $user = $this->getUserByemail($email); 
        // OTP is correct, continue with email verification
        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'Success', 'status_code' => 200], 200);
    }
}
//  'token' => $hashedToken,     $hashedToken = Hash::make($token);