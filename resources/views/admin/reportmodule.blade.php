@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<style>
    /* Your existing CSS styles */
    .container {
        margin-top: 30px;
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        padding: 20px;
    }
    .tabs {
        display: flex;
        cursor: pointer;
        padding: 10px;
        border-bottom: 1px solid #D3D3D3;
    }
    .tab {
        margin-right: 20px;
        padding: 10px;
        border-bottom: 2px solid transparent;
    }
    .tab.active {
        border-bottom: 2px solid #8B0000;
        font-weight: bold;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .badge-danger {
        background-color: #dc3545;
        color: white;
    }
    .badge-warning {
        background-color: #ffc107;
        color: white;
    }
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    .stat-card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 15px;
        margin: 10px;
        text-align: center;
    }
    .stat-card {
        border-radius: 8px;
        padding: 20px;
        margin: 10px 0;
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .stat-card:hover {
        transform: scale(1.02);
    }
    .icon-title {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }
    .icon-title i {
        font-size: 2em;
        margin-right: 10px;
        color: white;
        border-radius: 5px;
        padding: 15px;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    transition: opacity 0.5s ease;
    display: none; /* Hidden by default */
    z-index: 1000; /* Ensure it appears above other content */
}
.total-orders i {
    background-color: #dc3545; /* Red */
}
.completed-orders i {
    background-color: #c82333; /* Dark Red */
}
.pending-orders i {
    background-color: #bd2131; /* Darker Red */
}
.cancelled-orders i {
    background-color: #a71c24; /* Even Darker Red */
}
.total-products i {
    background-color: #dc3545; /* Red */
}
.in-stock-products i {
    background-color: #c82333; /* Dark Red */
}
.low-stock-products i {
    background-color: #bd2131; /* Darker Red */
}
.out-of-stock-products i {
    background-color: #a71c24; /* Even Darker Red */
}
.total-users i {
    background-color: #dc3545; /* Red */
}
.new-users i {
    background-color: #bd2131; /* Darker Red */
}
.total-orders-by-users i {
    background-color: #c82333; /* Dark Red */
}
.revenue-per-user i {
    background-color: #a71c24; /* Even Darker Red */
}
.total-sales i {
    background-color: #ff5733; /* Bright Red */
}
.products-sold i {
    background-color: #ff2e00; /* Vivid Red */
}
.total-revenue i {
    background-color: #e63946; /* Deep Red */
}
.avg-order-value i {
    background-color: #d71a1a; /* Crimson Red */
}
.weekly-sales i {
        background-color: #c0392b; /* Darker Red */
    
    }
    .weekly-sales p {
        color: #922b27; /* Darkest Red */
        font-weight: bold; /* Bold text */
    }

    /* Monthly Sales Card Styles */
    .monthly-sales i {
        background-color: #c0392b; /* Darker Red */
    }
    .monthly-sales p {
        color: #922b27; /* Darkest Red */
        font-weight: bold; /* Bold text */
    }
/* Adjusted text color based on background */
.total-orders p {
    color: #a71c24; /* Even Darker Red */
    font-weight: bold; /* Bold text */
}
.completed-orders p {
    color: #c82333; /* Dark Red */
    font-weight: bold; /* Bold text */
}
.pending-orders p {
    color: #bd2131; /* Darker Red */
    font-weight: bold; /* Bold text */
}
.cancelled-orders p {
    color: #c82333; /* Dark Red */
    font-weight: bold; /* Bold text */
}
.total-products p {
    color: #a71c24; /* Even Darker Red */
    font-weight: bold; /* Bold text */
}
.in-stock-products p {
    color: #c82333; /* Dark Red */
    font-weight: bold; /* Bold text */
}
.low-stock-products p {
    color: #bd2131; /* Darker Red */
    font-weight: bold; /* Bold text */
}
.out-of-stock-products p {
    color: #a71c24; /* Even Darker Red */
    font-weight: bold; /* Bold text */
}
.total-users p {
    color: #a71c24; /* Even Darker Red */
    font-weight: bold; /* Bold text */
}
.new-users p {
    color: #bd2131; /* Darker Red */
    font-weight: bold; /* Bold text */
}
.total-orders-by-users p {
    color: #c82333; /* Dark Red */
    font-weight: bold; /* Bold text */
}
.revenue-per-user p {
    color: #a71c24; /* Even Darker Red */
    font-weight: bold; /* Bold text */
}
.total-sales p {
    color: #ff5733; /* Bright Red */
    font-weight: bold; /* Bold text */
}
.products-sold p {
    color: #ff2e00; /* Vivid Red */
    font-weight: bold; /* Bold text */
}
.total-revenue p {
    color: #e63946; /* Deep Red */
    font-weight: bold; /* Bold text */
}
.avg-order-value p {
    color: #d71a1a; /* Crimson Red */
    font-weight: bold; /* Bold text */
}

    .stat-card h5 {
        margin: 0;
        font-weight: bold;
        color: #333; /* Heading color */
    }
    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
    }
    .table th, .table td {
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }
    .table th {
        background-color: white;
        color: black;
        font-weight: bold;
    }
    .table tr:hover {
        background-color: #e9ecef;
    }
    .table td {
        color: #333;
    }
    .table td:last-child {
        text-align: left;
    }
    .btn {
        margin: 10px 5px;
    }
    .custom-blue {
    background-color: #007bff; /* Bootstrap primary blue */
    color: white; /* Text color */
    border: none; /* Remove border */
    cursor: pointer; /* Pointer cursor on hover */
}

