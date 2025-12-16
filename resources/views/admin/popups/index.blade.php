@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-4">

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="my-4 font-weight-bold">
                <i class="fas fa-bullhorn"></i> Manage Popups
            </h4>

            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center font-weight-bold"><i class="fas fa-id-badge"></i> ID</th>
                        <th class="text-center font-weight-bold"><i class="fas fa-heading"></i> Title</th>
                        <th class="text-center font-weight-bold"><i class="fas fa-file-alt"></i> Content</th>
                        <th class="text-center font-weight-bold"><i class="fas fa-calendar-alt"></i> Expiry Date</th>
                        <th class="text-center font-weight-bold"><i class="fas fa-toggle-on"></i> Active</th>
                        <th class="text-center font-weight-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($popups as $popup)
                        <tr>
                            <td class="text-center">{{ $popup->id }}</td>
                            <td class="text-center">{{ $popup->title }}</td>
                            <td class="text-center">{{ $popup->content }}</td>
                            <td class="text-center">{{ $popup->expiry_date ? \Carbon\Carbon::parse($popup->expiry_date)->format('Y-m-d') : 'N/A' }}</td>
                            <td class="text-center">
                                @if($popup->is_active)
                                    <span style="color: green; font-weight: bold; padding: 5px;">
                                        <i class="fas fa-check-circle"></i> Active
                                    </span>
                                @else
                                    <span style="color: gray; font-weight: bold; padding: 5px;">
                                        <i class="fas fa-times-circle"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('popups.edit', $popup->id) }}" title="Edit" class="action-icon edit-icon">
                                    <i class="fas fa-edit" style="color: #007bff;"></i>
                                </a>
                                <a href="#" onclick="confirmDelete({{ $popup->id }})" title="Delete" class="action-icon delete-icon">
                                    <i class="fas fa-trash-alt" style="color: red;"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $popups->links() }}
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will not be able to recover this popup!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("popups/") }}/' + id; // Adjust the URL as needed
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
</script>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    table {
        border-collapse: collapse;
    }
    th, td {
        border: none; /* Remove vertical borders */
        padding: 12px;
    }
    tr {
        border-bottom: 1px solid #dee2e6; /* Horizontal border */
    }
    tr:last-child {
        border-bottom: none; /* Remove bottom border for the last row */
    }
    .card {
        border-radius: 0.5rem;
    }
    .action-icon {
        text-decoration: none; /* Remove underline */
        margin: 0 5px; /* Space between icons */
        font-size: 1.5em; /* Icon size */
        transition: transform 0.3s;
    }
    .action-icon:hover {
        transform: scale(1.1); /* Slightly enlarge on hover */
    }
</style>

@endsection