<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;

class OrderController extends Controller
{
    function userOrder(Request $request)
    {
        try {
            $userId = $request->user->id;
            $orders = Order::with(['orderItems.product:id,image'])
                ->where('user_id', $userId)
                ->where(function ($query) {
                    $query->whereNotIn('payment_method', ['stripe', 'paypal'])
                        ->orWhere('payment_status', '!=', 'pending');
                })->get();

            // Transform the orders to include the desired fields
            $transformedOrders = $orders->map(function ($order) {
                $orderItems = $order->orderItems->map(function ($orderItem) {
                    return $orderItem->product->image ?? null;
                });

                return [
                    'id' => $order->id,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'payment_method' => $order->payment_method,
                    'currency' => $order->currency,
                    'cancelled' => $order->cancelled,
                    'total' => $order->total,
                    'created_at' => $order->created_at,
                    'product_count' => $order->orderItems->count(),
                    'images_product' => $orderItems->filter()->toArray(),
                ];
            });

            return response()->json([
                'status_code' => 200,
                'message' => 'Success',
                'orders' => $transformedOrders,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'error' => $th->getMessage()], 500);
        }
    }
    function orderDetalis($id)
    {
        try {
            $validator = Validator::make(['id' => $id], [
                'id' => 'required|integer|exists:orders,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            $order = Order::with(
                [
                    'orderItems.product' => function ($query) {
                        $query->select('id', DB::raw("name_" . app()->getLocale() . " AS name"), DB::raw("name_" . ReverseLanguage(app()->getLocale()) . " AS favorite_name"), 'price', 'image', 'discount_start', 'discount_end', 'discount');
                    },
                    'userAddress' => function ($query) {
                        $query->select('id', 'phone', 'address_1', 'country', 'city');
                    },
                ]
            )->select("id", 'status', 'payment_status', 'payment_method', 'shipping', 'subtotal', 'total', 'delivery_time', 'created_at', 'user_address_id', 'coupon_id')->find($id);
            return response()->json([
                'status_code' => 200,
                'message' => 'Success',
                'order' => $order,

            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'error' => $th->getMessage()], 500);
        }
    }
    public function saveOrder(Request $request)
    {

        $request->validate([
            'user_address_id' => 'required|integer',
            'payment_method' => 'required|string',
            'token' => 'required|string',
            'coupon_code' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $token = $request->token;
        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken) {
            return response()->json(['message' => __('custom.unauthorized'), 401], 401);
        }

        $mainRoute = env('MAIN_ROUTE');
        $user = $accessToken->tokenable;
        $orderPrice = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            // Add any additional headers if required
        ])->get($mainRoute . '/cart/checkout', [
            'user_address_id' => $request->user_address_id,
            'payment_method' => $request->payment_method,
            'coupon_code' => $request->coupon_code,
        ]);
        // return $orderPrice;
        if ($orderPrice['check_out']['total'] <= 0) {
            return response()->json(['message' => __('custom.your_cart_is_empty'), 'status_code' => 401], 401);
        }
        $userId = $user->id; //1; //$request->user->id; 
        $userAddressId = $request->input('user_address_id');
        $paymentMethod = $request->input('payment_method');
        // $paymentStatus = $request->input('payment_status');
        // $userAddress = UserAddress::find($userAddressId);
        // $emarat = Country::where('name_en', 'United Arab Emirates')->first();
        // $selectedCountry = Country::where('name', $userAddress->country)->orWhere('name_en', $userAddress->country)->first();
        // if ($emarat->id !=  $selectedCountry->id && $paymentMethod == "cash_on_delivery") {
        //     return response()->json(['message' => __('custom.cash_on_delivery_not_available'), 'status_code' => 401,], 401);
        // }
        try {
            DB::beginTransaction();
            $copon = Coupon::where('code', $request->coupon_code)->first();

            // Fetching cart items grouped by merchant
            $cartItemsGroupedByMerchant = CartItem::select('cart_items.user_id', 'cart_items.product_id', 'cart_items.quantity', 'products.user_id AS shope_id')
                ->join('products', 'cart_items.product_id', '=', 'products.id')
                ->where('cart_items.user_id', $userId)
                ->get()
                ->groupBy('shope_id');


            // return $cartItemsGroupedByMerchant;
            foreach ($cartItemsGroupedByMerchant as $shopeId => $items) {
                // Calculate order total for this merchant
                $subtotal = 0;
                foreach ($items as $item) {
                    $product = Product::find($item->product_id);
                    $subtotal += $product->price * $item->quantity;
                }

                // Inserting order for this merchant
                $orderId = DB::table('orders')->insertGetId([
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => $paymentMethod,
                    'currency' => 'aed',
                    'cancelled' => false,
                    'isrefund' => $orderPrice['check_out']['isrefund'],
                    'refound_money' => $orderPrice['check_out']['refound_money'] ?? 0,
                    'shipping' => $orderPrice['check_out']['total_shipping_fee'] ?? 0,
                    'tax' => 0,
                    'total_country_tax' => $orderPrice['check_out']['country_tax'] ?? 0,
                    'discount' => $orderPrice['check_out']['total_discount'] ?? 0,
                    'subtotal' => $subtotal,
                    'total' => $subtotal, // For simplicity, assuming no tax, shipping, or discount per merchant
                    'description' => $request->description,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'user_address_id' => $userAddressId,
                    'coupon_id' => $copon->id ?? null,
                    'shope_id' => $shopeId, // Assigning shope_id to the order
                ]);

                // Inserting order items for this merchant
                foreach ($items as $item) {
                    DB::table('order_items')->insert([
                        'order_id' => $orderId,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                    ]);
                }
            }



            // DB::table('order_items')->insert($orderItems);
            if ($paymentMethod != 'paypal' && $paymentMethod != 'stripe') {
                CartItem::where('user_id', $userId)->delete();
            }

            DB::commit();
            if ($paymentMethod == 'paypal') {
                // return redirect()->route('payment', [
                //     'orderItems' => $orderItems,
                //     'order_id' => $orderId,
                // ]);
            } else {
                // sendNotificationToAdmin('اضافة طلبيه', ' قام العميل ' . $user->name . ' بانشاء طلبيه جديده ' . ' معرف الطلبيه ' . $orderId, env("BASE_URL") . "/dashboard/orders/invoice/" . $orderId);
                // $user->refund -= $orderPrice['check_out']['refound_money'];
                // $user->save();
                return response()->json(['message' => __('custom.order_saved_successfully')], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'error' => $e->getMessage()], 500);
        }
    }
    function Reorder(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|integer',
            ]);
            $order = Order::find($request->order_id);
            if ($order->status == 'cancelled') {

                $order->cancelled = false;
                $order->status = 'pending';
                $order->save();
                return response()->json([
                    'message' => __("order_returned_processing"),
                    'status_code' => 200,
                ], 200);
            } else {
                return response()->json([
                    'message' => __("orde_not_closed"),
                    'status_code' => 501,
                ], 501);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('custom.failed_to_cancel_order'),
                'status_code' => 500,
            ], 500);
        }
    }
    function cancelOrder(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|integer',
            ]);
            $order = Order::find($request->order_id);
            $user = $request->user;
            if ($order->status == "pending") {
                $order->cancelled = true;
                $order->status = 'cancelled';
                $order->save();
                if ($order->payment_status != 'cash_on_delivery') {
                    $user->refund  =  $user->refund + $order->total;
                    $user->save();
                }
            }

            return response()->json([
                'message' => 'Success',
                'status_code' => 200,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('custom.failed_to_cancel_order'),
                'status_code' => 500,
            ], 500);
        }
    }
    public function calculateTotalAndPrices($cartItems, $coupon = 0)
    {
        $total_shipping_fee = 0.0;
        $total_discount = 0.0;
        $subtotal = 0.0;
        $total = 0.0;

        foreach ($cartItems as $item) {
            $total_shipping_fee += $item->shipping_fee * $item->quantity;
            $total_discount += $item->discount * $item->quantity;
            $subtotal += $item->price * $item->quantity;
        }

        $total = ($total_shipping_fee + $subtotal) - ($total_discount + $coupon);

        return response()->json([
            // 'prices' => [
            'total_shipping_fee' => $total_shipping_fee,
            'total_discount' => $total_discount,
            'subtotal' => $subtotal,
            'total' => $total,
            // ],
            // 'status_code' => 200
        ], 200);
    }
    function getUsersforAffalite(Request $request)
    {
        try {
            $user = $request->user;
            $users = User::where("referrer_id", $user->id)->get();

            return response()->json([
                'message' => 'Success',
                'status_code' => 200,
                "data" => $users,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('custom.failed_to_cancel_order'),
                'status_code' => 500,
            ], 500);
        }
    }
}
