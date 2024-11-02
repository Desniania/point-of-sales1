<?php
require_once('koneksi.php');

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $stmt = $conn->prepare('INSERT INTO categories1 (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $stmt = $conn->prepare('UPDATE categories1 SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare('DELETE FROM categories1 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

// Fetch categories
$result = $conn->query("SELECT * FROM categories1 ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori</title>
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <header class="mb-6">
            <h2 class="text-3xl font-semibold text-gray-800">Daftar Kategori Makanan</h2>
            <br>
            <!-- Add Category Form -->
            <form action="" method="POST" class="mb-6">
                <input type="text" name="name" placeholder="Nama Kategori" required class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                <button type="submit" name="create" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition">Tambah Kategori</button>
            </form>
        </header>

        <!-- Category List -->
        <div class="bg-white shadow-lg rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Nama Kategori</th>
                        <th class="py-3 px-6 text-left">Tanggal Dibuat</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-3 px-6"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="py-3 px-6"><?php echo htmlspecialchars(date('d-m-Y', strtotime($row['created_at']))); ?></td>
                            <td class="py-3 px-6 text-center space-x-2">
                                <!-- Edit Button -->
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg"
                                    onclick="document.getElementById('edit-<?php echo $row['id']; ?>').classList.toggle('hidden')">Edit</button>

                                <!-- Delete Button -->
                                <form action="" method="POST" style="display:inline">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                                </form>

                                <!-- Edit Form (Hidden by default) -->
                                <div id="edit-<?php echo $row['id']; ?>" class="hidden mt-4 bg-blue-50 p-4 border border-blue-300 rounded-lg shadow-md">
                                    <form action="" method="POST" class="space-y-2">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div>
                                            <label for="name-<?php echo $row['id']; ?>" class="block font-medium text-blue-700">Nama Kategori</label>
                                            <input type="text" id="name-<?php echo $row['id']; ?>" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" class="w-full p-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        </div>
                                        <button type="submit" name="update" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Update</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
