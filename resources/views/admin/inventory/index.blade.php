@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="container">
    <h1 class="mb-4" style="font-weight: bold; font-size: 2.5em; color: #343a40;">
        <i class="fas fa-warehouse"></i> Inventory Dashboard
    </h1>

    <!-- Summary Cards -->
    <div class="row mb-2">
        <div class="col-md-4">
            <div class="card text-center mb-3 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #4a90e2, #0056b3);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #ffffff;">
                        <i class="fas fa-box" style="color: #ffffff;"></i> Total Products
                    </h5>
                    <p class="card-text" style="font-size: 1.5em; font-weight: bold; color: #ffffff;">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center mb-3 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #5cb85c, #28a745);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #ffffff;">
                        <i class="fas fa-dollar-sign" style="color: #ffffff;"></i> Total Inventory Value
                    </h5>
                    <p class="card-text" style="font-size: 1.5em; font-weight: bold; color: #ffffff;">₱{{ number_format($totalInventoryValue, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center mb-3 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #9b59b6, #6f42c1);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #ffffff;">
                        <i class="fas fa-calendar-alt" style="color: #ffffff;"></i> Total Sales This Month
                    </h5>
                    <p class="card-text" style="font-size: 1.5em; font-weight: bold; color: #ffffff;">₱{{ number_format($totalSalesThisMonth, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-center mb-3 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f0ad4e, #ffc107);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #ffffff;">
                        <i class="fas fa-exclamation-circle" style="color: #ffffff;"></i> Low Stock Products
                    </h5>
                    <p class="card-text" style="font-size: 1.5em; font-weight: bold; color: #ffffff;">{{ $lowStockCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center mb-3 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #d9534f, #dc3545);">
                <div class="card-body">
                    <h5 class="card-title" style="color: #ffffff;">
                        <i class="fas fa-times-circle" style="color: #ffffff;"></i> Out of Stock
                    </h5>
                    <p class="card-text" style="font-size: 1.5em; font-weight: bold; color: #ffffff;">{{ $outOfStockCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs for Inventory Status and Products Overview -->
    <h5 class="row-title" style="font-weight: bold; text-align: left;">
        <i class="fas fa-th-list"></i> Inventory Overview
    </h5>
    <div class="tabs mb-2" id="inventoryOverviewTabs">
        <div class="tab active" data-target="inventoryStatusTab"><i class="fas fa-exclamation-circle"></i> Inventory Status</div>
        <div class="tab" data-target="productsOverviewTab"><i class="fas fa-chart-pie"></i> Products Overview</div>
    </div>

    <div class="tab-content">
        <div id="inventoryStatusTab" class="tab-item">
            <h5 class="row-title" style="font-weight: bold; text-align: left;">Inventory Status</h5>
            <div class="card" style="background-color: #ffffff; border-radius: 15px; padding: 20px;">
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th><i class="fas fa-tag"></i> Name</th>
                                <th><i class="fas fa-sort-numeric-up"></i> Quantity</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                                <th><i class="fas fa-cogs"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->qty }}</td>
                                    <td>
                                        @if($product->qty == 0)
                                            <span class="text-danger" title="No Stock">
                                                <i class="fas fa-times-circle"></i> No Stock
                                            </span>
                                        @elseif($product->qty < 3)
                                            <span class="text-warning" title="Low Stock">
                                                <i class="fas fa-exclamation-triangle"></i> Low Stock
                                            </span>
                                        @else
                                            <span class="text-success" title="In Stock">
                                                <i class="fas fa-check-circle"></i> In Stock
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
        </div>

        <div id="productsOverviewTab" class="tab-item hidden">
            <h5 class="row-title" style="font-weight: bold; text-align: left;">Products Overview</h5>
            <div class="card" style="background-color: #ffffff; border-radius: 15px; padding: 20px;">
                <div id="productChart" style="height: 400px;"></div>
            </div>
        </div>
    </div>

    <!-- Top Selling Products Section -->
    <h5 class="row-title mt-4" style="font-weight: bold; text-align: left;">
        <i class="fas fa-chart-bar"></i> Top Selling Products
    </h5>
    <div class="card" style="background-color: #ffffff; border-radius: 15px; padding: 20px;">
        <div class="tabs mb-2" id="topSellingTabs">
            <div class="tab active" data-target="quantitySoldTab"><i class="fas fa-chart-line"></i> Quantity Sold</div>
            <div class="tab" data-target="totalPurchaseTab"><i class="fas fa-shopping-cart"></i> Total Purchase</div>
        </div>

        <div class="tab-content">
            <div id="quantitySoldTab" class="tab-item">
                <table class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-sort-numeric-up"></i> Rank</th>
                            <th><i class="fas fa-box"></i> Product Name</th>
                            <th><i class="fas fa-chart-bar"></i> Quantity Sold</th>
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
                            <th><i class="fas fa-sort-numeric-up"></i> Rank</th>
                            <th><i class="fas fa-box"></i> Product Name</th>
                            <th><i class="fas fa-shopping-cart"></i> Total Purchase</th>
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
    </div>

    <!-- New Products Section -->
    <h5 class="row-title mt-4" style="font-weight: bold; text-align: left;">
        <i class="fas fa-box-open"></i> New Products
    </h5>
    <div class="card" style="background-color: #ffffff; border-radius: 15px; padding: 20px;">
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th><i class="fas fa-box"></i> Product Name</th>
                        <th><i class="fas fa-peso-sign"></i> Price</th>
                        <th><i class="fas fa-calendar-plus"></i> Date Added</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>₱{{ number_format($product->selling_price, 2) }}</td>
                            <td>{{ $product->created_at->format('F j, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inventory Overview Chart
            var options = {
                chart: {
                    type: 'donut',
                    height: 400
                },
                series: [{{ $inStock }}, {{ $outOfStockCount }}, {{ $lowStockCount }}],
                labels: ['In Stock', 'Out of Stock', 'Low Stock'],
                colors: ['#00A65A', '#FF6384', '#FFCE56'],
                legend: {
                    position: 'top',
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        }
                    }
                }
            };

            var productChart = new ApexCharts(document.querySelector("#productChart"), options);
            productChart.render();

            // Function to handle tab switching
            function setupTabs(tabsContainer, tabItems) {
                const tabs = tabsContainer.querySelectorAll('.tab');

                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        const targetId = tab.getAttribute('data-target');
                        tabs.forEach(t => t.classList.remove('active'));
                        tabItems.forEach(item => item.classList.add('hidden'));

                        tab.classList.add('active');
                        document.getElementById(targetId).classList.remove('hidden');
                    });
                });
            }

            // Setup Inventory Overview Tabs
            const inventoryTabsContainer = document.getElementById('inventoryOverviewTabs');
            const inventoryTabItems = document.querySelectorAll('#inventoryOverviewTabs + .tab-content > .tab-item');
            setupTabs(inventoryTabsContainer, inventoryTabItems);

            // Setup Top Selling Products Tabs
            const topSellingTabsContainer = document.getElementById('topSellingTabs');
            const topSellingTabItems = document.querySelectorAll('#topSellingTabs + .tab-content > .tab-item');
            setupTabs(topSellingTabsContainer, topSellingTabItems);
        });
    </script>
</div>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f8f9fa;
    }
    .container {
        margin-top: 20px;
    }
    .row-title {
        margin-top: 20px;
        margin-bottom: 10px;
        color: #343a40;
    }
    .table {
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }
    .table th {
        background-color: #e9ecef;
        font-weight: bold;
        text-align: center;
    }
    .btn {
        transition: background-color 0.2s, transform 0.2s;
    }
    .btn:hover {
        background-color: #0056b3;
        color: #fff;
        transform: translateY(-2px);
    }
    .tabs {
        display: flex;
        cursor: pointer;
        margin-bottom: 20px;
    }
    .tab {
        flex: 1;
        text-align: center;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-right: 5px;
        background-color: #e9ecef;
        transition: background-color 0.2s;
    }
    .tab.active {
        background-color: #ffffff;
        font-weight: bold;
        border-bottom: 1px solid transparent;
    }
    .tab-item {
        display: none;
    }
    .tab-item:not(.hidden) {
        display: block;
    }

    @media (max-width: 768px) {
        .row-title {
            font-size: 1.5em;
        }
        .card-text {
            font-size: 1.5em;
        }
        .table th, .table td {
            padding: 10px;
        }
    }
</style>
@endsection