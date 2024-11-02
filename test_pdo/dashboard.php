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
    <title>Dashboard - Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Custom Styles */
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
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-gray-900 text-white">
        <div class="container mx-auto flex justify-between items-center p-5">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="dashboard.php" class="hover:underline">Dashboard</a></li>
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
                        <i class="fa fa-user-circle dashboard-icon"></i> Selamat Datang,
                    <div class="card-body text-center">
                        <p class="welcome-message">Anda berada di Dashboard Admin.</p>
                        <div class="dashboard-actions mt-4">
                            <a href="tambah.php" class="btn btn-primary btn-lg">
                                <i class="fa fa-user-plus"></i> Tambah Admin
                            </a>
                            <a href="../.php" class="btn btn-success btn-lg">
                                <i class="fa fa-list"></i> Lihat Menu
                            </a>
                            <a href="../pesan.php" class="btn btn-info btn-lg">
                                <i class="fa fa-shopping-cart"></i>  Memesanan
                            </a>
                             <!-- Added Dashboard Penjualan Button -->
                        <a href="dashboard1.php" class="btn btn-secondary btn-lg">
                            <i class="fa fa-line-chart"></i> Dashboard Penjualan
                        </a>
                    </div>
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
</body>
</html>
