@extends('layouts.admin')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #fdfdfd;
        color: #333;
        line-height: 1.4;
    }
    .container {
        margin-top: 20px;
    }
    .stat-card {
        border-radius: 8px;
        padding: 15px;
        margin: 10px 0;
        text-align: center;
        background-color: #ffffff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: scale(1.02);
    }
    .canvas-large {
        max-width: 100%;
        height: 350px;
        margin-bottom: 20px;
    }
    .table-responsive {
        margin-top: 20px;
    }
    h2 {
        font-weight: bold;
        margin-top: 20px;
        font-size: 1.5em; /* Minimized font size */
    }
    .chart-title {
        text-align: center;
        font-weight: bold;
        margin: 15px 0;
        font-size: 1.2em; /* Minimized font size */
    }
    .status-icon {
        margin-right: 5px;
    }
    .pending-text {
        color: #ffcc00;
    }
    .completed-text {
        color: green;
    }
</style>

<div class="container">
    <h1 class="mb-4" style="font-weight: bold; font-size: 2em; color: #343a40;">
        <i class="fas fa-warehouse"></i> Order Manager
    </h1>

    <div class="row">
        <div class="col-md-3">
            <div class="stat-card">
                <h5><i class="fas fa-list" style="color: #007bff;"></i> Total Orders</h5>
                <p><strong>{{ $totalOrders }}</strong></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h5><i class="fas fa-clock" style="color: yellow;"></i> Pending Orders</h5>
                <p><strong>{{ $pendingOrders }}</strong></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h5><i class="fas fa-check-circle" style="color: green;"></i> Completed Orders</h5>
                <p><strong>{{ $completedOrders }}</strong></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h5><i class="fas fa-cogs" style="color: #ffcc00;"></i> Preparing</h5>
                <p><strong>{{ $preparingOrders }}</strong></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h5><i class="fas fa-truck" style="color: #007bff;"></i> Ready for Delivery</h5>
                <p><strong>{{ $readyForDeliveryOrders }}</strong></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h5><i class="fas fa-shipping-fast" style="color: green;"></i> Shipped</h5>
                <p><strong>{{ $shippedOrders }}</strong></p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h5><i class="fas fa-times-circle" style="color: red;"></i> Cancelled</h5>
                <p><strong>{{ $cancelledOrders }}</strong></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2 class="chart-title">Orders Overview</h2>
            <canvas id="ordersChart" class="canvas-large"></canvas>
        </div>
        <div class="col-md-6">
            <h2 class="chart-title">Payment Methods</h2>
            <canvas id="paymentMethodChart" class="canvas-large"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2 class="chart-title">Order Status Distribution</h2>
            <canvas id="orderStatusChart" class="canvas-large"></canvas>
        </div>
        <div class="col-md-6">
            <h2 class="chart-title">Daily Orders</h2>
            <canvas id="dailyOrdersChart" class="canvas-large"></canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2 class="chart-title">Monthly Orders</h2>
            <canvas id="monthlyOrdersChart" class="canvas-large"></canvas>
        </div>
        <div class="col-md-6">
            <h2 class="chart-title">Average Order Value</h2>
            <canvas id="averageOrderValueChart" class="canvas-large"></canvas>
        </div>
    </div>

    <h2>Recent Orders</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->fname }} {{ $order->lname }}</td>
                        <td>
                            @if($order->status == 0)
                                <i class="fas fa-clock status-icon pending-text"></i>
                                <span class="pending-text">Pending</span>
                            @elseif($order->status == 1)
                                <i class="fas fa-check-circle status-icon completed-text"></i>
                                <span class="completed-text">Completed</span>
                            @elseif($order->status == 2)
                                <i class="fas fa-cogs status-icon"></i>
                                <span>Preparing</span>
                            @elseif($order->status == 3)
                                <i class="fas fa-truck status-icon"></i>
                                <span>Ready for Delivery</span>
                            @elseif($order->status == 4)
                                <i class="fas fa-shipping-fast status-icon"></i>
                                <span>Shipped</span>
                            @else
                                <i class="fas fa-times-circle status-icon pending-text"></i>
                                <span class="pending-text">Cancelled</span>
                            @endif
                        </td>
                        <td>₱{{ number_format($order->total_price, 2) }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ url('admin/view-order/'.$order->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Orders Overview Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ordersCtx, {
            type: 'pie',
            data: {
                labels: ['Pending Orders', 'Completed Orders', 'Preparing', 'Ready for Delivery', 'Shipped', 'Cancelled'],
                datasets: [{
                    label: 'Orders Overview',
                    data: [{{ $pendingOrders }}, {{ $completedOrders }}, {{ $preparingOrders }}, {{ $readyForDeliveryOrders }}, {{ $shippedOrders }}, {{ $cancelledOrders }}],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        // Payment Method Chart
        const paymentMethodCtx = document.getElementById('paymentMethodChart').getContext('2d');
        const paymentMethodChart = new Chart(paymentMethodCtx, {
            type: 'doughnut',
            data: {
                labels: ['Cash', 'PayPal'],
                datasets: [{
                    label: 'Payment Methods',
                    data: [{{ $paymentMethodCounts['cash'] }}, {{ $paymentMethodCounts['paypal'] }}],
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        // Order Status Chart
        const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
        const orderStatusChart = new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: ['Pending Orders', 'Completed Orders', 'Preparing', 'Ready for Delivery', 'Shipped', 'Cancelled'],
                datasets: [{
                    label: 'Order Status Count',
                    data: [{{ $pendingOrders }}, {{ $completedOrders }}, {{ $preparingOrders }}, {{ $readyForDeliveryOrders }}, {{ $shippedOrders }}, {{ $cancelledOrders }}],
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
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

        // Daily Orders Chart
        const dailyCtx = document.getElementById('dailyOrdersChart').getContext('2d');
        const dailyOrdersChart = new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyOrders->pluck('date')) !!},
                datasets: [{
                    label: 'Daily Orders',
                    data: {!! json_encode($dailyOrders->pluck('total_orders')) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
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

        // Monthly Orders Chart
        const monthlyCtx = document.getElementById('monthlyOrdersChart').getContext('2d');
        const monthlyOrdersChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyOrders->pluck('month_name')) !!},
                datasets: [{
                    label: 'Total Orders per Month',
                    data: {!! json_encode($monthlyOrders->pluck('total_orders')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
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

        // Average Order Value Chart
        const avgOrderValueCtx = document.getElementById('averageOrderValueChart').getContext('2d');
        const avgOrderValueChart = new Chart(avgOrderValueCtx, {
            type: 'bar',
            data: {
                labels: ['Average Order Value'],
                datasets: [{
                    label: '₱{{ number_format($averageOrderValue, 2) }}',
                    data: [{{ $averageOrderValue }}],
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Average Order Value'
                        }
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
    });
</script>
@endsection