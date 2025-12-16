@extends('layouts.admin')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Adding Roboto font -->
    <style>
        body {
            background-color: #f8f9fa; /* Light background for the body */
            color: #333; /* Dark text color */
            font-family: 'Roboto', Arial, sans-serif; /* Apply Roboto font */
            margin: 0; /* Remove default margin */
        }
        .container {
            max-width: 1400px; /* Increased container width */
            margin: 20px auto; /* Centered with auto margins */
            padding: 0 15px; /* Added horizontal padding */
        }
        .card {
            margin: 20px 0;
            border-radius: 8px; /* Rounded corners for the card */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            background-color: #ffffff; /* White background for the card */
        }
        .table {
            border-radius: 8px; /* Rounded corners for the table */
            margin-bottom: 0; /* Remove bottom margin for cleaner look */
            border: 1px solid #dee2e6; /* Add a border around the table */
            border-spacing: 0; /* Remove spacing between cells */
        }
        .table th, .table td {
            vertical-align: middle; /* Align text vertically */
            text-align: center; /* Center text */
            padding: 20px 30px; /* Vertical padding 20px, horizontal padding 30px */
            border-top: 1px solid #dee2e6; /* Top border for each cell */
            border-left: none; /* Remove left border */
            border-right: none; /* Remove right border */
        }
        .table th {
            font-weight: bold; /* Ensure header text is bold */
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9; /* Light gray for odd rows */
        }
        .cate-image {
            width: 60px; /* Adjusted image size */
            height: auto;
            border-radius: 4px; /* Rounded corners for the image */
        }
        .btn-icon {
            background: none; /* No background */
            border: none; /* No border */
            cursor: pointer; /* Pointer cursor on hover */
            color: #007bff; /* Blue icon color */
        }
        .btn-icon:hover {
            color: #0056b3; /* Darker blue on hover */
        }
        th {
            background-color: #ffffff; /* White background for header */
            color: #333; /* Dark text color for header */
        }
        th:nth-child(1), th:nth-child(2), th:nth-child(3), th:nth-child(4), th:nth-child(5) {
            font-weight: bold; /* Bold for specific columns */
        }
        th:nth-child(1) {
            text-transform: uppercase; /* Capitalize only ID header */
        }
        th:nth-child(n+2) {
            text-transform: capitalize; /* Capitalize only the first letter for other headers */
        }
        .action-icon {
            color: #007bff; /* Blue color for edit icon */
        }
        .delete-icon {
            color: #dc3545; /* Red color for delete icon */
        }
        tr:hover {
            background-color: #e9ecef; /* Light gray on row hover */
        }
        .card-title {
            font-size: 1.6rem; /* Adjusted font size */
            font-weight: bold; /* Bold title */
            color: #333; /* Darker title color */
        }
        hr {
            border: 1px solid #dee2e6; /* Light gray for horizontal rule */
        }
        /* New styles for description */
        .description-cell {
            text-align: justify; /* Justify text */
            padding-left: 15px; /* Left padding */
            padding-right: 15px; /* Right padding */
        }
    </style>
    <title>Category Page</title>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><i class="fas fa-th-list"></i> Category Page</h4>
            <hr>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><i class="fas fa-id-badge"></i><strong>ID</strong></th>
                        <th><i class="fas fa-image"></i><strong>Image</strong></th>
                        <th><i class="fas fa-tag"></i><strong>Name</strong></th>
                        <th><i class="fas fa-info-circle"></i> <strong>Description</strong></th>
                        <th><i class="fas fa-cogs"></i><strong>Action</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            <img src="{{ asset('assets/uploads/category/'.$item->image) }}" class="cate-image" alt="Image for {{ $item->name }}">
                        </td>
                        <td>{{ $item->name }}</td>
                        <td class="description-cell">{{ $item->description }}</td>
                        <td>
                            <button class="btn-icon" onclick="window.location.href='{{ url('edit-category/'.$item->id) }}'">
                                <i class="fas fa-edit action-icon"></i>
                            </button>
                            <button class="btn-icon" onclick="if(confirm('Are you sure you want to delete this category?')) window.location.href='{{ url('delete-category/'.$item->id) }}'">
                                <i class="fas fa-trash delete-icon"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
</body>
</html>
@endsection