<?php

namespace App\Http\Controllers;

use App\Mail\RefundStatusInitial;
use App\Models\ReturnRequest;
use App\Models\Product;
use App\Models\Warehouse; // Import the Warehouse model
use Illuminate\Http\Request;
use App\Mail\ReturnStatusUpdated;
use App\Mail\RefundStatusUpdated;
use Illuminate\Support\Facades\Mail;

class ReturnController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'prod_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'return_reason' => 'required|string',
            'comment' => 'nullable|string',
            'images' => 'nullable|image|max:2048',
        ]);

        // Check if the product is already marked for return in the given order
        $existingRequest = ReturnRequest::where('order_id', $request->order_id)
            ->where('prod_id', $request->prod_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingRequest) {
            return response()->json(['success' => false, 'message' => 'You already have a return request for this item in this order.']);
        }

        // Create a new return request
        $returnRequest = new ReturnRequest();
        $returnRequest->order_id = $request->order_id;
        $returnRequest->user_id = auth()->id();
        $returnRequest->prod_id = $request->prod_id;
        $returnRequest->qty = $request->qty;
        $returnRequest->return_reason = $request->return_reason;
        $returnRequest->comment = $request->comment;

        // Handle return request image upload
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/returns'), $filename);
            $returnRequest->images = $filename; 
        }

        $returnRequest->save(); // Save the return request

        return response()->json(['success' => true, 'message' => 'Return request submitted successfully!']);
    }

    public function index()
    {
        // Fetch all return requests with user and product relationships
        $returnRequests = ReturnRequest::with(['user', 'product'])->get();

        // Return the view with return requests data
        return view('admin.returns.index', compact('returnRequests'));
    }

    public function view($id)
    {
        // Fetch the specific return request with user and product relationships
        $returnRequest = ReturnRequest::with(['user', 'product'])->findOrFail($id);
        
        // Return the view with the return request data
        return view('admin.returns.view', compact('returnRequest'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $request->validate([
            'return_status' => 'required|in:0,1,2',
            'return_response' => 'nullable|string',
        ]);

        // Find the return request with order
        $returnRequest = ReturnRequest::with('order')->findOrFail($id);

        // Update the return request's status and response
        $returnRequest->return_status = $request->return_status;
        $returnRequest->return_response = $request->return_response ?? '';

        if ($returnRequest->return_status == 1) { // If approved
            // Calculate refund amount
            $order = $returnRequest->order;
            $product = $returnRequest->product;

            if ($order && $product) {
                // Calculate the refund based on quantity and selling price
                $refundAmount = $order->total_price - ($product->selling_price * $returnRequest->qty);
                $returnRequest->refund_amount = $refundAmount;
            }
        }

        $returnRequest->save(); // Save the changes

        // Send email notification if needed
        if ($returnRequest->return_status == 1 || $returnRequest->return_status == 2) {
            Mail::to($returnRequest->user->email)->send(new ReturnStatusUpdated($returnRequest));
        }

        return redirect()->route('returns.view', $id)->with('success', 'Return status updated successfully!');
    }

    public function refundsIndex()
    {
        // Fetch refund requests with refund_status 0
        $refundRequests = ReturnRequest::with(['user', 'product'])->get();
        return view('admin.refunds.index', compact('refundRequests'));
    }

    public function updateRefundStatus(Request $request, $id)
    {
        $returnRequest = ReturnRequest::findOrFail($id);
    
        // Check if the refund can be processed
        if ($returnRequest->refund_status < 1) {
            $returnRequest->updated_at = now(); // Update timestamp
            $returnRequest->refund_date = now()->addDays(3); // Set refund date to 3 days later
            $returnRequest->refund_status = 0; // Ensure it remains unprocessed
            $returnRequest->save();
    
            // Send email notification about refund status update
            Mail::to($returnRequest->user->email)->send(new RefundStatusInitial($returnRequest));
        }
    
        // Queue the check for refund status to handle further processing
        return $this->checkRefundStatus();
    }
    
    public function checkRefundStatus()
    {
        // Update refund statuses for requests that are due
        $updatedCount = ReturnRequest::where('refund_status', 0)
            ->where('refund_date', '<=', now())
            ->update(['refund_status' => 1]);
    
        // If any records were updated, send emails to the respective users
        if ($updatedCount > 0) {
            // Get only the return requests that have been updated to refund_status 1
            $returnRequests = ReturnRequest::where('refund_status', 1)
                ->where('updated_at', '>=', now()->subSeconds(1)) // Fetch recently updated records
                ->get();
    
            foreach ($returnRequests as $request) {
                // Handle the case where refund is now complete
                $this->updateWarehouse($request);
                Mail::to($request->user->email)->send(new RefundStatusUpdated($request));
            }
    
            // Return response after processing refund statuses
            return response()->json(['success' => true, 'updated_count' => $updatedCount, 'message' => 'Refund statuses updated.']);
        }
    }

    protected function updateWarehouse(ReturnRequest $returnRequest)
    {
        // Find the associated warehouse entry for the product
        $warehouse = Warehouse::where('prod_id', $returnRequest->prod_id)->first();

        if ($warehouse) {
            // If the product exists in the warehouse, update the quantity and total price
            $warehouse->quantity += $returnRequest->qty; // Increase quantity
            $warehouse->price = $returnRequest->product->selling_price; // Set price (if needed)
            $warehouse->save();
        } else {
            // If the warehouse entry does not exist, create a new one
            Warehouse::create([
                'prod_id' => $returnRequest->prod_id,
                'quantity' => $returnRequest->qty,
                'price' => $returnRequest->product->selling_price, // Set price
            ]);
        }
    }
    public function dispose($id)
    {
        // Find the warehouse entry and delete it
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
    
        // Redirect to the warehouse index route
        return redirect()->route('warehouse.index')->with('success', 'Product disposed successfully!');
    }
    
    public function addToStock($id)
    {
        // Find the warehouse entry
        $warehouse = Warehouse::findOrFail($id);
        $product = Product::findOrFail($warehouse->prod_id);
    
        // Update the product quantity
        $product->qty += $warehouse->quantity; // Use qty instead of quantity
        $product->save();
    
        // Remove the warehouse entry
        $warehouse->delete();
    
        // Redirect to the warehouse index route
        return redirect()->route('warehouse.index')->with('success', 'Product stock updated successfully!');
    }
}