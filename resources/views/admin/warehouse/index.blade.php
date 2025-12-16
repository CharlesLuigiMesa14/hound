@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        
        <div class="card-body">
            <h3 class="my-4 font-weight-bold">Warehouse Management <i class="fas fa-warehouse"></i></h3>

            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center font-weight-bold">Product Image</th>
                        <th class="text-center font-weight-bold">Product Name <i class="fas fa-box"></i></th>
                        <th class="text-center font-weight-bold">Product ID <i class="fas fa-id-card"></i></th>
                        <th class="text-center font-weight-bold">Quantity <i class="fas fa-sort-numeric-up"></i></th>
                        <th class="text-center font-weight-bold">Price <i class="fas fa-tag"></i></th>
                        <th class="text-center font-weight-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($warehouses as $warehouse)
                        <tr>
                            <td class="text-center">
                                @if($warehouse->product->image)
                                    <img src="{{ asset('assets/uploads/products/' . $warehouse->product->image) }}" alt="{{ $warehouse->product->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default.png') }}" alt="No Image" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                            </td>
                            <td class="text-center font-weight-bold">
                                <i class="fas fa-box"></i> {{ $warehouse->product->name }}
                            </td>
                            <td class="text-center">{{ $warehouse->prod_id }}</td>
                            <td class="text-center">{{ $warehouse->quantity }}</td>
                            <td class="text-center">{{ number_format($warehouse->price, 2) }} <i class="fas fa-peso-sign"></i></td>
                            <td class="text-center">
                                <!-- Dispose Button -->
                                <button class="btn btn-danger btn-sm" onclick="confirmDispose({{ $warehouse->id }})">
                                    <i class="fas fa-trash"></i> Dispose
                                </button>
                                <!-- Add to Stock Button -->
                                <button class="btn btn-success btn-sm" onclick="confirmAddToStock({{ $warehouse->id }})">
                                    <i class="fas fa-plus"></i> Add to Stock
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $warehouses->links() }}
        </div>
    </div>
</div>

<script>
    function confirmDispose(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will not be able to recover this product!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, dispose it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("warehouses/") }}/' + id; // Adjust the URL as needed
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = '{{ csrf_token() }}';
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(csrfField);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    function confirmAddToStock(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to add this product to stock.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add to stock!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("warehouses/add/") }}/' + id; // Adjust the URL as needed
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = '{{ csrf_token() }}';
                form.appendChild(csrfField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    table {
        border-collapse: collapse;
    }
    th, td {
        border: none;
        padding: 12px;
    }
    tr {
        border-bottom: 1px solid #dee2e6;
    }
    tr:last-child {
        border-bottom: none;
    }
    .card {
        border-radius: 0.5rem;
    }
</style>
@endsection