<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch orders with various statuses (Pending, Preparing, Ready to Deliver, Shipped, Cancelled)
        $orders = Order::whereIn('status', ['0', '1', '2', '3', '4', '5'])->get();

        // Calculate sales statistics
        $dailySales = Order::whereDate('created_at', Carbon::today())->sum('total_price');
        $weeklySales = Order::where('created_at', '>=', Carbon::now()->subDays(7))->sum('total_price');
        $monthlySales = Order::where('created_at', '>=', Carbon::now()->subDays(30))->sum('total_price');

        return view('admin.orders.index', compact('orders', 'dailySales', 'weeklySales', 'monthlySales'));
    }

    public function view($id)
    {
        // Fetch a specific order by ID
        $orders = Order::with('orderitems.products')->find($id);
        return view('admin.orders.view', compact('orders'));
    }

    public function updateorder(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'order_status' => 'required|in:0,1,2,3,4,5', // Ensure the status is one of the allowed values
        ]);

        // Find the order by ID and update the status
        $orders = Order::find($id);
        if ($orders) {
            $orders->status = $request->input('order_status');
            $orders->save(); // Use save() instead of update() for clarity
        }

        return redirect('orders')->with('status', "Order Updated Successfully");
    }

    public function orderhistory()
    {
        // Fetch orders with status '1' (Completed)
        $orders = Order::where('status', '1')->get();
        return view('admin.orders.history', compact('orders'));
    }

    public function promoteOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.']);
        }

        $newStatus = $request->input('newStatus');
        $order->status = $newStatus;
        $order->save();

        return response()->json(['success' => true]);
    }

    public function demoteOrder(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found.']);
        }

        $newStatus = $request->input('newStatus');
        $order->status = $newStatus;
        $order->save();

        return response()->json(['success' => true]);
    }

    public function cancelOrder(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|integer|min:0|max:4', // Validate the reason
        ]);

        $order = Order::with('orderitems.products')->find($id); // Eager load order items with products

        if ($order) {
            // Loop through each order item and update the stock quantity
            foreach ($order->orderitems as $item) {
                $product = $item->products; // Get the product
                $product->qty += $item->qty; // Increase the stock quantity
                $product->save(); // Save the updated product
            }

            // Set order status to Cancelled
            $order->status = 5; // Assuming '5' is the status for Cancelled
            $order->cancellation_reason = $request->reason; // Update cancellation reason
            $order->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }

    public function reorder($orderId)
    {
        // Check if the user has placed any orders
        $userOrders = Order::where('user_id', Auth::id())->count();
        
        if ($userOrders === 0) {
            return redirect()->route('/')->with('error', 'No previous orders found to reorder.');
        }
    
        // Fetch order items associated with the given order ID
        $orderItems = OrderItem::where('order_id', $orderId)->get();
        
        // Check if any order items were found
        if ($orderItems->isEmpty()) {
            return redirect()->back()->with('error', 'No items found for this order.');
        }
        
        // Store current cart items before clearing
        $currentCartItems = Cart::where('user_id', Auth::id())->get();
    
        // Check stock availability
        $insufficientStock = [];
        foreach ($orderItems as $item) {
            $product = Product::find($item->prod_id);
            if (!$product || $product->qty < $item->qty) {
                $insufficientStock[] = $product->name ?? 'Product ID ' . $item->prod_id; // Capture product name or ID
            }
        }
    
        // If any products are out of stock or insufficient quantity, restore the current cart items
        if (!empty($insufficientStock)) {
            // Restore current cart items
            foreach ($currentCartItems as $cartItem) {
                $existingCartItem = Cart::where('prod_id', $cartItem->prod_id)
                                        ->where('user_id', Auth::id())
                                        ->first();
    
                if ($existingCartItem) {
                    $existingCartItem->prod_qty += $cartItem->prod_qty; // Restore quantity
                    $existingCartItem->save();
                } else {
                    // Create new cart item to restore
                    $newCartItem = new Cart();
                    $newCartItem->prod_id = $cartItem->prod_id;
                    $newCartItem->user_id = Auth::id();
                    $newCartItem->prod_qty = $cartItem->prod_qty;
                    $newCartItem->save();
                }
            }
    
            return redirect()->back()->with('error', 'Cannot reorder: Insufficient stock for ' . implode(', ', $insufficientStock));
        }
    
        // Clear existing cart items for the user
        Cart::where('user_id', Auth::id())->delete();
        
        // Add items to the cart
        foreach ($orderItems as $item) {
            // Now add to the cart
            $cartItem = Cart::where('prod_id', $item->prod_id)
                            ->where('user_id', Auth::id())
                            ->first();
    
            if ($cartItem) {
                // If item exists, update the quantity
                $cartItem->prod_qty += $item->qty;
                $cartItem->save();
            } else {
                // If item does not exist, create a new cart item
                $newCartItem = new Cart();
                $newCartItem->prod_id = $item->prod_id;
                $newCartItem->user_id = Auth::id();
                $newCartItem->prod_qty = $item->qty;
                $newCartItem->save();
            }
        }
    
        // Redirect to the checkout page
        return redirect()->route('checkout'); // Ensure this route is defined
    }
}