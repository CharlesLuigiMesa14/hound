@extends('layouts.front')

@section('title')
    My Orders
@endsection

@section('content')
    <div class="container py-5" style="background-color: #f8f9fa;">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #e74c3c;">
                        <h4 class="text-white mb-0">My Orders</h4>
                    </div>
                    <div class="card-body">
                        <!-- Filter Menu -->
                        <div class="mb-4 text-center">
                            <form method="GET" action="{{ url('my-orders') }}">
                                <div class="btn-group" role="group" aria-label="Order Status Filter">
                                    <button type="submit" name="status" value=""
                                        class="btn btn-link {{ request('status') === null ? 'active' : '' }}"><i class="fas fa-th"></i> All Orders</button>
                                    <button type="submit" name="status" value="0"
                                        class="btn btn-link {{ request('status') == '0' ? 'active' : '' }}"><i class="fas fa-clock"></i> Pending</button>
                                    <button type="submit" name="status" value="2"
                                        class="btn btn-link {{ request('status') == '2' ? 'active' : '' }}"><i class="fas fa-spinner"></i> Preparing</button>
                                    <button type="submit" name="status" value="3"
                                        class="btn btn-link {{ request('status') == '3' ? 'active' : '' }}"><i class="fas fa-truck"></i> Ready for Delivery</button>
                                    <button type="submit" name="status" value="4"
                                        class="btn btn-link {{ request('status') == '4' ? 'active' : '' }}"><i class="fas fa-box"></i> Shipped</button>
                                    <button type="submit" name="status" value="1"
                                        class="btn btn-link {{ request('status') == '1' ? 'active' : '' }}"><i class="fas fa-check-circle"></i> Completed</button>
                                    <button type="submit" name="status" value="5"
                                        class="btn btn-link {{ request('status') == '5' ? 'active' : '' }}"><i class="fas fa-ban"></i> Cancelled</button>
                                </div>
                            </form>
                        </div>

                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th><i class="fas fa-calendar-alt"></i> Order Date</th>
                                    <th><i class="fas fa-truck"></i> Tracking Number</th>
                                    <th><i class="fas fa-coins"></i> Total Price</th>
                                    <th class="text-center"><i class="fas fa-info-circle"></i> Status</th>
                                    <th class="text-center"><i class="fas fa-eye"></i> Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $statusFilter = request('status');
                                    $filteredOrders = $orders->filter(function ($item) use ($statusFilter) {
                                        return $statusFilter === null || $item->status == $statusFilter;
                                    });
                                @endphp

                                @foreach ($filteredOrders as $item)
                                
                                    <tr style="transition: background-color 0.3s; cursor: pointer;"
                                        onmouseover="this.style.backgroundColor='#e2e6ea'"
                                        onmouseout="this.style.backgroundColor='';">
                                        <td>{{ date('F j, Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ $item->tracking_no }}</td>
                                        <td>₱ {{ number_format($item->total_price, 2) }}</td>
                                        <td class="text-center">
                                            <span style="color: 
                                            {{ $item->status == '0' ? '#cc9a00' : // Darkened color for Pending
                                               ($item->status == '1' ? '#28a745' : 
                                               ($item->status == '2' ? '#0066cc' : // Darkened color for Preparing
                                               ($item->status == '3' ? '#17a2b8' : 
                                               ($item->status == '4' ? '#5a329a' : '#b22234')))) }}; 
                                               font-size: 1em;">
                                                <i class="{{ $item->status == '0' ? 'fas fa-clock' : 
                                                           ($item->status == '1' ? 'fas fa-check-circle' : 
                                                           ($item->status == '2' ? 'fas fa-spinner' : 
                                                           ($item->status == '3' ? 'fas fa-truck' : 
                                                           ($item->status == '4' ? 'fas fa-box' : 'fas fa-ban')))) }}"></i>
                                                {{ $item->status == '0' ? 'Pending' : 
                                                   ($item->status == '1' ? 'Completed' : 
                                                   ($item->status == '2' ? 'Preparing' : 
                                                   ($item->status == '3' ? 'Ready for Delivery' : 
                                                   ($item->status == '4' ? 'Shipped' : 'Cancelled')))) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('view-order/' . $item->id) }}"
                                                style="color: #007bff; text-decoration: none; font-size: 0.85em; transition: color 0.3s;">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @if ($item->status == '1')
                                                <button class="btn-reorder" data-id="{{ $item->id }}"
                                                    style="color: #28a745; text-decoration: none; font-size: 0.85em; margin-left: 10px; border: none; background: none; cursor: pointer;">
                                                    <i class="fas fa-redo"></i> Reorder
                                                </button>
                                            @endif
                                            @if (in_array($item->status, [0, 2])) <!-- Only show cancel button for specific statuses -->
                                                <button class="btn-cancel" data-id="{{ $item->id }}"
                                                    style="color: #dc3545; text-decoration: none; font-size: 0.85em; margin-left: 10px; border: none; background: none; cursor: pointer;">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.querySelectorAll('.btn-reorder').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                html: `
                    <div style="text-align: center;">
                        <p style="font-weight: bold; color: #333; line-height: 1.2;">Note!</p>
                        <p style="margin-top: 10px; font-style: italic; color: #555;">
                            All current items in your cart will be removed.
                        </p>
                        <p style="font-style: italic; color: #555;">
                            Do you want to reorder all the items?
                        </p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fas fa-check"></i> Yes, Reorder it!',
                cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                customClass: {
                    popup: 'swal-popup',
                    confirmButton: 'swal-button-confirm',
                    cancelButton: 'swal-button-cancel',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('reorder') }}/" + orderId;
                }
            });
        });
    });

    document.querySelectorAll('.btn-cancel').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id');
            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to cancel this order?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, keep it"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ask for the cancellation reason
                    Swal.fire({
                        title: "Cancellation Reason",
                        input: 'select',
                        inputOptions: {
                            '0': 'Select a reason',
                            '1': 'Changed my mind',
                            '2': 'Found a better price',
                            '3': 'Product not needed anymore',
                            '4': 'Other'
                        },
                        inputPlaceholder: 'Select a reason',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            return new Promise((resolve) => {
                                if (value === '0') {
                                    resolve('You need to select a reason!');
                                } else {
                                    resolve();
                                }
                            });
                        }
                    }).then((result) => {
                        if (result.value) {
                            // AJAX call to cancel the order
                            $.ajax({
                                url: '{{ url('cancel-order') }}/' + orderId,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    reason: result.value // Send the selected reason
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire("Cancelled!", "Your order has been cancelled.", "success")
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire("Error!", response.message, "error");
                                    }
                                },
                                error: function(xhr) {
                                    console.log(xhr);
                                    Swal.fire("Error!", "There was an error cancelling your order.", "error");
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire("Your order is safe!");
                }
            });
        });
    });

    </script>

    <style>
        body {
            font-family: 'Arial', sans-serif; /* A clean, modern font */
        }

        .btn-link {
            border: none;
            color: rgba(51, 51, 51, 0.6);
            padding: 10px 15px;
            text-decoration: none;
            position: relative;
            transition: color 0.3s;
        }

        .btn-link.active {
            color: #e74c3c;
            font-weight: bold;
            border-bottom: 2px solid #e74c3c;
        }

        .btn-link:hover {
            color: #333;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .table td {
            vertical-align: middle;
            font-size: 0.9em; /* Slightly larger font for readability */
        }

        .swal-popup {
            border-radius: 10px;
            padding: 20px; /* Add some padding to the popup */
        }

        .swal-popup .swal2-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px; /* Reduce space below title */
        }

        .swal-popup .swal2-html-container {
            font-size: 1em; /* Slightly smaller font size */
            color: #555;
        }

        .swal-button-confirm,
        .swal-button-cancel {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .swal-button-confirm {
            background-color: #3085d6;
            color: white;
        }

        .swal-button-cancel {
            background-color: #d33;
            color: white;
        }

        .swal-button-confirm i,
        .swal-button-cancel i {
            margin-right: 5px; /* Space between icon and text */
        }

        /* Optional: Add hover effects */
        .swal-button-confirm:hover {
            background-color: #007bff; /* Darker blue on hover */
        }

        .swal-button-cancel:hover {
            background-color: #c82333; /* Darker red on hover */
        }
    </style>
    @include('layouts.inc.frontfooter')
@endsection