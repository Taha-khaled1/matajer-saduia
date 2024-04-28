<?php

namespace App\Http\Controllers\Api\Auth;

use App\Traits\AuthTrait;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailverfyNotification;
use App\Rules\ValidPhoneNumber;
use App\Traits\WhatsAppTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmailVerificationController extends Controller
{

    use AuthTrait, WhatsAppTrait;
    public $otp;

    public function __construct()
    {
        // $this->middleware('auth'); // Ensure user is authenticated
        $this->otp = new Otp;
    }



    public function sendEmailverfyc(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:30', new ValidPhoneNumber], //
        ]);

        $inpout = $request->phone;
        // $user = User::where('phone', $inpout)->first();

        // if (!$user) {
        //     return response()->json(['message' => __('custom.user_not_found'),], 404);
        // }
        $this->otp = new Otp;
        $otp = $this->otp->generate($inpout, 6, 60);
        $this->sendWhatsapp($inpout, $this->sendCodeVerification('', $otp->token));
        return response()->json(['message' => 'Success', 'status_code' => 200,], 200);
    }

    public function verifyCode(Request $request)
    {
        $email = $this->validateEmail($request->email);
        $otp2 = $this->otp->validate($email, $request->otp);
        if (!$otp2->status) {
            return response()->json(['message' => __('custom.email_verification_error'), 'status_code' => 404], 404);
        }
        $user = $this->getUserByemail($email);
        $token = $user->createToken('Laravel Sanctum')->plainTextToken;
        return response()->json(['token' => $token, 'message' => 'Success', 'status_code' => 200], 200);
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:30', new ValidPhoneNumber], //
        ]);

        $otp2 = $this->otp->validate($request->phone, $request->otp);

        if (!$otp2->status) {
            return response()->json(['message' => __('custom.email_verification_error'), 'status_code' => 404], 404);
        }
        $user = $this->getUserByPhone($request->phone);
        $user->email_verified_at = now();
        $user->save();
        $token = $user->createToken('Laravel Sanctum')->plainTextToken;

        return response()->json(['message' => 'Success', 'token' => $token, 'user' => $user, 'status_code' => 200], 200);
    }
}
//  'token' => $hashedToken,     $hashedToken = Hash::make($token);