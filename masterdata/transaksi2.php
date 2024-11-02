<?php
session_start();
include 'koneksi.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit();
}

// Mengambil data dari database
$customers = mysqli_query($conn, "SELECT * FROM customers");
$categories = mysqli_query($conn, "SELECT * FROM categories1");
$products = mysqli_query($conn, "SELECT * FROM products_makan WHERE stock > 0"); // Hanya menampilkan produk dengan stok lebih dari 0

// Proses transaksi
if (isset($_POST['submit_transaction'])) {
    $customer_id = $_POST['customer_id'];
    $total_price = $_POST['total_price'];
    $payment_amount = $_POST['payment_amount']; // Nominal pembayaran
    $change = $payment_amount - $total_price; // Uang kembalian

    if ($change < 0) {
        echo "<script>alert('Jumlah pembayaran tidak mencukupi.'); window.location='transaksi2.php';</script>";
        exit();
    }

    // Simpan order di tabel orders
    $insert_order = mysqli_query($conn, "INSERT INTO orders_makan (customer_id, total_price, payment_amount, change_amount, order_date) VALUES ('$customer_id', '$total_price', '$payment_amount', '$change', NOW())");
    $order_id = mysqli_insert_id($conn); // Mendapatkan order_id dari transaksi

    foreach ($_POST['product_id'] as $index => $product_id) {
        $quantity = $_POST['quantity'][$index];
        $price = $_POST['price'][$index];
        $total_item_price = $quantity * $price;

        // Ambil stok produk
        $product_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stock FROM products WHERE id='$product_id'"));
        $stock = $product_data['stock'];

        // Cek apakah stok mencukupi
        if ($quantity > $stock) {
            echo "<script>alert('Stok produk tidak mencukupi. Transaksi dibatalkan.'); window.location='transaksi2.php';</script>";
            exit();
        }

        // Simpan produk ke dalam tabel order_products
        $insert_order_product = mysqli_query($conn, "INSERT INTO order_products (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$total_item_price')");

        // Update stok produk
        $new_stock = $stock - $quantity;
        $update_stock = mysqli_query($conn, "UPDATE products SET stock='$new_stock' WHERE id='$product_id'");
    }

    echo "<script>alert('Transaksi berhasil! Kembalian: Rp " . number_format($change, 0, ',', '.') . "'); window.location='transaksi.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .product-card {
            cursor: pointer;
            border-radius: 10px;
            transition: transform 0.2s ease-in-out;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .cart-list {
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <?php include "header.php"; ?>

    <div class="container mx-auto py-12 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Daftar Produk -->
            <div class="col-span-2">
                <h2 class="text-2xl font-bold mb-6">Daftar Produk</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden product-card" onclick="addToCart(<?= $product['id']; ?>, '<?= $product['name']; ?>', <?= $product['price']; ?>, <?= $product['stock']; ?>)">
                            <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>" class="w-full h-32 object-cover" onerror="this.onerror=null; this.src='images/default.jpg';">
                            <div class="p-4">
                                <h5 class="text-lg font-bold"><?= $product['name']; ?></h5>
                                <p class="text-gray-700">Rp <?= number_format($product['price'], 0, ',', '.'); ?></p>
                                <p class="text-sm text-gray-500">Stok: <?= $product['stock']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Keranjang -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Keranjang</h2>
                <form method="POST" action="transaksi.php" class="bg-white p-6 rounded-lg shadow-md">

                    <!-- Pilih Customer -->
                    <div class="mb-4">
                        <label for="customer_id" class="block text-gray-700 font-semibold mb-2">Pilih Customer</label>
                        <select name="customer_id" id="customer_id" class="w-full p-3 border border-gray-300 rounded-lg" required>
                            <option value="">-- Pilih Customer --</option>
                            <?php while ($customer = mysqli_fetch_assoc($customers)) { ?>
                                <option value="<?= $customer['id']; ?>"><?= $customer['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Daftar Produk di Keranjang -->
                    <div id="cart-list" class="cart-list mb-4 border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <!-- Produk yang ditambahkan akan muncul di sini -->
                        <p class="text-gray-600">Keranjang masih kosong.</p>
                    </div>

                    <!-- Subtotal -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Subtotal: Rp <span id="subtotal">0</span></label>
                        <input type="hidden" name="total_price" id="total_price" value="0">
                    </div>

                    <!-- Input Pembayaran -->
                    <div class="mb-4">
                        <label for="payment_amount" class="block text-gray-700 font-semibold mb-2">Jumlah Pembayaran</label>
                        <input type="number" name="payment_amount" id="payment_amount" class="w-full p-3 border border-gray-300 rounded-lg" required>
                    </div>

                    <button type="submit" name="submit_transaction" class="w-full bg-gradient-to-r from-green-500 to-blue-500 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition duration-300">
                        Submit Transaksi
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        let cart = [];
        let subtotal = 0;

        // Fungsi untuk menambahkan produk ke keranjang
        function addToCart(id, name, price, stock) {
            let quantity = prompt(`Masukkan jumlah untuk ${name} (Stok: ${stock}):`);
            quantity = parseInt(quantity);

            if (quantity > stock || quantity <= 0) {
                alert('Jumlah tidak valid atau stok tidak mencukupi.');
                return;
            }

            // Cek apakah produk sudah ada di keranjang
            const existingProduct = cart.find(item => item.id === id);

            if (existingProduct) {
                existingProduct.quantity += quantity;
            } else {
                cart.push({ id, name, price, quantity, stock });
            }

            // Update subtotal
            subtotal += quantity * price;
            document.getElementById('subtotal').textContent = subtotal;
            document.getElementById('total_price').value = subtotal;

            // Render ulang keranjang
            renderCart();
        }

        // Fungsi untuk merender keranjang
        function renderCart() {
            const cartList = document.getElementById('cart-list');
            cartList.innerHTML = '';

            cart.forEach((item, index) => {
                cartList.innerHTML += `
                    <div class="cart-item">
                        <span>${item.name} (x${item.quantity})</span>
                        <span>Rp ${item.quantity * item.price}</span>
                        <input type="hidden" name="product_id[]" value="${item.id}">
                        <input type="hidden" name="quantity[]" value="${item.quantity}">
                        <input type="hidden" name="price[]" value="${item.price}">
                    </div>
                `;
            });
        }
    </script>

</body>
</html>

