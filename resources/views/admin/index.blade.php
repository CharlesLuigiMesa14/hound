@extends('layouts.admin')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://www.gstatic.com/charts/loader.js"></script>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #fdfdfd;
        color: #333;
        line-height: 1.4;
    }
    .table .quantity-column {
    text-align: center; /* Center align only the quantity cells */
}
    .container {
        margin-top: 20px;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .stat-card {
        border-radius: 8px;
        padding: 15px;
        margin: 5px 0;
        text-align: left;
        background-color: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: scale(1.02);
    }
    .table {
        width: 100%;
        margin-top: 10px;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }
    .table th {
        background-color: #f8f9fa;
    }
    .percentage {
        font-weight: bold;
    }
    .increase {
        color: green;
    }
    .decrease {
        color: red;
    }
    .neutral {
        color: gray;
    }
    .date-display {
        font-size: 0.9em;
        color: #6c757d;
        margin: 20px 0 10px;
    }
    .row-title {
        font-size: 1.5em;
        margin-top: 20px;
        margin-bottom: 10px;
        color: #333;
    }
    .canvas-small, .canvas-large {
        max-width: 100%;
        height: 150px;
    }
    .icon {
        margin-right: 3px; /* Space between icon and text */
        font-size: 1em; /* Standard icon size */
    }
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25em 0.5em; /* Consistent padding for smaller size */
        border-radius: 0.5rem;
        font-size: 0.8em; /* Reduced font size for smaller badges */
        color: white; /* White text */
        margin-right: 5px; /* Space between badges */
        text-transform: capitalize; /* Capitalize text */
        min-width: 100px; /* Set a minimum width for consistent sizing */
        justify-content: center; /* Center content within the badge */
    }
    .badge-danger {
        background-color: #dc3545; /* Red */
    }
    .badge-warning {
        background-color: #ffc107; /* Yellow */
    }
    .badge-success {
        background-color: #28a745; /* Green */
    }
    .tabs {
    display: flex;
    cursor: pointer;
    margin: 20px 0;
}

.tab {
    padding: 10px 20px;
    border: 1px solid #dee2e6;
    border-radius: 4px 4px 0 0;
    background-color: #f8f9fa;
    margin-right: 5px;
}

.tab.active {
    background-color: white;
    border-bottom: 1px solid white;
    font-weight: bold;
}

.tab-content {
    border: 1px solid #dee2e6;
    border-radius: 0 0 4px 4px;
    padding: 20px;
    background-color: white;
}

.hidden {
    display: none;
}

/* Additional styles for the ranking */
.rank {
    font-weight: bold;
    color: #007bff;
}
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center" style="padding: 10px 20px;">
        <h4 style="color: #333; font-weight: bold; font-size: 1.5em; margin: 0;">
            <i class="fas fa-chart-line"></i> Dashboard
        </h4>
        <div class="date-display" style="font-size: 0.9em; color: #6c757d;">
            Date: {{ now('Asia/Manila')->format('F j, Y') }} - Today is <span id="current-day"></span>
            - Current Time: <span id="current-time"></span>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Daily Checkouts -->
            <div class="col-md-4">
                <div class="stat-card">
                    <h5 style="font-weight: bold; text-align: left;">
                        <i class="fas fa-shopping-cart fa-lg"></i> Daily Checkouts
                    </h5>
                    <p>
                        Total checkouts made today:
                        <strong class="percentage {{ $todayCheckoutPercentageChange > 0 ? 'increase' : ($todayCheckoutPercentageChange < 0 ? 'decrease' : 'neutral') }}">
                            {{ number_format($dailyCheckoutsData[date('Y-m-d')] ?? 0) }}
                        </strong>
                        <span class="{{ $todayCheckoutPercentageChange > 0 ? 'increase' : ($todayCheckoutPercentageChange < 0 ? 'decrease' : 'neutral') }}">
                            ({{ $todayCheckoutPercentageChange > 0 ? '+' : '' }}{{ number_format($todayCheckoutPercentageChange, 2) }}%)
                        </span>
                    </p>
                    <canvas id="checkoutChart" class="canvas-small"></canvas>
                </div>
            </div>

            <!-- Daily Sales -->
