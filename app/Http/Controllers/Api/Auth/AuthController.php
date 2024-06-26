<?php

namespace App\Http\Controllers\Api\Auth;


use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SocialRegisterRequest;
use App\Jobs\SendVerificationEmailJob;
use App\Models\MarketersReports;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Order;
use App\Models\ShippingCompanies;
use App\Models\User;
use App\Traits\AuthTrait;
use Ichtrojan\Otp\Otp;
use App\Traits\WhatsAppTrait;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
// __('custom.')
class AuthController extends Controller
{
    use Notifiable, WhatsAppTrait, AuthTrait;
    private $auth;
    public $otp;

    public function __construct()
    {
        // $this->middleware('auth'); // Ensure user is authenticated
        $this->otp = new Otp;
    }
    public function login(LoginRequest $request)
    {

        $credentials = $request->only(['phone', 'password']);

        if (!Auth::attempt($credentials)) {
            throw new \Illuminate\Auth\AuthenticationException(__('custom.authentication_failed'));
        }

        $user = auth()->user();

        if (!$user->email_verified_at) {
            throw new \Illuminate\Auth\AuthenticationException(__('custom.email_not_verified'));
        }
        if ($user->status == '0') {
            throw new \Illuminate\Auth\AuthenticationException(__('custom.user_blocked'));
        }
        $otp2 = $this->otp->validate($request->phone, $request->otp);
        if (!$otp2->status) {
            return response()->json(['message' => "يوجد مشكله في التحققك من رقم هاتفك", 'status_code' => 404], 404);
        }
        $this->sendWhatsapp($user->phone, $this->successfulLogin($user->name));
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

    public function getAds(Request $request)
    {

        $ads = Advertisement::where("status", true)->where("show", false)->where("type", "ads")->get();

        return response()->json([
            "data" => $ads,
            'message' => 'Success', 'status_code' => 200,
        ], 200);
    }

    public function getRepoerts(Request $request)
    {
        $user = $request->user;

        $reports = MarketersReports::where("user_id", $user->id)->where("status", "procedure")->with("order")->get();
        // MarketersReports::where("user_id", $user->id)->with("user.mosaoqOrders")->get();

        return response()->json([
            "data" => $reports,
            'message' => 'Success', 'status_code' => 200,
        ], 200);
    }
    public function getmange(Request $request)
    {
        $user = $request->user;

        $reports = MarketersReports::where("user_id", $user->id)->where("status", "sold")->with("order")->get();
        // MarketersReports::where("user_id", $user->id)->with("user.mosaoqOrders")->get();

        return response()->json([
            "data" => $reports,
            'message' => 'Success', 'status_code' => 200,
        ], 200);
    }
    public function register(RegisterRequest $request)
    {
        if ($request->has('invitation_code')) {
            $referrer = User::where('invitation_code', $request->invitation_code)->first();

            if ($referrer) {
                $request['referrer_id'] = $referrer->id;
            }
        }


        $otp2 = $this->otp->validate($request->phone, $request->otp);
        if (!$otp2->status) {
            return response()->json(['message' => "يوجد مشكله في التحققك من رقم هاتفك", 'status_code' => 404], 404);
        }
        $user = $this->createUser($request->validated(), $request['referrer_id']);
        $token = $user->createToken('Laravel Sanctum')->plainTextToken;
        $user->assignRole([$request->type ?? "user"]);
        $user->email_verified_at = now();
        $user->save();
        if ($request->type == "vendor") {
            $category = new ShippingCompanies;
            $category->name_ar = "شركة فيجن";
            $category->cost = "25";
            $category->user_id = $user->id;
            $category->save();
        }
        if ($user->type == 'vendor') {
            $this->sendWhatsapp($user->phone, $this->registerStore($user->name, 'الباقه العاديه'));
        } elseif ($user->type == 'affiliate') {
            $this->sendWhatsapp($user->phone, $this->registerAffiliate($user->name, $user->invitation_code));
        } else {
            $this->sendWhatsapp($user->phone, $this->successfulRegistration($user->name));
        }
        return response()->json([
            'token' => $token, 'user' => $user, 'message' => 'Success', 'status_code' => 200
        ], 200);
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

    private function createUser(array $data, $referrer_id = null)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'type' => $data['type'],
            'referrer_id' => $referrer_id,
            'fcm' => $data['fcm'] ?? "test",
            'password' => Hash::make($data['password']),
            "invitation_code" => generateUniqueInvitationCode(),
        ]);
    }
}
