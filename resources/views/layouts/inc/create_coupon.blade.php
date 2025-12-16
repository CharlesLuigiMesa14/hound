@extends('layouts.admin')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .note-icon {
            margin-right: 5px;
        }
        .note {
            opacity: 0.85;
        }
    </style>

@endsection

@section('content')
<div class="container mt-4">
    <div class="card p-4" style="background-color: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h3 class="mb-4">
            <i class="fas fa-tags" style="color: #333; font-weight: bold;"></i>
            <span style="color: #333; font-weight: bold;">Add Coupon</span>
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

        <form action="{{ route('coupons.store') }}" method="POST" onsubmit="return validateDiscountAmount()">
            @csrf
            
            <div class="form-group">
                <label for="name"><i class="fas fa-tag" style="color: #c00000;"></i> Coupon Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter coupon name" required>
                <small class="note">
                    <i class="fas fa-pencil-alt note-icon"></i> This is the name of the coupon.
                </small>
            </div>

            <div class="form-group">
                <label for="code"><i class="fas fa-tag" style="color: #c00000;"></i> Coupon Code</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="Enter coupon code" required>
                <small class="note">
                    <i class="fas fa-key note-icon"></i> Unique code used for the coupon.
                </small>
            </div>

            <div class="form-group">
                <label for="discount_type"><i class="fas fa-percent" style="color: #d00000;"></i> Discount Type</label>
                <select class="form-control" id="discount_type" name="discount_type" required onchange="toggleDiscountFields()">
                    <option value="fixed">Fixed Amount</option>
                    <option value="percentage">Percentage</option>
                </select>
                <small class="note">
                    <i class="fas fa-signal note-icon"></i> Choose discount type.
                </small>
            </div>

            <div class="form-group">
                <label for="discount_amount"><i class="fas fa-money-bill-wave" style="color: #b00000;"></i> Discount Amount</label>
                <input type="number" class="form-control" id="discount_amount" name="discount_amount" placeholder="Enter discount amount" required oninput="toggleDiscountFields()" onblur="preventNegativeInput(event)" min="1">
                <small class="note">
                    <i class="fas fa-exclamation-triangle note-icon"></i> Amount or percentage off.
                </small>
            </div>

            <div class="form-group">
                <label for="start_date"><i class="fas fa-calendar-alt" style="color: #e60000;"></i> Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
                <small class="note">
                    <i class="fas fa-clock note-icon"></i> When the coupon becomes valid.
                </small>
            </div>

            <div class="form-group">
                <label for="end_date"><i class="fas fa-calendar-times" style="color: #ff0000;"></i> Expiry Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
                <small class="note">
                    <i class="fas fa-clock note-icon"></i> When the coupon expires.
                </small>
            </div>

            <div class="form-group">
                <label for="max_usage"><i class="fas fa-users" style="color: #c70000;"></i> Max Usage</label>
                <input type="number" class="form-control" id="max_usage" name="max_usage" placeholder="Enter maximum usage" min="1" required>
                <small class="note">
                    <i class="fas fa-users-cog note-icon"></i> Total times this coupon can be used.
                </small>
            </div>

            <div class="form-group">
                <label for="min_checkout_amount"><i class="fas fa-shopping-cart" style="color: #a40000;"></i> Minimum Checkout Amount</label>
                <input type="number" class="form-control" id="min_checkout_amount" name="min_checkout_amount" placeholder="Enter minimum checkout amount" min="0" step="0.01" required>
                <small class="note">
                    <i class="fas fa-dollar-sign note-icon"></i> Minimum amount to use the coupon.
                </small>
            </div>

            <div class="form-group">
                <label for="max_usage_per_user"><i class="fas fa-user-friends" style="color: #b30000;"></i> Max Usage Per User</label>
                <input type="number" class="form-control" id="max_usage_per_user" name="max_usage_per_user" placeholder="Enter max usage per user" min="1" required>
                <small class="note">
                    <i class="fas fa-user-check note-icon"></i> Max times a user can use this coupon.
                </small>
            </div>

            <div class="form-group">
                <label for="description"><i class="fas fa-info-circle" style="color: #900000;"></i> Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter a brief description"></textarea>
                <small class="note">
                    <i class="fas fa-clipboard note-icon"></i> Provide details about the coupon.
                </small>
            </div>

            <button type="submit" class="btn btn-danger mt-3" style="background-color: #a00000; border-color: #a00000;">
                <i class="fas fa-plus-circle"></i> Add Coupon
            </button>
        </form>
    </div>
</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        function toggleDiscountFields() {
            const discountType = document.getElementById('discount_type').value;
            const discountAmountInput = document.getElementById('discount_amount');

            if (discountType === 'percentage') {
                discountAmountInput.setAttribute('min', '1');
                discountAmountInput.setAttribute('max', '100');
                discountAmountInput.setAttribute('placeholder', 'Enter percentage (1-100)');
            } else {
                discountAmountInput.setAttribute('min', '1');
                discountAmountInput.removeAttribute('max');
                discountAmountInput.setAttribute('placeholder', 'Enter fixed amount (1 or more)');
            }
        }

        function validateDiscountAmount() {
            const discountType = document.getElementById('discount_type').value;
            const discountAmount = parseFloat(document.getElementById('discount_amount').value);
            const maxUsagePerUser = parseInt(document.getElementById('max_usage_per_user').value);

            // Validate discount amount
            if (discountType === 'percentage') {
                if (isNaN(discountAmount) || discountAmount < 1 || discountAmount > 100) {
                    alert("Discount amount must be between 1 and 100 for percentage type.");
                    return false;
                }
            } else if (discountType === 'fixed') {
                if (isNaN(discountAmount) || discountAmount < 1) {
                    alert("Discount amount must be at least 1 for fixed amount.");
                    return false;
                }
            }

            // Validate max usage per user
            if (isNaN(maxUsagePerUser) || maxUsagePerUser < 1) {
                alert("Max usage per user must be at least 1.");
                return false;
            }

            return true;
        }

        function preventNegativeInput(evt) {
            const input = evt.target;
            if (input.value < 1) {
                input.value = 1; // Set minimum to 1
            }
        }
    </script>
@endsection
@endsection