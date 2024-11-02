<?php
require_once('koneksi.php');

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $stmt = $conn->prepare('INSERT INTO customers (name, email, phone, address) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $email, $phone, $address);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['customer_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        $stmt = $conn->prepare('UPDATE customers SET name = ?, email = ?, phone = ?, address = ? WHERE customer_id = ?');
        $stmt->bind_param('ssssi', $name, $email, $phone, $address, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['customer_id'];
        $stmt = $conn->prepare('DELETE FROM customers WHERE customer_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

// Fetch all customers from the database
$result = $conn->query("SELECT * FROM customers ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
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
            background-color: #f1f5f9;
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
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Header -->
    <header class="bg-gradient-to-r from-green-500 to-teal-600 text-white p-6 shadow-md">
        <div class="container mx-auto">
            <h1 class="text-4xl font-bold flex items-center justify-center">
                <svg class="w-8 h-8 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h18M3 12h18m-9 7h9" />
                </svg>
                Customer List
            </h1>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-semibold text-gray-700">Customers</h2>
            <button id="addCustomerBtn" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition-all duration-300 ease-in-out">Add Customer</button>
        </div>
        
        <!-- Add Customer Form -->
        <div id="addCustomerForm" class="hidden bg-white p-6 rounded-lg shadow-lg mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Add New Customer</h3>
            <form action="" method="POST" class="space-y-4">
                <input type="text" name="name" placeholder="Name" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">
                <input type="email" name="email" placeholder="Email" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">
                <input type="text" name="phone" placeholder="Phone" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">
                <input type="text" name="address" placeholder="Address" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 w-full">
                <button type="submit" name="create" class="bg-green-500 text-white px-4 py-2 rounded-lg">Add Customer</button>
            </form>
        </div>

        <!-- Customer List -->
        <div class="table-container bg-white p-6 rounded-lg shadow-lg">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Email</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Phone</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-50 uppercase tracking-wider">Address</th>
                        <th class="py-3 px-4 text-center text-xs font-medium text-gray-50 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($customer = $result->fetch_assoc()): ?>
                            <tr class="border-b hover:bg-gray-50 transition duration-200">
                                <td class="py-3 px-4"><?php echo htmlspecialchars($customer['name']); ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($customer['phone']); ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($customer['address']); ?></td>
                                <td class="py-3 px-4 text-center">
                                    <button class="text-blue-500 action-btn" onclick="document.getElementById('edit-<?php echo $customer['customer_id']; ?>').classList.remove('hidden')">Edit</button> | 
                                    <form action="" method="POST" style="display:inline">
                                        <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
                                        <button type="submit" name="delete" class="text-red-500 action-btn" onclick="return confirm('Apakah anda yakin menghapus ini?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Edit Form (Hidden) -->
                            <tr id="edit-<?php echo $customer['customer_id']; ?>" class="hidden">
                                <td colspan="5">
                                    <div class="bg-blue-50 p-4 border border-blue-300 rounded-lg shadow-md">
                                        <form action="" method="POST" class="space-y-2">
                                            <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">
                                            <input type="text" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" class="w-full p-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                            <input type="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" class="w-full p-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                            <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" class="w-full p-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                            <input type="text" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>" class="w-full p-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                                            <button type="submit" name="update" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Update</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td class="py-3 px-4 text-center text-gray-500" colspan="5">No customers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white p-6 mt-12 text-center">
        <p>&copy; 2024 Your Company - All Rights Reserved</p>
    </footer>

    <script>
        document.getElementById('addCustomerBtn').addEventListener('click', function() {
            document.getElementById('addCustomerForm').classList.toggle('hidden');
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
