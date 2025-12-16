@extends('layouts.front')

@section('title')
Welcome to Hound
@endsection

@section('content')
@include('layouts.inc.slider')

@php
$popups = \App\Models\Popup::where('is_active', true)->get();
@endphp

@if ($popups->count())
<div id="popupModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 50%; display: flex; align-items: center; justify-content: center; margin-top: 100px;">
        <div class="modal-content" style="border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #333, #444);">
                <h5 class="modal-title" style="color: #C70039; font-weight: 800; text-shadow: 2px 2px 5px rgba(0,0,0,0.5);">
                    {{ $popups[0]->title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #C70039;">
                    <span aria-hidden="true" style="color: #8B0000;">×</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; margin: 0; background-color: #444;">
                <div class="owl-carousel popup-carousel owl-theme">
                    @foreach ($popups as $popup)
                    <div class="item" style="background: linear-gradient(135deg, #333, #444); margin: 0; color: #fff;">
                        <img src="{{ asset('assets/uploads/popups/' . $popup->image) }}" alt="Popup Image" class="img-fluid" style="width: 100%; height: auto; display: block;">
                        @if (!empty($popup->content))
                        <p style="color: #C70039; margin: 0;">{{ $popup->content }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#popupModal').modal('show'); // Show the modal on load

    // Initialize Owl Carousel for popups
    $('.popup-carousel').owlCarousel({
        loop: true,
        margin: 0, // Ensure no margin between items
        nav: true,
        dots: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsive: {
            0: { items: 1 },
            600: { items: 1 }
        }
    });

    // Close modal actions
    $('#popupModal .close').on('click', function() {
        $('#popupModal').modal('hide'); // Hide the modal
    });
});
</script>

<div class="py-5">
    <div class="container">
        <div class="row">
            <h2 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold; color: #333;">Featured Products</h2>
            <p class="text-center mb-4" style="font-size: 1.25rem; color: #333;">Discover our selection of top-rated products!</p>
            <div class="owl-carousel featured-carousel owl-theme">
                @foreach ($featured_products as $prod)
                    <div class="item" style="padding: 15px;">
                        <a href="{{ url('category/'.$prod->category->slug.'/'.$prod->slug) }}">
                            <div class="card shadow-lg rounded slide-in" style="position: relative; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; height: 450px; background: linear-gradient(135deg, #ffffff, #f0f0f0); opacity: 0; transform: translateX(800%);">
                                <img src="{{ asset('assets/uploads/products/'.$prod->image) }}" alt="Product image" class="card-img-top" style="border-radius: 0.5rem; transition: transform 0.3s ease; height: 300px; object-fit: cover;">
                                <div class="card-body text-center" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <h5 class="card-title" style="font-size: 1.25rem; font-weight: 600; color: #333;">{{ $prod->name }}</h5>
                                    <span class="text" style="font-size: 1.5rem; color: darkred; font-weight: bold;">₱ {{ $prod->selling_price }}</span>
                                    <span class="text-muted" style="font-size: 1rem; color: #333;"><s>₱ {{ $prod->original_price }}</s></span>
                                </div>
                                <div class="card-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.2); opacity: 0; transition: opacity 0.8s ease;"></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- New Products Section -->
<div class="py-5">
    <div class="container">
        <div class="row">
            <h2 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold; color: #333;">New Products</h2>
            <p class="text-center mb-4" style="font-size: 1.25rem; color: #333;">Check out our latest arrivals!</p>
            <div class="owl-carousel new-products-carousel owl-theme">
                @foreach ($new_products as $newProd)
                    <div class="item" style="padding: 15px;">
                        <a href="{{ url('category/'.$newProd->category->slug.'/'.$newProd->slug) }}">
                            <div class="card shadow-lg rounded slide-in" style="position: relative; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; height: 450px; background: linear-gradient(135deg, #ffffff, #f0f0f0); opacity: 0; transform: translateX(800%);">
                                <img src="{{ asset('assets/uploads/products/'.$newProd->image) }}" alt="Product image" class="card-img-top" style="border-radius: 0.5rem; transition: transform 0.3s ease; height: 300px; object-fit: cover;">
                                <div class="card-body text-center" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <h5 class="card-title" style="font-size: 1.25rem; font-weight: 600; color: #333;">{{ $newProd->name }}</h5>
                                    <span class="badge bg-success" style="font-size: 0.75rem; position: absolute; top: 10px; left: 10px; border-radius: 5px;">
                                        <i class="fa fa-star" style="margin-right: 5px;"></i> New
                                    </span>
                                    <span class="text" style="font-size: 1.5rem; color: darkred; font-weight: bold;">₱ {{ $newProd->selling_price }}</span>
                                    <span class="text-muted" style="font-size: 1rem; color: #333;"><s>₱ {{ $newProd->original_price }}</s></span>
                                </div>
                                <div class="card-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.2); opacity: 0; transition: opacity 0.8s ease;"></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Most Viewed Products Section -->
<div class="py-5">
    <div class="container">
        <div class="row">
            <h2 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold; color: #333;">Most Viewed Products</h2>
            <p class="text-center mb-4" style="font-size: 1.25rem; color: #333;">Check out our most popular products!</p>
            <div class="owl-carousel most-viewed-carousel owl-theme">
                @foreach ($most_viewed_products as $viewedProd)
                    <div class="item" style="padding: 15px;">
                        <a href="{{ url('category/'.$viewedProd->category->slug.'/'.$viewedProd->slug) }}">
                            <div class="card shadow-lg rounded slide-in" style="position: relative; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; height: 450px; background: linear-gradient(135deg, #ffffff, #f0f0f0); opacity: 0; transform: translateX(800%);">
                                <img src="{{ asset('assets/uploads/products/'.$viewedProd->image) }}" alt="Product image" class="card-img-top" style="border-radius: 0.5rem; transition: transform 0.3s ease; height: 300px; object-fit: cover;">
                                <div class="card-body text-center" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <h5 class="card-title" style="font-size: 1.25rem; font-weight: 600; color: #333;">{{ $viewedProd->name }}</h5>
                                    <span class="text" style="font-size: 1.5rem; color: darkred; font-weight: bold;">₱ {{ $viewedProd->selling_price }}</span>
                                    <span class="text-muted" style="font-size: 1rem; color: #333;"><s>₱ {{ $viewedProd->original_price }}</s></span>
                                    <span class="text-muted" style="font-size: 0.875rem; color: #333;">Views: {{ $viewedProd->view_count }}</span>
                                </div>
                                <div class="card-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.2); opacity: 0; transition: opacity 0.8s ease;"></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-dark">
    <div class="container">
        <div class="row">
            <h2 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold; color: #fff;">Trending Categories</h2>
            <p class="text-center mb-4" style="font-size: 1.25rem; color: #fff;">Explore the categories that are trending now!</p>
            <div class="owl-carousel featured-carousel owl-theme">
                @foreach ($trending_category as $tcategory)
                    <div class="item" style="padding: 15px;">
                        <a href="{{ url('view-category/'.$tcategory->slug) }}">
                            <div class="card shadow-lg rounded slide-in" style="position: relative; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; height: 450px; background: linear-gradient(135deg, #ffffff, #f0f0f0); opacity: 0; transform: translateX(800%);">
                                <img src="{{ asset('assets/uploads/category/'.$tcategory->image) }}" alt="Category image" class="card-img-top" style="border-radius: 0.5rem; transition: transform 0.3s ease; height: 300px; object-fit: cover;">
                                <div class="card-body text-center" style="flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                    <h5 class="card-title" style="font-size: 1.25rem; font-weight: 600; color: darkred;">{{ $tcategory->name }}</h5>
                                    <p class="card-text" style="font-size: 0.875rem; color: #333;">{{ $tcategory->meta_descrip }}</p>
                                </div>
                                <div class="card-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.2); opacity: 0; transition: opacity 0.8s ease;"></div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Gallery Section -->
<div class="py-5">
    <div class="container">
        <h2 class="text-center mb-4" style="font-size: 2.5rem; font-weight: bold; color: #333;">Gallery</h2>
        <p class="text-center mb-4" style="font-size: 1.25rem; color: #333;">Check out our gallery!</p>
        <div class="owl-carousel gallery-carousel owl-theme">
            @for ($i = 1; $i <= 10; $i++)
                <div class="item" style="padding: 15px;">
                    <div class="card shadow-lg rounded reveal" style="overflow: hidden; height: 250px; opacity: 0; transform: translateX(800%); transition: opacity 0.5s ease, transform 2.5s ease;">
                        @php
                            $imagePath = public_path("assets/images/g{$i}.png");
                        @endphp
                        @if (file_exists($imagePath))
                            <img src="{{ asset("assets/images/g{$i}.png") }}" alt="Gallery image {{ $i }}" class="card-img-top" style="height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/uploads/placeholder.png') }}" alt="Placeholder image" class="card-img-top" style="height: 100%; object-fit: cover;">
                        @endif
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

@include('layouts.inc.frontfooter')
@endif
@endsection

@section('scripts')

<script>
$(document).ready(function() {
    // Set initial styles for cards
    $('.card').css({
        'transition': 'transform 2.5s ease, opacity 1s ease' // Set transition duration to 2 seconds
    });

    // Hover effect for cards
    $('.card').hover(
        function() {
            $(this).css({
                'transform': 'scale(1.05)',
            }).find('.card-overlay').css('opacity', 0.6); // Make overlay brighter
        },
        function() {
            $(this).css({
                'transform': 'scale(1)',
            }).find('.card-overlay').css('opacity', 0); // Remove overlay
        }
    );

    // Scroll animation for cards
    const cards = $('.card');
    let animated = false; // Track if the animation has already occurred
    $(window).on('scroll', function() {
        const scrollTop = $(this).scrollTop();
        if (!animated) { // Only animate if it hasn't happened yet
            cards.each(function() {
                const offsetTop = $(this).offset().top;
                const windowHeight = $(window).height();
                if (offsetTop < scrollTop + windowHeight - 100) {
                    $(this).css({
                        'transform': 'translateX(0)',
                        'opacity': 1
                    }); // Animate to visible state
                }
            });
            // Check if all cards are animated, and set animated to true
            if (cards.filter(function() { return $(this).css('opacity') == '1'; }).length === cards.length) {
                animated = true; // Set to true to prevent further animations
            }
        }
    });

    // Initialize Owl Carousel for all carousels with autoslider for the gallery
    $('.featured-carousel, .new-products-carousel, .most-viewed-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: false, // Disable autoplay for featured and new products
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 4 }
        }
    });

    $('.gallery-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        autoplay: true, // Enable autoplay for the gallery carousel
        autoplayTimeout: 5000, // Set the time between slides
        autoplayHoverPause: true, // Pause on hover
        responsive: {
            0: { items: 1 },
            600: { items: 2 },
            1000: { items: 4 }
        }
    });

    // Initial scroll animation trigger
    $(window).trigger('scroll');

    // Reveal transition for gallery images from right to left
    const revealCards = $('.gallery-carousel .reveal');
    revealCards.each(function(index) {
        $(this).delay(300 * index).queue(function(next) {
            $(this).css({
                'opacity': 1,
                'transform': 'translateX(0)'
            });
            next();
        });
    });
});
</script>

@endsection