<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Cart;
use App\Models\CouponUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function create()
    {
        return view('layouts.inc.create_coupon');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'discount_amount' => 'required|numeric',
            'discount_type' => 'required|in:fixed,percentage',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'max_usage' => 'nullable|integer|min:1',
            'max_usage_per_user' => 'nullable|integer|min:1',
            'min_checkout_amount' => 'nullable|numeric|min:0',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Coupon::create(array_merge($request->all(), ['usage_count' => 0]));

        return redirect()->back()->with('success', 'Coupon created successfully.');
    }

    public function validateCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', $request->code)
            ->where(function ($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->first();

        if ($coupon) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
            $totalCheckoutAmount = $cartItems->sum(function ($item) {
                return $item->products->selling_price * $item->prod_qty;
            });

            // Check for minimum checkout amount
            if ($coupon->min_checkout_amount && $coupon->min_checkout_amount > $totalCheckoutAmount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your total must be at least ' . number_format($coupon->min_checkout_amount, 2) . ' to use this coupon.'
                ]);
            }

            // Check for max usage
            if ($coupon->max_usage && $coupon->usage_count >= $coupon->max_usage) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon has reached its maximum usage limit.',
                    'inactive' => true
                ]);
            }

            // Check user usage count
            $userUsageCount = CouponUser::where('coupon_id', $coupon->id)
                ->where('user_id', Auth::id())
                ->count();

            if ($coupon->max_usage_per_user && $userUsageCount >= $coupon->max_usage_per_user) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have reached the maximum usage for this coupon.'
                ]);
            }

            // Store coupon in session to track application
            session(['applied_coupon' => $coupon->id]);

            return response()->json(['success' => true, 'coupon' => $coupon]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid coupon code.']);
    }
}