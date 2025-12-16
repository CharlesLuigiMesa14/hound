@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card {
            border: 1px solid #dee2e6;
            margin-top: 20px;
            border-radius: 8px;
        }
        .card-body {
            padding: 30px;
        }
        h4 {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            color: #343a40;
            text-align: left; /* Align title to the left */
        }
        label {
            font-weight: 600;
            color: #495057;
        }
        .category-image-label {
            margin-top: 60px;
        }
        .form-control {
            border: none;
            border-bottom: 1px solid #ced4da;
            box-shadow: none;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }
        textarea {
            resize: none;
        }
        .icon-color {
            color: #007bff;
        }
        .status-icon {
            color: #28a745;
        }
        .popular-icon {
            color: #ffc107;
        }
        .custom-file-input {
            display: none;
        }
        .custom-file-label {
            display: inline-block;
            padding: 0.5rem 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
            color: #333;
            cursor: pointer;
            margin-top: 0px;
        }
        .image-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 0px;
        }
        .image-preview {
            max-height: 200px;
            object-fit: cover;
            margin-top: 10px;
            border-radius: 5px;
        }
        .upload-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 200px;
        }
        .accept-text {
            margin-top: 20px;
            align-self: flex-end;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .submit-button {
            display: flex;
            justify-content: flex-end;
        }
        hr {
            margin: 20px 0;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
    <title>Edit/Update Category</title>
</head>
<body>

<div class="container">
    <h4 class="mb-4"><i class="fas fa-edit icon-color"></i> <strong>Edit Category</strong></h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('update-category/'.$category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="name"><i class="fas fa-tag icon-color"></i> Category Name</label>
                        <input type="text" id="name" value="{{ $category->name }}" class="form-control" name="name" placeholder="Enter category name" required>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="slug"><i class="fas fa-link icon-color"></i> SEO Slug</label>
                        <input type="text" id="slug" value="{{ $category->slug }}" class="form-control" name="slug" placeholder="Enter category slug" required>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="description"><i class="fas fa-info-circle icon-color"></i> Category Description</label>
                        <textarea id="description" name="description" rows="3" class="form-control" placeholder="Enter category description" required>{{ $category->description }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="status"><i class="fas fa-check-circle status-icon"></i> Status</label>
                        <div>
                            <input type="checkbox" id="status" {{ $category->status == "1" ? 'checked' : '' }} name="status">
                            <label for="status"> Active</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="popular"><i class="fas fa-star popular-icon"></i> Mark as Popular</label>
                        <div>
                            <input type="checkbox" id="popular" {{ $category->popular == "1" ? 'checked' : '' }} name="popular">
                            <label for="popular"> Yes</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="meta_title"><i class="fas fa-heading icon-color"></i> Meta Title</label>
                        <input type="text" id="meta_title" value="{{ $category->meta_title }}" class="form-control" name="meta_title" placeholder="Enter meta title">
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="meta_keywords"><i class="fas fa-key icon-color"></i> Meta Keywords</label>
                        <textarea id="meta_keywords" name="meta_keywords" rows="3" class="form-control" placeholder="Enter meta keywords">{{ $category->meta_keywords }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="meta_description"><i class="fas fa-file-alt icon-color"></i> Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" class="form-control" placeholder="Enter meta description">{{ $category->meta_descrip}}</textarea>
                    </div>

                    @if ($category->image)
                        <div class="col-md-12 mb-3">
                            <label class="category-image-label"><i class="fas fa-image icon-color"></i> Category Image</label>
                            <div class="upload-section">
                                <label for="image" class="custom-file-label">Choose file</label>
                                <input type="file" id="image" name="image" class="custom-file-input" accept=".png, .jpg, .jpeg">
                                <small class="accept-text">Accepts PNG and JPG only.</small>
                            </div>
                            <div class="image-upload-container">
                                <img src="{{ asset('assets/uploads/category/'.$category->image) }}" alt="Category image" class="img-fluid image-preview" title="{{ $category->name }}">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="submit-button">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Update the label to show the selected file name
    document.querySelector('#image').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : 'Choose file';
        this.previousElementSibling.innerText = fileName;
    });
</script>

</body>
</html>
@endsection