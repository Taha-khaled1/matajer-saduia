<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
   function __construct()
    {
         $this->middleware('permission:الصفحه الرئيسيه', ['only' => ['main','getStatistics']]);

    }
  public function main()
  {
    $totalProduct = Product::count();
    $totalCatogeries = Category::count();
    $totalSubCatogeries = SubCategory::count();
    $totalcountery = Country::count();
    $productUnActive = Product::where('status', 0)->count();
    $productActive = Product::where('status', 1)->count();
    $mostViewedProducts = Product::orderBy('views', 'desc')->limit(5)->get();
    $totalOrder = Order::count();
    $totalUser = User::count();
    $last5Customers = User::orderBy('created_at', 'desc')->take(5)->get();
    $totalRevenue = Order::where('status',"!=","cancelled")->sum('total');
    $topSellingProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sales'))
        ->groupBy('product_id')
        ->orderByDesc('total_sales')
        ->take(5) // Change this number to get more or fewer top-selling products
        ->get();
    $ordersBypayment_status= Order::select('payment_status', DB::raw('COUNT(*) as total_orders'))
        ->groupBy('payment_status')
        ->get();
    // If you need the product details, you can join the 'products' table
    $topSellingProductsWithDetails = $topSellingProducts->map(function ($item) {
        $product = Product::find($item->product_id);
        $item->product = $product;
        return $item;
    });
    $ordersByPaymentMethod = Order::select('payment_method', DB::raw('COUNT(*) as total_orders'))
      ->groupBy('payment_method')
      ->get();
    $cancelledOrders = Order::where('cancelled', true)->count();
    $Orderpendings = Order::where('status', 'pending')->count();
    $Ordercompleted = Order::where('status', 'completed')->count();
    $Ordercancelled = Order::where('status', 'cancelled')->count();
     $lastFiveOrders = Order::orderBy('created_at', 'desc')
                           ->limit(5)
                           ->get();



  

    //  return response([
    //    'ordersBypayment_status' => $ordersBypayment_status,
    //   'totalProduct' => $totalProduct,     
    //   'totalCatogeries' => $totalCatogeries,
    //   'totalSubCatogeries' => $totalSubCatogeries,
    //   'totalcountery' => $totalcountery,
    //   'productUnActive' => $productUnActive,
    //   'productActive' => $productActive,
    //   'mostViewedProducts' => $mostViewedProducts,
    //   'totalOrder' => $totalOrder,
    //   'totalUser' => $totalUser,
    //   'last5Customers' => $last5Customers,
    //   'totalRevenue' => $totalRevenue,
    //   'topSellingProducts' => $topSellingProducts,
    //   'ordersByPaymentMethod' => $ordersByPaymentMethod,
    //   'cancelledOrders' => $cancelledOrders,
    // ]);
    return view('dashboard.home.index', [
       'ordersBypayment_status' => $ordersBypayment_status,
      'totalProduct' => $totalProduct,     
      'totalCatogeries' => $totalCatogeries,
      'totalSubCatogeries' => $totalSubCatogeries,
      'totalcountery' => $totalcountery,
      'productUnActive' => $productUnActive,
      'productActive' => $productActive,
      'mostViewedProducts' => $mostViewedProducts,
      'totalOrder' => $totalOrder,
      'totalUser' => $totalUser,
      'last5Customers' => $last5Customers,
      'totalRevenue' => $totalRevenue,
      'topSellingProducts' => $topSellingProducts,
      'ordersByPaymentMethod' => $ordersByPaymentMethod,
      'cancelledOrders' => $cancelledOrders,
      'Ordercancelled' => $Ordercancelled,
      'Ordercompleted' => $Ordercompleted,
      'Orderpendings' => $Orderpendings,
      'lastFiveOrders' => $lastFiveOrders,
  
    ]);
  } 
     public function getStatistics()
    {
        $orders = Order::selectRaw('MONTH(created_at) as month, total, status')
            ->whereYear('created_at', date('Y'))
            ->get();

        $pending = [];
        $completed = [];
        $cancelled = [];
        $categories = [];

        // Initialize an array to store data for each month
        $monthsData = array_fill(1, 12, null);

        foreach ($orders as $order) {
            $month = (int)$order->month;
            $total = $order->total;
            $status = $order->status;

            // Assign the total to the corresponding month and status in the array
            if ($status == 'pending') {
                $pending[$month] = $total;
            } elseif ($status == 'completed') {
                $completed[$month] = $total;
            } elseif ($status == 'cancelled') {
                $cancelled[$month] = $total;
            }

            // We store all months' data to ensure that all categories are covered
            $monthsData[$month] = $total;
        }

        // Populate the data arrays and missing categories
        for ($month = 1; $month <= 12; $month++) {
            $categories[] = date('M', mktime(0, 0, 0, $month, 1)); // Get month abbreviation (Jan, Feb, etc.)

            // If there is no data for a specific status in a month, set it to 0
            $pendingg[] = $pending[$month] ?? 0;
            $completedd[] = $completed[$month] ?? 0;
            $cancelledd[] = $cancelled[$month] ?? 0;
        }

        $data = [
            'pendingg' => $pendingg,
            'completedd' => $completedd,
            'cancelledd' => $cancelledd,
            'categories' => $categories,
        ];

        return response()->json($data)->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}