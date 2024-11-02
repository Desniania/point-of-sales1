<?php
require_once('koneksi.php');
// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Custom styles */
        .colored-table thead th {
            background-color: #007bff;
            color: #fff;
        }
        .btn-custom {
            background-color: #28a745;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .table-actions a {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="bg-gray-800 text-white">
        <div class="container mx-auto flex justify-between items-center p-5">
            <h1 class="text-3xl font-bold">DASHBOARD ADMIN</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="../masterdata/orders_product/tampilan.php" class="hover:underline">Pemesanan</a></li>
                    <li><a href="../masterdata/product/list_products.php" class="hover:underline">Product</a></li>
                    <li><a href="dashboard.php" class="hover:underline">Dashboard</a></li>
                    <li><a href="../masterdata/category/category.php" class="hover:underline">Category</a></li>
                    <li><a href="../masterdata/customer/list_customers.php" class="hover:underline">Customers</a></li>
                    <li><a href="login.php" class="hover:underline">Admin</a></li>
                    <li><a href="logout.php" class="hover:underline">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- Main Content -->
    <div class="container mt-4">
        <a href="tambah.php" class="btn btn-custom mb-3">+ TAMBAH ADMIN</a>
        <div class="table-responsive">
            <table class="table table-striped table-bordered colored-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Email</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM user";
                    $row = $koneksi->prepare($sql);
                    $row->execute();
                    $hasil = $row->fetchAll();
                    $a = 1;
                    foreach($hasil as $isi) {
                    ?>
                    <tr>
                        <td><?php echo $a ?></td>
                        <td><?php echo htmlspecialchars($isi['nama']) ?></td>
                        <td><?php echo htmlspecialchars($isi['jenis_kelamin']); ?></td>
                        <td><?php echo htmlspecialchars($isi['email']); ?></td>
            
                        <td class="text-center table-actions">
                            <a href="edit.php?id=<?php echo $isi['id'];?>" class="btn btn-success btn-sm">
                                <span class="fa fa-edit"></span>
                            </a>
                            <a onclick="return confirm('Apakah yakin data akan dihapus?')" href="hapus.php?id=<?php echo $isi['id'];?>" class="btn btn-danger btn-sm">
                                <span class="fa fa-trash"></span>
                            </a>
                        </td>
                    </tr>
                    <?php
                    $a++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>