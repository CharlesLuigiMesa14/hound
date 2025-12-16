@extends('layouts.admin')

@section('content')
<div class="card">
    <h3 class="text-center font-weight-bold">
        <i class="fas fa-plus-circle icon"></i> Edit Product
    </h3>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('update-product/'.$products->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateQuantity()">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="category">Category <i class="fas fa-tags icon category-icon"></i></label>
                    <div class="form-control-plaintext" id="category">{{ $products->category->name }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="name">Name <i class="fas fa-box icon product-icon"></i></label>
                    <input type="text" class="form-control" value="{{ $products->name }}" name="name" id="name">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="slug">Slug <i class="fas fa-link icon slug-icon"></i></label>
                    <input type="text" class="form-control" value="{{ $products->slug }}" name="slug" id="slug">
                </div>

                <div class="col-md-12 mb-3">
                    <label for="small_description">Small Description <i class="fas fa-comment icon description-icon"></i></label>
                    <textarea name="small_description" rows="3" class="form-control" id="small_description">{{ $products->small_description }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="description">Description <i class="fas fa-info-circle icon description-icon"></i></label>
                    <textarea name="description" rows="3" class="form-control" id="description">{{ $products->description }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="original_price">Original Price <i class="fas fa-money-bill-wave icon price-icon"></i></label>
                    <input type="number" value="{{ $products->original_price }}" class="form-control" name="original_price" id="original_price">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="selling_price">Selling Price <i class="fas fa-tag icon price-icon"></i></label>
                    <input type="text" class="form-control mb-2" value="{{ $products->selling_price }}" name="selling_price" id="selling_price" readonly style="background: rgba(255, 255, 255, 0.7); opacity: 0.5; cursor: not-allowed;">
                    <small class="form-text text-muted" style="color: #dc3545;">
                        <i class="fas fa-info-circle"></i> This field is read-only and cannot be changed.
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="tax">Tax <i class="fas fa-percent icon tax-icon"></i></label>
                    <input type="number" value="{{ $products->tax }}" class="form-control" name="tax" id="tax">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="qty">Quantity <i class="fas fa-boxes icon quantity-icon"></i></label>
                    <input type="number" value="{{ $products->qty }}" class="form-control" name="qty" id="qty" placeholder="Current quantity: {{ $products->qty }}" min="{{ $products->qty }}">
                    <small id="quantity-note" class="form-text text-danger">
                        <i class="fas fa-exclamation-triangle"></i> Note: You cannot reduce the quantity below the current stock level.
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status <i class="fas fa-check-circle icon status-icon"></i></label>
                    <input type="checkbox" value="1" name="status" {{ $products->status == "1" ? 'checked' : '' }}>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Trending <i class="fas fa-star icon trending-icon"></i></label>
                    <input type="checkbox" value="1" name="trending" {{ $products->trending == "1" ? 'checked' : '' }}>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="meta_title">Meta Title <i class="fas fa-heading icon meta-icon"></i></label>
                    <input type="text" value="{{ $products->meta_title }}" class="form-control" name="meta_title" id="meta_title">
                </div>

                <div class="col-md-12 mb-3">
                    <label for="meta_keywords">Meta Keywords <i class="fas fa-key icon meta-icon"></i></label>
                    <textarea name="meta_keywords" rows="3" class="form-control" id="meta_keywords">{{ $products->meta_keywords }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="meta_description">Meta Description <i class="fas fa-file-alt icon meta-icon"></i></label>
                    <textarea name="meta_description" rows="3" class="form-control" id="meta_description">{{ $products->meta_description }}</textarea>
                </div>

                @if ($products->image)
                <div class="col-md-12 mb-3">
                    <img src="{{ asset('assets/uploads/products/'.$products->image) }}" alt="Product Image" class="img-thumbnail" id="current-image">
                </div>
                @endif

                <div class="col-md-12 mb-3">
                    <label for="image">Upload Image <i class="fas fa-upload icon upload-icon"></i></label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                    <small class="form-text text-muted">Accepted file types: JPEG, PNG, JPG.</small>
                    <img id="image-preview" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display: none; max-width: 200px;">
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-dark-red"><i class="fas fa-save icon save-icon"></i> Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        font-family: 'Roboto', sans-serif; 
        background-color: #f4f4f4; 
        margin: 0; 
        padding: 20px; 
    }
    .card {
        background-color: #ffffff; 
        border-radius: 8px; 
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
        margin: 20px 0; 
    }
    h3.text-center {
        font-weight: bold; 
        margin-top: 20px; 
    }
    hr {
        border: 1px solid #007bff; 
        margin: 20px 0; 
    }
    .form-control, .form-control-plaintext {
        border-radius: 4px; 
    }
    .btn {
        width: 100%; 
        background-color: darkred; 
        color: #ffffff; 
        border: none; 
        border-radius: 4px; 
        transition: background-color 0.3s; 
    }
    .btn:hover {
        background-color: #c00000; 
    }
    .img-thumbnail {
        max-width: 200px; 
        margin-top: 10px; 
    }
    .icon {
        color: #007bff; 
        transition: color 0.3s ease; 
    }
    .category-icon { color: #28a745; }
    .product-icon { color: #17a2b8; }
    .slug-icon { color: #ffc107; }
    .description-icon { color: #007bff; }
    .price-icon { color: #dc3545; }
    .tax-icon { color: #6f42c1; }
    .quantity-icon { color: #fd7e14; }
    .status-icon { color: #28a745; }
    .trending-icon { color: #ffcc00; }
    .meta-icon { color: #007bff; }
    .upload-icon { color: #ffc107; }
    .save-icon { color: #ffffff; }
    .icon:hover { color: darkred; }
</style>

<!-- FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<script>
    function previewImage(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];
        const reader = new FileReader();
        
        reader.onload = function() {
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        
        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }

    function validateQuantity() {
        const currentQty = {{ $products->qty }};
        const newQty = parseInt(document.getElementById('qty').value);
        
        if (newQty < currentQty) {
            alert("Quantity cannot be decreased below the current stock level.");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>
@endsection