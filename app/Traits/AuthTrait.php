<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Ichtrojan\Otp\Otp;

trait AuthTrait
{
    // Validate email address before using it
    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email address',
            ]);
        }
        return $email;
    }

    // A separate method to get the user
    public function getUserByemail($email)
    {
        return User::where('email', $email)->first();
    }
    public function getUserByPhone($phone)
    {
        return User::where('phone', $phone)->first();
    }
    public function sendOtpPhone($user)
    {
        $this->otp = new Otp;
        $otp = $this->otp->generate($user->phone, 6, 60);
        $this->sendWhatsapp($user->phone, $this->sendCodeVerification($user->name, $otp->token));
    }
}
