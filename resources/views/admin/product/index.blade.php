@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="product-title">
            <i class="fas fa-shopping-cart"></i> Product Page
        </h4>
        <hr>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <form method="GET" action="{{ url('products') }}" class="w-75">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, category, or price..." class="form-control" />
                    <button type="submit" class="btn btn-dark-red ml-2">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <a href="{{ url('archived-products') }}" class="btn btn-danger ml-2">
                <i class="fas fa-archive"></i> View Archived Products
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table text-left">
            <thead>
                <tr>
                    <th class="font-bold">
                        <div class="icon-title">
                            <i class="fas fa-id-badge"></i> ID
                        </div>
                    </th>
                    <th class="font-bold">
                        <div class="icon-title">
                            <i class="fas fa-image"></i> Image
                        </div>
                    </th>
                    <th class="font-bold name-title">
                        <div class="icon-title">
                            <i class="fas fa-box"></i> Name
                        </div>
                    </th>
                    <th class="font-bold">
                        <div class="icon-title">
                            <i class="fas fa-tags"></i> Category
                        </div>
                    </th>
                    <th class="font-bold">
                        <div class="icon-title">
                            <i class="fas fa-money-bill-wave"></i> Selling Price
                        </div>
                    </th>
                    <th class="font-bold">
                        <div class="icon-title">
                            <i class="fas fa-cogs"></i> Action
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                <tr class="table-content">
                    <td>{{ $item->id }}</td>
                    <td>
                        <img src="{{ asset('assets/uploads/products/'.$item->image) }}" class="cate-image" alt="Image here">
                    </td>
                    <td class="name-cell">{{ $item->name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>₱{{ number_format($item->selling_price, 2) }}</td>
                    <td>
                        <a href="{{ url('edit-product/'.$item->id) }}" title="Edit" class="action-icon edit-icon">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if ($item->qty == 0)
                        <a href="{{ url('archive-product/'.$item->id) }}" title="Archive" class="action-icon archive-icon">
                            <i class="fas fa-archive"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
        margin: 0px 0;
        padding: 20px;
    }
    .product-title {
        font-weight: bold;
        font-size: 2em;
        color: #333;
        text-align: left;
    }
    .table {
        border-collapse: collapse;
        width: 100%;

    }
    .table th, .table td {
        padding: 10px;
        text-align: center;
    }
    .icon-title {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .cate-image {
        border-radius: 4px;
        max-width: 120px;
        height: auto;
    }
    .action-icon {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        color: #007bff;
        font-size: 1em;
        margin: 0 5px;
        transition: color 0.3s;
    }
    .archive-icon {
        color: #dc3545; /* Dark Red for archive icon */
    }
    .archive-icon:hover {
        color: #c82333; /* Darker red on hover */
    }
    .btn-dark-red {
        background-color: #8B0000; /* Dark Red */
        color: white;
    }
    .btn-dark-red:hover {
        background-color: #A52A2A; /* Lighter Dark Red on hover */
    }
    .ml-2 {
        margin-left: 0.5rem; /* Margin left for spacing */
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
@endsection