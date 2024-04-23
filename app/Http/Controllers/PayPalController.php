<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use App\Traits\WhatsAppTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nafezly\Payments\Classes\TapPayment;

class PayPalController extends Controller
{
    use WhatsAppTrait;

    public function payWithTap(Request $request)
    {
        $user = User::find($request->id);
        $payment = new TapPayment();
        $response = $payment
            ->setUserFirstName($user->name)
            ->setUserLastName('packge' . '-' . $user->id . '-' . $request->type)
            ->setUserEmail($user->email)
            ->setUserPhone($user->phone ?? "01113051656")
            ->setAmount($request->money)
            ->pay();
        // echo $response['redirect_url'];
        return redirect()->away($response['redirect_url']);
    }
    public function payWithTapPayment(Request $request)
    {
        $order = Order::find($request['order_id']);
        $user = User::find($order->user_id);
        $payment = new TapPayment();
        // $user = Auth::user();
        $response = $payment
            ->setUserFirstName($user->name)
            ->setUserLastName("order" . '-' . $order->id . '-' . $order->id)
            ->setUserEmail($user->email)
            ->setUserPhone($user->phone ?? "01113051656")
            ->setAmount($order->total)
            ->pay();
        // echo $response['redirect_url'];
        return redirect()->away($response['redirect_url']);
    }

    public function verifyWithTap(Request $request)
    {
        $payment = new TapPayment();
        $response = $payment->verify($request);
        $parts = explode("-", $response['process_data']['customer']['last_name']);
        $firstName = $parts[0];
        $middleName = $parts[1];
        $lastName = $parts[2];
        if ($response['success'] == true) {
            if ($firstName == 'order') {
                $orderId = $middleName ?? $lastName;
                $order = Order::find($orderId);
                $order->payment_status = 'paid';
                $order->payment_method = 'paypal';
                $order->save();
                $user = User::find($order->user_id);
                CartItem::where('user_id',  $user->id)->delete();
                $user->refund -=  $order->refound_money;
                $user->save();
                sendNotificationToAdmin('اضافة طلبيه', ' قام العميل ' . $user->name . ' بانشاء طلبيه جديده ' . ' معرف الطلبيه ' . $orderId, env("BASE_URL") . "/dashboard/orders/invoice/" . $orderId);
                return view("sucss-page");
            } elseif ($firstName == 'packge') {
                $user = User::find($middleName);
                $user->subscription = $lastName;
                $user->subscription_at = now();
                $user->save();
                $this->sendWhatsapp($user->phone, $this->upgradePackage($user->name, subScribeStatus($lastName) . 'الباقه', now()->addDays(30)));
            }
            return response()->json("Payment completed successfully");
        }
        return response()->json("Payment failed");
    }
}
