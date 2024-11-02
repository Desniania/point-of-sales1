<?php
require_once('koneksi.php');

// Ambil semua data pesanan dari database
$sql = "SELECT * FROM orders_makan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .table-container {
            margin-top: 20px;
            border-radius: 10px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #4A5568;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f5f9;
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }

        .header-icon svg {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body class="font-sans bg-gray-100 leading-normal tracking-normal">

    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold flex items-center justify-center header-icon">
                <svg class="w-8 h-8 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V8a4 4 0 00-4-4H8a4 4 0 00-4 4v5m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
                </svg>
                Data Pesanan Makanan
            </h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="table-container bg-white p-6 rounded-lg shadow-xl">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Daftar Pesanan</h2>
            <table class="table-auto w-full rounded-lg overflow-hidden shadow-lg">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-2">Tanggal Pemesanan</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Pesanan</th>
                        <th class="px-4 py-2">Jumlah</th>
                        <th class="px-4 py-2">Total Harga (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-blue-50">
                                <td class="px-4 py-3"><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
                                <td class="px-4 py-3"><?php echo $row['nama']; ?></td>
                                <td class="px-4 py-3"><?php echo $row['pesanan']; ?></td>
                                <td class="px-4 py-3"><?php echo $row['jumlah']; ?></td>
                                <td class="px-4 py-3"><?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">Tidak ada pesanan ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Restoran Makanan - Daftar Pesanan Makanan</p>
        </div>
    </footer>

</body>
</html>

<?php
$conn->close();
?>