.custom-blue:hover {
    background-color: #0056b3; /* Darker blue on hover */
}


.date-range {
    display: flex;
    flex-direction: column;
    background-color: #f8f9fa; /* Light background for contrast */
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 15px;
    margin-bottom: 20px;
}
.top-customers-title {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #333;
    padding-bottom: 10px;
    color: #333; /* Title color */
}
.date-inputs {
    display: flex;
    align-items: center;
    margin-top: 10px; /* Space between title and inputs */
}

.date-inputs label {
    margin-right: 5px; /* Space between label and input */
    color: #555; /* Label color */
}

.date-inputs input[type="date"] {
    margin: 0 10px; /* Space between inputs */
    padding: 5px;
    border: 1px solid #ced4da;
    border-radius: 4px;
    width: 120px; /* Fixed width for better alignment */
    font-size: 14px;
}
.btn.custom-blue {
    margin-left: 10px; /* Space before the button */
    background-color: #007bff; /* Default background color */
    color: white; /* Text color */
    border: none; /* Remove border */
    cursor: pointer; /* Pointer cursor on hover */
    transition: background-color 0.3s; /* Smooth background transition */
}

.btn.custom-blue:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

.btn.custom-blue:active,
.btn.custom-blue:focus {
    outline: none; /* Remove default outline */
    background-color: #0056b3; /* Keep the darker blue on active */
    box-shadow: none; /* Remove any box-shadow */
}
.top-customers-title {
    display: flex;
    align-items: center;
    border-bottom: 2px solid #333;
    padding-bottom: 10px;
    color: #333; /* Title color */
}

.top-customers-title span {
    margin: 0 5px; /* Add margin to the spans for better spacing */
}
.highlight {
    font-weight: bold; /* Make the text bold */
    padding: 2px 4px; /* Add some padding for better visibility */
    border-radius: 4px; /* Rounded corners */
    color: DarkRed /* Dark text color for contrast */
}
.icon-spacing {
    margin-right: 8px; /* Space to the right of each icon */
}
</style>


<div class="container">
<div id="notification" class="notification" style="display: none;"></div>
    <div class="card">
        <h4 style="color: #333; font-weight: bold; font-size: 2em; margin: 20px;">
            <i class="fas fa-chart-line"></i> Report Module
        </h4>

        <div>
    <button class="btn btn-danger" onclick="printReport()">
        <i class="fas fa-print"></i> Print to PDF
    </button>
    <button class="btn custom-blue" onclick="printToWord()">
        <i class="fas fa-file-word"></i> Print to Word
    </button>
    <button class="btn btn-success" onclick="exportToExcel()">
        <i class="fas fa-file-excel"></i> Download Excel
    </button>
    <button class="btn btn-warning" onclick="exportToCSV()" 
            title="Export data to CSV format">
        <i class="fas fa-file-csv"></i> Export to CSV
    </button>
