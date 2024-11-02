<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM user WHERE id = :id";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute([':id' => $id]);

    header('Location: index.php');
    exit;
}
?>
