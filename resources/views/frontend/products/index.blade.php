@extends('layouts.front')

@section('title')
    {{ $category->name }}
@endsection


@section('content')
<body style="background-color: #F7F7F7; color: #fff;"></body>
<div class="py-3 mb-3 shadow-sm" style="background-color: #ffffff; border-top: 1px solid;">
    <div class="container">
        <h6 style="margin: 0; font-weight: 500; color: #555;">
            <a href="{{ url('category') }}" style="text-decoration: none; color: #dc3545; transition: color 0.3s;">Collections</a> 
            <span style="color: #333;"> / {{ $category->name }}</span>
        </h6>
    </div>
</div>

<div class="py-4">
    <div class="container">
    <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem; color: #343a40; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #dc3545; padding-bottom: 10px; box-shadow: 0 0px 0px rgba(0, 0, 0, 0.1);">
    {{ $category->name }}
</h2>
        <div class="row">
            @foreach ($products as $prod)
            <div class="col-md-3 mb-4">
                <div class="card" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; height: 100%; transition: border 0.3s, transform 0.3s; cursor: pointer;">
                    <a href="{{ url('category/'.$category->slug.'/'.$prod->slug) }}" style="text-decoration: none; color: inherit;">
                        <div style="position: relative;">
                            <img src="{{ asset('assets/uploads/products/'.$prod->image) }}" alt="Product image" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @if($prod->trending == 1)
                                <div style="position: absolute; top: 10px; left: 10px; background: rgba(255, 0, 0, 0.7); color: white; padding: 5px 10px; border-radius: 5px; font-weight: bold; z-index: 1;">
                                    Trending
                                </div>
                            @endif
                        </div>
                        <div class="card-body" style="padding: 1.5rem; text-align: center; flex-grow: 1;">
                            <h5 style="font-size: 1.25rem; color: #333; margin-bottom: 0.5rem;">{{ $prod->name }}</h5>

                            <div style="margin: 1rem 0;">
                                @php
                                    $averageRating = $prod->averageRating();
                                    $reviewCount = $prod->reviewCount();
                                @endphp
                                <div style="font-size: 1.2rem;">
                                    @for ($i = 0; $i < 5; $i++)
                                        <span style="color: {{ $i < $averageRating ? '#dc3545' : '#ccc' }};">★</span>
                                    @endfor
                                    <span style="color: #888; font-size: 0.9rem;"> ({{ $reviewCount }} reviews)</span>
                                </div>
                            </div>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                                <span style="color: #dc3545; font-weight: bold; font-size: 1.2rem;">₱ {{$prod->selling_price}}</span>
                                <span style="color: #888; text-decoration: line-through; font-size: 1rem;">₱ {{$prod->original_price}}</span>
                            </div>
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
<script>
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.border = '3px solid #dc3545';
            card.style.transform = 'scale(1.02)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.border = '1px solid #e0e0e0';
            card.style.transform = 'scale(1)'; 
        });
    });
</script>
@endsection