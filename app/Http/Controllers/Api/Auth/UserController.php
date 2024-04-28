<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Ichtrojan\Otp\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{

    public function updateUserInfo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                // 'user_last_name' => 'required|string|max:255',
                // 'email' => 'required|string|email|max:255|unique:users',

            ]);

            $user = $request->user;
            if ($user->email != $request->email) {
                $validatedData = $request->validate([
                    'email' => 'required|string|email|max:255|unique:users',
                ]);
                $user->email = $request->email;
            }
            $user->name = $request->name;


            $user->save();
            return response()->json(['message' => 'Success', 'status_code' => 200,], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => __('custom.server_issue'), 'status_code' => 404,], 404);
        }
    }



    public function changePassword(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'old_password' => 'required|string',
                'new_password' => 'required|string|min:8|different:old_password',
                'new_password_confirmation' => 'required|string|same:new_password',
            ]);
            $user = $request->user;
            if (!Hash::check($validatedData['old_password'], $user->password)) {
                return response()->json(['message' => __('custom.old_password_incorrect'), 'status_code' => 422], 422);
            }

            $user->update(['password' => Hash::make($validatedData['new_password'])]);

            return response()->json(['message' => 'Success', 'status_code' => 200,], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => __('custom.server_issue'), 'status_code' => 404,], 404);
        }
    }


    public function getUserInfo(Request $request)
    {
        try {
            $token = $request->bearerToken();
            $accessToken = PersonalAccessToken::findToken($token);
            if (!$accessToken) {
                return response()->json(['message' => __('custom.unauthorized'), 401], 401);
            }

            $user = $accessToken->tokenable;
            return $user;
        } catch (\Throwable $th) {
            return response()->json(['message' => __('custom.server_issue'), 'status_code' => 404,], 404);
        }
    }

    public function getOtpForUser(Request $request)
    {
        $otp = DB::table('otps')->where('identifier', '=', $request->phone)->get();
        return response()->json(['otp' => $otp], 200);
    }
}
