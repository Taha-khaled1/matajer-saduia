<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\UserReview;
use DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $setting = Setting::where('isadmin', true)->first();
        return response()->json([
            'setting' => $setting,
            'message' => 'Success',
            'status_code' => 200
        ], 200);
    }

    public function shopDetalis($id)
    {
        $setting = Setting::where('id', $id)->first();
        $merchantId = $setting->user_id;
        $products = Product::where('user_id', '=', $merchantId)->activeAndSorted()->take(10)->get();
        $totalProducts = Product::where('user_id', $merchantId)->count();

        // $totalviews = Product::where('user_id', $merchantId)->sum('views');

        $totalRevenue = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', "!=", "orders.cancelled")
            ->where('products.user_id', $merchantId)
            ->sum(DB::raw('order_items.quantity * products.price'));
        $averageRating = UserReview::where('vendor_id', $merchantId)->avg('rating');
        $totalSales = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'cancelled')
            ->where('products.user_id', $merchantId)
            ->sum('order_items.quantity');
        $reviews = UserReview::with('user')->where('vendor_id', $merchantId)->get();

        return response()->json([
            'totalProducts' => $totalProducts,
            'totalSales' => $totalSales,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'totalRevenue' => $totalRevenue,
            'shop' => $setting,
            'products' => $products,
            'message' => 'Success',
            'status_code' => 200
        ], 200);
    }
}
