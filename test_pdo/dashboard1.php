<?php
session_start();
require_once('koneksi.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjualan - Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .card-header {
            background-color:#E6E6FA;
            color: black;
            text-align: center;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .welcome-message {
            font-size: 1.75rem;
            font-weight: bold;
            color: #333;
        }
        .dashboard-actions a {
            margin: 0 10px;
            color: white;
        }
        .dashboard-actions .btn {
            transition: all 0.3s ease;
        }
        .dashboard-actions .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .container {
            margin-top: 50px;
        }
        .dashboard-icon {
            font-size: 50px;
            color: #007bff;
        }
        .logout-btn {
            background-color: #dc3545;
            border: none;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
        .chart-container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-gray-900 text-white">
        <div class="container mx-auto flex justify-between items-center p-5">
            <h1 class="text-3xl font-bold">Dashboard Penjualan</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="dashboard.php" class="hover:underline">Dashboard</a></li>
                    <li><a href="sales_dashboard.php" class="hover:underline">Dashboard Penjualan</a></li>
                    <li><a href="logout.php" class="hover:underline">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <i class="fa fa-line-chart dashboard-icon"></i> Laporan Penjualan
                    </div>
                    <div class="card-body">
                        <p class="welcome-message text-center">Analisis Penjualan Restoran Anda</p>

                        <!-- Sales Metrics -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header bg-success text-white">Total Penjualan</div>
                                    <div class="card-body text-center">
                                        <h2 class="font-weight-bold">Rp 25,000,000</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header bg-info text-white">Penjualan Hari Ini</div>
                                    <div class="card-body text-center">
                                        <h2 class="font-weight-bold">Rp 10,200,000</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header bg-warning text-white">Jumlah Transaksi</div>
                                    <div class="card-body text-center">
                                        <h2 class="font-weight-bold">550</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sales Chart -->
                        <div class="chart-container">
                            <h3 class="text-center">Grafik Penjualan Bulanan</h3>
                            <canvas id="salesChart"></canvas>
                        </div>

                        <!-- Button Actions -->
                        <div class="dashboard-actions text-center mt-4">
                            <a href="sales_export.php" class="btn btn-primary btn-lg">
                                <i class="fa fa-download"></i> Export Laporan
                            </a>
                            <a href="dashboard.php" class="btn btn-secondary btn-lg">
                                <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample data for sales chart
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: [1200000, 1500000, 1300000, 1400000, 1600000, 1700000, 1800000, 1500000, 1600000, 1400000, 1300000, 1200000],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
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
    </script>
</body>
</html>
