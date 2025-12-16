@extends('layouts.front')

@section('title')
    My Cart
@endsection

@section('content')

<div class="container my-5 cartitems" style="background-color: #f8f9fa;">
    <div class="card shadow" style="background-color: #ffffff; border-radius: 10px;">
        <div class="card-header text-center" style="background-color: #ffffff; padding: 20px; border-bottom: 2px solid #e0e0e0;">
            <h5 class="mb-0" style="font-size: 1.8rem; font-weight: 500">Your Shopping Cart <i class="fa fa-shopping-cart"></i></h5>
            <p style="margin-top: 5px; font-size: 1rem; color: #666;">Review the items in your cart before proceeding to checkout.</p>
        </div>

        @if($cartitems->count() > 0)
            <div class="card-body">
                @php $total = 0; @endphp
                @foreach ($cartitems as $item)
                    <div class="row product_data align-items-center mb-3 border-bottom pb-3">
                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/uploads/products/'.$item->products->image) }}" height="70px" width="70px" alt="Image of {{ $item->products->name }}" class="img-fluid rounded">
                        </div>
                        <div class="col-md-3 my-auto">
                            <h6 style="color: #000;">{{ $item->products->name }}</h6>
                        </div>
                        <div class="col-md-2 my-auto">
                            <h6 style="color: #000;">₱ {{ number_format($item->products->selling_price, 2) }}</h6>
                        </div>
                        <div class="col-md-3 my-auto text-center">
                            <input type="hidden" class="prod_id" value="{{ $item->prod_id }}">
                            <input type="hidden" class="stock" value="{{ $item->products->qty }}"> <!-- Added stock input -->
                            <label for="Quantity" style="color: #000;">Quantity</label>
                            <div class="input-group mb-3" style="width: 130px; margin: auto;">
                                @if($item->products->qty >= $item->prod_qty)
                                    <button class="input-group-text changeQuantity decrement-btn">-</button>
                                    <input type="text" name="quantity" class="form-control qty-input text-center" value="{{ $item->prod_qty }}">
                                    <button class="input-group-text changeQuantity increment-btn">+</button>
                                    @php $total += $item->products->selling_price * $item->prod_qty; @endphp
                                @else
                                    <h6 class="text-danger">Out of Stock</h6>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                            <button class="btn btn-danger delete-cart-item" style="width: 100%; max-width: 120px;">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- <div class="card-footer text-center" style="background-color: #ffffff;">
                <h6 style="color: #000;">Total Price: <strong style="font-size: 1.5rem;">₱ {{ number_format($total, 2) }}</strong></h6>
                <a href="{{ url('checkout') }}" class="btn btn-outline-success mt-2">
                    <i class="fa fa-money-check-alt"></i> Proceed to Checkout
                </a>
            </div> --}}

            <div class="card-footer" style="background-color: #ffffff;">
                <div class="row">
                    <div class="col-md-10">
                        <h6 style="color: #000;">Total Price:</h6>
                    </div>
                    <div class="col-md-2 text-end">
                        <h6 style="color: #000;"><strong style="font-size: 1.5rem;">₱ {{ number_format($total, 2) }}</strong></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{ url('checkout') }}" class="btn btn-outline-success mt-2">
                            <i class="fa fa-money-check-alt"></i> Proceed to Checkout
                        </a>
                    </div>
                </div>                
            </div>
        @else
            <div class="card-body text-center">
                <h2 style="color: #000;">Your <i class="fa fa-shopping-cart"></i> Cart is Empty</h2>
                <a href="{{ url('category') }}" class="btn btn-outline-primary mt-3">
                    <i class="fa fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@include('layouts.inc.frontfooter')
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/product.js') }}"></script>
@endsection