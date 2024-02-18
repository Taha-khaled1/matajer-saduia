<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;


class StripePaymentController extends Controller
{


    public function stripe(Request $request)
    {
        $data = [];
        $order = Order::find($request['order_id']);
        return view('stripe', compact("order"));
    }


    public function stripePost(Request $request)
    {


        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            $validatedData = $request->validate([
                'order_id' => 'required|integer',
            ]);
            Charge::create([
                "amount" => $request->total * 100,
                "currency" => "aed",
                "source" => $request->stripeToken,
                "description" => "Test payment from LaravelTus.com."
            ]);

            // Payment was successful, update the order status to "paid"
            $orderId = $request->order_id;
            $order = Order::findOrFail($orderId);

            // Make sure the order exists before updating it
            if ($order) {
                $order->payment_status = 'paid';
                $order->payment_method = 'stripe';
                $order->save();
                $user = User::find($order->user_id);
                sendNotificationToAdmin('اضافة طلبيه', ' قام العميل ' . $user->name . ' بانشاء طلبيه جديده ' . ' معرف الطلبيه ' . $orderId, env("BASE_URL") . "/dashboard/orders/invoice/" . $orderId);
                CartItem::where('user_id', $order->user_id)->delete();
                $user->refund -=  $order->refound_money;
                $user->save();
                Session::flash('success', 'Payment successful!');
            } else {
                // Handle the case where the order is not found
                Session::flash('error', 'Order not found.');
            }

            return view("sucss-page");
        } catch (\Exception $e) {
            // Handle payment failure
            $validatedData = $request->validate([
                'order_id' => 'required|integer',
            ]);

            $orderId = $request->order_id;
            $order = Order::findOrFail($orderId);

            // Make sure the order exists before updating it
            if ($order) {
                $order->cancelled = true;
                $order->status = 'cancelled';
                $order->save();
                Session::flash('error', 'Payment failed. The order has been cancelled .');
            } else {
                // Handle the case where the order is not found
                Session::flash('error', 'Order not found.');
            }

            return back();
        }
    }


    // public function successStripe(Request $request)
    // {
    //         $orderId = $request->query('order_id');
    //         $order = Order::find($orderId);
    //         $order->payment_status = 'paid';
    //         $order->payment_method = 'stripe';
    //         $order->save();
    //         return response()->json([
    //             'status_code' => 200,
    //             'message' => 'Payment completed successfully',
    //         ], 200);
    // }

}
