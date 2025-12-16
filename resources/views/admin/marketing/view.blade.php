@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa; /* Light background for contrast */
}

.card {
    margin: 20px;
    padding: 30px; /* Increased padding for a thinner card */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Added shadow */
    max-width: 1200px; /* Set a max width for the card */
    margin-left: auto; /* Center the card */
    margin-right: auto; /* Center the card */
}

.card h3 {
    font-weight: 500; /* Slightly bolder header */
}

.table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
}

.table th, 
.table td {
    padding: 15px; /* Adjusted padding for a tighter layout */
    text-align: left;
    border-bottom: 1px solid #ddd; /* Only horizontal borders */
}

.table th {
    background-color: #f4f4f4;
    font-weight: bold; /* Make column headers bold */
}

.table tr:hover {
    background-color: #e9ecef; /* Light hover effect */
}

.btn {
    padding: 5px 10px; /* Reduced padding for thinner buttons */
    font-size: 16px; /* Adjusted font size */
    border: none; /* Remove button border */
    background: none; /* Remove button background */
    cursor: pointer; /* Pointer cursor for button */
    color: #007bff; /* Default color for icons */
    box-shadow: none; /* Removed shadow from buttons */
}

.btn:hover {
    color: #0056b3; /* Darker color on hover */
}

.edit-btn {
    color: #007bff; /* Blue color for edit button */
}

.badge {
    padding: 0.5em 0.75em;
    border-radius: 0.5em;
    color: white;
}

.badge-active {
    background-color: #28a745; /* Green for active */
}

.badge-inactive {
    background-color: #dc3545; /* Red for inactive */
}

.table .action-buttons {
    display: flex; /* Use flexbox for buttons */
    gap: 10px; /* Space between buttons */
}

@media (max-width: 768px) {
    .card {
        padding: 15px; /* Adjust padding for smaller screens */
    }

    .table th, .table td {
        padding: 10px; /* Adjust padding for smaller screens */
    }
}
</style>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <h3>Coupons Overview <i class="fas fa-tags"></i></h3>
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-tag"></i> Coupon Code</th>
                        <th><i class="fas fa-user"></i> Name</th>
                        <th><i class="fas fa-percent"></i> Discount Amount</th>
                        <th><i class="fas fa-money-bill"></i> Discount Type</th>
                        <th><i class="fas fa-calendar-alt"></i> End Date</th>
                        <th><i class="fas fa-check-circle"></i> Status</th>
                        <th><i class="fas fa-cogs"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->name }}</td> <!-- Added Name column -->
                        <td>{{ $coupon->discount_amount }}</td>
                        <td>{{ $coupon->discount_type }}</td>
                        <td>{{ $coupon->end_date ? $coupon->end_date->format('F j, Y') : 'N/A' }}</td> <!-- Improved date format -->
                        <td>
                            @if ($coupon->end_date && $coupon->end_date < now())
                                <span class="badge badge-inactive">Inactive</span>
                            @else
                                <span class="badge badge-active">Active</span>
                            @endif
                        </td>
                        <td class="action-buttons">
                            <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" title="Delete Coupon">
                                    <i class="fas fa-trash text-danger"></i>
                                </button>
                            </form>
                            <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn edit-btn" title="Edit Coupon">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection