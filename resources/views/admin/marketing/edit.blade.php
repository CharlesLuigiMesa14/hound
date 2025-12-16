@extends('layouts.admin')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card p-4" style="background-color: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h3 class="mb-4">
            <i class="fas fa-tags" style="color: #333; font-weight: bold;"></i>
            <span style="color: #333; font-weight: bold;">Edit Coupon</span>
        </h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="code"><i class="fas fa-tag" style="color: #c00000;"></i> Coupon Code</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $coupon->code) }}" required>
            </div>
            
            <div class="form-group">
                <label for="discount_amount"><i class="fas fa-money-bill-wave" style="color: #b00000;"></i> Discount Amount</label>
                <input type="number" class="form-control" id="discount_amount" name="discount_amount" value="{{ old('discount_amount', $coupon->discount_amount) }}" min="1" required>
            </div>
            
            <div class="form-group">
                <label for="discount_type"><i class="fas fa-percent" style="color: #d00000;"></i> Discount Type</label>
                <select class="form-control" id="discount_type" name="discount_type" required>
                    <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="start_date"><i class="fas fa-calendar-alt" style="color: #e60000;"></i> Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $coupon->start_date ? $coupon->start_date->format('Y-m-d') : '') }}">
            </div>
            
            <div class="form-group">
                <label for="end_date"><i class="fas fa-calendar-times" style="color: #ff0000;"></i> Expiry Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $coupon->end_date ? $coupon->end_date->format('Y-m-d') : '') }}">
            </div>
            
            <div class="form-group">
                <label for="max_usage"><i class="fas fa-users" style="color: #c70000;"></i> Max Usage</label>
                <input type="number" class="form-control" id="max_usage" name="max_usage" value="{{ old('max_usage', $coupon->max_usage) }}" min="1">
            </div>
            
            <div class="form-group">
                <label for="min_checkout_amount"><i class="fas fa-shopping-cart" style="color: #a40000;"></i> Minimum Checkout Amount</label>
                <input type="number" class="form-control" id="min_checkout_amount" name="min_checkout_amount" value="{{ old('min_checkout_amount', $coupon->min_checkout_amount) }}" min="0" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="name"><i class="fas fa-tag" style="color: #c00000;"></i> Coupon Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $coupon->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description"><i class="fas fa-info-circle" style="color: #900000;"></i> Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter a brief description">{{ old('description', $coupon->description) }}</textarea>
            </div>
            
            <div class="form-group">
                <label for="max_usage_per_user"><i class="fas fa-user-friends" style="color: #b30000;"></i> Max Usage Per User</label>
                <input type="number" class="form-control" id="max_usage_per_user" name="max_usage_per_user" value="{{ old('max_usage_per_user', $coupon->max_usage_per_user) }}" min="1">
            </div>
            
            <button type="submit" class="btn btn-danger mt-3" style="background-color: #a00000; border-color: #a00000;">
                <i class="fas fa-save"></i> Update Coupon
            </button>
        </form>
    </div>
</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
@endsection
@endsection