<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

    $sql = "UPDATE user SET nama = :nama, jenis_kelamin = :jenis_kelamin, email = :email" .
           ($password ? ", password = :password" : "") .
           " WHERE id = :id";
    $stmt = $koneksi->prepare($sql);

    $params = [
        ":nama" => $nama,
        ":jenis_kelamin" => $jenis_kelamin,
        ":email" => $email,
        ":id" => $id
    ];

    if ($password) {
        $params[":password"] = $password;
        header('location:index.php');
    }

    $stmt->execute($params);

    '<div class="alert success">User updated successfully!</div>';
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM user WHERE id = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Update User</h1>
        <form method="POST" class="space-y-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <div>
                <label for="nama" class="block text-gray-700 font-medium">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="jenis_kelamin" class="block text-gray-700 font-medium">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="L" <?php if ($user['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki</option>
                    <option value="P" <?php if ($user['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan</option>
                </select>
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-medium">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-medium">Password (leave empty to keep current password):</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700">Update User</button>
            </div>
        </form>
    </div>
</body>
</html>