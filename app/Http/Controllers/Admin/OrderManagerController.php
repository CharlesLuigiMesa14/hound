<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderManagerController extends Controller
{
    public function index()
    {
        // Total Orders
        $totalOrders = Order::count();

        // Counting pending orders where status is 0
        $pendingOrders = Order::where('status', 0)->count();

        // Counting completed orders where status is 1
        $completedOrders = Order::where('status', 1)->count();

        // Counting preparing orders where status is 2
        $preparingOrders = Order::where('status', 2)->count();

        // Counting ready for delivery orders where status is 3
        $readyForDeliveryOrders = Order::where('status', 3)->count();

        // Counting shipped orders where status is 4
        $shippedOrders = Order::where('status', 4)->count();

        // Counting cancelled orders where status is 5
        $cancelledOrders = Order::where('status', 5)->count();

        // Fetch recent orders (for example, last 5 orders)
        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get();

        // Fetch monthly order totals
        $monthlyOrders = DB::table('orders')
            ->select(DB::raw('MONTH(created_at) as month, COUNT(*) as total_orders, DATE_FORMAT(created_at, "%M") as month_name'))
            ->groupBy('month', 'month_name')
            ->orderBy('month')
            ->get();

        // Fetch daily order totals for the last 7 days
        $dailyOrders = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as date, COUNT(*) as total_orders'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Calculate average order value
        $averageOrderValue = $recentOrders->avg('total_price');

        // Count payment methods
        $paymentMethodCounts = [
            'cash' => Order::where('payment_mode', 'COD')->count(),
            'paypal' => Order::where('payment_mode', 'Paid by Paypal')->count(),
        ];

        return view('admin.ordermanager.index', compact(
            'totalOrders', 
            'pendingOrders', 
            'completedOrders', 
            'preparingOrders', 
            'readyForDeliveryOrders', 
            'shippedOrders', 
            'cancelledOrders', 
            'recentOrders', 
            'monthlyOrders', 
            'dailyOrders', 
            'averageOrderValue', 
            'paymentMethodCounts'
        ));
    }
}