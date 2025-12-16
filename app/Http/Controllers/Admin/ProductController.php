<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search'));

        // Retrieve all products instead of paginating
        $products = Product::where('status', 1)
            ->when($search, function($query) use ($search) {
                $query->where(function($query) use ($search) {
                    // Search by name and slug with fuzzy logic
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('slug', 'like', "%{$search}%")
                          ->orWhereHas('category', function($q) use ($search) {
                              $q->where('name', 'like', "%{$search}%");
                          });

                    // Check if the search term is a valid number for price searching
                    if (is_numeric($search)) {
                        $price = (float)$search;
                        // Exact match for selling price
                        $query->orWhere('selling_price', $price);
                        $lowerBound = $price * 0.9; // 10% less
                        $upperBound = $price * 1.1; // 10% more
                        $query->orWhereBetween('selling_price', [$lowerBound, $upperBound]);
                    }

                    // Fuzzy search for typographical errors
                    $this->fuzzySearch($query, $search);
                });
            })
            ->get(); // Get all matching products

        return view('admin.product.index', compact('products', 'search'));
    }

    private function fuzzySearch($query, $search)
    {
        // Fuzzy matching for product names without specific typos
        $products = Product::all();
        foreach ($products as $product) {
            if ($this->isSimilar($product->name, $search)) {
                $query->orWhere('id', $product->id);
            }
        }
    }

    private function isSimilar($string1, $string2, $threshold = 2)
    {
        // Calculate the Levenshtein distance
        $distance = levenshtein(strtolower($string1), strtolower($string2));
        return $distance <= $threshold; // Adjust threshold for more or less tolerance
    }


    public function add()
    {
        $category = Category::all();
        return view('admin.product.add', compact('category'));
    }

    public function insert(Request $request)
    {
        $products = new Product();

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'small_description' => 'nullable|string',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'qty' => 'required|integer|min:0',
            'status' => 'nullable|boolean',
            'trending' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/products', $filename);
            $products->image = $filename;
        }

        $products->cate_id = $request->input('cate_id');
        $products->name = $request->input('name');
        $products->slug = $request->input('slug');
        $products->small_description = $request->input('small_description');
        $products->description = $request->input('description');
        $products->original_price = $request->input('original_price');
        $products->selling_price = $request->input('selling_price');
        $products->tax = $request->input('tax');
        $products->qty = $request->input('qty');
        $products->status = $request->input('status') == TRUE ? '1' : '0';
        $products->trending = $request->input('trending') == TRUE ? '1' : '0';
        $products->meta_title = $request->input('meta_title');
        $products->meta_keywords = $request->input('meta_keywords');
        $products->meta_description = $request->input('meta_description');
        $products->save();

        return redirect('products')->with('status', "Product Added Successfully");
    }

    public function edit($id)
    {
        $products = Product::find($id);
        return view("admin.product.edit", compact("products"));
    }

    public function update(Request $request, $id)
    {
        $products = Product::find($id);
        
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'small_description' => 'nullable|string',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'qty' => 'required|integer|min:0',
            'status' => 'nullable|boolean',
            'trending' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/products/' . $products->image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/products', $filename);
            $products->image = $filename;
        }

        // Update product fields
        $products->name = $request->input('name');
        $products->slug = $request->input('slug');
        $products->small_description = $request->input('small_description');
        $products->description = $request->input('description');
        $products->original_price = $request->input('original_price');
        $products->selling_price = $request->input('selling_price');
        $products->tax = $request->input('tax');
        $products->qty = $request->input('qty');
        $products->status = $request->input('status') == TRUE ? '1' : '0';
        $products->trending = $request->input('trending') == TRUE ? '1' : '0';
        $products->meta_title = $request->input('meta_title');
        $products->meta_keywords = $request->input('meta_keywords');
        $products->meta_description = $request->input('meta_description');
        
        $products->save();

        return redirect('products')->with('status', "Product updated Successfully");
    }

    public function archive($id)
    {
        $product = Product::find($id);
        
        // Archive the product by setting its status to 0
        $product->status = 0; // Assuming '0' indicates archived
        $product->save();

        return redirect('products')->with('status', "Product archived successfully");
    }

    public function unarchive($id)
    {
        $product = Product::find($id);
        
        // Unarchive the product by setting its status to 1
        $product->status = 1; // Assuming '1' indicates active
        $product->save();

        return redirect('products')->with('status', "Product unarchived successfully");
    }

    public function archivedProducts()
    {
        $archivedProducts = Product::where('status', 0)->get(); // Assuming '0' indicates archived
        return view('admin.product.archived', compact('archivedProducts'));
    }

    public function destroy($id)
    {
        // Removed the delete functionality as per your request
    }

    public function getLowStockNotifications()
    {
        $lowStockProducts = Product::where('qty', '<', 5)->get();
        return $lowStockProducts;
    }
}