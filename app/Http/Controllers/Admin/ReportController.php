<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class ReportController extends Controller
{
    public function index()
    {
        // Count only users with role_as equivalent to 0 (assuming 0 represents customers)
        $userCount = User::where('role_as', 0)->count();
        $productCount = Product::count();

        // Fetch daily checkouts and sales for the current week (Monday to Sunday)
        $dailyCheckoutsData = $this->getDailyCheckouts();
        $dailySalesData = $this->getDailySales();

        // Calculate percentage changes
        $checkoutChange = $this->calculatePercentageChange($dailyCheckoutsData);
        $salesChange = $this->calculatePercentageChange($dailySalesData);

        // Calculate yesterday's checkouts and sales
        $yesterdayCheckouts = $dailyCheckoutsData[now()->subDay()->format('Y-m-d')] ?? 0;
        $yesterdaySales = $dailySalesData[now()->subDay()->format('Y-m-d')] ?? 0;

        // Handle percentage change for yesterday's data
        $yesterdayCheckoutChange = $this->calculateYesterdayPercentageChange($yesterdayCheckouts, $checkoutChange);
        $yesterdaySalesChange = $this->calculateYesterdayPercentageChange($yesterdaySales, $salesChange);

        // Calculate today's checkouts and sales for percentage change
        $todayCheckouts = $dailyCheckoutsData[now()->format('Y-m-d')] ?? 0;
        $todaySales = $dailySalesData[now()->format('Y-m-d')] ?? 0;

        // Calculate today's percentage change from yesterday
        $todayCheckoutPercentageChange = $this->calculateTodayPercentageChange($yesterdayCheckouts, $todayCheckouts);
        $todaySalesPercentageChange = $this->calculateTodayPercentageChange($yesterdaySales, $todaySales);

        // Count new users registered today
        $newUsers = User::where('role_as', 0)->whereDate('created_at', now())->count();
        // Count returning users (total users - new users)
        $returningUsers = $userCount - $newUsers;

        // Count products in different stock statuses
        $inStock = Product::where('qty', '>', 0)->count();
        $outOfStockCount = Product::where('qty', 0)->count();
        $lowStockCount = Product::where('qty', '<', 3)->where('qty', '>', 0)->count();
        $lowStockProducts = Product::where('qty', '<', 3)->get();

        // Top 5 users based on orders, filtered for role_as 0
        $users = User::where('role_as', 0)
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Weekly sales data for the last 4 weeks
        $weeklySalesData = $this->getWeeklySalesData();

        // Check if it's Monday, if so reset weekly sales data
        if (now()->isMonday()) {
            $weeklySalesData = array_fill(0, 4, 0); // Reset to default values
        }

        // Total weekly sales and its change
        $totalWeeklySales = array_sum($weeklySalesData);
        $totalWeeklySalesChange = $this->calculatePercentageChange($weeklySalesData);

        // Top selling products
        [$topSellingProductNames, $topSellingProductCounts, $topSellingProductTotalPurchases] = $this->getTopSellingProducts();

        // Fetch new products
        $newProducts = Product::where('created_at', '>=', now()->subDays(30))->get();

        // Purchase orders data aligned with dates
        $purchaseOrdersData = $this->getPurchaseOrdersData();

        // Calculate additional statistics
        $totalPurchaseOrders = Order::where('created_at', '>=', now()->subMonth())->count();
        $averageOrdersPerDay = $totalPurchaseOrders > 0 ? $totalPurchaseOrders / 30 : 0;
        $highestOrdersInADay = $this->getHighestOrdersInADay();

        // Ensure all dates in the last month are represented
        $purchaseOrdersData = $this->fillMissingDates($purchaseOrdersData);

        // Get current month and week
        $currentMonth = now()->format('F Y');
        $currentWeek = now()->weekOfYear;

        $weeklyNewUsers = User::where('role_as', 0)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return view('admin.index', compact(
            'userCount',
            'productCount',
            'dailyCheckoutsData',
            'dailySalesData',
            'checkoutChange',
            'salesChange',
            'newUsers',
            'returningUsers',
            'weeklyNewUsers',
            'inStock',
            'outOfStockCount',
            'lowStockCount',
            'lowStockProducts',
            'users',
            'weeklySalesData',
            'totalWeeklySales',
            'totalWeeklySalesChange',
            'topSellingProductNames',
            'topSellingProductCounts',
            'topSellingProductTotalPurchases',
            'newProducts', // Pass new products to the view
            'purchaseOrdersData',
            'totalPurchaseOrders',
            'averageOrdersPerDay',
            'highestOrdersInADay',
            'currentMonth',
            'currentWeek',
            'yesterdayCheckoutChange',
            'yesterdaySalesChange',
            'todayCheckoutPercentageChange',
            'todaySalesPercentageChange'
        ));
    }

    private function getDailyCheckouts()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $dailyCheckouts = $this->initializeDailyArray($startOfWeek, $endOfWeek);

        $checkoutsData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->pluck('total_orders', 'date');

        foreach ($checkoutsData as $date => $total) {
            $dailyCheckouts[$date] = $total;
        }

        return $dailyCheckouts; 
    }

    private function getDailySales()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $dailySales = $this->initializeDailyArray($startOfWeek, $endOfWeek);

        $salesData = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->pluck('total', 'date');

        foreach ($salesData as $date => $total) {
            $dailySales[$date] = $total;
        }

        return $dailySales; 
    }

    private function getWeeklySalesData()
    {
        return Order::selectRaw('WEEK(created_at, 1) as week, SUM(total_price) as total')
            ->where('created_at', '>=', now()->subWeeks(4))
            ->groupBy('week')
            ->orderBy('week')
            ->pluck('total')
            ->toArray();
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

    private function getPurchaseOrdersData()
    {
        return Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total_orders', 'date')
            ->toArray();
    }

    private function getHighestOrdersInADay()
    {
        return Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders')
            ->groupBy('date')
            ->orderBy('total_orders', 'desc')
            ->pluck('total_orders')
            ->first() ?: 0;
    }

    private function calculatePercentageChange($data)
    {
        if (count($data) < 2) return 0; // Not enough data for comparison

        $first = reset($data);
        $last = end($data);

        if ($first == 0 && $last == 0) return 0; // No change if both are zero
        if ($first == 0) return ($last > 0) ? 100 : -100; // From 0 to positive or negative
        return (($last - $first) / abs($first)) * 100; // Standard percentage change
    }

    private function calculateYesterdayPercentageChange($yesterdayValue, $currentValue)
    {
        if ($yesterdayValue === 0 && $currentValue === 0) {
            return 0; // No change
        } elseif ($yesterdayValue === 0) {
            return ($currentValue > 0) ? 100 : -100; // From 0 to something
        }

        return (($currentValue - $yesterdayValue) / abs($yesterdayValue)) * 100;
    }

    private function calculateTodayPercentageChange($yesterdayValue, $todayValue)
    {
        if ($yesterdayValue === 0 && $todayValue === 0) {
            return 0; // No change
        } elseif ($yesterdayValue === 0) {
            return ($todayValue > 0) ? 100 : -100; // From 0 to something
        }

        return (($todayValue - $yesterdayValue) / abs($yesterdayValue)) * 100;
    }

    private function fillMissingDates($data)
    {
        $filledData = [];
        $start = now()->startOfWeek()->startOfDay();
        $end = now()->endOfWeek()->endOfDay();

        while ($start <= $end) {
            $dateKey = $start->format('Y-m-d');
            $filledData[$dateKey] = $data[$dateKey] ?? 0; // Default to 0 if missing
            $start->addDay();
        }

        return array_values($filledData); // Return values as indexed array
    }

    private function initializeDailyArray($start, $end)
    {
        $dailyArray = [];
        $currentDate = $start->copy();

        while ($currentDate <= $end) {
            $dailyArray[$currentDate->format('Y-m-d')] = 0; // Default to 0
            $currentDate->addDay();
        }

        return $dailyArray;
    }
}