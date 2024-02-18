<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255',  'email:rfc,dns','indisposable'],
            'password' => 'required|string|min:8',
            'fcm' => 'nullable|string',
        ];
    }
}