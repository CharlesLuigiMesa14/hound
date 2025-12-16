@extends('layouts.front')

@section('title')
    Category
@endsection

@section('content')
<div style="padding: 0; background: #f8f9fa;">
    <div style="max-width: 1200px; margin: auto;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <img src="{{ asset('assets/images/header.png') }}" alt="Header Image" 
            style="width: 100%; max-height: 300px; object-fit: cover; margin-bottom: 2rem;">
            
            <h2 style="font-size: 2.5rem; font-weight: 600; color: #dc3545;">CATEGORIES</h2>
            <p style="font-size: 1.2rem; color: #333; max-width: 600px; margin: auto;">
                Explore our diverse range of categories to find what you love.
            </p>
        </div>
        <div id="category-container" style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 2rem;">
            @foreach ($category as $cate)
            <div class="category-card" style="flex: 1 1 calc(33.33% - 1rem); margin-bottom: 2rem; opacity: 0;">
                <a href="{{ url('view-category/'.$cate->slug) }}" style="text-decoration: none;">
                    <div style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: transform 0.3s, box-shadow 0.3s; display: flex; flex-direction: column; height: 100%;">
                        <img src="{{ asset('assets/uploads/category/'.$cate->image) }}" style="width: 100%; height: 200px; object-fit: cover;" alt="Category image">
                        <div style="padding: 2rem; text-align: center; flex-grow: 1; background: #ffffff;">
                            <h5 style="font-size: 1.5rem; margin: 0; color: #343a40;">{{ $cate->name }}</h5>
                            <p style="margin: 0.5rem 0; color: #6c757d; line-height: 1.5;">{{ $cate->description }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

@include('layouts.inc.frontfooter')
@endsection

@section('scripts')
<script>
// Function to apply slide-in animation
function slideIn(element, delay) {
    element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    element.style.transform = 'translateY(20px)';
    element.style.opacity = '0';

    setTimeout(() => {
        element.style.transform = 'translateY(0)';
        element.style.opacity = '1';
    }, delay);
}

const cards = document.querySelectorAll('.category-card');
cards.forEach((card, index) => {
    slideIn(card, index * 100);
});

cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
        const cardDiv = card.querySelector('div');
        cardDiv.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.2)';
        cardDiv.style.transform = 'scale(1.05)';
    });

    card.addEventListener('mouseleave', () => {
        const cardDiv = card.querySelector('div');
        cardDiv.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.1)'; 
        cardDiv.style.transform = 'scale(1)';
    });
});
</script>
@endsection