</div>

        <div class="tabs">
            <div class="tab active" data-target="order-stats">Order Stats</div>
            <div class="tab" data-target="sales-stats">Sales Stats</div>
            <div class="tab" data-target="product-masterlist">Product Masterlist</div>
            <div class="tab" data-target="most-viewed-products">Most Viewed Products</div>
            <div class="tab" data-target="user-stats">User Stats</div>
        </div>

        <!-- Order Stats Tab -->
        <div class="tab-content active" id="order-stats">
            <h5 class="top-customers-title mt-4"><i class="fas fa-list icon-spacing"></i> Orders Stats</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card total-orders">
                        <h5>Total Orders</h5>
                        <div class="icon-title">
                            <i class="fas fa-shopping-cart"></i>
                            <p>{{ $allOrders->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card completed-orders">
                        <h5>Completed Orders</h5>
                        <div class="icon-title">
                            <i class="fas fa-check-circle"></i>
                            <p>{{ $allOrders->where('status', 'completed')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card pending-orders">
                        <h5>Pending Orders</h5>
                        <div class="icon-title">
                            <i class="fas fa-hourglass-half"></i>
                            <p>{{ $allOrders->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card cancelled-orders">
                        <h5>Cancelled Orders</h5>
                        <div class="icon-title">
                            <i class="fas fa-times-circle"></i>
                            <p>{{ $allOrders->where('status', 'cancelled')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h6>Recent Orders</h6>
            <table class="table" id="recent-orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Total Price</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPurchaseOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                            <td>₱{{ number_format($order->total_price, 2) }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h6>All Orders</h6>
            <table class="table" id="all-orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User</th>
                        <th>Total Price</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user ? $order->user->full_name : 'N/A' }}</td>
                            <td>₱{{ number_format($order->total_price, 2) }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Sales Stats Tab -->
        <div class="tab-content" id="sales-stats">
            <h5 class="top-customers-title mt-4"><i class="fas fa-dollar-sign icon-spacing"></i> Sales Stats</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card total-sales">
                        <h5>Total Sales</h5>
                        <div class="icon-title">
                            <i class="fas fa-wallet"></i>
                            <p>₱{{ number_format($totalSales, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card products-sold">
                        <h5>Products Sold</h5>
                        <div class="icon-title">
                            <i class="fas fa-shopping-basket"></i>
                            <p>{{ $productsSold }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card weekly-sales">
                        <h5>Weekly Sales</h5>
                        <div class="icon-title">
                            <i class="fas fa-calendar-week"></i>
                            <p>₱{{ number_format($weeklySales, 2) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card monthly-sales">
                        <h5>Monthly Sales</h5>
                        <div class="icon-title">
                            <i class="fas fa-calendar-alt"></i>
                            <p>₱{{ number_format($monthlySales, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
            <div class="date-range">
    <h5 class="top-customers-title" id="date-range-title">
        <i class="fas fa-calendar-alt icon-spacing"></i> 
        From <span id="start-date-display" class="highlight">Select Start Date</span> 
        to <span id="end-date-display" class="highlight">Select End Date</span> 
        Total Sales
    </h5>
    <div class="date-inputs">
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" onchange="updateDisplayDates()" />
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" onchange="updateDisplayDates()" />
        <button id="filter-sales" class="btn custom-blue">
            <i class="fas fa-filter icon-spacing"></i> Filter
        </button>
    </div>
</div>
</div>

            <h6>Daily Sales</h6>
<table class="table" id="daily-sales-table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Total Sales</th>
            <th>New Users</th>
            <th>Checkouts</th>
        </tr>
    </thead>
    <tbody id="daily-sales-body">
        @foreach($dailyStats as $date => $stats)
            <tr data-date="{{ $date }}">
                <td>{{ $date }}</td>
                <td>₱{{ number_format($stats['sales'], 2) }}</td>
                <td>{{ $stats['newUsers'] }}</td>
                <td>{{ $stats['checkouts'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row">
    <div class="col-md-6">
        <h6>Weekly Sales Summary</h6>
        <table class="table" id="weekly-sales-table">
            <thead>
                <tr>
                    <th>Week Number</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody id="weekly-sales-body">
                <!-- Weekly sales data will be populated here -->
            </tbody>
        </table>
    </div>

    <div class="col-md-6">
        <h6>Monthly Sales Summary</h6>
        <table class="table" id="monthly-sales-table">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody id="monthly-sales-body">
                <!-- Monthly sales data will be populated here -->
            </tbody>
        </table>
    </div>
</div>



            <h6>Least Purchased Products</h6>
            <table class="table" id="least-purchased-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Quantity Sold</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leastPurchasedProducts as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->orderItems->sum('qty') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h6>Most Reviewed Products</h6>
            <table class="table" id="most-reviewed-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Reviews Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mostReviewedProducts as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->reviews_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h6>Most Rated Products</h6>
            <table class="table" id="most-rated-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Average Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mostRatedProducts as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->reviews->avg('rating'), 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Product Masterlist Tab -->
        <div class="tab-content" id="product-masterlist">
            <h5 class="top-customers-title mt-4"><i class="fas fa-cube icon-spacing"></i> Product Masterlist</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card total-products">
                        <h5>Total Products</h5>
                        <div class="icon-title">
                            <i class="fas fa-cubes"></i>
                            <p>{{ $products->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card in-stock-products">
                        <h5>In Stock Products</h5>
                        <div class="icon-title">
                            <i class="fas fa-check-circle"></i>
                            <p>{{ $products->where('qty', '>', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card low-stock-products">
                        <h5>Low Stock Products</h5>
                        <div class="icon-title">
                            <i class="fas fa-exclamation-circle"></i>
                            <p>{{ $products->where('qty', '<', 3)->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card out-of-stock-products">
                        <h5>Out of Stock Products</h5>
                        <div class="icon-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>{{ $products->where('qty', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h6>All Products</h6>
            <table class="table" id="product-masterlist-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Stock Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->qty }}</td>
                            <td>₱{{ number_format($product->selling_price, 2) }}</td>
                            <td>
                                @if ($product->qty == 0)
                                    <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Out of Stock</span>
                                @elseif ($product->qty < 3)
                                    <span class="badge badge-warning"><i class="fas fa-exclamation-circle"></i> Low Stock</span>
                                @else
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> In Stock</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- User Stats Tab -->
        <div class="tab-content" id="user-stats">
            <h5 class="top-customers-title mt-4"><i class="fas fa-users icon-spacing"></i> User Statistics</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card total-users">
                        <h5>Total Users</h5>
                        <div class="icon-title">
                            <i class="fas fa-users"></i>
                            <p>{{ $userCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card new-users">
                        <h5>New Users This Month</h5>
                        <div class="icon-title">
                            <i class="fas fa-user-plus"></i>
                            <p>{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card total-orders-by-users">
                        <h5>Total Orders by Users</h5>
                        <div class="icon-title">
                            <i class="fas fa-shopping-basket"></i>
                            <p>{{ $allOrders->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card revenue-per-user">
                        <h5>Avg Revenue per User</h5>
                        <div class="icon-title">
                            <i class="fas fa-dollar-sign"></i>
                            <p>₱{{ number_format($totalSales / max($userCount, 1), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table" id="user-stats-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Most Viewed Products Tab -->
<div class="tab-content" id="most-viewed-products">
    <h5 class="top-customers-title mt-4"><i class="fas fa-eye icon-spacing"></i> Most Viewed Products</h5>
    <table class="table" id="most-viewed-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>View Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mostViewedProducts as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->view_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    </div>
</div>



<script>
 document.addEventListener("DOMContentLoaded", function() {
    
    // Tab functionality
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(tc => tc.classList.remove('active'));

            tab.classList.add('active');
            const target = tab.getAttribute('data-target');
            document.getElementById(target).classList.add('active');
        });
    });

    // Export to Excel function
    window.exportToExcel = function() {
        const wb = XLSX.utils.book_new();
        const tables = [
            { id: 'recent-orders-table', name: 'Recent Orders' },
            { id: 'all-orders-table', name: 'All Orders' },
            { id: 'daily-sales-table', name: 'Daily Sales' },
            { id: 'least-purchased-table', name: 'Least Purchased Products' },
            { id: 'most-reviewed-table', name: 'Most Reviewed Products' },
            { id: 'most-rated-table', name: 'Most Rated Products' },
            { id: 'product-masterlist-table', name: 'Product Masterlist' },
            { id: 'user-stats-table', name: 'User Statistics' }
        ];

        tables.forEach(table => {
            const sheet = XLSX.utils.table_to_sheet(document.getElementById(table.id));
            formatExcelSheet(sheet);
            XLSX.utils.book_append_sheet(wb, sheet, table.name);
        });

        const date = new Date();
        const month = date.toLocaleString('default', { month: 'long' });
        const weekNumber = getWeekOfMonth(date);
        XLSX.writeFile(wb, `Report_${month}_Week_${weekNumber}.xlsx`);
        showNotification("Excel report generated successfully!");
    };

    // Export to CSV function
    window.exportToCSV = function() {
        const tables = [
            { id: 'recent-orders-table', name: 'Recent Orders' },
            { id: 'all-orders-table', name: 'All Orders' },
            { id: 'daily-sales-table', name: 'Daily Sales' },
            { id: 'least-purchased-table', name: 'Least Purchased Products' },
            { id: 'most-reviewed-table', name: 'Most Reviewed Products' },
            { id: 'most-rated-table', name: 'Most Rated Products' },
            { id: 'product-masterlist-table', name: 'Product Masterlist' },
            { id: 'user-stats-table', name: 'User Statistics' }
        ];

        let csvContent = "data:text/csv;charset=utf-8,";
        
        tables.forEach(table => {
            const rows = document.getElementById(table.id).querySelectorAll('tr');
            rows.forEach(row => {
                const cols = row.querySelectorAll('td, th');
                const rowData = Array.from(cols).map(col => col.innerText).join(",");
                csvContent += rowData + "\r\n";
            });
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `Report_${new Date().toLocaleDateString()}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        showNotification("CSV report generated successfully!");
    };

    

    // Function to format Excel sheet
    function formatExcelSheet(sheet) {
        const range = XLSX.utils.decode_range(sheet['!ref']);
        const headerStyle = {
            font: { bold: true, sz: 12, color: { rgb: "FFFFFF" } },
            fill: { fgColor: { rgb: "007bff" } },
            alignment: { horizontal: "center", vertical: "center" },
            border: {
                top: { style: "thin", color: { rgb: "000000" } },
                bottom: { style: "thin", color: { rgb: "000000" } },
                left: { style: "thin", color: { rgb: "000000" } },
                right: { style: "thin", color: { rgb: "000000" } },
            }
        };

        // Apply header style
        for (let C = range.s.c; C <= range.e.c; ++C) {
            const cell = sheet[XLSX.utils.encode_cell({ c: C, r: 0 })];
            if (cell) {
                cell.s = headerStyle;
            }
        }

        // Apply styles to all cells
        for (let R = range.s.r; R <= range.e.r; ++R) {
            for (let C = range.s.c; C <= range.e.c; ++C) {
                const cell = sheet[XLSX.utils.encode_cell({ c: C, r: R })];
                if (cell) {
                    cell.s = {
                        border: {
                            top: { style: "thin", color: { rgb: "000000" } },
                            bottom: { style: "thin", color: { rgb: "000000" } },
                            left: { style: "thin", color: { rgb: "000000" } },
                            right: { style: "thin", color: { rgb: "000000" } },
                        },
                        alignment: { horizontal: "center", vertical: "center" },
                    };
                }
            }
        }

        // Set column widths based on the maximum length of the data
        const colWidths = Array.from({ length: range.e.c + 1 }, (_, i) => {
            let maxLength = 0;
            for (let r = range.s.r; r <= range.e.r; r++) {
                const cell = sheet[XLSX.utils.encode_cell({ c: i, r })];
                if (cell && cell.v) {
                    maxLength = Math.max(maxLength, cell.v.toString().length);
                }
            }
            return { wpx: Math.max(60, maxLength * 10) };
        });
        sheet['!cols'] = colWidths;
    }

    // Function to get the week of the month
    function getWeekOfMonth(date) {
        const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        const dayOfWeek = firstDay.getDay();
        const adjustedDate = date.getDate() + dayOfWeek;
        return Math.ceil(adjustedDate / 7);
    }

    // Print report function
    window.printReport = function() {
        window.print();
        showNotification("Report printed successfully!");
    };

    // Print to Word function
    window.printToWord = function() {
        let content = document.querySelector('.container').innerHTML;

        // Add title page and styling
        let styledContent = `
            <html>
            <head>
                <style>
                    body {
                        font-family: 'Roboto', sans-serif;
                        margin: 20px;
                        color: #333;
                    }
                    .title-page {
                        text-align: center;
                        padding: 50px 20px;
                        page-break-after: always;
                    }
                    h1 {
                        font-size: 36px;
                        margin: 0;
                        color: black;
                    }
                    h2 {
                        font-size: 24px;
                        margin: 10px 0;
                        color: #555;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        border: 1px solid #000;
                        padding: 12px;
                        text-align: left;
                    }
                    th {
                        background-color: #007bff;
                        color: #fff;
                        font-weight: bold;
                    }
                    td {
                        background-color: #f9f9f9;
                    }
                    .footer {
                        position: fixed;
                        bottom: 0;
                        width: 100%;
                        text-align: center;
                        font-size: 12px;
                    }
                    @media print {
                        .footer {
                            position: fixed;
                            bottom: 0;
                            width: 100%;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="title-page">
                    <h1>E-commerce Report</h1>
                    <h2>${new Date().toLocaleDateString()}</h2>
                </div>
                <div>${content}</div>
                <div class="footer">
                    <p>Generated on ${new Date().toLocaleDateString()}</p>
                </div>
            </body>
            </html>
        `;

        let blob = new Blob(['\ufeff', styledContent], { type: 'application/msword' });
        let url = URL.createObjectURL(blob);
        let date = new Date();
        let month = date.toLocaleString('default', { month: 'long' });
        let weekNumber = getWeekOfMonth(date);
        let link = document.createElement('a');
        link.href = url;
        link.download = `Report_${month}_Week_${weekNumber}.doc`;
        link.click();
        URL.revokeObjectURL(url);
        showNotification("Word report generated successfully!");
    };

    // Function to show notification
    function showNotification(message) {
        const notification = document.getElementById("notification");
        notification.innerText = message;
        notification.style.display = "block";
        notification.style.opacity = 1;

        setTimeout(() => {
            notification.style.opacity = 0;
            setTimeout(() => {
                notification.style.display = "none";
            }, 500);
        }, 3000);
    }

    document.getElementById('filter-sales').addEventListener('click', function() {
        const startDate = new Date(document.getElementById('start-date').value);
        const endDate = new Date(document.getElementById('end-date').value);
        const rows = document.querySelectorAll('#daily-sales-body tr');
        let totalSalesForPeriod = 0;
        let weeklySales = {};
        let monthlySales = {};

        // Clear previous sales data
        const weeklySalesBody = document.getElementById('weekly-sales-body');
        weeklySalesBody.innerHTML = '';
        const monthlySalesBody = document.getElementById('monthly-sales-body');
        monthlySalesBody.innerHTML = '';

        // Loop through daily sales rows to calculate sales
        rows.forEach(row => {
            const rowDate = new Date(row.getAttribute('data-date'));
            const sales = parseFloat(row.cells[1].innerText.replace('₱', '').replace(',', ''));

            // Check if row date is within the selected range
            if (rowDate >= startDate && rowDate <= endDate) {
                row.style.display = ''; // Show row
                totalSalesForPeriod += sales;

                const weekNumber = getWeekOfMonth(rowDate);
                const yearMonth = `${rowDate.getFullYear()}-${rowDate.getMonth() + 1}`;
                const monthName = rowDate.toLocaleString('default', { month: 'long' });

                // Initialize weekly sales
                if (!weeklySales[yearMonth]) {
                    weeklySales[yearMonth] = {};
                }
                if (!weeklySales[yearMonth][weekNumber]) {
                    weeklySales[yearMonth][weekNumber] = 0;
                }
                // Add sales to the corresponding week
                weeklySales[yearMonth][weekNumber] += sales;

                // Initialize monthly sales
                if (!monthlySales[monthName]) {
                    monthlySales[monthName] = 0;
                }
                monthlySales[monthName] += sales; // Add sales to the corresponding month
            } else {
                row.style.display = 'none'; // Hide row
            }
        });

        // Generate weekly and monthly summaries
        generateWeeklySummary(startDate, endDate, weeklySales, weeklySalesBody);
        generateMonthlySummary(startDate, endDate, monthlySales, monthlySalesBody);

        // Display total sales for the selected period
        document.getElementById('monthly-total').innerText = `Total Sales for Selected Period: ₱${formatCurrency(totalSalesForPeriod)}`;
    });
});

// Function to generate weekly summary
function generateWeeklySummary(startDate, endDate, weeklySales, weeklySalesBody) {
    const currentDate = new Date(startDate);

    // Adjust currentDate to the start of the week (e.g., Sunday)
    const dayOfWeek = currentDate.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
    const startOfWeek = new Date(currentDate);
    startOfWeek.setDate(currentDate.getDate() - dayOfWeek); // Adjust to start of the week

    while (startOfWeek <= endDate) {
        const weekNumber = getWeekOfMonth(startOfWeek);
        const yearMonth = `${startOfWeek.getFullYear()}-${startOfWeek.getMonth() + 1}`;

        // Initialize sales total for the week
        const salesTotal = (weeklySales[yearMonth] && weeklySales[yearMonth][weekNumber]) ? weeklySales[yearMonth][weekNumber] : 0;

        // Create and append the row for the week
        const row = document.createElement('tr');
        row.innerHTML = `<td>${yearMonth} - Week ${weekNumber}</td><td>₱${formatCurrency(salesTotal)}</td>`;
        weeklySalesBody.appendChild(row);

        // Move to the next week
        startOfWeek.setDate(startOfWeek.getDate() + 7);
    }
}

// Function to generate monthly summary
function generateMonthlySummary(startDate, endDate, monthlySales, monthlySalesBody) {
    const startMonth = startDate.getMonth();
    const endMonth = endDate.getMonth();
    const startYear = startDate.getFullYear();
    const endYear = endDate.getFullYear();

    // Loop through months for the specified range
    for (let year = startYear; year <= endYear; year++) {
        const monthStart = year === startYear ? startMonth : 0;
        const monthEnd = year === endYear ? endMonth : 11;

        for (let month = monthStart; month <= monthEnd; month++) {
            const monthName = new Date(year, month).toLocaleString('default', { month: 'long' });
            const salesTotal = monthlySales[monthName] || 0;

            const row = document.createElement('tr');
            row.innerHTML = `<td>${monthName}</td><td>₱${formatCurrency(salesTotal)}</td>`;
            monthlySalesBody.appendChild(row);
        }
    }
}

// Helper function to get the week of the month
function getWeekOfMonth(date) {
    const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    const dayOfWeek = firstDay.getDay();
    const adjustedDate = date.getDate() + dayOfWeek;

    // Calculate the week number
    return Math.ceil(adjustedDate / 7);
}

// Helper function to format currency with commas
function formatCurrency(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function updateDisplayDates() {
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    
    const startDate = new Date(startDateInput.value);
    const endDate = new Date(endDateInput.value);
    
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    
    const formattedStartDate = startDateInput.value ? startDate.toLocaleDateString('en-US', options) : 'Select Start Date';
    const formattedEndDate = endDateInput.value ? endDate.toLocaleDateString('en-US', options) : 'Select End Date';
    
    document.getElementById('start-date-display').innerText = formattedStartDate;
    document.getElementById('end-date-display').innerText = formattedEndDate;
}
</script>
@endsection