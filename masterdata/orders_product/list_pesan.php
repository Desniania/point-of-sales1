<?php
require_once('koneksi.php');

// Ambil semua data pesanan, termasuk total harga dan status pembayaran
$result = $conn->query("SELECT * FROM orders_makan ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans leading-normal tracking-normal bg-gray-100">
    <!-- Header -->
    <header class="bg-gray-800 text-white p-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center">Daftar Pesanan Makanan</h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <table class="min-w-full bg-white rounded-lg shadow-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200">ID</th>
                    <th class="py-2 px-4 bg-gray-200">Nama</th>
                    <th class="py-2 px-4 bg-gray-200">Pesanan</th>
                    <th class="py-2 px-4 bg-gray-200">Jumlah</th>
                    <th class="py-2 px-4 bg-gray-200">Alamat</th>
                    <th class="py-2 px-4 bg-gray-200">Total Harga (Rp)</th>
                    <th class="py-2 px-4 bg-gray-200">Status Pembayaran</th>
                    <th class="py-2 px-4 bg-gray-200">Tanggal</th>
                    <th class="py-2 px-4 bg-gray-200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-2 px-4 border"><?php echo $row['id']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $row['nama']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $row['pesanan']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $row['jumlah']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $row['alamat']; ?></td>
                        <td class="py-2 px-4 border"><?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td class="py-2 px-4 border">
                            <?php echo $row['status_pembayaran']; ?>
                            <form action="proses_pembayaran.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">
                                    Tandai Lunas
                                </button>
                            </form>
                        </td>
                        <td class="py-2 px-4 border"><?php echo $row['created_at']; ?></td>
                        <td class="py-2 px-4 border text-center">
                            <a href="edit_pesanan.php?id=<?php echo $row['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>
                            <a href="hapus_pesanan.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Restoran Makanan - Pesan Makanan Lezat dari Rumah</p>
        </div>
    </footer>

</body>
</html>

