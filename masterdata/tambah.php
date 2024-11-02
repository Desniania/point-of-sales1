<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_date = $_POST['transaction_date'];
    $customer_name = $_POST['customer_name'];
    $item_count = $_POST['item_count'];
    $total_price = $_POST['total_price'];
    $status = $_POST['status'];
    
    $sql = "INSERT INTO transactions (transaction_date, customer_name, item_count, total_price, status) VALUES (:transaction_date, :customer_name, :item_count, :total_price, :status)";
    $stmt = $koneksi->prepare($sql);

    $stmt->execute([
        "transaction_date" => $transaction_date,
        "customer_name" => $customer_name,
        "item_count" => $item_count,
        "total_price" => $total_price,
        "status" => $status
    ]);

    header('Location: transaksi.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Proses</h1>
        <form method="POST" class="space-y-4">
            <div>
                <label for="transaction_date" class="block text-gray-700 font-medium">Transaction Date:</label>
                <input type="datetime-local" id="transaction_date" name="transaction_date" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="customer_name" class="block text-gray-700 font-medium">Customer Name:</label>
                <input type="text" id="customer_name" name="customer_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="item_count" class="block text-gray-700 font-medium">Item Count:</label>
                <input type="number" id="item_count" name="item_count" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="total_price" class="block text-gray-700 font-medium">Total Price:</label>
                <input type="number" id="total_price" name="total_price" step="0.01" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="status" class="block text-gray-700 font-medium">Status:</label>
                <select id="status" name="status" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700">Add Transaction</button>
            </div>
        </form>
    </div>
</body>
</html>
