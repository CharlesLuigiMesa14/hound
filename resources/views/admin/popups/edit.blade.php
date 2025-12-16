@extends('layouts.admin')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .btn-blue {
            background-color: #007bff; /* Bootstrap primary blue */
            color: white;
        }
        .btn-blue:hover {
            background-color: #0056b3; /* Darker blue on hover */
            color: white;
        }
        .note {
            font-size: 0.9em;
            color: #666;
        }
        .img-thumbnail {
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 200px;
            height: auto;
        }
    </style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="card p-4" style="background-color: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h3 class="mb-4">
            <i class="fas fa-bullhorn" style="color: #333; font-weight: bold;"></i>
            <span style="color: #333; font-weight: bold;">Edit Popup</span>
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

        <form action="{{ route('popups.update', $popup->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title"><i class="fas fa-heading" style="color: #c00000;"></i> Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $popup->title) }}" required>
                <small class="note">
                    <i class="fas fa-pencil-alt note-icon"></i> Enter the title of the popup.
                </small>
            </div>
            
            <div class="form-group">
                <label for="content"><i class="fas fa-file-alt" style="color: #c00000;"></i> Content</label>
                <textarea name="content" class="form-control" required>{{ old('content', $popup->content) }}</textarea>
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
                @if($popup->image)
                    <img id="image-preview" class="img-thumbnail" src="{{ asset('assets/uploads/popups/' . $popup->image) }}" alt="Current Image">
                @else
                    <img id="image-preview" class="img-thumbnail" alt="No Image Preview">
                @endif
            </div>

            <div class="form-group">
                <label for="expiry_date"><i class="fas fa-calendar-alt" style="color: #c00000;"></i> Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $popup->expiry_date) }}">
                <small class="note">
                    <i class="fas fa-clock note-icon"></i> Optional: Set an expiry date for the popup.
                </small>
            </div>

            <div class="form-group">
                <label for="is_active"><i class="fas fa-toggle-on" style="color: green;"></i> Active</label>
                <input type="checkbox" name="is_active" value="1" {{ $popup->is_active ? 'checked' : '' }}>
            </div>

            <button type="submit" class="btn btn-danger">
                <i class="fas fa-save"></i> Update Popup
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
            const file = event.target.files[0];

            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = 'block'; // Show the preview
            } else {
                imagePreview.style.display = 'none'; // Hide preview if no file is selected
            }
        }
    </script>
@endsection