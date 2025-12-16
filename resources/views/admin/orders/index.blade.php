@extends('layouts.admin')

@section('title')
    New Orders Dashboard
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="title-bar bg-dark-red text-white d-flex justify-content-between align-items-center" style="padding: 15px;">
                    <h4 class="m-0">
                        <i class="fas fa-shopping-cart"></i> New Orders
                    </h4>
                    <a href="{{ url('order-history') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-history"></i> Order History
                    </a>
                </div>
                <div class="card-body">
                    <!-- Tab Navigation -->
                    <ul class="use-tabs mb-3">
                        <li class="use-item">
                            <a class="use-link active" id="all-orders-tab" data-toggle="tab" href="#all-orders" role="tab" aria-controls="all-orders" aria-selected="true">All Orders</a>
                        </li>
                        <li class="use-item">
                            <a class="use-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
                        </li>
                        <li class="use-item">
                            <a class="use-link" id="preparing-tab" data-toggle="tab" href="#preparing" role="tab" aria-controls="preparing" aria-selected="false">Preparing</a>
                        </li>
                        <li class="use-item">
                            <a class="use-link" id="ready-tab" data-toggle="tab" href="#ready" role="tab" aria-controls="ready" aria-selected="false">Ready to Deliver</a>
                        </li>
                        <li class="use-item">
                            <a class="use-link" id="shipped-tab" data-toggle="tab" href="#shipped" role="tabpanel" aria-controls="shipped" aria-selected="false">Shipped</a>
                        </li>
                        <li class="use-item">
                            <a class="use-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tabpanel" aria-controls="cancelled" aria-selected="false">Cancelled</a>
                        </li>
                    </ul>

                    <input type="text" id="searchInput" placeholder="Search by Tracking Number or Customer Name..." class="form-control mb-3">

                    <div class="tab-content" id="orderTabsContent">
                        <div class="tab-pane fade show active" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">
                            <table class="table table-striped text-left" id="ordersTable">
                                <thead>
                                    <tr>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-truck"></i> Tracking Number</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-user"></i> Customer Name</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-calendar-alt"></i> Order Date</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-money-bill-wave"></i> Total Price</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-check-circle"></i> Status</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-cogs"></i> Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $item)
                                        @if ($item->status != 5 && $item->status != 1) <!-- Exclude cancelled orders -->
                                            <tr class="table-content" data-status="{{ $item->status }}">
                                                <td>{{ $item->tracking_no }}</td>
                                                <td>{{ $item->fname }} {{ $item->lname }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>₱{{ number_format($item->total_price, 2) }}</td>
                                                <td>
                                                    <div class="
                                                        {{ $item->status == '0' ? 'status-pending' : 
                                                           ($item->status == '2' ? 'status-preparing' : 
                                                           ($item->status == '3' ? 'status-ready' : 
                                                           ($item->status == '4' ? 'status-shipped' : 
                                                           'status-cancelled'))) 
                                                        }}">
                                                        <span>
                                                            <i class="
                                                                {{ $item->status == '0' ? 'fas fa-clock' : 
                                                                   ($item->status == '2' ? 'fas fa-tools' : 
                                                                   ($item->status == '3' ? 'fas fa-check-circle' : 
                                                                   ($item->status == '4' ? 'fas fa-shipping-fast' : 
                                                                   'fas fa-ban'))) 
                                                                }}"></i>
                                                            {{ $item->status == '0' ? 'Pending' : 
                                                               ($item->status == '2' ? 'Preparing' : 
                                                               ($item->status == '3' ? 'Ready to Deliver' : 
                                                               ($item->status == '4' ? 'Shipped' : 
                                                               'Cancelled'))) 
                                                            }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
    <a href="{{ url('admin/view-order/'.$item->id) }}" class="btn btn-info btn-sm">
        <i class="fas fa-eye"></i>
    </a>
    @if ($item->status == 0) <!-- Pending -->
        <button class="btn btn-success btn-sm promote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
            <i class="fas fa-arrow-right"></i> Promote
        </button>
    @elseif ($item->status == 4) <!-- Shipped -->
        <button class="btn btn-warning btn-sm demote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
            <i class="fas fa-arrow-left"></i> Demote
        </button>
        <button class="btn btn-success btn-sm promote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
            <i class="fas fa-check-circle"></i> Complete
        </button>
    @else
        <button class="btn btn-warning btn-sm demote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
            <i class="fas fa-arrow-left"></i> Demote
        </button>
        <button class="btn btn-success btn-sm promote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
            <i class="fas fa-arrow-right"></i> Promote
        </button>
    @endif
    @if ($item->status != 3 && $item->status != 4) 
    <!-- <button class="btn btn-danger btn-sm cancel-btn" data-id="{{ $item->id }}">
        <i class="fas fa-ban"></i> Cancel
    </button> -->
    @endif
</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Other tabs for Pending, Preparing, Ready, Shipped, and Cancelled orders go here -->
                        <!-- Example for Pending -->
                        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                            <table class="table table-striped text-left">
                                <thead>
                                    <tr>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-truck"></i> Tracking Number</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-user"></i> Customer Name</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-calendar-alt"></i> Order Date</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-money-bill-wave"></i> Total Price</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-check-circle"></i> Status</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-cogs"></i> Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders->where('status', '0') as $item) <!-- Only Pending orders -->
                                    <tr class="table-content">
                                        <td>{{ $item->tracking_no }}</td>
                                        <td>{{ $item->fname }} {{ $item->lname }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td>₱{{ number_format($item->total_price, 2) }}</td>
                                        <td>
                                            <div class="status-pending">
                                                <span>
                                                    <i class="fas fa-clock"></i> Pending
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/view-order/'.$item->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button class="btn btn-success btn-sm promote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                                <i class="fas fa-arrow-right"></i> Promote
                                            </button>
                                            <!-- <button class="btn btn-danger btn-sm cancel-btn" data-id="{{ $item->id }}">
                                                <i class="fas fa-ban"></i> Cancel
                                            </button> -->
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="shipped" role="tabpanel" aria-labelledby="shipped-tab">
    <table class="table table-striped text-left">
        <thead>
            <tr>
                <th class="font-bold"><div class="icon-title"><i class="fas fa-truck"></i> Tracking Number</div></th>
                <th class="font-bold"><div class="icon-title"><i class="fas fa-user"></i> Customer Name</div></th>
                <th class="font-bold"><div class="icon-title"><i class="fas fa-calendar-alt"></i> Order Date</div></th>
                <th class="font-bold"><div class="icon-title"><i class="fas fa-money-bill-wave"></i> Total Price</div></th>
                <th class="font-bold"><div class="icon-title"><i class="fas fa-check-circle"></i> Status</div></th>
                <th class="font-bold"><div class="icon-title"><i class="fas fa-cogs"></i> Action</div></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders->where('status', 4) as $item) <!-- Only Shipped orders -->
            <tr class="table-content">
                <td>{{ $item->tracking_no }}</td>
                <td>{{ $item->fname }} {{ $item->lname }}</td>
                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                <td>₱{{ number_format($item->total_price, 2) }}</td>
                <td>
                    <div class="status-shipped">
                        <span>
                            <i class="fas fa-shipping-fast"></i> Shipped
                        </span>
                    </div>
                </td>
                <td>
                    <a href="{{ url('admin/view-order/'.$item->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button class="btn btn-warning btn-sm demote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                        <i class="fas fa-arrow-left"></i> Demote
                    </button>
                    <button class="btn btn-success btn-sm promote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                        <i class="fas fa-check-circle"></i> Complete
                    </button>
                </td>
            </tr>
            @endforeach
              @foreach ($orders->where('status', 4) as $item) <!-- Only Shipped orders -->
            <tr class="table-content">
                <td>{{ $item->tracking_no }}</td>
                <td>{{ $item->fname }} {{ $item->lname }}</td>
                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                <td>₱{{ number_format($item->total_price, 2) }}</td>
                <td>
                    <div class="status-shipped">
                        <span>
                            <i class="fas fa-shipping-fast"></i> Shipped
                        </span>
                    </div>
                </td>
                <td>
                    <a href="{{ url('admin/view-order/'.$item->id) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <button class="btn btn-warning btn-sm demote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                        <i class="fas fa-arrow-left"></i> Demote
                    </button>
                    <button class="btn btn-success btn-sm promote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                        <i class="fas fa-check-circle"></i> Complete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

                        <!-- Repeat similar structure for Preparing, Ready, Shipped, and Cancelled tabs -->
                        @foreach (['2' => 'Preparing', '3' => 'Ready', '4' => 'Shipped', '5' => 'Cancelled'] as $status => $statusLabel)
                        <div class="tab-pane fade" id="{{ strtolower(str_replace(' ', '-', $statusLabel)) }}" role="tabpanel" aria-labelledby="{{ strtolower(str_replace(' ', '-', $statusLabel)) }}-tab">
                            <table class="table table-striped text-left">
                                <thead>
                                    <tr>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-truck"></i> Tracking Number</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-user"></i> Customer Name</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-calendar-alt"></i> Order Date</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-money-bill-wave"></i> Total Price</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-check-circle"></i> Status</div></th>
                                        <th class="font-bold"><div class="icon-title"><i class="fas fa-cogs"></i> Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders->where('status', $status) as $item)
                                    <tr class="table-content">
                                        <td>{{ $item->tracking_no }}</td>
                                        <td>{{ $item->fname }} {{ $item->lname }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                        <td>₱{{ number_format($item->total_price, 2) }}</td>
                                        <td>
                                            <div class="
                                                {{ $item->status == '2' ? 'status-preparing' : 
                                                   ($item->status == '3' ? 'status-ready' : 
                                                   ($item->status == '4' ? 'status-shipped' : 
                                                   'status-cancelled')) 
                                                }}">
                                                <span>
                                                    <i class="
                                                        {{ $item->status == '2' ? 'fas fa-tools' : 
                                                           ($item->status == '3' ? 'fas fa-check-circle' : 
                                                           ($item->status == '4' ? 'fas fa-shipping-fast' : 
                                                           'fas fa-ban')) 
                                                        }}"></i>
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/view-order/'.$item->id) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($item->status != 5) <!-- No promote/demote buttons for Cancelled -->
                                                <button class="btn btn-warning btn-sm demote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                                    <i class="fas fa-arrow-left"></i> Demote
                                                </button>
                                                <button class="btn btn-success btn-sm promote-btn" data-id="{{ $item->id }}" data-status="{{ $item->status }}">
                                                    <i class="fas fa-arrow-right"></i> Promote
                                                </button>
                                                @if ($item->status != 3) 
                                                <!-- <button class="btn btn-danger btn-sm cancel-btn" data-id="{{ $item->id }}">
                                                    <i class="fas fa-ban"></i> Cancel
                                                </button> -->
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f7f9fc;
        margin: 0;
        padding: 20px;
    }
    .card {
        background-color: #ffffff;
        border-radius: 8px;
        margin: 20px 0;
    }
    .title-bar h4 {
        color: black;
        margin: 0;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2131;
    }
    .table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 0;
    }
    .table th {
        font-weight: bold;
        background-color: #f8f9fa;
        font-size: 1em;
        text-align: center;
        padding: 12px;
    }
    .table td {
        font-size: 0.95em;
        border: none;
        border-bottom: 1px solid #dee2e6;
        padding: 10px;
        text-align: center;
    }
    .icon-title {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 0.9em;
    }
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
    }
    .status-pending {
        color: #ffcc00; /* Brighter yellow for pending */
    }
    .status-preparing {
        color: gray;
    }
    .status-ready {
        color: #17a2b8;
    }
    .status-shipped {
        color: darkblue;
    }
    .status-cancelled {
        color: #dc3545; /* Red for cancelled */
    }
    .use-tabs {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
    }
    .use-item {
        margin-right: 15px; /* Space between tabs */
    }
    .use-link {
        text-decoration: none;
        padding: 10px 15px;
        color: #555; /* Default text color */
        transition: color 0.3s ease; /* Smooth transition for color change */
    }
    .use-link.active {
        color: rgba(51, 51, 51, 0.8); /* Active text color with low opacity */
        font-weight: bold; /* Optional: make it bold */
        border-bottom: 2px solid darkred; /* Optional: underline effect */
    }
    .use-link:hover {
        color: darkred; /* Change color on hover */
    }
    .promote-btn {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: none;
        background: #28a745; /* Bootstrap success color */
        color: white;
        transition: background-color 0.3s;
    }
    .promote-btn:hover {
        background-color: #218838; /* Darker shade on hover */
    }
    .demote-btn {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border: none;
        background: #ffc107; /* Bootstrap warning color */
        color: white;
        transition: background-color 0.3s;
    }
    .demote-btn:hover {
        background-color: #e0a800; /* Darker shade on hover */
    }
