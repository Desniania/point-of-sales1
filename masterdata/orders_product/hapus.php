<?php
require_once('koneksi.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM orders_makan WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: list_pesan.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat menghapus pesanan.";
    }
}
?>
