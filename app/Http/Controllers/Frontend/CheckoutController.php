<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon; // Import the Coupon model
use App\Models\CouponUser; // Import the CouponUser model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {

        
        // Fetch cart items for the authenticated user
        $old_cartitems = Cart::where('user_id', Auth::id())->get();

        // Get product IDs and quantities from the cart
        $productIds = $old_cartitems->pluck('prod_id')->toArray();
        $quantities = $old_cartitems->pluck('prod_qty', 'prod_id')->toArray();

        // Fetch products that are still available in stock
        $products = Product::whereIn('id', $productIds)
            ->whereIn('id', function($query) use ($quantities) {
                $query->select('id')
                      ->from('products')
                      ->whereRaw('qty >= ?', [1]); // Ensure products are in stock
            })
            ->get();

        // Remove items from cart that are no longer available
        foreach ($old_cartitems as $item) 
        {
            if (!in_array($item->prod_id, $products->pluck('id')->toArray())) {
                Cart::where('user_id', Auth::id())->where('prod_id', $item->prod_id)->delete();
            }
        }

        // Get the updated cart items
        $cartitems = Cart::where('user_id', Auth::id())->get();

        // Calculate the total price of items in the cart
        $total = $cartitems->sum(function ($item) {
            return $item->products->selling_price * $item->prod_qty;
        });

        // Fetch available coupons
        $coupons = Coupon::where(function($query) {
            $query->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
        })->where(function($query) {
            $query->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
        })->get();

        // Pass the cart items, total, and coupons to the view
        return view('frontend.checkout', compact('cartitems', 'total', 'coupons'));
    }

    public function placeorder(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'fname' => 'required|string|max:50',
            'lname' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'pincode' => 'required|string',
            'payment_mode' => 'required|string',
            'delivery_fee' => 'required|numeric',
        ]);
        
        // Create a new order instance
        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address1 = $request->input('address1');
        $order->address2 = $request->input('address2');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->country = $request->input('country');
        $order->pincode = $request->input('pincode');
        $order->payment_mode = $request->input('payment_mode');
        
        // Calculate total from cart items
        $cartitems_total = Cart::where('user_id', Auth::id())->get();
        $total = $cartitems_total->sum(function ($item) {
            return $item->products->selling_price * $item->prod_qty;
        });
        
        // Get the delivery fee from the request
        $deliveryFee = (float) $request->input('delivery_fee', 0);
        
        // Initialize discount value
        $discountValue = 0;

        // Fetch the coupon if it's applied
        if (session()->has('applied_coupon')) {
            $coupon = Coupon::find(session('applied_coupon'));
            if ($coupon) {
                $discountValue = $coupon->discount_amount; // Assuming the coupon has a discount_amount field
                $order->applied_coupon = $coupon->code; // Assuming the coupon has a code field
            }
        }

        // Calculate grand total
        $grandTotal = $total + $deliveryFee;

        // Ensure grand total is not negative
        $grandTotal = max(0, $grandTotal);
        
        // Assign the grand total to the order
        $order->total_price = $grandTotal;
        $order->discount_amount = $discountValue; // Store the discount amount
        $order->tracking_no = 'hound' . rand(000001, 999999);
        $order->save();
        
        // Save order items
        foreach ($cartitems_total as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);

            // Update product quantity
            $prod = Product::find($item->prod_id);
            if ($prod) {
                $prod->qty -= $item->prod_qty;
                $prod->save();
            }
        }

        // Check if a coupon was applied and increment usage
        if (session()->has('applied_coupon')) {
            $couponId = session('applied_coupon');
            $coupon = Coupon::find($couponId);
            if ($coupon) {
                // Increment usage count
                $coupon->increment('usage_count');

                // Create a record in the coupon_user table
                CouponUser::create([
                    'coupon_id' => $coupon->id,
                    'user_id' => Auth::id(),
                ]);
            }

            // Clear the session variable
            session()->forget('applied_coupon');
        }

        // Clear cart items
        Cart::where('user_id', Auth::id())->delete();

        if ($request->input('payment_mode') == "Paid by Paypal") {
            return response()->json(['status' => "Order placed successfully", 'grand_total' => $grandTotal]);
        }
        return redirect('/')->with('status', "Order placed successfully");
    }
}