<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <title>@yield('title', 'Pondok Pesantren Ibnu Hafidz Subang')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        green: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#4CAF50', // Primary green from logo
                            600: '#3e8e41', // Darker green from logo
                            700: '#2e7d32', // Darkest green from logo
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        'arabic': ['Amiri', 'serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Additional custom styles */
        .font-arabic {
            font-family: 'Amiri', serif;
        }

        /* Sticky navigation styles */
        .sticky-nav {
            position: fixed;
            top: -100px;
            /* Start offscreen */
            left: 0;
            right: 0;
            z-index: 1000;
            animation: slideDown 0.5s forwards;
        }

        @keyframes slideDown {
            from {
                top: -100px;
                opacity: 0;
            }

            to {
                top: 0;
                opacity: 1;
            }
        }

        .nav-scrolled {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.3);
            height: 80px !important;
            background: linear-gradient(to right, #2e7d32, #4CAF50);
        }

        .nav-scrolled .logo-container img {
            height: 60px;
            transition: height 0.3s ease;
        }

        .nav-scrolled .nav-link {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .nav-scrolled .admin-btn {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        /* Dropdown styles - MODIFIED to work with click instead of hover */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 180px;
            box-shadow: 0px 8px 20px 0px rgba(0, 0, 0, 0.15);
            z-index: 1;
            border-radius: 0.5rem;
            transform: translateY(15px);
            opacity: 0;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
            overflow: hidden;
        }

        /* Removed hover trigger for dropdown */
        .dropdown-content.show {
            display: block;
            transform: translateY(0);
            opacity: 1;
        }

        /* Mobile menu toggle */
        .mobile-menu-hidden {
            display: none;
        }

        /* NEW FANCY MENU ANIMATIONS */
        .nav-link {
            position: relative;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
            z-index: 1;
        }

        /* Underline animation - desktop only */
        @media (min-width: 768px) {
            .nav-link::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                width: 0;
                height: 3px;
                background: #fff;
                transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
                transform: translateX(-50%);
                border-radius: 3px;
            }

            .nav-link:hover::after,
            .nav-link.active::after {
                width: 70%;
            }

            /* Glow effect - desktop only */
            .nav-link:hover {
                text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
                transform: translateY(-2px);
            }
        }

        /* Active tab styling */
        .nav-link.active {
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        /* Admin button hover effect */
        .admin-btn {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .admin-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: linear-gradient(to bottom, rgba(76, 175, 80, 0.1), transparent);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: -1;
        }

        .admin-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }

        .admin-btn:hover::before {
            height: 100%;
        }

        /* Mobile dropdown animation - IMPROVED */
        .mobile-dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .mobile-dropdown-content.open {
            max-height: 200px;
        }

        /* Mobile-specific menu animations */
        @media (max-width: 767px) {
            .nav-link {
                position: relative;
                transition: all 0.3s ease;
                border-left: 0px solid transparent;
            }

            .nav-link:active,
            .nav-link.active {
                background-color: rgba(255, 255, 255, 0.1);
                border-left: 4px solid #fff;
                padding-left: calc(0.75rem + 4px);
            }

            /* Ripple effect for mobile */
            .nav-link-ripple {
                position: absolute;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }

            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        }

        /* Dropdown item animations */
        .dropdown-item {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            padding-left: 1rem;
            border-left: 0px solid #4CAF50;
        }

        .dropdown-item:hover {
            padding-left: 1.5rem;
            background-color: #f0fdf4;
            border-left: 4px solid #4CAF50;
        }

        /* Footer Styles */
        .footer-link {
            transition: all 0.3s ease;
            position: relative;
        }

        .footer-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #4CAF50;
            transition: width 0.3s ease;
        }

        .footer-link:hover {
            color: #4CAF50;
        }

        .footer-link:hover::after {
            width: 100%;
        }

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-5px);
            color: #4CAF50;
        }

        .footer-wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
        }

        .footer-wave svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 70px;
        }

        .footer-wave .shape-fill {
            fill: #F9FAFB;
        }

        /* Mobile menu button animation - IMPROVED */
        .hamburger-icon {
            width: 24px;
            height: 24px;
            position: relative;
            transition: all 0.3s;
            z-index: 1001;
        }

        .hamburger-icon span {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: white;
            border-radius: 3px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: all 0.3s ease;
        }

        .hamburger-icon span:nth-child(1) {
            top: 4px;
        }

        .hamburger-icon span:nth-child(2) {
            top: 11px;
        }

        .hamburger-icon span:nth-child(3) {
            top: 18px;
        }

        .hamburger-icon.open span:nth-child(1) {
            top: 11px;
            transform: rotate(135deg);
        }

        .hamburger-icon.open span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }

        .hamburger-icon.open span:nth-child(3) {
            top: 11px;
            transform: rotate(-135deg);
        }

        /* Add padding to body when nav is fixed */
        body {
            padding-top: 0;
            transition: padding-top 0.4s ease;
        }

        body.nav-fixed {
            padding-top: 96px;
            /* Height of the navbar */
        }

        /* Progress indicator for scroll */
        .scroll-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(to right, #ffeb3b, #ffc107);
            width: 0%;
            transition: width 0.3s ease;
            z-index: 1001;
        }

        /* Menu item scale animation on scroll */
        .nav-scrolled .nav-link {
            transform: scale(0.95);
        }

        .nav-scrolled .nav-link:hover {
            transform: scale(1) translateY(-2px);
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navigation Bar -->
    <nav id="main-nav" class="bg-gradient-to-r from-green-600 to-green-700 shadow-lg">
        <div class="scroll-progress" id="scroll-progress"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-24"> <!-- Increased height for larger logo -->
                <div class="flex items-center">
                    <!-- Logo - Increased size -->
                    <div class="flex-shrink-0 flex items-center logo-container">
                        <a href="{{ url('/') }}" class="flex items-center">
                            <img class="h-20 w-auto transition-all duration-300"
                                src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo-pptih-662OWSNOMb9jbuUOZiu21o6hUJjgH4.png"
                                alt="Pondok Pesantren Ibnu Hafidz">
                        </a>
                    </div>
                </div>

                <!-- Desktop Navigation Menu -->
                <div class="hidden md:flex md:items-center md:space-x-6"> <!-- Increased spacing -->
                    <a href="{{ url('/') }}"
                        class="nav-link {{ request()->is('/') ? 'active' : '' }} text-white hover:text-white px-4 py-3 rounded-md text-sm font-medium transition duration-500">Beranda</a>

                    <a href="{{ url('/profil') }}"
                        class="nav-link {{ request()->is('profil*') ? 'active' : '' }} text-white hover:text-white px-4 py-3 rounded-md text-sm font-medium transition duration-500">Profil</a>

                    <a href="{{ url('/prestasi') }}"
                        class="nav-link {{ request()->is('prestasi*') ? 'active' : '' }} text-white hover:text-white px-4 py-3 rounded-md text-sm font-medium transition duration-500">Prestasi</a>

                    <!-- Gallery Dropdown - MODIFIED to use click instead of hover -->
                    <div class="dropdown relative">
                        <button id="desktop-gallery-button"
                            class="nav-link {{ request()->is('gallery*') ? 'active' : '' }} text-white hover:text-white px-4 py-3 rounded-md text-sm font-medium transition duration-500 inline-flex items-center">
                            Gallery
                            <svg class="ml-1 w-4 h-4 transition-transform duration-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="desktop-gallery-content" class="dropdown-content mt-2 w-48">
                            <a href="{{ url('/gallery/photo') }}"
                                class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:text-green-800 transition duration-300">Foto</a>
                            <a href="{{ url('/gallery/video') }}"
                                class="dropdown-item block px-4 py-3 text-sm text-gray-700 hover:text-green-800 transition duration-300">Video</a>
                        </div>
                    </div>

                    <a href="{{ url('/pendaftaran') }}"
                        class="nav-link {{ request()->is('pendaftaran*') ? 'active' : '' }} text-white hover:text-white px-4 py-3 rounded-md text-sm font-medium transition duration-500">Pendaftaran</a>

                    <a href="{{ url('/login') }}"
                        class="admin-btn ml-4 inline-flex items-center px-5 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-green-700 bg-white hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Admin Login
                    </a>
                </div>

                <!-- Mobile menu button - IMPROVED -->
                <div class="flex md:hidden items-center">
                    <button id="mobile-menu-button" aria-label="Toggle mobile menu"
                        class="p-2 rounded-md text-white hover:text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition duration-500">
                        <div class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu - IMPROVED -->
        <div id="mobile-menu"
            class="md:hidden mobile-menu-hidden fixed inset-0 bg-green-700 bg-opacity-95 z-50 pt-24 overflow-y-auto">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ url('/') }}"
                    class="nav-link {{ request()->is('/') ? 'active' : '' }} text-white block px-3 py-3 rounded-md text-base font-medium transition duration-500">Beranda</a>
                <a href="{{ url('/profil') }}"
                    class="nav-link {{ request()->is('profil*') ? 'active' : '' }} text-white block px-3 py-3 rounded-md text-base font-medium transition duration-500">Profil</a>
                <a href="{{ url('/prestasi') }}"
                    class="nav-link {{ request()->is('prestasi*') ? 'active' : '' }} text-white block px-3 py-3 rounded-md text-base font-medium transition duration-500">Prestasi</a>

                <!-- Mobile Gallery Dropdown - IMPROVED -->
                <div class="mobile-dropdown">
                    <button id="mobile-gallery-button"
                        class="nav-link {{ request()->is('gallery*') ? 'active' : '' }} text-white w-full text-left flex justify-between items-center px-3 py-3 rounded-md text-base font-medium transition duration-500">
                        <span>Gallery</span>
                        <svg id="mobile-gallery-icon" class="w-4 h-4 transition-transform duration-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="mobile-gallery-content" class="mobile-dropdown-content pl-4">
                        <a href="{{ url('/gallery/photo') }}"
                            class="dropdown-item text-white block px-3 py-3 rounded-md text-base font-medium transition duration-300 hover:bg-green-700">Foto</a>
                        <a href="{{ url('/gallery/video') }}"
                            class="dropdown-item text-white block px-3 py-3 rounded-md text-base font-medium transition duration-300 hover:bg-green-700">Video</a>
                    </div>
                </div>

                <a href="{{ url('/pendaftaran') }}"
                    class="nav-link {{ request()->is('pendaftaran*') ? 'active' : '' }} text-white block px-3 py-3 rounded-md text-base font-medium transition duration-500">Pendaftaran</a>
                <a href="{{ url('/login') }}"
                    class="admin-btn flex items-center text-white px-3 py-3 rounded-md text-base font-medium transition duration-500 bg-green-700 hover:bg-green-800 mt-2">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Admin Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white relative">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Logo and About -->
                <div class="md:col-span-1">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo-pptih-662OWSNOMb9jbuUOZiu21o6hUJjgH4.png"
                        alt="Pondok Pesantren Ibnu Hafidz" class="h-16 w-auto mb-4">
                    <p class="text-gray-300 text-sm mt-4">
                        Membentuk generasi Qur'ani yang berakhlak mulia, berwawasan luas, dan siap menghadapi tantangan
                        global.
                    </p>
                    <!-- Social Media Icons -->
                    <div class="flex space-x-4 mt-6">
                        <a href="https://www.facebook.com/ponpesibnuhafidz/"
                            class="social-icon text-gray-300 hover:text-green-500">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/ponpesibnuhafidz/"
                            class="social-icon text-gray-300 hover:text-green-500">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="https://www.youtube.com/@ibnuhafidztv7314"
                            class="social-icon text-gray-300 hover:text-green-500">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="md:col-span-1">
                    <h3 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="footer-link text-gray-300 hover:text-green-500">Beranda</a>
                        </li>
                        <li><a href="{{ url('/profil') }}"
                                class="footer-link text-gray-300 hover:text-green-500">Profil</a></li>
                        <li><a href="{{ url('/prestasi') }}"
                                class="footer-link text-gray-300 hover:text-green-500">Prestasi</a></li>
                        <li><a href="{{ url('/gallery/photo') }}"
                                class="footer-link text-gray-300 hover:text-green-500">Galeri Foto</a></li>
                        <li><a href="{{ url('/gallery/video') }}"
                                class="footer-link text-gray-300 hover:text-green-500">Galeri Video</a></li>
                        <li><a href="{{ url('/pendaftaran') }}"
                                class="footer-link text-gray-300 hover:text-green-500">Pendaftaran</a></li>
                    </ul>
                </div>

                <!-- Programs -->
                <div class="md:col-span-1">

                    <ul class="space-y-2">

                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="md:col-span-1">
                    <h3 class="text-lg font-bold mb-4 border-b border-gray-700 pb-2">Hubungi Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-green-500"></i>
                            <span class="text-gray-300">Sukamulya, RT.25/RW.06, Rancadaka, Kec. Pusakanagara, Kabupaten
                                Subang, Jawa Barat 41255</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-green-500"></i>
                            <span class="text-gray-300">+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-green-500"></i>
                            <span class="text-gray-300">info@ibnuhafidz.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock mt-1 mr-3 text-green-500"></i>
                            <span class="text-gray-300">Senin - Jumat: 08:00 - 16:00</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-700 my-8"></div>

            <!-- Copyright -->
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Pondok Pesantren Ibnu Hafidz. Hak Cipta Dilindungi.
                </p>
                <div class="mt-4 md:mt-0">

                </div>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get elements
            const nav = document.getElementById('main-nav');
            const body = document.body;
            const scrollProgress = document.getElementById('scroll-progress');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.querySelector('.hamburger-icon');
            const mobileGalleryButton = document.getElementById('mobile-gallery-button');
            const mobileGalleryContent = document.getElementById('mobile-gallery-content');
            const mobileGalleryIcon = document.getElementById('mobile-gallery-icon');
            const desktopGalleryButton = document.getElementById('desktop-gallery-button');
            const desktopGalleryContent = document.getElementById('desktop-gallery-content');

            // Function to handle scroll
            function handleScroll() {
                // Calculate scroll percentage for progress bar
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrollPercentage = (scrollTop / scrollHeight) * 100;

                // Update progress bar width
                scrollProgress.style.width = scrollPercentage + '%';

                // Add sticky nav when scrolled past threshold
                if (scrollTop > 50) {
                    if (!nav.classList.contains('sticky-nav')) {
                        nav.classList.add('sticky-nav');
                        setTimeout(() => {
                            nav.classList.add('nav-scrolled');
                            body.classList.add('nav-fixed');
                        }, 10); // Small delay for animation sequence
                    }
                } else {
                    nav.classList.remove('sticky-nav', 'nav-scrolled');
                    body.classList.remove('nav-fixed');
                }
            }

            // Add scroll event listener
            window.addEventListener('scroll', handleScroll);

            // Initial call to set correct state on page load
            handleScroll();

            // IMPROVED Mobile menu toggle with animation
            mobileMenuButton.addEventListener('click', function (e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('mobile-menu-hidden');
                hamburgerIcon.classList.toggle('open');

                // Prevent body scrolling when menu is open
                if (!mobileMenu.classList.contains('mobile-menu-hidden')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';

                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!mobileMenu.classList.contains('mobile-menu-hidden') &&
                    !mobileMenu.contains(e.target) &&
                    !mobileMenuButton.contains(e.target)) {
                    mobileMenu.classList.add('mobile-menu-hidden');
                    hamburgerIcon.classList.remove('open');
                    document.body.style.overflow = '';
                }
            });

            // Prevent clicks inside mobile menu from closing it
            mobileMenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            // IMPROVED Mobile gallery dropdown toggle with animation
            mobileGalleryButton.addEventListener('click', function (e) {
                e.stopPropagation();
                mobileGalleryContent.classList.toggle('open');
                mobileGalleryIcon.classList.toggle('rotate-180');
            });

            // DESKTOP GALLERY DROPDOWN - Click instead of hover
            desktopGalleryButton.addEventListener('click', function (e) {
                e.stopPropagation();
                desktopGalleryContent.classList.toggle('show');
            });

            // Close desktop dropdown when clicking outside
            document.addEventListener('click', function () {
                desktopGalleryContent.classList.remove('show');
            });

            // Prevent clicks inside dropdown from closing it
            desktopGalleryContent.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            // Add entrance animation for nav items on page load
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach((link, index) => {
                link.style.opacity = '0';
                link.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    link.style.transition = 'all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
                    link.style.opacity = '1';
                    link.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });

            // Add ripple effect to mobile nav links
            const mobileNavLinks = document.querySelectorAll('.mobile-dropdown .nav-link, #mobile-menu .nav-link:not(.mobile-dropdown .nav-link)');

            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    const rect = link.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const ripple = document.createElement('span');
                    ripple.classList.add('nav-link-ripple');
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';

                    link.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });
    </script>
</body>

</html>
