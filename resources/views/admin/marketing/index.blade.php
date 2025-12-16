@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: #f8f9fa;
    }
    .container {
        padding: 15px;
    }
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .card h2 {
        font-size: 1.25rem;
        color: #343a40;
        margin-bottom: 15px;
    }
    .chart-container {
        margin-bottom: 30px;
    }
    .text-center {
        color: #495057;
        margin-bottom: 15px;
    }
    .table th {
        background-color: #e9ecef;
    }
    .table td {
        vertical-align: middle;
    }
</style>

<div class="container mt-0">
    <h3 class="text-center">Marketing Management Dashboard <i class="fas fa-chart-line"></i></h3>

    <div class="row">
        <div class="col-md-6 chart-container">
            <div class="card">
                <h2>Reviews Over Time <i class="fas fa-star"></i></h2>
                <canvas id="reviewsChart"></canvas>
            </div>
        </div>
        <div class="col-md-6 chart-container">
            <div class="card">
                <h2>Average Ratings <i class="fas fa-star-half-alt"></i></h2>
                <canvas id="ratingsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 chart-container">
            <div class="card">
                <h2>New vs Returning Users <i class="fas fa-users"></i></h2>
                <div id="userChart"></div>
            </div>
        </div>
        <div class="col-md-6 chart-container">
            <div class="card">
                <h2>Top Reviewers <i class="fas fa-medal"></i></h2>
                <div id="topReviewersChart"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 chart-container">
            <div class="card">
                <h2>User Ratings Distribution <i class="fas fa-chart-pie"></i></h2>
                <div id="userRatingsRadarChart"></div>
            </div>
        </div>
        <div class="col-md-6 chart-container">
            <div class="card">
                <h2>Review Sentiment Analysis <i class="fas fa-comments"></i></h2>
                <div id="sentimentChart"></div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 chart-container">
            <div class="card">
                <h2>User Engagement Metrics <i class="fas fa-chart-bar"></i></h2>
                <div id="engagementChart"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h2>Recent Reviews <i class="fas fa-list"></i></h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Review</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                        <tr>
                            <td>{{ $review->user->name }} {{ $review->user->lname }}</td>
                            <td>{{ $review->user_review }}</td>
                            <td>{{ $review->created_at->format('Y-m-d') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Include Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
    // Reviews Chart
    const reviewsCtx = document.getElementById('reviewsChart').getContext('2d');
    const reviewsChart = new Chart(reviewsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($reviewData->keys()) !!},
            datasets: [{
                label: 'Number of Reviews Over Time',
                data: {!! json_encode($reviewData->values()) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Reviews Over Time'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Reviews'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            }
        }
    });

    // Ratings Chart
    const ratingsCtx = document.getElementById('ratingsChart').getContext('2d');
    const ratingsChart = new Chart(ratingsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ratingData->keys()) !!},
            datasets: [{
                label: 'Average Ratings per Category',
                data: {!! json_encode($ratingData->values()) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Average Ratings by Category'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Average Rating'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Rating Categories'
                    }
                }
            }
        }
    });

    // User Chart (Pie)
    const userOptions = {
        chart: {
            type: 'pie',
            height: '350'
        },
        series: [{{ $userData['new_users'] }}, {{ $userData['returning_users'] }}],
        labels: ['New Users', 'Returning Users'],
        title: {
            text: 'User Distribution: New vs Returning Users'
        }
    };
    const userChart = new ApexCharts(document.querySelector("#userChart"), userOptions);
    userChart.render();

    // Top Reviewers Chart
    const topReviewersOptions = {
        chart: {
            type: 'bar',
            height: '350'
        },
        series: [{
            name: 'Top Reviewers',
            data: {!! json_encode($topReviewersData) !!}
        }],
        xaxis: {
            categories: {!! json_encode($topReviewersNames) !!},
            title: {
                text: 'Reviewers'
            }
        },
        title: {
            text: 'Top Reviewers by Number of Reviews'
        }
    };
    const topReviewersChart = new ApexCharts(document.querySelector("#topReviewersChart"), topReviewersOptions);
    topReviewersChart.render();

    // User Ratings Distribution Radar Chart
    const userRatingsRadarOptions = {
        chart: {
            type: 'radar',
            height: 350,
        },
        series: [{
            name: 'User Ratings',
            data: {!! json_encode($userRatingsData) !!}
        }],
        labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
        title: {
            text: 'User Ratings Distribution',
        },
        stroke: {
            width: 2,
        },
        fill: {
            opacity: 0.6,
        },
        markers: {
            size: 5,
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
        },
    };

    const userRatingsRadarChart = new ApexCharts(document.querySelector("#userRatingsRadarChart"), userRatingsRadarOptions);
    userRatingsRadarChart.render();

    // Sentiment Analysis Chart
    google.charts.load('current', { packages: ['corechart', 'bar'] });
    google.charts.setOnLoadCallback(drawSentimentChart);

    function drawSentimentChart() {
        var data = google.visualization.arrayToDataTable([
            ['Sentiment', 'Count'],
            ['Positive', {{ $sentimentData['positive'] }}],
            ['Neutral', {{ $sentimentData['neutral'] }}],
            ['Negative', {{ $sentimentData['negative'] }}]
        ]);

        var options = {
            title: 'Review Sentiment Analysis',
            hAxis: {
                title: 'Sentiment Type'
            },
            vAxis: {
                title: 'Number of Reviews'
            },
            height: 350
        };

        var chart = new google.visualization.BarChart(document.getElementById('sentimentChart'));
        chart.draw(data, options);
    }

    // User Engagement Metrics Chart
    const engagementOptions = {
        chart: {
            type: 'line',
            height: '350'
        },
        series: [{
            name: 'User Engagement',
            data: {!! json_encode($engagementData->values()) !!}
        }],
        xaxis: {
            categories: {!! json_encode($engagementLabels) !!},
            title: {
                text: 'Engagement Time Periods'
            }
        },
        title: {
            text: 'User Engagement Metrics Over Time',
        }
    };
    const engagementChart = new ApexCharts(document.querySelector("#engagementChart"), engagementOptions);
    engagementChart.render();
</script>
@endsection