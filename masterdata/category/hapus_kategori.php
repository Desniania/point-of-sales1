<?php
require_once('koneksi.php');

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM categories1 WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header("Location: list_kategori.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
