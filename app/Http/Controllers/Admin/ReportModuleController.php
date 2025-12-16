<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class ReportModuleController extends Controller
{
    public function index()
    {
        // Count total users and products
        $userCount = User::count();
        $productCount = Product::count();
    
        // Fetch total sales
        $totalSales = Order::sum('total_price');
        
        // Calculate total products sold
        $productsSold = Order::with('orderItems')->get()->sum(function ($order) {
            return $order->orderItems->sum('qty');
        });
    
        // Get current stock on hand value in pesos (using selling_price)
        $inStockProducts = Product::where('qty', '>', 0)->get();
        $totalInStockValue = $inStockProducts->sum(function ($product) {
            return $product->selling_price * $product->qty; // Calculate total value based on selling price
        });
    
        // Calculate total value of out-of-stock products
        $outOfStockProducts = Product::where('qty', 0)->pluck('id');
        $totalOutOfStockValue = OrderItem::whereIn('prod_id', $outOfStockProducts)->sum(\DB::raw('price * qty'));
    
        // Fetch low stock products
        $lowStockProducts = Product::where('qty', '<', 3)->get();
    
        // Fetch recent purchase orders (latest 10)
        $recentPurchaseOrders = Order::with('user')->latest()->take(10)->get();
    
        // Track daily progress for total sales, new users, and checkouts
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dailyStats[$date] = [
                'sales' => Order::whereDate('created_at', $date)->sum('total_price'),
                'newUsers' => User::whereDate('created_at', $date)->count(),
                'checkouts' => Order::whereDate('created_at', $date)->count(),
            ];
        }
    
        // Fetch all orders
        $allOrders = Order::with('user')->get();
    
        // Fetch all products
        $products = Product::all();
        
        // Fetch all users
        $users = User::all();
    
        // Fetch least purchased products
        $leastPurchasedProducts = Product::with('orderItems')
            ->get()
            ->sortBy(function ($product) {
                return $product->orderItems->sum('qty'); // Use the relationship here
            })
            ->take(10); // Adjust the count as needed
    
        // Fetch most reviewed products
        $mostReviewedProducts = Product::withCount('reviews') // Assuming 'reviews' is the relationship
            ->orderBy('reviews_count', 'desc')
            ->take(10) // Adjust the count as needed
            ->get();

        // Fetch most rated products
        $mostRatedProducts = Product::with('ratings') // Assuming 'ratings' is the relationship
            ->get()
            ->sortByDesc(function ($product) {
                return $product->ratings->avg('stars_rated'); // Use 'stars_rated' from the Rating model
            })
            ->take(10); // Adjust the count as needed

        // Fetch most viewed products
        $mostViewedProducts = Product::orderBy('view_count', 'desc')
            ->take(10) // Adjust the count as needed
            ->get();

        // Calculate weekly sales (last 7 days)
        $weeklySales = Order::where('created_at', '>=', now()->subDays(7))->sum('total_price');

        // Calculate monthly sales (last 30 days)
        $monthlySales = Order::where('created_at', '>=', now()->subDays(30))->sum('total_price');

        return view('admin.reportmodule', compact(
            'userCount',
            'productCount',
            'totalSales',
            'productsSold',
            'totalInStockValue',
            'totalOutOfStockValue',
            'lowStockProducts',
            'recentPurchaseOrders',
            'allOrders',
            'dailyStats',
            'products',
            'users',
            'leastPurchasedProducts',
            'inStockProducts',
            'mostReviewedProducts',
            'mostRatedProducts', // Include most rated products
            'mostViewedProducts', // Include most viewed products
            'weeklySales', // Include weekly sales
            'monthlySales' // Include monthly sales
        ));
    }
}