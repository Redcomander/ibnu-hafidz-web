<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Pondok Pesantren Ibnu Hafidz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
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
    <style>
        /* Dashboard specific styles */
        body {
            background-color: #f9fafb;
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease;
        }

        .dark body {
            background-color: #111827;
        }

        /* Sidebar styles - IMPROVED FOR DESKTOP SCROLLING */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 50;
            overflow: hidden;
            /* Important: prevent sidebar itself from scrolling */
        }

        .dark .sidebar {
            background-color: #1f2937;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        .sidebar-collapsed {
            width: 5rem;
        }

        .sidebar-expanded {
            width: 16rem;
        }

        /* Logo and header area - fixed at top */
        .sidebar-header {
            flex-shrink: 0;
            /* Prevent shrinking */
            padding-bottom: 0.5rem;
            /* Add some padding at the bottom */
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .dark .sidebar-header {
            border-bottom: 1px solid rgba(75, 85, 99, 0.5);
        }

        /* Create a scrollable container for the navigation */
        .sidebar-content {
            flex: 1;
            /* Take remaining space */
            overflow-y: auto;
            /* Enable vertical scrolling */
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Ensure it takes full height */
            padding-bottom: 160px;
            /* FURTHER INCREASED padding to ensure all items aren't covered by footer */
        }

        /* Add margin to the navigation list */
        .sidebar-content nav ul {
            margin-bottom: 5px;
            /* Add space after the last item */
        }

        /* Ensure the footer stays at the bottom */
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: inherit;
            padding: 1rem;
            border-top: 1px solid rgba(229, 231, 235, 0.5);
            z-index: 10;
        }

        .dark .sidebar-footer {
            border-top: 1px solid rgba(75, 85, 99, 0.5);
        }

        /* Improve scrollbar styles for the sidebar content */
        .sidebar-content::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .dark .sidebar-content::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        .dark .sidebar-content::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Sidebar menu item styles */
        .sidebar-menu-item {
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0.75rem;
        }

        .sidebar-menu-item:hover {
            background-color: rgba(76, 175, 80, 0.1);
            transform: translateX(5px);
        }

        .dark .sidebar-menu-item {
            color: #e5e7eb;
        }

        .dark .sidebar-menu-item:hover {
            background-color: rgba(76, 175, 80, 0.2);
        }

        .sidebar-menu-item.active {
            background-color: #4CAF50;
            color: white;
        }

        .sidebar-menu-item.active:hover {
            background-color: #3e8e41;
            transform: translateX(5px);
        }

        /* Icon styles */
        .sidebar-icon {
            transition: all 0.3s ease;
        }

        .sidebar-menu-item:hover .sidebar-icon {
            transform: scale(1.1);
        }

        /* Content area styles */
        .content-area {
            transition: all 0.3s ease;
        }

        /* User dropdown styles */
        .user-dropdown {
            transition: all 0.3s ease;
        }

        .user-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: white;
            min-width: 12rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 0.5rem;
            z-index: 50;
            overflow: hidden;
            transform: translateY(10px);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .dark .user-dropdown-content {
            background-color: #1f2937;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        .user-dropdown-content.show {
            display: block;
            transform: translateY(0);
            opacity: 1;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
            padding-left: 1.5rem;
        }

        .dark .dropdown-item {
            color: #e5e7eb;
        }

        .dark .dropdown-item:hover {
            background-color: #374151;
        }

        /* Card styles */
        .dashboard-card {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .dark .dashboard-card {
            background-color: #1f2937;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .dark .dashboard-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        /* Tooltip styles */
        .tooltip {
            position: relative;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: auto;
            background-color: #1f2937;
            color: white;
            text-align: center;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            position: absolute;
            z-index: 100;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 0.5rem;
            opacity: 0;
            transition: opacity 0.3s;
            white-space: nowrap;
        }

        .dark .tooltip .tooltip-text {
            background-color: #4b5563;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Scrollbar styles */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Floating Dark Mode Toggle */
        .floating-dark-mode-toggle {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 50%;
            background-color: white;
            color: #4CAF50;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                background-color 0.3s ease,
                box-shadow 0.3s ease;
            overflow: hidden;
        }

        .floating-dark-mode-toggle:hover {
            transform: scale(1.1) rotate(8deg);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .floating-dark-mode-toggle:active {
            transform: scale(0.95);
        }

        .dark .floating-dark-mode-toggle {
            background-color: #1f2937;
            color: #f3f4f6;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .floating-dark-mode-toggle .sun-icon,
        .floating-dark-mode-toggle .moon-icon {
            position: absolute;
            font-size: 1.5rem;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                opacity 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .floating-dark-mode-toggle .sun-icon {
            opacity: 1;
            transform: rotate(0deg);
            color: #f59e0b;
        }

        .dark .floating-dark-mode-toggle .sun-icon {
            opacity: 0;
            transform: rotate(90deg);
        }

        .floating-dark-mode-toggle .moon-icon {
            opacity: 0;
            transform: rotate(-90deg);
            color: #f3f4f6;
        }

        .dark .floating-dark-mode-toggle .moon-icon {
            opacity: 1;
            transform: rotate(0deg);
        }

        @media (max-width: 640px) {
            .floating-dark-mode-toggle {
                bottom: 1.5rem;
                right: 1.5rem;
                width: 3rem;
                height: 3rem;
            }
        }

        /* Mobile sidebar toggle */
        .sidebar-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background-color: #f3f4f6;
            color: #4b5563;
            transition: all 0.3s ease;
        }

        .dark .sidebar-toggle-btn {
            background-color: #374151;
            color: #e5e7eb;
        }

        .sidebar-toggle-btn:hover {
            background-color: #e5e7eb;
            color: #4CAF50;
        }

        .dark .sidebar-toggle-btn:hover {
            background-color: #4b5563;
            color: #4CAF50;
        }

        /* Mobile sidebar styles */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem;
            background-color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 100;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .dark .mobile-sidebar {
            background-color: #1f2937;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
        }

        .mobile-sidebar.show {
            transform: translateX(0);
        }

        .mobile-sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .mobile-sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* Logout button styles */
        .logout-button {
            display: flex;
            align-items: center;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            color: #ef4444;
        }

        .logout-button:hover {
            background-color: #f3f4f6;
            padding-left: 1.5rem;
        }

        .dark .logout-button {
            color: #f87171;
        }

        .dark .logout-button:hover {
            background-color: #374151;
        }

        .logout-button i {
            margin-right: 0.75rem;
            color: #9ca3af;
        }

        .dark .logout-button i {
            color: #6b7280;
        }
    </style>
    @yield('head')
</head>

<body class="min-h-screen flex flex-col dark:text-gray-100">
    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-sidebar-overlay" class="mobile-sidebar-overlay md:hidden"></div>

    <!-- Mobile Sidebar -->
    <aside id="mobile-sidebar" class="mobile-sidebar md:hidden">
        <!-- Logo -->
        <div class="flex justify-center py-6">
            <a href="{{ url('/dashboard') }}" class="flex items-center">
                <img class="h-12 w-auto transition-all duration-300 dark:hidden" src="{{ asset('favicon.png') }}"
                    alt="Pondok Pesantren Ibnu Hafidz">
                <img class="h-12 w-auto transition-all duration-300 hidden dark:block"
                    src="{{ asset('logo_putih.png') }}" alt="Pondok Pesantren Ibnu Hafidz">
            </a>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-100 dark:border-gray-700 my-2"></div>

        <!-- Navigation Menu -->
        <nav class="mt-4 px-2">
            <ul class="space-y-1">
                <!-- Dashboard -->
                <li>
                    <a href="{{ url('/dashboard') }}"
                        class="sidebar-menu-item {{ request()->is('dashboard') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-tachometer-alt text-lg"></i>
                        </span>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>

                <!-- Santri -->
                <li>
                    <a href="{{ url('/admin/student') }}"
                        class="sidebar-menu-item {{ request()->is('admin/student*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-user-graduate text-lg"></i>
                        </span>
                        <span class="sidebar-text">Santri</span>
                    </a>
                </li>

                <!-- Pengajar -->
                <li>
                    <a href="{{ url('/teachers') }}"
                        class="sidebar-menu-item {{ request()->is('teachers*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-chalkboard-teacher text-lg"></i>
                        </span>
                        <span class="sidebar-text">Pengajar</span>
                    </a>
                </li>

                <!-- Kelas -->
                <li>
                    <a href="{{ url('/dashboard/kelas') }}"
                        class="sidebar-menu-item {{ request()->is('dashboard/kelas*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-school text-lg"></i>
                        </span>
                        <span class="sidebar-text">Kelas</span>
                    </a>
                </li>

                <!-- Hafalan -->
                <li>
                    <a href="{{ url('/dashboard/hafalan') }}"
                        class="sidebar-menu-item {{ request()->is('dashboard/hafalan*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-book-open text-lg"></i>
                        </span>
                        <span class="sidebar-text">Hafalan</span>
                    </a>
                </li>

                <!-- Pembayaran -->
                <li>
                    <a href="{{ url('/dashboard/pembayaran') }}"
                        class="sidebar-menu-item {{ request()->is('dashboard/pembayaran*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-money-bill-wave text-lg"></i>
                        </span>
                        <span class="sidebar-text">Pembayaran</span>
                    </a>
                </li>

                <!-- Berita -->
                <li>
                    <a href="{{ url('/articles') }}"
                        class="sidebar-menu-item {{ request()->is('articles*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-newspaper text-lg"></i>
                        </span>
                        <span class="sidebar-text">Berita</span>
                    </a>
                </li>

                <!-- Galeri -->
                <li>
                    <a href="{{ url('/dashboard/galeri') }}"
                        class="sidebar-menu-item {{ request()->is('dashboard/galeri*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-images text-lg"></i>
                        </span>
                        <span class="sidebar-text">Galeri</span>
                    </a>
                </li>

                <!-- Pendaftaran Admin -->
                <li>
                    <a href="{{ url('/admin/pendaftaran') }}"
                        class="sidebar-menu-item {{ request()->is('admin/pendaftaran*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-user-graduate text-lg"></i>
                        </span>
                        <span class="sidebar-text">Calon Santri</span>
                    </a>
                </li>

                <!-- Profile -->
                <li>
                    <a href="{{ url('/profile') }}"
                        class="sidebar-menu-item {{ request()->is('profile*') ? 'active' : '' }} flex items-center p-3">
                        <span class="sidebar-icon mr-3">
                            <i class="fas fa-user text-lg"></i>
                        </span>
                        <span class="sidebar-text">Profil</span>
                    </a>
                </li>

                <!-- Logout -->
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-menu-item flex items-center p-3 w-full text-left">
                            <span class="sidebar-icon mr-3">
                                <i class="fas fa-sign-out-alt text-lg text-red-500"></i>
                            </span>
                            <span class="sidebar-text text-red-500">Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="flex min-h-screen">
        <!-- Desktop Sidebar - Improved structure for scrolling -->
        <aside id="sidebar" class="sidebar sidebar-expanded bg-white dark:bg-gray-800 rounded-r-2xl hidden md:block">

            <!-- Logo - Fixed at top -->
            <div class="sidebar-header">
                <div class="flex justify-center py-6">
                    <a href="{{ url('/dashboard') }}" class="flex items-center">
                        <img class="h-12 w-auto transition-all duration-300 dark:hidden"
                            src="{{ asset('favicon.png') }}" alt="Pondok Pesantren Ibnu Hafidz">
                        <img class="h-12 w-auto transition-all duration-300 hidden dark:block"
                            src="{{ asset('logo_putih.png') }}" alt="Pondok Pesantren Ibnu Hafidz">
                    </a>
                </div>
            </div>

            <!-- Scrollable Content Area - IMPROVED -->
            <div class="sidebar-content">
                <!-- Navigation Menu -->
                <nav class="mt-4 px-2">
                    <ul class="space-y-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ url('/dashboard') }}"
                                class="sidebar-menu-item {{ request()->is('dashboard') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-tachometer-alt text-lg"></i>
                                </span>
                                <span class="sidebar-text">Dashboard</span>
                            </a>
                        </li>

                        <!-- Santri -->
                        <li>
                            <a href="{{ url('/admin/student') }}"
                                class="sidebar-menu-item {{ request()->is('admin/student*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-user-graduate text-lg"></i>
                                </span>
                                <span class="sidebar-text">Santri</span>
                            </a>
                        </li>

                        <!-- Pengajar -->
                        <li>
                            <a href="{{ url('/teachers') }}"
                                class="sidebar-menu-item {{ request()->is('teachers*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-chalkboard-teacher text-lg"></i>
                                </span>
                                <span class="sidebar-text">Pengajar</span>
                            </a>
                        </li>

                        <!-- Kelas -->
                        <li>
                            <a href="{{ url('/dashboard/kelas') }}"
                                class="sidebar-menu-item {{ request()->is('dashboard/kelas*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-school text-lg"></i>
                                </span>
                                <span class="sidebar-text">Kelas</span>
                            </a>
                        </li>

                        <!-- Hafalan -->
                        <li>
                            <a href="{{ url('/dashboard/hafalan') }}"
                                class="sidebar-menu-item {{ request()->is('dashboard/hafalan*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-book-open text-lg"></i>
                                </span>
                                <span class="sidebar-text">Hafalan</span>
                            </a>
                        </li>

                        <!-- Pembayaran -->
                        <li>
                            <a href="{{ url('/dashboard/pembayaran') }}"
                                class="sidebar-menu-item {{ request()->is('dashboard/pembayaran*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-money-bill-wave text-lg"></i>
                                </span>
                                <span class="sidebar-text">Pembayaran</span>
                            </a>
                        </li>

                        <!-- Berita -->
                        <li>
                            <a href="{{ url('/articles') }}"
                                class="sidebar-menu-item {{ request()->is('articles*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-newspaper text-lg"></i>
                                </span>
                                <span class="sidebar-text">Berita</span>
                            </a>
                        </li>

                        <!-- Galeri -->
                        <li>
                            <a href="{{ url('/dashboard/galeri') }}"
                                class="sidebar-menu-item {{ request()->is('dashboard/galeri*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-images text-lg"></i>
                                </span>
                                <span class="sidebar-text">Galeri</span>
                            </a>
                        </li>

                        <!-- Pendaftaran Admin -->
                        <li>
                            <a href="{{ url('/admin/pendaftaran') }}"
                                class="sidebar-menu-item {{ request()->is('admin/pendaftaran*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-user-graduate text-lg"></i>
                                </span>
                                <span class="sidebar-text">Calon Santri</span>
                            </a>
                        </li>

                        <!-- User Profile -->
                        <li>
                            <a href="{{ url('/profile') }}"
                                class="sidebar-menu-item {{ request()->is('profile*') ? 'active' : '' }} flex items-center p-3">
                                <span class="sidebar-icon mr-3">
                                    <i class="fas fa-user text-lg"></i>
                                </span>
                                <span class="sidebar-text">Profile</span>
                            </a>
                        </li>

                        <!-- Logout for sidebar -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="sidebar-menu-item flex items-center p-3 w-full text-left">
                                    <span class="sidebar-icon mr-3">
                                        <i class="fas fa-sign-out-alt text-lg text-red-500"></i>
                                    </span>
                                    <span class="sidebar-text text-red-500">Keluar</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Sidebar Footer - Fixed at bottom -->
            <div class="sidebar-footer">
                <button id="sidebar-toggle"
                    class="w-full flex items-center justify-center p-2 text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-500 transition-all duration-300">
                    <i id="sidebar-toggle-icon" class="fas fa-chevron-left text-lg"></i>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <div id="content-area" class="content-area flex-1 md:ml-64">
            <!-- Top Navigation Bar -->
            <header class="bg-white dark:bg-gray-800 shadow-sm">
                <div class="max-w-full mx-auto px-4">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left side: Sidebar Toggle only -->
                        <div class="flex items-center">
                            <!-- Sidebar Toggle Button (Mobile) -->
                            <button id="mobile-sidebar-toggle" class="sidebar-toggle-btn md:hidden">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>

                        <!-- Center: Logo (Mobile only) -->
                        <div class="flex justify-center md:hidden">
                            <a href="{{ url('/dashboard') }}" class="flex items-center">
                                <img class="h-8 w-auto transition-all duration-300 dark:hidden"
                                    src="{{ asset('favicon.png') }}" alt="Pondok Pesantren Ibnu Hafidz">
                                <img class="h-8 w-auto transition-all duration-300 hidden dark:block"
                                    src="{{ asset('logo_putih.png') }}" alt="Pondok Pesantren Ibnu Hafidz">
                            </a>
                        </div>

                        <!-- Right side: User Profile -->
                        <div class="relative user-dropdown">
                            <button id="user-menu-button" class="flex items-center space-x-3 focus:outline-none">
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ asset('storage/' . Auth::user()->foto_guru) ?? '/placeholder.svg?height=32&width=32' }}"
                                    alt="{{ Auth::user()->name ?? 'User Profile' }}">
                                <div class="hidden md:block text-left">
                                    <span
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name ?? 'Admin Pesantren' }}</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email
                                        ?? 'admin@ibnuhafidz.com' }}</span>
                                </div>
                                <i
                                    class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400 hidden md:block"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-dropdown-menu" class="user-dropdown-content">
                                <a href="{{ url('/profile') }}"
                                    class="dropdown-item flex items-center text-gray-700 dark:text-gray-200 hover:text-green-600 dark:hover:text-green-500">
                                    <i class="fas fa-user mr-3 text-gray-400 dark:text-gray-500"></i>
                                    <span>Profile</span>
                                </a>
                                <a href="{{ url('/dashboard/pengaturan') }}"
                                    class="dropdown-item flex items-center text-gray-700 dark:text-gray-200 hover:text-green-600 dark:hover:text-green-500">
                                    <i class="fas fa-cog mr-3 text-gray-400 dark:text-gray-500"></i>
                                    <span>Pengaturan</span>
                                </a>
                                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="logout-button">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="py-6 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Floating Dark Mode Toggle -->
    <button id="dark-mode-toggle" class="floating-dark-mode-toggle" aria-label="Toggle Dark Mode">
        <i class="fas fa-lightbulb sun-icon"></i>
        <i class="fas fa-moon moon-icon"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dark mode toggle functionality
            const html = document.documentElement;
            const darkModeToggle = document.getElementById('dark-mode-toggle');

            // Check for saved theme preference or use system preference
            if (localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                html.classList.add('dark');
            } else {
                html.classList.remove('dark');
            }

            // Toggle dark mode
            darkModeToggle.addEventListener('click', function () {
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            });

            // Sidebar toggle functionality (Desktop)
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarToggleIcon = document.getElementById('sidebar-toggle-icon');
            const contentArea = document.getElementById('content-area');
            const sidebarText = document.querySelectorAll('.sidebar-text');

            sidebarToggle.addEventListener('click', function () {
                if (sidebar.classList.contains('sidebar-expanded')) {
                    // Collapse sidebar
                    sidebar.classList.remove('sidebar-expanded');
                    sidebar.classList.add('sidebar-collapsed');
                    contentArea.classList.remove('md:ml-64');
                    contentArea.classList.add('md:ml-20');
                    sidebarToggleIcon.classList.remove('fa-chevron-left');
                    sidebarToggleIcon.classList.add('fa-chevron-right');

                    // Hide text
                    sidebarText.forEach(text => {
                        text.classList.add('hidden');
                    });
                } else {
                    // Expand sidebar
                    sidebar.classList.remove('sidebar-collapsed');
                    sidebar.classList.add('sidebar-expanded');
                    contentArea.classList.remove('md:ml-20');
                    contentArea.classList.add('md:ml-64');
                    sidebarToggleIcon.classList.remove('fa-chevron-right');
                    sidebarToggleIcon.classList.add('fa-chevron-left');

                    // Show text
                    sidebarText.forEach(text => {
                        text.classList.remove('hidden');
                    });
                }
            });

            // Mobile sidebar toggle
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
            const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');

            mobileSidebarToggle.addEventListener('click', function () {
                mobileSidebar.classList.toggle('show');
                mobileSidebarOverlay.classList.toggle('show');
                document.body.classList.toggle('overflow-hidden');
            });

            mobileSidebarOverlay.addEventListener('click', function () {
                mobileSidebar.classList.remove('show');
                mobileSidebarOverlay.classList.remove('show');
                document.body.classList.remove('overflow-hidden');
            });

            // User dropdown functionality
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');

            userMenuButton.addEventListener('click', function () {
                userDropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!userMenuButton.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.classList.remove('show');
                }
            });

            // Add tooltips to collapsed sidebar items
            function updateTooltips() {
                const menuItems = document.querySelectorAll('.sidebar-menu-item');

                if (sidebar.classList.contains('sidebar-collapsed')) {
                    menuItems.forEach(item => {
                        if (!item.classList.contains('tooltip')) {
                            item.classList.add('tooltip');

                            const text = item.querySelector('.sidebar-text').textContent;
                            const tooltip = document.createElement('span');
                            tooltip.classList.add('tooltip-text');
                            tooltip.textContent = text;

                            item.appendChild(tooltip);
                        }
                    });
                } else {
                    menuItems.forEach(item => {
                        item.classList.remove('tooltip');
                        const tooltip = item.querySelector('.tooltip-text');
                        if (tooltip) {
                            item.removeChild(tooltip);
                        }
                    });
                }
            }

            // Dynamic adjustment of sidebar content padding based on footer height
            function adjustSidebarContentPadding() {
                const sidebarFooter = document.querySelector('.sidebar-footer');
                const sidebarContent = document.querySelector('.sidebar-content');

                if (sidebarFooter && sidebarContent) {
                    const footerHeight = sidebarFooter.offsetHeight;
                    // Add extra padding (80px) to ensure all items are visible
                    sidebarContent.style.paddingBottom = (footerHeight + 110) + 'px';
                }
            }

            // Call this function on load and on window resize
            window.addEventListener('load', adjustSidebarContentPadding);
            window.addEventListener('resize', adjustSidebarContentPadding);

            // Initial call to set tooltips
            updateTooltips();

            // Update tooltips when sidebar state changes
            sidebarToggle.addEventListener('click', updateTooltips);
        });
    </script>
    @yield('scripts')
</body>

</html>
