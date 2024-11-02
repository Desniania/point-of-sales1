<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurant Food</title>
    <meta name="description" content="Welcome to Restaurant Name. Enjoy delicious food and a great atmosphere.">
    <meta name="keywords" content="restaurant, food, dining, cuisine">

    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .hero {
            background-image: url('gambar/7makan.jpg'); /* Replace with your hero image URL */
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="font-sans leading-normal tracking-normal">

    <!-- Header -->
    <header class="bg-gray-800 text-white">
        <div class="container mx-auto flex justify-between items-center p-5">
            <h1 class="text-3xl font-bold">Restaurant food</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li><a href="pesan.php" class="hover:underline">Pemesanan</a></li>
                    <li><a href="masterdata/transaksi.php" class="hover:underline">proses</a></li>
                    <li><a href="test_pdo/login.php" class="hover:underline">Dashboard</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero h-96 flex items-center justify-center text-center text-white">
        <div class="bg-black bg-opacity-50 p-8 rounded">
            <h2 class="text-4xl font-bold mb-4">Welcome to Restaurant food</h2>
            <p class="text-lg mb-6">Experience the best dining with exquisite dishes and an unforgettable atmosphere.</p>
            <a href="#menu" class="bg-yellow-500 text-gray-800 px-6 py-3 rounded font-semibold hover:bg-yellow-600">View Menu</a>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Our Menu</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Menu Item 1 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/2makan.jpg" alt="Grilled Salmon" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Cireng</h3>
                    <p class="text-gray-700 mb-4">cireng yang berbumbu seblak yang dapat memanjakan lidah anda.</p>
                    <span class="font-bold text-lg">RP.15.000</span>
                </div>
                <!-- Menu Item 2 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/3makan.jpg" alt="Sate Madura" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Sate Madura</h3>
                    <p class="text-gray-700 mb-4">Sate madura  yang berisikan sambel kacang yang memanjakan lidah.</p>
                    <span class="font-bold text-lg">Rp 22.000</span>
                </div>
                <!-- Menu Item 3 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/4makan.jpg" alt="Pecel" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Pecel</h3>
                    <p class="text-gray-700 mb-4">Pecel makanan daerah yang sangat lezat dan di kenal di berbagai kalangan.</p>
                    <span class="font-bold text-lg">Rp 20.000</span>
                </div>
                <!-- Menu Item 4 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/5makan.jpg" alt="Kepiting Lava" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Kepiting Lava</h3>
                    <p class="text-gray-700 mb-4">Kepiting lava adalah makanan yang menggunakan saus lava ke kepiting untuk menambahkan cita rasa.</p>
                    <span class="font-bold text-lg">Rp.70.000</span>
                </div>
                <!-- Menu Item 5 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/6makan.jpg" alt="Spaghetti" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">spaghetti</h3>
                    <p class="text-gray-700 mb-4">Spaghetti adalah makanan spesial yang kami buat untuk pelanggan kami</p>
                    <span class="font-bold text-lg">Rp.18.000</span>
                </div>
                <!-- Menu Item 6 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/9makan.jpeg" alt="Margherita Pizza" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Margherita Pizza</h3>
                    <p class="text-gray-700 mb-4">Classic pizza with fresh tomatoes, mozzarella cheese, and basil leaves.</p>
                    <span class="font-bold text-lg">$16.99</span>
                </div>
                <!-- Menu Item 7 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/9makan.jpg" alt="Spaghetti Bolognese" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Spaghetti Bolognese</h3>
                    <p class="text-gray-700 mb-4">Spaghetti topped with a rich and savory meat sauce.</p>
                    <span class="font-bold text-lg">$17.99</span>
                </div>
                <!-- Menu Item 8 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/10makan.jpg" alt="Chicken Alfredo" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Chicken Alfredo</h3>
                    <p class="text-gray-700 mb-4">Tender chicken breast in a creamy Alfredo sauce with fettuccine pasta.</p>
                    <span class="font-bold text-lg">$19.49</span>
                </div>
                <!-- Menu Item 9 -->
                <div class="bg-white p-6 rounded shadow-md">
                    <img src="gambar/11makanjpg.jpg" alt="Greek Salad" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-xl font-semibold mb-4">Greek Salad</h3>
                    <p class="text-gray-700 mb-4">A fresh mix of cucumbers, tomatoes, olives, feta cheese, and red onions with a Greek dressing.</p>
                    <span class="font-bold text-lg">$11.99</span>
                </div>
               
    </section>

    <!-- About Section -->
    <section id="about" class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Tentang Restaurant Food</h2>
            <p class="text-lg text-center">Restaurant food adalah restaurant yang menyediakan makanana untuk para pelanggan dan memuaskan perut pelanggan dengan menu yang memuaskan.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class

