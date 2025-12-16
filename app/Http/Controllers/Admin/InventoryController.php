<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InventoryController extends Controller
{
    public function index()
    {
        // Fetch total products and other necessary data
        $totalProducts = Product::count();
        $totalInventoryValue = Product::sum(\DB::raw('qty * selling_price'));
        $totalSalesThisMonth = OrderItem::whereMonth('created_at', now()->month)->sum('price');

        // Fetch low stock products
        $lowStockProducts = Product::where('qty', '<', 3)->get();
        $lowStockCount = $lowStockProducts->count();
        $outOfStockCount = Product::where('qty', 0)->count();
        $inStock = Product::where('qty', '>', 0)->count();

        // Calculate top-selling products
        [$topSellingProductNames, $topSellingProductCounts, $topSellingProductTotalPurchases] = $this->getTopSellingProducts();

        // Fetch new products added in the last 30 days
        $newProducts = Product::where('created_at', '>=', now()->subDays(30))->get();

        // Prepare data for product overview charts
        $productOverview = [
            'in_stock' => $inStock,
            'out_of_stock' => $outOfStockCount,
            'low_stock' => $lowStockCount,
        ];

        // Fetch stock movement data for the last 30 days
        $stockMovement = [];
        $dates = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::today()->subDays($i);
            $dates[] = $date->format('Y-m-d');

            // Calculate the total stock quantity for all products on that date
            $stockQuantity = Product::whereDate('created_at', '<=', $date)->sum('qty');
            $stockMovement[] = $stockQuantity;
        }

        // Return the view with all necessary data
        return view('admin.inventory.index', compact(
            'totalProducts',
            'totalInventoryValue',
            'totalSalesThisMonth',
            'lowStockCount',
            'outOfStockCount',
            'lowStockProducts',
            'topSellingProductNames',
            'topSellingProductCounts',
            'topSellingProductTotalPurchases',
            'newProducts',
            'productOverview',
            'stockMovement',
            'dates',
            'inStock' // A // Include dates for the chart
        ));
    }

    private function getTopSellingProducts()
    {
        // Fetch top-selling products based on quantity sold
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
                $topSellingProductTotalPurchases[] = $item->total_purchase;
            }
        }

        // Ensure we return empty arrays if no products found
        return [
            $topSellingProductNames ?: [],
            $topSellingProductCounts ?: [],
            $topSellingProductTotalPurchases ?: []
        ];
    }
}