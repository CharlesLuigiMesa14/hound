@extends('layouts.front')

@section('title')
My Wishlist
@endsection

@section('content')

<div class="py-3 mb-4 shadow-sm bg-white border-top">
    <div class="container">
        <h6 class="mb-0">
            <a href="{{ url('/') }}" class="text-danger text-decoration-none">
                <i class="fa fa-home"></i> Home
            </a> / <i class="fa fa-heart"></i> Wishlist
        </h6>
    </div>
</div>

<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="font-weight-bold" style="color: #333;">Your Wishlist</h2>
        <p class="text-muted">Explore your favorite items before making a decision!</p>
    </div>

    <div class="card shadow wishlistitems" style="border-radius: 10px; background-color: #f9f9f9;">
        <div class="card-body">
            @if($wishlist->count() > 0)
                @foreach ($wishlist as $item)
                <div class="row product_data align-items-center border-bottom py-3" style="transition: background-color 0.3s;">
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('assets/uploads/products/'.$item->products->image) }}" class="img-fluid rounded" alt="{{ $item->products->name }}" style="max-height: 70px;">
                    </div>
                    <div class="col-md-4">
                        <h6 class="font-weight-bold">{{ $item->products->name }}</h6>
                    </div>
                    <div class="col-md-2 text-center">
                        <label for="price" class="font-weight-bold">Price</label>
                        <h6 class="text-dark">₱ {{ number_format($item->products->selling_price, 2) }}</h6>
                    </div>
                    <div class="col-md-2">
                        <input type="hidden" class="prod_id" value="{{ $item->prod_id }}">
                        <input type="hidden" class="stock" value="{{ $item->products->qty }}">
                        @if($item->products->qty > 0)
                        <label for="quantity" class="font-weight-bold">Quantity</label>
                        <div class="input-group mb-2" style="width: 130px; margin: auto;">
                            <button class="input-group-text decrement-btn">-</button>
                            <input type="text" name="quantity" class="form-control qty-input text-center" value="1" readonly>
                            <button class="input-group-text increment-btn">+</button>
                        </div>
                        @else
                        <h6 class="text-danger">Out of Stock</h6>
                        @endif
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="d-flex flex-column">
                            <button class="btn btn-success addToCartBtn w-100 mb-2" style="border-radius: 5px; transition: background-color 0.3s; font-weight: bold;">
                                <i class="fa fa-shopping-cart"></i> Add to Cart
                            </button>
                            <button class="btn btn-danger remove-wishlist-item w-100" style="border-radius: 5px; transition: background-color 0.3s; font-weight: bold;">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <h4 class="text-center text-muted">There are no products in your Wishlist</h4>
            @endif
        </div>
    </div>
</div>
@include('layouts.inc.frontfooter')
@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/custom.js') }}"></script>

@endsection