</style>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const allRows = document.querySelectorAll('.table tbody tr');

        allRows.forEach(row => {
            const trackingNumber = row.cells[0].textContent.toLowerCase();
            const customerName = row.cells[1].textContent.toLowerCase();
            if (trackingNumber.includes(searchValue) || customerName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.promote-btn').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id');
        const currentStatus = parseInt(this.getAttribute('data-status'));
        let newStatus;

        // Determine new status based on current status
        switch (currentStatus) {
            case 0: newStatus = 2; break; // Pending to Preparing
            case 2: newStatus = 3; break; // Preparing to Ready
            case 3: newStatus = 4; break; // Ready to Shipped
            case 4: newStatus = 1; break; // Shipped to Completed
            default: return;
        }

        Swal.fire({
            title: 'Confirm Promotion',
            text: "Are you sure you want to promote this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, promote it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/promote-order/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ newStatus: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Promoted!', 'The order status has been updated.', 'success');
                        location.reload();
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Something went wrong: ' + error.message, 'error');
                });
            }
        });
    });
});


document.querySelectorAll('.demote-btn').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id');
        const currentStatus = parseInt(this.getAttribute('data-status'));
        let newStatus;

        // Determine new status based on current status
        switch (currentStatus) {
            case 2: newStatus = 0; break; // Preparing to Pending
            case 3: newStatus = 2; break; // Ready to Preparing
            case 4: newStatus = 3; break; // Shipped to Ready
            default: return; // No action for Pending or Completed
        }

        Swal.fire({
            title: 'Confirm Demotion',
            text: "Are you sure you want to demote this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, demote it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/demote-order/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ newStatus: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Demoted!', 'The order status has been updated.', 'success');
                        location.reload();
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Something went wrong: ' + error.message, 'error');
                });
            }
        });
    });
});

    // Add event listeners for tab functionality
    document.querySelectorAll('.use-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.use-link').forEach(l => l.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
            
            this.classList.add('active');
            const target = this.getAttribute('href');
            document.querySelector(target).classList.add('show', 'active');
        });
    });
    document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-id');

        Swal.fire({
            title: 'Confirm Cancellation',
            text: "Are you sure you want to cancel this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                const reason = prompt("Please enter cancellation reason (0-4):");
                if (reason !== null) {
                    fetch(`/cancel-order/${orderId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ reason: reason })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Cancelled!', 'The order has been cancelled.', 'success');
                            location.reload();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Something went wrong: ' + error.message, 'error');
                    });
                }
            }
        });
    });
});
</script>
@endsection