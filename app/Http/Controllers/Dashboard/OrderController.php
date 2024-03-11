<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
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
        $order->payment_status = $request->payment_status;
        $order->save();
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
        $usersWithCartItems =  User::has('cartItems')->with('cartItems.product', 'cartItems.attribute')->get();
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
        $withdrawal->type =  "suspended";
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
}
