@extends('layouts.front')

@section('title', $products->name)

@section('content')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/add-rating') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $products->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rate {{ $products->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="rating-css">
                        <div class="star-icon">
                            @if($user_rating)
                                @for ($i = 1; $i <= $user_rating->stars_rated; $i++)
                                    <input type="radio" value="{{ $i }}" name="product_rating" checked id="rating{{ $i }}">
                                    <label for="rating{{ $i }}" class="fa fa-star checked"></label>
                                @endfor
                                @for ($j = $user_rating->stars_rated + 1; $j <= 5; $j++)
                                    <input type="radio" value="{{ $j }}" name="product_rating" id="rating{{ $j }}">
                                    <label for="rating{{ $j }}" class="fa fa-star"></label>
                                @endfor
                            @else
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" value="{{ $i }}" name="product_rating" id="rating{{ $i }}" {{ $i == 1 ? 'checked' : '' }}>
                                    <label for="rating{{ $i }}" class="fa fa-star"></label>
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="py-3 mb-3 shadow-sm" style="background-color: #ffffff; border-top: 1px solid;">
    <div class="container">
        <h6 class="mb-0" style="color: #000;">
            <a href="{{ url('category') }}" style="color: #dc3545; text-decoration: none;">Collections</a> /
            <a href="{{ url('view-category/'.$products->category->slug) }}" style="color: #dc3545; text-decoration: none;">{{ $products->category->name }}</a> /
            <span style="color: #000;">{{ $products->name }}</span>
        </h6>
    </div>
</div>

