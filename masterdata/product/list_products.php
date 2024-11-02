<?php
require_once('koneksi.php');

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $stmt = $conn->prepare('INSERT INTO products_makan (name, description, price) VALUES (?, ?, ?)');
        $stmt->bind_param('ssd', $name, $description, $price);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['product_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        $stmt = $conn->prepare('UPDATE products_makan SET name = ?, description = ?, price = ? WHERE id = ?');
        $stmt->bind_param('ssdi', $name, $description, $price, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['product_id'];
        $stmt = $conn->prepare('DELETE FROM products_makan WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

// Fetch products from the database
$result = $conn->query("SELECT * FROM products_makan ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead th {
            background-color: #4A5568;
            color: white;
        }
        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #e2e8f0;
            transform: scale(1.01);
            transition: all 0.3s ease;
        }
        .action-btn {
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }
        .action-btn:hover {
            color: #2563EB;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-6 shadow-md">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold flex items-center justify-center">
                <svg class="w-8 h-8 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v12m5 5H6a2 2 0 01-2-2V10a2 2 0 012-2h3m7-2h4a2 2 0 012 2v7" />
                </svg>
                Product List
            </h1>
        </div>
    </header>
    
    <!-- Main Content -->
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-700">Products</h2>
            <button id="addProductBtn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 shadow-md transition-all duration-200 ease-in-out">Add Product</button>
        </div>
        
        <!-- Add Product Form -->
        <div id="addProductForm" class="hidden bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Add New Product</h3>
            <form action="" method="POST" class="space-y-4">
                <input type="text" name="name" placeholder="Name" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-full">
                <textarea name="description" placeholder="Description" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-full"></textarea>
                <input type="number" name="price" placeholder="Price" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-full" step="0.01">
                <button type="submit" name="create" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Product</button>
            </form>
        </div>

        <!-- Product List -->
        <div class="table-container bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Description</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Price</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-50 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b hover:bg-gray-50 transition duration-200">
                            <td class="py-3 px-6"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="py-3 px-6"><?php echo htmlspecialchars($row['description']); ?></td>
                            <td class="py-3 px-6"><?php echo number_format($row['price'], 2); ?> Rp</td>
                            <td class="py-3 px-6 text-center">
                                <button class="text-blue-500 action-btn" onclick="document.getElementById('edit-<?php echo $row['id']; ?>').classList.remove('hidden')">Edit</button> | 
                                <form action="" method="POST" style="display:inline">
                                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete" class="text-red-500 action-btn" onclick="return confirm('Apakah anda yakin menghapus ini?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        
                        <!-- Edit Form (Hidden) -->
                        <tr id="edit-<?php echo $row['id']; ?>" class="hidden">
                            <td colspan="4">
                                <div class="bg-yellow-50 p-4 border border-yellow-300 rounded-lg shadow-md">
                                    <form action="" method="POST" class="space-y-2">
                                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" class="w-full p-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
                                        <textarea name="description" class="w-full p-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                                        <input type="number" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" class="w-full p-2 border border-yellow-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400" required step="0.01">
                                        <button type="submit" name="update" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">Update</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if ($result->num_rows == 0): ?>
                <p class="text-center text-gray-500 mt-4">No products found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6 mt-12 text-center">
        <p>&copy; 2024 Restoran Makanan - All Rights Reserved</p>
    </footer>

    <script>
        document.getElementById('addProductBtn').addEventListener('click', function() {
            document.getElementById('addProductForm').classList.toggle('hidden');
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
