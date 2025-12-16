@extends('layouts.admin')

@section('content')
<div class="card">
    <div>
        <h3 class="text-center font-weight-bold"><i class="fas fa-plus-circle icon"></i> Add Product</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('insert-product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="category">Category <i class="fas fa-tags icon category-icon"></i></label>
                    <select class="form-select" name="cate_id" required>
                        <option value="">Select a Category</option>
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="name">Name <i class="fas fa-box icon product-icon"></i></label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="slug">Slug <i class="fas fa-link icon slug-icon"></i></label>
                    <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter product slug" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="small_description">Small Description <i class="fas fa-comment icon description-icon"></i></label>
                    <textarea name="small_description" rows="3" class="form-control" id="small_description" placeholder="Enter small description" required></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="description">Description <i class="fas fa-info-circle icon description-icon"></i></label>
                    <textarea name="description" rows="3" class="form-control" id="description" placeholder="Enter description" required></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="original_price">Original Price <i class="fas fa-money-bill-wave icon price-icon"></i></label>
                    <input type="number" class="form-control" name="original_price" id="original_price" placeholder="Enter original price" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="selling_price">Selling Price <i class="fas fa-tag icon price-icon"></i></label>
                    <input type="number" class="form-control" name="selling_price" id="selling_price" placeholder="Enter selling price" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tax">Tax <i class="fas fa-percent icon tax-icon"></i></label>
                    <input type="number" class="form-control" name="tax" id="tax" placeholder="Enter tax amount" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="qty">Quantity <i class="fas fa-boxes icon quantity-icon"></i></label>
                    <input type="number" class="form-control" name="qty" id="qty" placeholder="Enter quantity" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status <i class="fas fa-check-circle icon status-icon"></i></label>
                    <input type="checkbox" name="status" value="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Trending <i class="fas fa-star icon trending-icon"></i></label>
                    <input type="checkbox" name="trending" value="1">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="meta_title">Meta Title <i class="fas fa-heading icon meta-icon"></i></label>
                    <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Enter meta title">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="meta_keywords">Meta Keywords <i class="fas fa-key icon meta-icon"></i></label>
                    <textarea name="meta_keywords" rows="3" class="form-control" id="meta_keywords" placeholder="Enter meta keywords"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="meta_description">Meta Description <i class="fas fa-file-alt icon meta-icon"></i></label>
                    <textarea name="meta_description" rows="3" class="form-control" id="meta_description" placeholder="Enter meta description"></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="image">Upload Image <i class="fas fa-upload icon upload-icon"></i></label>
                    <input type="file" name="image" class="form-control" id="image" accept="image/png, image/jpeg" onchange="previewImage(event)">
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> Accepted file types: JPEG, PNG, JPG.
                    </small>
                    <img id="image-preview" src="" alt="Image Preview" class="img-thumbnail mt-2" style="display: none; max-width: 200px;">
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-dark-red"><i class="fas fa-save icon save-icon"></i> Submit</button>
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
    .form-control {
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
    .icon {
        color: #007bff; 
        transition: color 0.3s ease; 
    }
    .category-icon {
        color: #28a745; 
    }
    .product-icon {
        color: #17a2b8; 
    }
    .slug-icon {
        color: #ffc107; 
    }
    .description-icon {
        color: #007bff; 
    }
    .price-icon {
        color: #dc3545; 
    }
    .tax-icon {
        color: #6f42c1; 
    }
    .quantity-icon {
        color: #fd7e14; 
    }
    .status-icon {
        color: #28a745; 
    }
    .trending-icon {
        color: #ffcc00; 
    }
    .meta-icon {
        color: #007bff; 
    }
    .upload-icon {
        color: #ffc107; 
    }
    .save-icon {
        color: #ffffff; 
    }
    .icon:hover {
        color: darkred; 
    }
    .img-thumbnail {
        max-width: 200px; 
        margin-top: 10px; 
    }
</style>

<!-- Don't forget to include FontAwesome for icons -->
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
</script>
@endsection