<div class="container pb-5">
    <div class="shadow product_data" style="border-radius: 10px; background: white; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 border-right">
                    <img src="{{ asset('assets/uploads/products/'.$products->image) }}" class="w-100" alt="{{ $products->name }}" style="border-radius: 10px;">
                </div>
                <div class="col-md-8">
                    <h2 class="mb-0" style="font-size: 36px; font-weight: bold; color: #343a40;">
                        {{ $products->name }}
                        @if ($products->trending == '1')
                            <span class="badge" style="background: linear-gradient(135deg, #ff7e00, #ff3300); color: white; font-size: 0.875rem; padding: 0.25rem 0.5rem; border-radius: 15px; margin-left: 10px; vertical-align: middle;">
                                <i class="fa fa-fire" aria-hidden="true" style="font-size: 1.25rem; margin-right: 3px;"></i>
                                Trending
                            </span>
                        @endif
                    </h2>
                    <hr>
                    <div class="price-info mb-3">
                        <label class="text-muted" style="font-size: 14px;">Original Price:</label>
                        <span class="text-muted text-decoration-line-through">₱ {{ $products->original_price }}</span>
                        <br>
                        <label class="fw-bold" style="font-size: 22px; color: #dc3545;">Selling Price: ₱ {{ $products->selling_price }}</label>
                    </div>

                    <div class="mb-3" style="display: flex; align-items: center;">
                        <div style="margin-right: 15px; display: flex; align-items: center;">
                            <div style="display: flex; align-items: center;">
                                <i class="fa fa-eye" style="margin-right: 5px;"></i>
                                <span style="font-weight: bold; color: darkred;">{{ $products->view_count ?? 0 }}</span>
                            </div>
                            <span style="margin-left: 5px;">Views</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            @php $ratenum = number_format($rating_value); @endphp
                            <div class="rating" style="display: flex; align-items: center;">
                                @for ($i = 1; $i <= $ratenum; $i++)
                                    <i class="fa fa-star checked" style="color: #ffcc00;"></i>
                                @endfor
                                @for ($j = $ratenum + 1; $j <= 5; $j++)
                                    <i class="fa fa-star" style="color: #ccc;"></i>
                                @endfor
                                <span class="ms-2">
                                    @if($ratings->count() > 0)
                                        {{ $ratings->count() }} Ratings
                                    @else
                                        No Ratings
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <p class="mt-3" style="text-align: justify;">{!! $products->small_description !!}</p>
                    <hr>
                    <div class="availability mb-3">
                        @if($products->qty > 0)
                            <label class="badge bg-success" style="font-size: 16px;">
                                <i class="fa fa-check-circle"></i> In stock: {{ $products->qty }} available
                                <input type="hidden" class="stock" value="{{ $products->qty }}">
                            </label>
                        @else
                            <label class="badge bg-danger" style="font-size: 16px;">
                                <i class="fa fa-times-circle"></i> Out of stock
                            </label>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <input type="hidden" value="{{ $products->id }}" class="prod_id">
                            <label for="Quantity">Quantity</label>
                            <div class="input-group text-center">
                                <button class="input-group-text decrement-btn">-</button>
                                <input type="text" name="quantity" class="form-control qty-input text-center" value="1" />
                                <button class="input-group-text increment-btn">+</button>
                            </div>
                        </div>
                        <div class="col-md-9 d-flex align-items-end">
                            @if($products->qty > 0)
                                <button type="button" class="btn btn-danger me-3 addToCartBtn" style="font-weight: bold; width: 100%;">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                            @endif
                            <button type="button" class="btn btn-success me-3 addToWishlist" style="font-weight: bold; width: 100%;">
                                <i class="fa fa-heart"></i> Add to Wishlist
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h3 style="font-size: 24px; font-weight: bold; color: #343a40;">Description</h3>
                    <p class="mt-3" style="text-align: justify;">{!! $products->description !!}</p>
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="width: 100%; font-weight: bold;">
                        <i class="fa fa-star"></i> Rate This Product
                    </button>
                </div>
                <div class="col-md-4 text-center">
                    <a href="{{ url('add-review/'.$products->slug.'/userreview') }}" class="btn btn-outline-secondary" style="font-weight: bold; width: 100%;">
                        <i class="fa fa-pencil-alt"></i> Write a Review
                    </a>
                </div>
                <div class="col-md-4 text-end">
                    <h4 style="font-size: 18px; font-weight: bold;">User Reviews ({{ $reviews->count() }})</h4>
                </div>
            </div>
            <div class="user-reviews">
                <div class="mb-3">
                    <label for="sort-reviews">Sort by:</label>
                    <select id="sort-reviews" class="form-select" onchange="sortReviews(this.value)">
                        <option value="newest" selected>Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="highest">Highest Rating</option>
                        <option value="lowest">Lowest Rating</option>
                    </select>
                </div>
                <div class="reviews-container">
                    @foreach ($reviews as $item)
                    <div class="user-review" style="padding: 15px; border-radius: 8px; background-color: #f9f9f9; margin-bottom: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: justify;">
                        <span class="fa fa-user-circle" style="font-size: 30px; margin-right: 10px; display: inline-block;"></span>
                        <strong>{{ $item->user->name .' '.$item->user->lname }}</strong>
                        @if($item->user_id == Auth::id())
                            <a href="{{ url('edit-review/'.$products->slug.'/userreview')}}" class="text-decoration-none">Edit</a>
                        @endif
                        <br>
                        @php
                        $rating = App\Models\Rating::where('prod_id', $products->id)->where('user_id', $item->user->id)->first();
                        @endphp
                        @if ($rating)
                        @php $user_rated = $rating->stars_rated @endphp
                        @for ($i = 1; $i <= $user_rated; $i++)
                            <i class="fa fa-star checked" style="color: #ffcc00;"></i>
                        @endfor
                        @for ($j = $user_rated + 1; $j <= 5; $j++)
                            <i class="fa fa-star" style="color: #ccc;"></i>
                        @endfor
                        @endif
                        <small class="text-muted">Reviewed on {{ $item->created_at->format('d M Y, h:i A') }}</small>
                        <p class="mt-2" style="text-align: justify;">{{ $item->user_review }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Most Viewed Products Section -->
<div class="py-4">
    <div class="container">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #343a40; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #dc3545; padding-bottom: 10px;">
            Most Viewed Products
        </h2>
        <div class="row">
            @foreach ($most_viewed_products as $viewedProd)
            <div class="col-md-2 mb-4">
                <div class="card" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; height: 100%; transition: border 0.3s, transform 0.3s; cursor: pointer;">
                    <a href="{{ url('category/'.$viewedProd->category->slug.'/'.$viewedProd->slug) }}" style="text-decoration: none; color: inherit;">
                        <div style="position: relative;">
                            <img src="{{ asset('assets/uploads/products/'.$viewedProd->image) }}" alt="Product image" class="card-img-top" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-body" style="padding: 1rem; text-align: center; flex-grow: 1;">
                            <h5 style="font-size: 1rem; color: #333; margin-bottom: 0.5rem;">{{ $viewedProd->name }}</h5>
                            <span style="color: #dc3545; font-weight: bold; font-size: 1rem; display: block; margin-top: auto;">₱ {{$viewedProd->selling_price}}</span> <!-- Center align price -->
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Related Products Section -->
<div class="py-4">
    <div class="container">
        <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #343a40; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #dc3545; padding-bottom: 10px;">
            Related Products
        </h2>
        <div class="row">
            @foreach ($related_products as $relatedProd)
            <div class="col-md-2 mb-4">
                <div class="card" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; height: 100%; transition: border 0.3s, transform 0.3s; cursor: pointer;">
                    <a href="{{ url('category/'.$relatedProd->category->slug.'/'.$relatedProd->slug) }}" style="text-decoration: none; color: inherit;">
                        <div style="position: relative;">
                            <img src="{{ asset('assets/uploads/products/'.$relatedProd->image) }}" alt="Product image" class="card-img-top" style="height: 200px; object-fit: cover;">
                        </div>
                        <div class="card-body" style="padding: 1rem; text-align: center; flex-grow: 1;">
                            <h5 style="font-size: 1rem; color: #333; margin-bottom: 0.5rem;">{{ $relatedProd->name }}</h5>
                            <span style="color: #dc3545; font-weight: bold; font-size: 1rem; display: block; margin-top: auto;">₱ {{$relatedProd->selling_price}}</span> <!-- Center align price -->
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@include('layouts.inc.frontfooter')
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
let currentSortOrder = 'newest'; // Default sorting order

function sortReviews(order) {
    const reviewsContainer = document.querySelector('.reviews-container');
    const reviews = Array.from(reviewsContainer.querySelectorAll('.user-review'));

    reviews.sort((a, b) => {
        const ratingA = a.querySelectorAll('.fa-star.checked').length;
        const ratingB = b.querySelectorAll('.fa-star.checked').length;
        const dateA = new Date(a.querySelector('small').innerText.split('on ')[1]);
        const dateB = new Date(b.querySelector('small').innerText.split('on ')[1]);

        if (order === 'highest') {
            return ratingB - ratingA;
        } else if (order === 'lowest') {
            return ratingA - ratingB;
        } else if (order === 'newest') {
            return dateB - dateA;
        } else if (order === 'oldest') {
            return dateA - dateB;
        }
    });

    reviewsContainer.innerHTML = '';
    reviews.forEach(review => reviewsContainer.appendChild(review));
}

window.onload = function() {
    const selectElement = document.getElementById('sort-reviews');
    selectElement.value = currentSortOrder;
    sortReviews(currentSortOrder);
};
</script>
@endsection