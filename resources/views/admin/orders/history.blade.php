@extends('layouts.admin')

@section('title')
    Orders History
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="title-bar bg-dark-red text-white d-flex justify-content-between align-items-center" style="padding: 15px;">
                    <h4 class="m-0" style="color: #333;">
                        <i class="fas fa-history"></i> Orders History
                    </h4>
                    <a href="{{ url('orders') }}" class="btn btn-danger btn-sm" style="position: relative;">
                        <i class="fas fa-shopping-cart"></i> New Orders
                    </a>
                </div>
                <div class="card-body">
                    <input type="text" id="searchInput" placeholder="Search by Tracking Number or Customer Name..." class="form-control mb-3">

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
                            <tr class="table-content">
                                <td>{{ $item->tracking_no }}</td>
                                <td>{{ $item->fname }} {{ $item->lname }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                <td>₱{{ number_format($item->total_price, 2) }}</td>
                                <td>
                                    <div class="
                                        {{ $item->status == '0' ? 'status-pending' : 
                                           ($item->status == '1' ? 'status-completed' : 
                                           ($item->status == '2' ? 'status-preparing' : 
                                           ($item->status == '3' ? 'status-ready' : 
                                           ($item->status == '4' ? 'status-shipped' : 
                                           'status-cancelled')))) }}">
                                        <span>
                                            @if ($item->status == '0')
                                                <i class="fas fa-clock"></i> Pending
                                            @elseif ($item->status == '1')
                                                <i class="fas fa-check-circle" style="color: green;"></i> Completed
                                            @elseif ($item->status == '2')
                                                <i class="fas fa-spinner"></i> Preparing
                                            @elseif ($item->status == '3')
                                                <i class="fas fa-truck"></i> Ready to Deliver
                                            @elseif ($item->status == '4')
                                                <i class="fas fa-shipping-fast"></i> Shipped
                                            @else
                                                <i class="fas fa-ban"></i> Cancelled
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ url('admin/view-order/'.$item->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
    }
    .title-bar h4 {
        margin: 0;
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
    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 8px 12px;
        border-radius: 5px;
        border: none;
        text-decoration: none;
    }
    .btn-danger:hover {
        background-color: #c82333;
        transform: scale(1.05);
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
        background-color: #ffc107; /* Yellow */
        color: white; /* Text color */
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        margin: 0 auto;
    }
    .status-completed {
        color: green; /* Text color for completed */
        display: inline-flex;
        align-items: center;
        margin: 0 auto;
    }
    .status-preparing {
        background-color: gray; /* Gray */
        color: white; /* Text color */
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        margin: 0 auto;
    }
    .status-ready {
        background-color: #17a2b8; /* Blue */
        color: white; /* Text color */
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        margin: 0 auto;
    }
    .status-shipped {
        background-color: darkblue; /* Dark Blue */
        color: white; /* Text color */
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        margin: 0 auto;
    }
    .status-cancelled {
        background-color: #dc3545; /* Red */
        color: white; /* Text color */
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        margin: 0 auto;
    }
</style>

<!-- Include FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#ordersTable tbody tr');

        rows.forEach(row => {
            const trackingNumber = row.cells[0].textContent.toLowerCase();
            const customerName = (row.cells[1].textContent).toLowerCase();
            if (trackingNumber.includes(searchValue) || customerName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection