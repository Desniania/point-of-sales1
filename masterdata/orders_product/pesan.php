<?php
require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars($_POST['nama']);
    $pesanan = htmlspecialchars($_POST['pesanan']);
    $jumlah = intval($_POST['jumlah']);
    $total_harga = floatval($_POST['total_harga']);
    $pembayaran = floatval($_POST['pembayaran']);
    $kembalian = $pembayaran - $total_harga;

    // Simple validation
    if (empty($nama) || empty($pesanan) || empty($jumlah) || $total_harga <= 0) {
        $error = "Semua bidang harus diisi dan jumlah pesanan harus lebih dari 0!";
    } elseif ($pembayaran < $total_harga) {
        $error = "Jumlah pembayaran tidak cukup!";
    } else {
        // Insert data into the database
        $stmt = $conn->prepare("INSERT INTO orders_makan (nama, pesanan, jumlah, total_harga, pembayaran, kembalian) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdddd", $nama, $pesanan, $jumlah, $total_harga, $pembayaran, $kembalian);
        if ($stmt->execute()) {
            $success = "Pesanan Anda berhasil disimpan!";
        } else {
            $error = "Terjadi kesalahan saat menyimpan pesanan.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pesanan Makanan</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .input-field:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.5);
        }
        .input-field {
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
    </style>
    <script>
        function updateTotal() {
            const pesananSelect = document.getElementById('pesanan');
            const selectedOption = pesananSelect.options[pesananSelect.selectedIndex];
            const harga = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
            const totalHarga = harga * jumlah;
            document.getElementById('total_harga').value = totalHarga.toFixed(2);
            updateKembalian();
        }

        function updateKembalian() {
            const totalHarga = parseFloat(document.getElementById('total_harga').value) || 0;
            const pembayaran = parseFloat(document.getElementById('pembayaran').value) || 0;
            const kembalian = pembayaran - totalHarga;
            document.getElementById('kembalian').value = kembalian.toFixed(2);
        }
    </script>
</head>
<body class="font-sans bg-gray-100 leading-normal tracking-normal">

    <!-- Header -->
    <header class="bg-gradient-to-r from-green-500 to-blue-600 text-white p-6 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold flex items-center justify-center">
                <svg class="w-8 h-8 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V8a4 4 0 00-4-4H8a4 4 0 00-4 4v5m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4" />
                </svg>
                Form Pesanan Makanan
            </h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto border border-gray-200">
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Isi Pesanan Anda</h2>

            <?php if (isset($error)): ?>
                <div class="bg-red-500 text-white p-4 mb-6 rounded-lg shadow-lg text-center">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="bg-green-500 text-white p-4 mb-6 rounded-lg shadow-lg text-center">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <form action="pesan.php" method="POST">
                <div class="mb-6">
                    <label for="nama" class="block text-gray-700 font-bold mb-2">Nama:</label>
                    <input type="text" id="nama" name="nama" class="input-field w-full p-3 border rounded-lg border-gray-300" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="mb-6">
                    <label for="pesanan" class="block text-gray-700 font-bold mb-2">Pesanan:</label>
                    <select id="pesanan" name="pesanan" class="input-field w-full p-3 border rounded-lg border-gray-300" onchange="updateTotal()" required>
                        <option value="" data-price="0">Pilih Menu</option>
                        <option value="Nasi Goreng" data-price="25000">Nasi Goreng - Rp 25,000</option>
                        <option value="Mie Ayam" data-price="20000">Mie Ayam - Rp 20,000</option>
                        <option value="Sate Ayam" data-price="30000">Sate Ayam - Rp 30,000</option>
                        <option value="Gado-gado" data-price="15000">Gado-gado - Rp 15,000</option>
                        <option value="Bakso" data-price="18000">Bakso - Rp 18,000</option>
                        <option value="Ayam Geprek" data-price="22000">Ayam Geprek - Rp 22,000</option>
                        <option value="Rendang" data-price="35000">Rendang - Rp 35,000</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label for="jumlah" class="block text-gray-700 font-bold mb-2">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah" class="input-field w-full p-3 border rounded-lg border-gray-300" placeholder="Jumlah pesanan" onchange="updateTotal()" required>
                </div>

                <div class="mb-6">
                    <label for="total_harga" class="block text-gray-700 font-bold mb-2">Total Harga (Rp):</label>
                    <input type="text" id="total_harga" name="total_harga" class="input-field w-full p-3 border rounded-lg border-gray-300 bg-gray-200" readonly>
                </div>

                <div class="mb-6">
                    <label for="pembayaran" class="block text-gray-700 font-bold mb-2">Jumlah Pembayaran (Rp):</label>
                    <input type="number" id="pembayaran" name="pembayaran" class="input-field w-full p-3 border rounded-lg border-gray-300" placeholder="Masukkan jumlah pembayaran" oninput="updateKembalian()" required>
                </div>

                <div class="mb-6">
                    <label for="kembalian" class="block text-gray-700 font-bold mb-2">Kembalian (Rp):</label>
                    <input type="text" id="kembalian" name="kembalian" class="input-field w-full p-3 border rounded-lg border-gray-300 bg-gray-200" readonly>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-blue-500 text-white px-6 py-3 rounded-full font-bold hover:shadow-lg hover:bg-gradient-to-l transition duration-300 ease-in-out">
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Restoran Makanan - Pesan Makanan Lezat dari Rumah</p>
        </div>
    </footer>

</body>
</html>


