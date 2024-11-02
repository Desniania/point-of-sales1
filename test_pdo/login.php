<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    
    <title>Admin Login</title>
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(to right, #667eea, #764ba2);
        }

        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .input-field {
            position: relative;
        }

        .input-field input {
            padding-right: 2.5rem;
        }

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 0.75rem;
            cursor: pointer;
            color: #6b7280;
        }

        .toggle-password:hover {
            color: #111827;
        }

        .submit-btn {
            background: linear-gradient(to right, #667eea, #764ba2);
            transition: background 0.3s ease-in-out;
        }

        .submit-btn:hover {
            background: linear-gradient(to right, #764ba2, #667eea);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="login-container">
        <h2 class="text-2xl font-bold text-center mb-6">Admin Login</h2>
        <form action="login_process.php" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400" required>
            </div>
            <div class="mb-6 input-field">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M9 12h.01M12 12h.01M9.172 9.172a4 4 0 115.656 0L12 15l-2.828-2.828zM12 20l4-4a4 4 0 00-5.656-5.656L12 9m0 11v-4"/>
                    </svg>
                </span>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md submit-btn transition-colors">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const passwordToggle = document.querySelector(".toggle-password svg");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                passwordToggle.setAttribute("fill", "#667eea");
            } else {
                passwordField.type = "password";
                passwordToggle.setAttribute("fill", "none");
            }
        }
    </script>

</body>
</html>
