<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class StoreManagerController extends Controller
{
    public function index()
    {
        // Fetch total sales
        $totalSales = Order::sum('total_price');

        // Fetch total orders
        $totalOrders = Order::count();

        // Fetch pending orders
        $pendingOrders = Order::where('status', 0)->count(); // 0 = Pending

        // Fetch total customers with role_as = 0
        $totalCustomers = User::where('role_as', 0)->count();

        // Fetch total categories
        $totalCategories = DB::table('categories')->count();

        // Fetch sales by product from order_items
        $salesByProduct = OrderItem::with('products')
            ->select('prod_id', DB::raw('SUM(price * qty) as total_sales'))
            ->groupBy('prod_id')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->products->name ?? 'Unknown Product',
                    'total_sales' => $item->total_sales,
                ];
            });

        // Fetch sales by category
        $salesByCategory = OrderItem::with(['products.category'])
            ->select('prod_id', DB::raw('SUM(price * qty) as total_sales'))
            ->groupBy('prod_id')
            ->get()
            ->groupBy(function($item) {
                return $item->products->cate_id; // Use cate_id to group
            })
            ->map(function($items, $cateId) {
                return [
                    'cate_id' => $cateId,
                    'name' => $items->first()->products->category->name ?? 'Unknown Category',
                    'total_sales' => $items->sum('total_sales'),
                ];
            });

        // Fetch order status counts
        $orderStatusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Fetch recent orders
        $recentOrders = Order::with('user')
            ->whereIn('status', [0, 1, 2]) // Pending, Completed, Cancelled
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

                 // Top selling products
        [$topSellingProductNames, $topSellingProductCounts, $topSellingProductTotalPurchases] = $this->getTopSellingProducts();

        // Count users by role
        $userRolesCount = User::select('role_as', DB::raw('count(*) as count'))
            ->groupBy('role_as')
            ->get()
            ->pluck('count', 'role_as');

            $dailySales = Order::whereDate('created_at', today())->sum('total_price');
            $weeklySales = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price');
            $monthlySales = Order::whereMonth('created_at', now()->month)->sum('total_price');
    
            // Fetch daily and weekly new customers
            $dailyNewCustomers = User::whereDate('created_at', today())->count();
            $weeklyNewCustomers = User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    
            // Fetch the number of new products
            $newProducts = DB::table('products')->where('created_at', '>=', now()->subMonth())->count();
    
            // Fetch completed orders
            $completedOrders = Order::where('status', 1)->count(); // 1 = Completed
    

        return view('admin.storemanager.index', compact(
            'totalSales',
            'totalOrders',
            'pendingOrders',
            'totalCustomers',
            'salesByProduct',
            'salesByCategory',
            'orderStatusCounts',
            'totalCategories',
            'userRolesCount',
                    'totalSales',
            'totalOrders',
            'totalCategories',
            'dailySales',
            'weeklySales',
            'monthlySales',
            'dailyNewCustomers',
            'weeklyNewCustomers',
            'newProducts',
            'completedOrders',
            'recentOrders',
            'userRolesCount',
            'topSellingProductNames',
            'topSellingProductCounts',
            'topSellingProductTotalPurchases', // Pass the user roles count to the view
        ));
    }
    private function getTopSellingProducts()
{
    $topSellingProducts = OrderItem::selectRaw('prod_id, SUM(qty) as total_qty, SUM(price * qty) as total_purchase')
        ->groupBy('prod_id')
        ->orderBy('total_qty', 'desc')
        ->take(5)
        ->get();

    $topSellingProductNames = [];
    $topSellingProductCounts = [];
    $topSellingProductTotalPurchases = [];

    foreach ($topSellingProducts as $item) {
        $product = Product::find($item->prod_id);
        if ($product) {
            $topSellingProductNames[] = $product->name;
            $topSellingProductCounts[] = $item->total_qty;
            $topSellingProductTotalPurchases[] = $item->total_purchase; // Add total purchase to the array
        }
    }

    return [$topSellingProductNames, $topSellingProductCounts, $topSellingProductTotalPurchases];
}
}