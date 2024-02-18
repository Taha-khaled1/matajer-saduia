<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SocialRegisterRequest;
use App\Jobs\SendVerificationEmailJob;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailverfyNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
// __('custom.')
class AuthController extends Controller
{
    use Notifiable;
    private $auth;

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            throw new \Illuminate\Auth\AuthenticationException(__('custom.authentication_failed'));
        }

        $user = Auth::user();

        if (!$user->email_verified_at) {
            throw new \Illuminate\Auth\AuthenticationException(__('custom.email_not_verified'));
        }
        if ($user->status == '0') {
            throw new \Illuminate\Auth\AuthenticationException(__('custom.user_blocked'));
        }

        $token = $user->createToken('authToken')->plainTextToken;
        $user->fcm = $request->fcm ?? "test";
        $user->save();
        return response()->json(['token' => $token, 'user' => $user], 200);
    }



    public function logout(Request $request)
    {

        $request->user->tokens()->delete();
        return response()->json(['message' => 'Success', 'status_code' => 200,], 200);
    }




    public function register(RegisterRequest $request)
    {
        $user = $this->createUser($request->validated());

        SendVerificationEmailJob::dispatch($user);

        $token = $user->createToken('Laravel Sanctum')->plainTextToken;
        $user->assignRole(["user"]);
        return response()->json(['token' => $token, 'message' => 'Success', 'status_code' => 200], 200);
    }



    public function socialRegister(SocialRegisterRequest $request)
    {


        try {
            $userData = $request->all();
            $request['password'] = 'social-register';
            // Check if the user already exists in your system
            $user = User::where('email', $userData['email'])->first();

            if (!$user) {
                // User doesn't exist, create a new user
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'fcm' => $userData['fcm'] ?? "test",
                    'email_verified_at' => now(),  // Set the email_verified_at field to current timestamp
                    'password' => Hash::make($request['password']),
                ]);
                $user->email_verified_at = now();
                $user->save();
            } else {

                $credentials = $request->only(['email', 'password']);

                if (!Auth::attempt($credentials)) {
                    return response()->json(
                        [
                            'message' => __('custom.auth_arror'),
                            'status_code' => 409
                        ],
                        409
                    );
                }

                $user = Auth::user();
            }
            $token = $user->createToken('authToken')->plainTextToken;
            // Create a token for the user


            return response()->json(['token' => $token, 'user' => $user, 'message' => 'Success', 'status_code' => 200], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed', 'status_code' => 500], 500);
        }
    }

    private function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'fcm' => $data['fcm'] ?? "test",
            'password' => Hash::make($data['password']),
        ]);
    }
}
