<?php

namespace App\Http\Requests;

use App\Rules\ValidPhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100', 'regex:/^[\p{Arabic}\p{L}\s]+$/u'],
            'email' => ['nullable', 'string', 'email'], //, 'max:255', 'unique:users', 'email:rfc', 'indisposable'], // 
            'phone' => ['required', 'string', 'max:30', new ValidPhoneNumber], // 'unique:users',
            'password' => 'required|string|min:8',
            'type' => 'required|string',
            'invitation_code' => 'nullable|string',
            'otp' => 'required|string|max:6|min:6',

        ];
    }
}
