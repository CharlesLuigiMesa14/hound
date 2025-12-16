@extends('layouts.admin')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .note-icon {
            margin-right: 5px;
        }
        .note {
            opacity: 0.85;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }
        .form-group label {
            font-weight: bold;
        }
        .upload-icon {
            color: #007bff;
        }
        .img-thumbnail {
            display: none; /* Hide preview by default */
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 200px;
            height: auto;
        }
        .filename-container {
            margin-top: 10px;
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card p-4" style="background-color: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h3 class="mb-4">
            <i class="fas fa-bullhorn" style="color: #333; font-weight: bold;"></i>
            <span style="color: #333; font-weight: bold;">Create New Popup</span>
        </h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('popups.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title"><i class="fas fa-heading" style="color: #c00000;"></i> Title</label>
                <input type="text" name="title" class="form-control" required placeholder="Enter popup title">
                <small class="note">
                    <i class="fas fa-pencil-alt note-icon"></i> This is the title of the popup.
                </small>
            </div>
            <div class="form-group">
                <label for="content"><i class="fas fa-file-alt" style="color: #c00000;"></i> Content</label>
                <textarea name="content" class="form-control" placeholder="Enter popup content"></textarea>
                <small class="note">
                    <i class="fas fa-info-circle note-icon"></i> Provide the content displayed in the popup.
                </small>
            </div>
            <div class="form-group">
                <label for="image">Upload Image <i class="fas fa-upload icon upload-icon"></i></label>
                <input type="file" name="image" class="form-control" id="image" accept="image/png, image/jpeg" onchange="previewImage(event)">
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> Accepted file types: JPEG, PNG, JPG.
                </small>
                <img id="image-preview" class="img-thumbnail" alt="Image Preview">
                <div id="filename-container" class="filename-container" style="display: none;"></div>
            </div>
            <div class="form-group">
                <label for="expiry_date"><i class="fas fa-calendar-alt" style="color: #c00000;"></i> Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control">
                <small class="note">
                    <i class="fas fa-clock note-icon"></i> Optional: Set an expiry date for the popup.
                </small>
            </div>
            <div class="form-group">
                <label for="is_active"><i class="fas fa-check-circle" style="color: #28a745;"></i> Active</label>
                <input type="checkbox" name="is_active" value="1">
            </div>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-plus-circle"></i> Create Popup
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            const filenameContainer = document.getElementById('filename-container');
            const file = event.target.files[0];

            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = 'block'; // Show the preview

                // Display the filename
                filenameContainer.textContent = file.name; // Set the filename text
                filenameContainer.style.display = 'block'; // Show the filename container
            } else {
                imagePreview.style.display = 'none'; // Hide preview if no file is selected
                filenameContainer.style.display = 'none'; // Hide filename if no file is selected
            }
        }
    </script>
@endsection