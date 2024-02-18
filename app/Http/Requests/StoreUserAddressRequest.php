<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAddressRequest extends FormRequest
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
        'country' => 'required|string',
        'state' => 'nullable|string',
        'user_id' => 'required|exists:users,id',
        'city' => 'required|string',
        'zip' => 'nullable|string',
        'address_1' => 'required|string',
        'address_2' => 'nullable|string',
        'name' => 'required|string',
        'email' => 'required|email',
        'phone' => 'required|string',
        'delivery_instruction' => 'nullable|string',
        'default' => 'required|in:0,1',
    ];
    }
}