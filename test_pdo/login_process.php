<?php
session_start();

// Hardcoded credentials for demonstration
$valid_username = 'eyyo';
$valid_password = '123456';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['logged_in'] = true;
        header('Location: index.php');
        exit();
    } else {
        echo '<p class="text-red-500 text-center">Invalid credentials. Please try again.</p>';
    }
}
?>
