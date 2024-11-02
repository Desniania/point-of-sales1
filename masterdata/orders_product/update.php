<?php
require_once('koneksi.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM orders_makan WHERE id = $id");

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pesanan = htmlspecialchars($_POST['pesanan']);
    $jumlah = intval($_POST['jumlah']);
    $alamat = htmlspecialchars($_POST['alamat']);

    $stmt = $conn->prepare("UPDATE orders SET nama = ?, email = ?, pesanan = ?, jumlah = ?, alamat = ? WHERE id = ?");
    $stmt->bind_param("sssdsi", $nama, $email, $pesanan, $jumlah, $alamat, $id);

    if ($stmt->execute()) {
        header("Location: list_pesanan.php");
        exit();
    } else {
        $error = "Terjadi kesalahan saat memperbarui pesanan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pesanan</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans leading-normal tracking-normal bg-gray-100">

    <!-- Header -->
    <header class="bg-gray-800 text-white p-6">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold text-center">Edit Pesanan</h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-12">
        <?php if (isset($error)): ?>
            <div class="bg-red-500 text-white p-4 mb-6 rounded-lg shadow-lg text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="edit_pesanan.php?id=<?php echo $id; ?>" method="POST" class="bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto border border-gray-200">
            <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
            <div class="mb-6">
                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama:</label>
                <input type="text" id="nama" name="nama" class="w-full p-3 border rounded-lg" value="<?php echo $order['nama']; ?>" required>
            </div>
            <div class="mb-6">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" class="w-full p-3 border rounded-lg" value="<?php echo $order['email']; ?>" required>
            </div>
            <div class="mb-6">
                <label for="pesanan" class="block text-gray-700 font-bold mb-2">Pesanan:</label>
                <input type="text" id="pesanan" name="pesanan" class="w-full p-3 border rounded-lg" value="<?php echo $order['pesanan']; ?>" required>
            </div>
            <div class="mb-6">
                <label for="jumlah" class="block text-gray-700 font-bold mb-2">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" class="w-full p-3 border rounded-lg" value="<?php echo $order['jumlah']; ?>" required>
            </div>
            <div class="mb-6">
                <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat Pengiriman:</label>
                <textarea id="alamat" name="alamat" class="w-full p-3 border rounded-lg" required><?php echo $order['alamat']; ?></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-6 py-3 rounded-full font-bold hover:shadow-lg hover:bg-gradient-to-l transition duration-300 ease-in-out">
                    Update Pesanan
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Restoran Makanan - Pesan Makanan Lezat dari Rumah</p>
        </div>
    </footer>

</body>
</html>
