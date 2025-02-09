<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Dashboard' ?></title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js for creating charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar {
            background-color: #2c3e50;
        }

        .navbar-brand {
            color: #ecf0f1 !important;
            font-weight: 700;
        }

        .navbar-nav .nav-item .nav-link {
            color: #ecf0f1;
            font-weight: 500;
        }

        .navbar-nav .nav-item .nav-link:hover {
            color: #3498db;
        }

        .container {
            margin-top: 30px;
        }

        .container h1 {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            color: #34495e;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Card Styles */
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }

        .card-body {
            background-color: #ffffff;
            color: #555;
            padding: 20px;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Button Styles */
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    

    <!-- Main Content -->
    <div class="container">
        <h1 class="mt-4 mb-4"><?= $title ?? '' ?></h1>

        <!-- Dashboard Overview -->
        <div class="row">
            <!-- Revenue Card -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Tổng Doanh Thu</div>
                    <div class="card-body">
                        <h5 class="card-title">$20,000</h5>
                        <p class="card-text">Tổng doanh thu trong tháng này</p>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Đơn Hàng Mới</div>
                    <div class="card-body">
                        <h5 class="card-title">150</h5>
                        <p class="card-text">Số lượng đơn hàng đã được nhận trong tháng</p>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Sản Phẩm</div>
                    <div class="card-body">
                        <h5 class="card-title">350</h5>
                        <p class="card-text">Tổng số sản phẩm có sẵn trong kho</p>
                    </div>
                </div>
            </div>

            <!-- Customers Card -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Khách Hàng</div>
                    <div class="card-body">
                        <h5 class="card-title">1,200</h5>
                        <p class="card-text">Tổng số khách hàng đăng ký trong tháng</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">Doanh Thu Hàng Tháng</div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Revenue Chart
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Doanh Thu',
                    data: [5000, 7000, 4000, 8000, 10000, 12000, 14000],
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.2)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>
