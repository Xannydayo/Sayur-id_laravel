<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sayur.id - Fresh & Organic Groceries</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Sayur.id, Organic, Vegetables, Fruits, Groceries, Online Store" name="keywords">
    <meta content="Sayur.id offers fresh and organic vegetables and fruits delivered to your doorstep." name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tailwind CSS (assuming it's compiled via Laravel Mix/Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom Scrollbar Styles -->
    <style>
        /* For Webkit browsers (Chrome, Safari) */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #22c55e;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #16a34a;
        }

        /* For Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #22c55e #f1f1f1;
        }
    </style>

</head>

<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">
    <!-- Navbar start -->
    <nav class="bg-white dark:bg-gray-800 shadow-md fixed w-full z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <h1 class="text-green-600 text-3xl font-extrabold">Sayur.id</h1>
            </a>
            <div class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 text-lg font-medium">Home</a>
                <a href="{{ route('product') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 text-lg font-medium">Produk</a>
                <a href="{{ route('contact') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 text-lg font-medium">Kontak Kami</a>

                @auth
                    <a href="{{ route('orders.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 text-lg font-medium">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                    </a>
                    <div class="relative group">
                        <button class="flex items-center text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 text-lg font-medium focus:outline-none">
                            @if (Auth::user()->profile_photo_path)
                                <img class="h-6 w-6 rounded-full object-cover mr-2" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" />
                            @else
                                <svg class="h-6 w-6 text-gray-300 dark:text-gray-700 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.993C0 17.514 4.032 14 9 14h6c4.968 0 9 3.514 9 6.993zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6z" />
                                </svg>
                            @endif
                            {{ Auth::user()->name }}
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="absolute right-0 top-full w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg pt-1 pb-1 hidden group-hover:block pointer-events-auto z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="border-l border-gray-300 dark:border-gray-600 h-6 mx-2"></div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 hover:text-green-600 dark:hover:text-green-400 text-lg font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-md text-base font-medium transition duration-300">Register</a>
                    </div>
                @endauth
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-200 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-800 py-2">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
            <a href="{{ route('product') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Produk</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Kontak Kami</a>
            @auth
                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Keranjang</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Register</a>
            @endauth
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content Area -->
    <main class="pt-20"> <!-- Adjust pt-x based on navbar height -->
        @yield('content')
    </main>

    <!-- Footer Start -->
    <footer class="bg-gray-800 text-gray-300 py-10 mt-10">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-white text-xl font-bold mb-4">Sayur.id</h3>
                <p class="text-sm">Fresh & Organic Groceries delivered to your doorstep.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="https://www.instagram.com/yogaviveka/?hl=en" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/yogaviveka/?hl=en" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/yogaviveka/?hl=en" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.instagram.com/yogaviveka/?hl=en" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div>
                <h3 class="text-white text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li><a href="{{ route('product') }}" class="hover:text-white">Produk</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Kontak Kami</a></li>
                    @auth
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white">Pesanan Saya</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-white">Profil</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h3 class="text-white text-xl font-bold mb-4">Contact Us</h3>
                <p class="text-sm mb-2"><i class="fa fa-map-marker-alt mr-2"></i> Jalan Ulujami, Kec. Ulujami, Jakarta</p>
                <p class="text-sm mb-2"><i class="fa fa-phone-alt mr-2"></i> +62 882 2575 3457</p>
                <p class="text-sm mb-2"><i class="fa fa-envelope mr-2"></i> farid@gmail.com</p>
            </div>
            <div>
                <h3 class="text-white text-xl font-bold mb-4">Yuk, Dapatkan Kabar Terbaru Setiap Minggu</h3>
                <p class="text-sm mb-4">Jangan lewatkan kabar terbaru, daftarkan email kamu sekarang</p>
                <form class="flex">
                    <input type="email" placeholder="Your Email" class="px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-primary-500 flex-grow dark:bg-gray-700 dark:text-gray-100">
                    <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-r-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">Berlangganan</button>
                </form>
            </div>
        </div>
        <div class="text-center text-gray-500 text-sm mt-8 pt-8 border-t border-gray-700">
            &copy; <a class="text-primary-500 hover:underline" href="#">Sayur.id</a>, All Right Reserved.
        </div>
    </footer>
    <!-- Footer End -->

    <!-- Back to Top -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-primary-600 text-white p-3 rounded-full shadow-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 hidden">
        <i class="fa fa-arrow-up"></i>
    </button>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

    @stack('scripts')
</body>

</html>