@extends('layouts.admin')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
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
    <div style="border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); background-color: #fdfdfd;">
        <h3 class="mb-4" style="font-size: 1.8rem; color: #343a40; text-align: left;">
            <i class="fas fa-store"></i> Store Manager Dashboard
        </h3>

        <!-- Dashboard Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6">
                <div style="border-radius: 8px; padding: 1rem; margin-bottom: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-dollar-sign" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Total Sales</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">₱{{ number_format($totalSales, 2) }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">Total sales this month</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div style="border-radius: 8px; padding: 1rem; margin-bottom: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-clock" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Pending Orders</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">{{ $pendingOrders }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">Orders pending approval</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div style="border-radius: 8px; padding: 1rem; margin-bottom: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-users" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Customers</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">{{ $totalCustomers }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">Total registered customers</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div style="border-radius: 8px; padding: 1rem; margin-bottom: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-th-list" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Total Categories</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">{{ $totalCategories }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">Total product categories</p>
                </div>
            </div>
        </div>

        <!-- User Roles Count -->
        <h2 style="font-size: 1.5rem; color: #343a40; text-align: left;">
            <i class="fas fa-user-tag"></i> User Roles Count
        </h2>
        <div class="row mb-4">
            @php
                $roles = [
                    2 => ['name' => 'Inventory Manager', 'icon' => 'fas fa-box'],
                    3 => ['name' => 'Order Manager', 'icon' => 'fas fa-shopping-cart'],
                    4 => ['name' => 'Marketing Manager', 'icon' => 'fas fa-bullhorn'],
                    5 => ['name' => 'Store Manager', 'icon' => 'fas fa-store'],
                ];
            @endphp

            @foreach($roles as $roleId => $roleData)
                @php
                    $count = $userRolesCount[$roleId] ?? 0; // Default to 0 if not set
                @endphp
                <div class="col-md-3 col-sm-6">
                    <div style="border-radius: 8px; padding: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                        <i class="{{ $roleData['icon'] }}" style="font-size: 1.4rem; color: darkred;"></i>
                        <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">{{ $roleData['name'] }}</div>
                        <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">{{ $count }}</h5>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sales Overview Card -->
        <h2 style="font-size: 1.5rem; color: #343a40; text-align: left;">
            <i class="fas fa-chart-line"></i> Sales Overview
        </h2>
        <div class="row mb-4">
            <div class="col-md-12">
                <div style="border-radius: 8px; padding: 1rem; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <canvas id="salesChart" style="max-width: 100%; height: 400px;"></canvas>
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

        <!-- Additional Metrics -->
        <h2 style="font-size: 1.5rem; color: #343a40; text-align: left;">
            <i class="fas fa-tasks"></i> Additional Metrics
        </h2>
        <div class="row mb-4">
            <div class="col-md-4 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-calendar-day" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Daily Sales</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">₱{{ number_format($dailySales, 2) }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">Sales today</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-calendar-week" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Weekly Sales</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">₱{{ number_format($weeklySales, 2) }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">Sales this week</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-calendar-alt" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Monthly Sales</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">₱{{ number_format($monthlySales, 2) }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">Sales this month</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-user-plus" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Daily New Customers</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">{{ $dailyNewCustomers }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">New customers today</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-users" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Weekly New Customers</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">{{ $weeklyNewCustomers }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">New customers this week</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; text-align: center; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <i class="fas fa-box-open" style="font-size: 1.4rem; color: darkred;"></i>
                    <div style="font-size: 1rem; font-weight: 700; color: #8B0000;">Number of New Products</div>
                    <h5 style="font-size: 1.4rem; margin: 0; color: #A00000;">{{ $newProducts }}</h5>
                    <p style="margin-top: 0.3rem; font-size: 0.75rem; color: #8B0000;">New products added</p>
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <h2 style="font-size: 1.5rem; color: #343a40; text-align: left;">
            <i class="fas fa-chart-pie"></i> Order Status Distribution
        </h2>
        <div class="row mb-4">
            <div class="col-md-6 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <canvas id="orderStatusChart" style="max-width: 100%; height: 400px;"></canvas>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div style="border-radius: 8px; padding: 1rem; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <canvas id="categorySalesChart" style="max-width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Orders Card -->
        <h2 style="font-size: 1.5rem; color: #343a40; text-align: left;">
            <i class="fas fa-shopping-cart"></i> Recent Orders
        </h2>
        <div class="table-responsive">
            <div style="border-radius: 8px; padding: 1rem; margin-top: 2rem; background-color: #fff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <table class="table table-striped" style="background-color: #fff;">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->fullName }}</td>
                                <td>
                                    @if($order->status == 0)
                                        <span class="badge badge-warning"><i class="fas fa-hourglass-start"></i> Pending</span>
                                    @elseif($order->status == 1)
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Completed</span>
                                    @elseif($order->status == 2)
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Cancelled</span>
                                    @endif
                                </td>
                                <td>₱{{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Overview Chart
    const salesOverviewData = @json($salesByProduct);

    const salesLabels = salesOverviewData.map(item => item.name);
    const salesData = salesOverviewData.map(item => item.total_sales);

    const salesChartData = {
        labels: salesLabels,
        datasets: [{
            label: 'Sales (₱)',
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            data: salesData,
        }]
    };
    
    const salesChartConfig = {
        type: 'bar',
        data: salesChartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Sales Overview by Product',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Sales (₱)'
                    }
                }
            }
        }
    };

    const salesChart = new Chart(
        document.getElementById('salesChart'),
        salesChartConfig
    );

    // Order Status Distribution Pie Chart
    const orderStatusCounts = @json($orderStatusCounts->pluck('count'));
    const orderStatusLabels = @json($orderStatusCounts->pluck('status'));

    const orderStatusData = {
        labels: orderStatusLabels.map(status => {
            if (status == 0) return 'Pending';
            if (status == 1) return 'Completed';
            if (status == 2) return 'Cancelled';
        }),
        datasets: [{
            label: 'Order Status Distribution',
            data: orderStatusCounts,
            backgroundColor: [
                'rgba(255, 206, 86, 0.7)', // Pending
                'rgba(75, 192, 192, 0.7)', // Completed
                'rgba(255, 99, 132, 0.7)', // Cancelled
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        }]
    };

    const orderStatusConfig = {
        type: 'doughnut',
        data: orderStatusData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Order Status Distribution',
                }
            }
        }
    };

    const orderStatusChart = new Chart(
        document.getElementById('orderStatusChart'),
        orderStatusConfig
    );

    // Category Sales Radar Chart
    const categorySalesData = {
        labels: @json($salesByCategory->pluck('name')),
        datasets: [{
            label: 'Sales by Category (₱)',
            data: @json($salesByCategory->pluck('total_sales')),
            backgroundColor: 'rgba(255, 159, 64, 0.5)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 2
        }]
    };

    const categorySalesConfig = {
        type: 'radar',
        data: categorySalesData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Sales by Category',
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    ticks: {
                        backdropColor: 'rgba(255, 255, 255, 0.5)',
                    }
                }
            }
        }
    };

    const categorySalesChart = new Chart(
        document.getElementById('categorySalesChart'),
        categorySalesConfig
    );
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
</script>
@endsection