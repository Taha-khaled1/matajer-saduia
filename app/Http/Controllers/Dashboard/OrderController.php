<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BranchCompany;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Withdrawal;
use App\Traits\WhatsAppTrait;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use WhatsAppTrait;
    function __construct()
    {

        // $this->middleware('permission:جميع الطلبيات', ['only' => ['index', 'pendingOrders', 'processingOrders', 'deliveringOrders', 'completedOrders', 'changePaymentStatus', 'changeOrderStatus', 'changeDeliveryTime']]);
        //  $this->middleware('permission:طباعة الطلبيه', ['only' => ['printInvoice']]);
        // $this->middleware('permission:حذف الطلبيه', ['only' => ['destroy']]);
        // $this->middleware('permission:عرض الطلبيه', ['only' => ['printInvoice']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $orders = Order::all();
        return view('dashboard.order.index', compact('orders'));
    }
    public function spacialOrderIndex()
    {
        $orders = Order::where("shope_id", "=", Auth::user()->id)->get();
        return view('dashboard.order.index', compact('orders'));
    }
    public function pendingOrders()
    {
        $orders = Order::where("status", "pending")->get();
        return view('dashboard.order.index', compact('orders'));
    }
    public function processingOrders()
    {
        $orders = Order::where("status", "processing")->get();
        return view('dashboard.order.index', compact('orders'));
    }

    public function deliveringOrders()
    {
        $orders = Order::where("status", "delivering")->get();
        return view('dashboard.order.index', compact('orders'));
    }

    public function completedOrders()
    {
        $orders = Order::where("status", "completed")->get();
        return view('dashboard.order.index', compact('orders'));
    }


    public function printInvoice($id)
    {
        $setting = Setting::select('logo', 'email', 'company_phone', 'company_address')->first();

        $order = Order::with('user', 'coupon', 'orderItems', 'orderItems.product')->find($id);

        return view('dashboard.order.invoice', compact('order', 'setting'));
        // compact('order','setting')
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function changePaymentStatus(Request $request)
    {
        $order = Order::find($request->id);
        $user = User::find($order->user_id);
        $shope = User::find($order->shope_id);
        $order->payment_status = $request->payment_status;
        $order->save();
        if ($request->payment_status == "shipped") {
            $this->sendWhatsapp($user->phone, $this->orderShipping($user->name, $order->id, $order->delivery_number ?? $order->id));
            $this->sendWhatsapp($user->phone, $this->orderShipped($shope->name, $order->id));
        } elseif ($request->payment_status == "delivering") {
            $this->sendWhatsapp($user->phone, $this->orderDelivery($user->name, $order->id, $order->delivery_number ?? $order->id));
        } elseif ($request->payment_status == "completed") {
            $this->sendWhatsapp($user->phone, $this->returnShippingPolicyIssuedForCustomer($user->name, $order->id, $order->delivery_number ?? $order->id));
            $this->sendWhatsapp($user->phone, $this->orderDelivered($shope->name, $order->id));
        } elseif ($request->payment_status == "bill_lading") {
            $this->sendWhatsapp($user->phone, $this->shippingPolicyIssued($shope->name, $order->bill_lading_number ?? $order->delivery_number ?? $order->id, $order->id));
        }
        session()->flash('Add', 'تم تعديل حالة الدفع بنجاح');
        return back();
    }





    public function changeOrderStatus(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = $request->status;
        $order->save();
        session()->flash('Add', 'تم تعديل حالة الطلبيه بنجاح');
        return back();
    }



    public function changeDeliveryTime(Request $request)
    {
        $validatedData = $request->validate([
            'delivery_time' => 'required|date',
        ]);


        $order = Order::find($request->id);
        $order->update($validatedData);
        session()->flash('Add', 'تم تعديل حالة التوصيل بنجاح');
        return back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $usersWithCartItems = User::has('cartItems')->with('cartItems.product', 'cartItems.attribute')->get();
        return view("dashboard.user.cart-users", compact("usersWithCartItems"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function uploadMotalpa()
    {
        $orders = Order::where("shope_id", Auth::user()->id)
            ->where("payment_method", "tap")
            ->whereDate('created_at', '>=', now()->subDays(3))
            ->get();
        if (count($orders) < 1) {
            session()->flash('delete', 'لا يوجد طلبات تمت');
            return redirect()->route('orders')->with('success', 'orders deleted successfully');
        }



        $shippingTotal = 0;
        $discountTotal = 0;
        $subtotalTotal = 0;
        $totalTotal = 0;

        foreach ($orders as $order) {
            $shippingTotal += $order->shipping;
            $discountTotal += $order->discount;
            $subtotalTotal += $order->subtotal;
            $totalTotal += $order->total;
        }
        $withdrawal = new Withdrawal;
        $withdrawal->total = $totalTotal;
        $withdrawal->type = "suspended";
        $withdrawal->user_id = Auth::user()->id;
        $withdrawal->save();
        // $withdrawal->id = md5(uniqid('', true));
        session()->flash('delete', 'تم رفع المطالبه بنجاح ');
        return redirect()->route('orders')->with('success', 'orders deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $order = Order::find($request->id);
        $order->delete();
        session()->flash('delete', 'تم حذف الطلبيه بنجاح ');
        return redirect()->route('orders')->with('success', 'orders deleted successfully');
    }











    public function createShipment(Request $request, $id)
    {
        $order = Order::with('orderItems.product')->find($id);
        // return $order->orderItems;
        // return $order['order_items'];
        $pickupAddress = BranchCompany::find(1);
        // return $pickupAddress;
        $dropOffAddress = UserAddress::find($order->user_id);
        $user = User::find($order->user_id);
        $url = 'https://server2-api.vision-log.com/matajer?token=' . env("FIGEN");
        $pickupUser = Auth::user();
        $totalWeight = 0;
        $items = [];
        $token = '664f15d1db303eb79e314231cc33a9d5a3d29fd0'; // Replace with your actual token (ensure it's kept confidential)
        $url = 'https://server2-api.vision-log.com/matajer?token=' . $token;
        $i = 0;
        foreach ($order->orderItems as $orderItem) {
            $totalWeight += $orderItem->product->weight * $orderItem->quantity;

            $items[] = [
                'englishName' => (string) $orderItem->product->name_en,
                'itemType' => '',
                'itemName' => (string)  $orderItem->product->name_ar,
                'itemValue' => (string)  $orderItem->product->final_price * $orderItem->quantity . '',
            ];
        }

        // return $items;

        $data = [
            'reciever' => [
                'address' => $dropOffAddress->address_1,
                'street' => $dropOffAddress->address_1,
                'city' => $dropOffAddress->city,
                'mobile' => $pickupUser->phone ?? "50000000",
                'mailBox' => null,
                'phone' => $pickupUser->phone ?? "50000000",
                'countryCode' => 'SA',
                'name' => $user->name,
                'company' => null,
                'postCode' => $dropOffAddress->zip,
                'prov' => 'Makkah Province',
            ],
            'sender' => [
                'address' => $pickupAddress->adress ?? '',
                'street' => null,
                'city' => $pickupAddress->city ?? "",
                'mobile' => $pickupUser->phone ?? "50000000",
                'mailBox' => null,
                'phone' => $pickupUser->phone ?? "50000000",
                'countryCode' => 'SA',
                'name' => $pickupUser->name,
                'company' => null,
                'postCode' => null,
                'prov' => 'Riyadh Province',
            ],
            'items' => ($items),
            'weight' =>  $totalWeight,
        ];

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post($url, [
                'json' => $data,
            ]);

            if ($response->getStatusCode() === 200) {
                // Handle successful response (parse JSON, etc.)
                $responseData = json_decode($response->getBody(), true);
                // ... process response data
                session()->flash('Add', ' تم ارسال الطلبيه بنجاح');
                return back();
            } else {
                // Handle error response
                return response()->json([
                    'message' => 'API request failed with status code ' . $response->getStatusCode(),
                ], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            session()->flash('delete', 'لم يتم ارسال الطلبيه');
            return back();
        }
    }
}
