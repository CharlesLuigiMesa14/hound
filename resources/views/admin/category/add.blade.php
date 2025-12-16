@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            padding-top: 10px; /* Prevent overlap with navbar */
            background-color: #f8f9fa; /* Light off-white background */
        }
        .card {
            border: 1px solid #dee2e6;
            margin-top: 20px;
            border-radius: 0.5rem; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .card-body {
            padding: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        label {
            font-weight: 600;
        }
        .form-control {
            border: none; /* No border */
            border-bottom: 1px solid #ced4da; /* Only bottom border */
            box-shadow: none;
            width: 100%; /* Ensure full width */
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #007bff; /* Change bottom border color on focus */
        }
        textarea {
            resize: none;
        }
        .icon-color {
            color: #007bff; /* Default icon color */
        }
        .status-icon {
            color: #28a745; /* Green for active status */
        }
        .popular-icon {
            color: #ffc107; /* Warning color for popular */
        }
        .custom-file-input {
            display: none; /* Hide the default file input */
        }
        .custom-file-label {
            display: inline-block; /* Keep label inline */
            padding: 0.5rem 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #f8f9fa; /* Light background for visibility */
            color: #333;
            cursor: pointer;
            margin-top: 5px; /* Margin to separate from the image */
        }
        .image-upload-container {
            display: flex;
            flex-direction: column; /* Stack image and upload section vertically */
            align-items: center; /* Center items horizontally */
            margin-bottom: 20px; /* Space below the image uploader */
        }
        .image-preview {
            max-height: 200px; /* Increase max height for larger image */
            object-fit: cover;
            margin-bottom: 10px; /* Space between image and file input */
        }
        .upload-section {
            display: flex;
            flex-direction: column; /* Stack label and input */
            align-items: flex-start; /* Align the upload section */
            width: 200px; /* Fixed width for the upload section */
        }
        .accept-text {
            margin-top: 5px; /* Adjust margin */
            font-size: 0.9rem; /* Slightly smaller font size */
            color: #6c757d; /* Muted color */
        }
        .submit-button {
            display: flex;
            justify-content: flex-end; /* Align to the right */
        }
        hr {
            margin: 20px 0; /* Spacing for the horizontal line */
        }
        .image-label {
            margin-bottom: 10px; /* Adjust as needed */
        }
        .section-title {
            margin-bottom: 20px; /* Space below the title */
            font-size: 1.5rem; /* Larger title font */
        }
    </style>
    <title>Add Category</title>
</head>
<body>

<div class="container">
    <h4 class="section-title"><i class="fas fa-plus icon-color"></i> <strong>Add Category</strong></h4>
    <div class="card">
        <div class="card-body">
            <form action="{{ url('insert-category') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3 form-group">
                        <label for="name"><i class="fas fa-tag icon-color"></i> Name</label>
                        <input type="text" id="name" class="form-control" name="name" placeholder="Enter category name" required>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="slug"><i class="fas fa-link icon-color"></i> Slug</label>
                        <input type="text" id="slug" class="form-control" name="slug" placeholder="Enter category slug" required>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="description"><i class="fas fa-info-circle icon-color"></i> Description</label>
                        <textarea id="description" name="description" rows="3" class="form-control" placeholder="Enter category description" required></textarea>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="status"><i class="fas fa-check-circle status-icon"></i> Status</label>
                        <div>
                            <input type="checkbox" id="status" name="status">
                            <label for="status"> Active</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3 form-group">
                        <label for="popular"><i class="fas fa-star popular-icon"></i> Popular</label>
                        <div>
                            <input type="checkbox" id="popular" name="popular">
                            <label for="popular"> Yes</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="meta_title"><i class="fas fa-heading icon-color"></i> Meta Title</label>
                        <input type="text" id="meta_title" class="form-control" name="meta_title" placeholder="Enter meta title">
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="meta_keywords"><i class="fas fa-key icon-color"></i> Meta Keywords</label>
                        <textarea id="meta_keywords" name="meta_keywords" rows="3" class="form-control" placeholder="Enter meta keywords"></textarea>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="meta_description"><i class="fas fa-file-alt icon-color"></i> Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" class="form-control" placeholder="Enter meta description"></textarea>
                    </div>
                    <div class="col-md-12 mb-3 form-group">
                        <label for="image" class="image-label"><i class="fas fa-image icon-color"></i> Category Image</label>
                        <div class="image-upload-container">
                            <img id="imagePreview" src="#" alt="Image preview" class="img-fluid image-preview" style="display:none;">
                        </div>
                        <div class="upload-section">
                            <label for="image" class="custom-file-label">Choose file</label>
                            <input type="file" id="image" name="image" class="custom-file-input" accept=".png, .jpg, .jpeg">
                            <small class="accept-text">
                                <i class="fas fa-image"> </i> Accepts PNG and JPG only.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="submit-button">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit</button>
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

        // Show image preview
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imagePreview = document.getElementById('imagePreview');
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Show the image
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>
@endsection