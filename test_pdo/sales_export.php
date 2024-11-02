<?php
session_start();
require_once('koneksi.php');

// Cek apakah admin sudah login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}

// Prepare CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=sales_report.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Write header row to CSV
fputcsv($output, ['Bulan', 'Total Penjualan (Rp)']);

// Example sales data (replace with your actual data from database)
$salesData = [
    ['Jan', 1200000],
    ['Feb', 1500000],
    ['Mar', 1300000],
    ['Apr', 1400000],
    ['May', 1600000],
    ['Jun', 1700000],
    ['Jul', 1800000],
    ['Aug', 1500000],
    ['Sep', 1600000],
    ['Oct', 1400000],
    ['Nov', 1300000],
    ['Dec', 1200000],
];

// Write data rows to CSV
foreach ($salesData as $row) {
    fputcsv($output, $row);
}

// Close output stream
fclose($output);
exit();
?>
