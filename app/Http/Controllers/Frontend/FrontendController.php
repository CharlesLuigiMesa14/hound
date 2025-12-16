<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Import Carbon for date manipulation

class FrontendController extends Controller
{
    public function index()
    {
        $featured_products = Product::where('trending', '1')->take(15)->get();
        $trending_category = Category::where('popular', '1')->take(15)->get();
        $new_products = Product::where('created_at', '>=', Carbon::now()->subDays(30)) // Get products from the last 30 days
                               ->where('status', '1') // Ensure the product is active
                               ->take(15) // Limit the number of new products
                               ->get();
    
        // Fetch the most viewed products from the database
        $most_viewed_products = Product::where('status', '1') // Ensure the product is active
                                        ->orderBy('view_count', 'desc') // Order by view count
                                        ->take(15) // Limit the number of most viewed products
                                        ->get();
    
        return view('frontend.index', compact('featured_products', 'trending_category', 'new_products', 'most_viewed_products'));
    }

    public function category()
    {
        $category = Category::where('status', '1')->get();  
        return view('frontend.category', compact('category'));
    }

    public function viewcategory($slug)
    {
        if (Category::where('slug', $slug)->exists()) {
            $category = Category::where('slug', $slug)->first();
            $products = Product::where('cate_id', $category->id)->where('status', '1')->get();
            return view('frontend.products.index', compact('category', 'products'));
        } else {
            return redirect('/')->with('status', "Slug does not exist");
        }
    }

    public function productview($cate_slug, $prod_slug)
    {
        if (Category::where('slug', $cate_slug)->exists()) {
            $products = Product::where('slug', $prod_slug)->first();
    
            if ($products) {
                // Increment the view count
                $products->increment('view_count');
    
                $ratings = Rating::where('prod_id', $products->id)->get();
                $rating_sum = Rating::where('prod_id', $products->id)->sum('stars_rated');
                $user_rating = Rating::where('prod_id', $products->id)->where('user_id', Auth::id())->first();
                $reviews = Review::where('prod_id', $products->id)->get();
    
                $rating_value = $ratings->count() > 0 ? $rating_sum / $ratings->count() : 0;

                // Fetch most viewed products
                $most_viewed_products = Product::where('status', '1') // Ensure the product is active
                                                ->orderBy('view_count', 'desc') // Order by view count
                                                ->take(15) // Limit to 15 most viewed products
                                                ->get();

                // Fetch related products
                $related_products = Product::where('cate_id', $products->cate_id)
                                           ->where('id', '!=', $products->id)
                                           ->where('status', '1')
                                           ->take(15)
                                           ->get();

                return view('frontend.products.view', compact('products', 'ratings', 'reviews', 'rating_value', 'user_rating', 'most_viewed_products', 'related_products'));
            } else {
                return redirect('/')->with('status', "Product not found");
            }
        } else {
            return redirect('/')->with('status', "No such category found");
        }
    }

    public function productlistAjax()
    {
        $products = Product::select('name')->where('status', '1')->get();
        $data = [];

        foreach ($products as $item) {
            $data[] = $item['name'];
        }
        return $data;
    }

    public function searchProduct(Request $request)
    {
        $searched_product = $request->product_name;

        if ($searched_product != "") {
            $product = Product::where("name", "LIKE", "%$searched_product%")->first();
            if ($product) {
                return redirect('category/' . $product->category->slug . '/' . $product->slug);
            } else {
                return redirect()->back()->with("status", "No products matched your search");
            }
        } else {
            return redirect()->back();
        }
    }
    
    public function about()
    {
        return view('frontend.about');
    }

    public function returnshipping()
    {
        return view('frontend.returnshipping');
    }

    public function faq()
    {
        return view('frontend.faq');
    }
}