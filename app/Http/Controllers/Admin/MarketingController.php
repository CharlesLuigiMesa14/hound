<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Rating;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Popup;
use Carbon\Carbon;

class MarketingController extends Controller
{
    public function index()
    {
        // Fetch reviews, ratings, users
        $reviews = Review::with('user')->get();
        $ratings = Rating::all();
        $users = User::all();

        $popup = Popup::where('is_active', true)->first();
    
        // Prepare data for charts
        $reviewData = $reviews->groupBy(function($review) {
            return Carbon::parse($review->created_at)->format('Y-m-d');
        })->map(function ($group) {
            return $group->count();
        });
    
        $ratingData = $ratings->groupBy(function($rating) {
            return Carbon::parse($rating->created_at)->format('Y-m-d');
        })->map(function ($group) {
            return $group->avg('stars_rated');
        });
    
        $userData = [
            'new_users' => $users->where('created_at', '>=', now()->subMonth())->count(),
            'returning_users' => $users->where('last_login', '>=', now()->subMonth())->count(),
        ];
    
        // Top Reviewers
        $topReviewersData = $reviews->groupBy('user_id')->map(function ($group) {
            return $group->count();
        })->sortDesc()->take(5)->values()->toArray();
    
        $topReviewersNames = User::whereIn('id', array_keys($topReviewersData))->pluck('name')->toArray();
    
        // User Ratings Distribution
        $userRatingsData = [
            $ratings->where('stars_rated', 1)->count(),
            $ratings->where('stars_rated', 2)->count(),
            $ratings->where('stars_rated', 3)->count(),
            $ratings->where('stars_rated', 4)->count(),
            $ratings->where('stars_rated', 5)->count(),
        ];
    
        // Sentiment Analysis based on stars_rated from ratings
        $sentimentData = [
            'positive' => 0,
            'neutral' => 0,
            'negative' => 0,
        ];
    
        foreach ($ratings as $rating) {
            if ($rating->stars_rated >= 4) {
                $sentimentData['positive']++;
            } elseif ($rating->stars_rated == 3) {
                $sentimentData['neutral']++;
            } else {
                $sentimentData['negative']++;
            }
        }
    
        // User Engagement Metrics
        $engagementData = $users->groupBy(function($user) {
            return Carbon::parse($user->created_at)->format('Y-m-d');
        })->map(function ($group) {
            return $group->count();
        });
        
        $engagementLabels = $engagementData->keys();

        // Pass all data to the admin marketing index view
        return view('admin.marketing.index', compact(
            'reviews', 'reviewData', 'ratingData', 'userData',
            'topReviewersData', 'topReviewersNames', 'userRatingsData',
            'sentimentData', 'engagementData', 'engagementLabels', 'popup' 
        ));
    }

    public function view()
    {
        // Fetch coupons for the view.blade.php
        $coupons = Coupon::all();
        
        // Pass coupons to the view
        return view('admin.marketing.view', compact('coupons'));
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id); // Find the coupon or fail
        $coupon->delete(); // Delete the coupon

        return redirect()->route('coupons.view')->with('success', 'Coupon deleted successfully.');
    }

    public function edit($id)
    {
        // Fetch the coupon to edit
        $coupon = Coupon::findOrFail($id);
        
        // Pass the coupon to the edit view
        return view('admin.marketing.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'code' => 'required|string|max:255',
            'discount_amount' => 'required|numeric|min:1',
            'discount_type' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'max_usage' => 'nullable|integer|min:1',
            'min_checkout_amount' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'max_usage_per_user' => 'nullable|integer|min:1',
        ]);

        // Find the coupon and update its details
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());

        return redirect()->route('coupons.view')->with('success', 'Coupon updated successfully.');
    }
}
