@extends('layouts.admin')

@section('title')
    Order View
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="font-weight-bold">
                            <i class="fas fa-shopping-cart"></i> Order Details
                        </h3>
                        <a href="{{ url('orders') }}" class="btn btn-danger text-white">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold text-secondary">
                                <i class="fas fa-user"></i> Shipping Information
                            </h4>
                            <hr>
                            <div class="mb-3">
                                <label class="font-weight-bold"><i class="fas fa-user-circle"></i> First Name:</label>
                                <div class="border-bottom p-2">{{ $orders->fname }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold"><i class="fas fa-user-circle"></i> Last Name:</label>
                                <div class="border-bottom p-2">{{ $orders->lname }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold"><i class="fas fa-envelope"></i> Email:</label>
                                <div class="border-bottom p-2">{{ $orders->email }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold"><i class="fas fa-phone"></i> Mobile Phone Number:</label>
                                <div class="border-bottom p-2">{{ $orders->phone }}</div>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold"><i class="fas fa-map-marker-alt"></i> Shipping Address:</label>
                                <div class="border-bottom p-2">
                                    {{ $orders->address1 }},<br>
                                    {{ $orders->address2 ? $orders->address2 . ',<br>' : '' }}
                                    {{ $orders->city }},<br>
                                    {{ $orders->state }},<br>
                                    {{ $orders->country }},
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="font-weight-bold"><i class="fas fa-code-branch"></i> Zip Code:</label>
                                <div class="border-bottom p-2">{{ $orders->pincode }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h4 class="font-weight-bold text-secondary">
                                <i class="fas fa-box"></i> Order Summary
                            </h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders->orderitems as $item)
                                        <tr>
                                            <td>{{ $item->products->name }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>₱{{ number_format($item->price, 2) }}</td>
                                            <td>
                                                <img src="{{ asset('assets/uploads/products/'.$item->products->image) }}" width="50px" alt="Product Image" class="rounded">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @php
                                $totalPrice = $orders->orderitems->sum(function($item) {
                                    return $item->price * $item->qty;
                                });
                                $deliveryFee = max(0, $orders->total_price - $totalPrice); // Ensure delivery fee is not negative
                                $discountAmount = $orders->discount_amount ?? 0; // Get the discount amount or default to 0
                                $grandTotal = $orders->total_price; // Grand total
                            @endphp

                            <div class="d-flex justify-content-between px-2">
                                <h6>Subtotal:</h6>
                                <h6 style="color: #333; font-weight: normal;">₱{{ number_format($totalPrice, 2) }}</h6>
                            </div>

                            <div class="d-flex justify-content-between px-2">
                                <h6>Delivery Fee:</h6>
                                <h6 style="color: #333; font-weight: normal;">₱{{ number_format($deliveryFee, 2) }}</h6>
                            </div>

                            <div class="d-flex justify-content-between px-2">
                                <h6>Discount Amount:</h6>
                                <h6 style="color: #333; font-weight: normal;">₱{{ number_format($discountAmount, 2) }}</h6>
                            </div>

                            <div class="d-flex justify-content-between px-2">
                                <h4 class="font-weight-bold"><strong>Grand Total:</strong></h4>
                                <h4 class="font-weight-bold" style="color: #333;"><strong>₱{{ number_format($grandTotal, 2) }}</strong></h4>
                            </div>

                            <hr>

                            <div class="mt-3 px-2">
                                <label class="font-weight-bold"><strong>Order Status:</strong></label>
                                <form action="{{ url('update-order/'.$orders->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select class="form-select" name="order_status">
                                        <option selected>Select Status</option>
                                        <option {{ $orders->status == '0' ? 'selected' : '' }} value="0">Pending</option>
                                        <option {{ $orders->status == '1' ? 'selected' : '' }} value="1">Completed</option>
                                        <option {{ $orders->status == '2' ? 'selected' : '' }} value="2">Preparing</option>
                                        <option {{ $orders->status == '3' ? 'selected' : '' }} value="3">Ready to Deliver</option>
                                        <option {{ $orders->status == '4' ? 'selected' : '' }} value="4">Shipped</option>
                                        <option {{ $orders->status == '5' ? 'selected' : '' }} value="5">Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-danger float-end mt-3">
                                        <i class="fas fa-sync-alt"></i> Update
                                    </button>
                                </form>
                            </div>

                            @if ($orders->status == 5)
                                <div class="mt-3 px-2">
                                    <label class="font-weight-bold"><strong>Cancellation Reason:</strong></label>
                                    <div class="border-bottom p-2">
                                        @switch($orders->cancellation_reason)
                                            @case(1)
                                                Changed my mind
                                            @break

                                            @case(2)
                                                Found a better price
                                            @break

                                            @case(3)
                                                Product not needed anymore
                                            @break

                                            @case(4)
                                                Other
                                            @break

                                            @default
                                                N/A
                                        @endswitch
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 20px;
    }
    .card {
        border-radius: 10px;
        margin: 20px 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    .border-bottom {
        border-bottom: 2px solid #007bff; /* Blue bottom border */
        padding: 10px 0; /* Padding for better spacing */
    }
    .table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 10px;
    }
    .table th, .table td {
        text-align: center;
        padding: 15px;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .btn-danger {
        background-color: #dc3545; /* Dark red */
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333; /* Darker red */
        border-color: #bd2131;
    }
</style>

<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
@endsection