<div class="col-md-4">
    <div class="stat-card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 style="font-weight: bold; text-align: left;">
                <i class="fas fa-dollar-sign fa-lg"></i> Daily Sales
            </h5>
            <a href="{{ route('reports.index') }}" class="btn btn-link" style="margin-top: -5px; margin-left: auto; font-size: 0.8em; text-decoration: none; color: #007bff;">
                <i class="fas fa-file-alt"></i> View Reports
            </a>
        </div>
        <p>
            Total sales today:
            <strong class="percentage {{ $todaySalesPercentageChange > 0 ? 'increase' : ($todaySalesPercentageChange < 0 ? 'decrease' : 'neutral') }}">
                ₱{{ number_format($dailySalesData[date('Y-m-d')] ?? 0, 2) }}
            </strong>
            <span class="{{ $todaySalesPercentageChange > 0 ? 'increase' : ($todaySalesPercentageChange < 0 ? 'decrease' : 'neutral') }}">
                ({{ $todaySalesPercentageChange > 0 ? '+' : '' }}{{ number_format($todaySalesPercentageChange, 2) }}%)
            </span>
        </p>
        <canvas id="salesChart" class="canvas-small"></canvas>
    </div>
</div>

            <!-- Total Sales for Current Month -->
            <div class="col-md-4">
                <div class="stat-card">
                    <h5 style="font-weight: bold; text-align: left;">
                        <i class="fas fa-chart-line fa-lg"></i> Total Sales for {{ $currentMonth }} 
                    </h5>
                    <a href="{{ route('reports.index') }}" class="btn btn-link" style="margin-top: -20px; text-align: right; color: #007bff;">
                <i class="fas fa-file-alt"></i>View Reports</a>
                    <p><strong class="percentage {{ $totalWeeklySalesChange > 0 ? 'increase' : ($totalWeeklySalesChange < 0 ? 'decrease' : 'neutral') }}">
                        ₱{{ number_format($totalWeeklySales, 2) }}
                    </strong></p>
                    <canvas id="weeklySalesChart" class="canvas-large"></canvas>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <h5 style="font-weight: bold; text-align: left;">
                        <i class="fas fa-users fa-lg"></i> User Overview (Total Users: {{ $userCount }})
                    </h5>
                    <p>
                        <i class="fas fa-user-plus icon increase"></i> New Daily Users: <strong>{{ $newUsers }}</strong>
                    </p>
                    <p>
                        <i class="fas fa-user-plus icon increase"></i> New Weekly Users: <strong>{{ $weeklyNewUsers }}</strong>
                    </p>
                    <p>
                        <i class="fas fa-user-friends icon neutral"></i> Returning Users: <strong>{{ $returningUsers }}</strong>
                    </p>
                    <canvas id="userChart" class="canvas-small"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <h5 style="font-weight: bold; text-align: left;">
                        <i class="fas fa-box fa-lg"></i> Products Overview (In Stock: <strong>{{ $inStock }}</strong>)
                    </h5>
                    <p>
                        <i class="fas fa-times-circle icon text-danger"></i> Out of stock products: <strong>{{ $outOfStockCount }}</strong>
                    </p>
                    <p>
                        <i class="fas fa-exclamation-triangle icon text-warning"></i> Low stock products: <strong>{{ $lowStockCount }}</strong>
                    </p>
                    <div id="productChart" style="height: 285px;"></div>
                </div>
            </div>
        </div>

        <h5 class="row-title mt-4" style="font-weight: bold; text-align: left;">
            <i class="fas fa-chart-bar"></i> Top Selling Products
        </h5>
        <div class="tabs">
            <div class="tab active" data-target="#quantitySoldTab">Quantity Sold</div>
            <div class="tab" data-target="#totalPurchaseTab">Total Purchase</div>
        </div>
        
        <div class="tab-content">
            <div id="quantitySoldTab" class="tab-item">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Product Name</th>
                            <th>Quantity Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSellingProductNames as $index => $productName)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $productName }}</td>
                                <td>{{ $topSellingProductCounts[$index] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="totalPurchaseTab" class="tab-item hidden">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Product Name</th>
                            <th>Total Purchase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topSellingProductNames as $index => $productName)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $productName }}</td>
                                <td>₱{{ number_format($topSellingProductTotalPurchases[$index], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <h5 class="row-title mt-4" style="font-weight: bold; text-align: left;">
            <i class="fas fa-box-open"></i> New Products
        </h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                @foreach($newProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->created_at->format('F j, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h5 class="row-title mt-4" style="font-weight: bold; text-align: left;">
            <i class="fas fa-users"></i> Top Customers
        </h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Total Purchase</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Sort users based on total purchases
                    $sortedUsers = $users->sortByDesc('orders_count')->values();
                @endphp
                
                @foreach($sortedUsers as $index => $customer)
                    <tr>
                        <td>
                            @if($index == 0)
                                <i class="fas fa-trophy" style="color: gold;" title="Rank 1"></i>
                            @elseif($index == 1)
                                <i class="fas fa-medal" style="color: silver;" title="Rank 2"></i>
                            @elseif($index == 2)
                                <i class="fas fa-medal" style="color: #cd7f32;" title="Rank 3"></i>
                            @else
                                <span>{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td>{{ $customer->full_name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>₱{{ number_format($customer->orders_count * $customer->total_purchases, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h5 class="row-title mt-4" style="font-weight: bold; text-align: left;">
            <i class="fas fa-exclamation-triangle"></i> Inventory Status
        </h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th class="quantity-column">Quantity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="quantity-column">{{ $product->qty }}</td>
                        <td>
                            @if($product->qty == 0)
                                <span class="badge badge-danger" title="No Stock">
                                    <i class="fas fa-times-circle icon"></i> No Stock
                                </span>
                            @elseif($product->qty < 3)
                                <span class="badge badge-warning" title="Low Stock">
                                    <i class="fas fa-exclamation-triangle icon"></i> Low Stock
                                </span>
                            @else
                                <span class="badge badge-success" title="In Stock">
                                    <i class="fas fa-check-circle icon"></i> In Stock
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('edit-product/' . $product->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-plus-circle"></i> Refill
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Display the current day
        const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        const today = new Date();
        const currentDay = daysOfWeek[today.getDay()];
        document.getElementById('current-day').textContent = currentDay;

        // Real-time clock
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        setInterval(updateTime, 1000); // Update every second

        // Chart.js setup for Daily Checkouts
        const checkoutCtx = document.getElementById('checkoutChart').getContext('2d');
        const checkoutChart = new Chart(checkoutCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Daily Checkouts',
                    data: [{{ implode(',', array_values($dailyCheckoutsData)) }}],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart.js setup for Daily Sales
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Daily Sales',
                    data: [{{ implode(',', array_values($dailySalesData)) }}],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart.js setup for Weekly Sales
        const weeklySalesCtx = document.getElementById('weeklySalesChart').getContext('2d');
        const weeklySalesChart = new Chart(weeklySalesCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Weekly Sales',
                    data: [{{ implode(',', $weeklySalesData) ?: '0' }}],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        // Chart.js setup for User Overview (Bar Chart)
        const userCtx = document.getElementById('userChart').getContext('2d');
        const userChart = new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: ['New Daily Users', 'New Weekly Users', 'Returning Users'],
                datasets: [{
                    label: 'User Overview',
                    data: [{{ $newUsers }}, {{ $weeklyNewUsers }}, {{ $returningUsers }}],
                    backgroundColor: ['#00bfff', '#ffcc00', '#28a745'], // Colors
                    borderColor: ['#007bff', '#ffd700', '#218838'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        // Google Charts setup for Products Overview (Pie Chart)
        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawProductChart);

        function drawProductChart() {
            const data = google.visualization.arrayToDataTable([
                ['Status', 'Quantity'],
                ['In Stock', {{ $inStock }}],
                ['Out of Stock', {{ $outOfStockCount }}],
                ['Low Stock', {{ $lowStockCount }}]
            ]);

            const options = {
                pieHole: 0.3, // Donut chart
                colors: ['#007bff', '#dc3545', '#ffc107'], // Blue for In Stock, Red for Out of Stock, Yellow for Low Stock
                legend: { position: 'top' },
            };

            const chart = new google.visualization.PieChart(document.getElementById('productChart'));
            chart.draw(data, options);
        }

        // Tab functionality
        const tabs = document.querySelectorAll('.tab');
        const tabItems = document.querySelectorAll('.tab-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tabItems.forEach(item => item.classList.add('hidden'));

                tab.classList.add('active');
                const target = tab.getAttribute('data-target');
                document.querySelector(target).classList.remove('hidden');
            });
        });
    });
</script>
@endsection