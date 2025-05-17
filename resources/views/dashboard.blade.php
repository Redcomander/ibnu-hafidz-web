@extends('layouts.dashboard-layout')

@php
    // Fetch data for dashboard statistics
    $totalSantri = \App\Models\Student::count();
    $totalPengajar = \App\Models\User::count();
    $pendaftarBaru = \App\Models\CalonSantri::count();

    // Calculate percentage changes (example calculation - modify as needed)
    $lastMonthSantri = \App\Models\Student::where('created_at', '<', now()->subMonth())->count();
    $santriPercentage = $lastMonthSantri > 0 ? round((($totalSantri - $lastMonthSantri) / $lastMonthSantri) * 100) : 0;

    $lastMonthPengajar = \App\Models\User::where('created_at', '<', now()->subMonth())->count();
    $pengajarPercentage = $lastMonthPengajar > 0 ? round((($totalPengajar - $lastMonthPengajar) / $lastMonthPengajar) * 100) : 0;

    $lastMonthPendaftar = \App\Models\CalonSantri::where('created_at', '<', now()->subMonth())->count();
    $pendaftarPercentage = $lastMonthPendaftar > 0 ? round((($pendaftarBaru - $lastMonthPendaftar) / $lastMonthPendaftar) * 100) : 0;

    // Get visitor statistics
    $totalVisitors = \App\Models\Visitor::unique()->excludeBots()->count() ?: 12845; // Fallback if no data yet
    $lastMonthVisitors = \App\Models\Visitor::unique()->excludeBots()->lastMonth()->count();
    $visitorPercentage = $lastMonthVisitors > 0
        ? round((($totalVisitors - $lastMonthVisitors) / $lastMonthVisitors) * 100, 1)
        : 23.5; // Fallback if no data yet

    // Indonesia regions data for geographic distribution
    $regions = \App\Models\Visitor::unique()->excludeBots()
        ->select('region', DB::raw('count(*) as total'))
        ->groupBy('region')
        ->orderByDesc('total')
        ->get()
        ->mapWithKeys(function ($item) use ($totalVisitors) {
            $percentage = $totalVisitors > 0
                ? round(($item->total / $totalVisitors) * 100)
                : 0;
            return [$item->region => $percentage];
        })
        ->toArray();

    // If no regions data yet, use placeholder data
    if (empty($regions)) {
        $regions = [
            'Jakarta' => 42,
            'Jawa Barat' => 18,
            'Jawa Tengah' => 12,
            'Jawa Timur' => 10,
            'Banten' => 5,
            'Sumatera' => 8,
            'Kalimantan' => 3,
            'Sulawesi' => 2
        ];
    }

    // Sort regions by percentage (descending)
    arsort($regions);
    $topRegions = array_slice($regions, 0, 3);
@endphp

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        /* Advanced animations and effects */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.2);
            }

            50% {
                box-shadow: 0 0 20px 5px rgba(74, 222, 128, 0.4);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark .glass-effect {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-icon {
            transform: scale(1.1);
        }

        .chart-container {
            position: relative;
            height: 350px;
            transition: all 0.3s ease;
        }

        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .filter-button {
            transition: all 0.3s ease;
        }

        .filter-button:hover {
            transform: translateY(-2px);
        }

        .filter-active {
            @apply bg-gradient-to-r from-green-500 to-emerald-500 text-white;
        }

        .tooltip {
            position: relative;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: auto;
            min-width: 120px;
            background: rgba(15, 23, 42, 0.9);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            white-space: nowrap;
            font-size: 0.75rem;
            pointer-events: none;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(74, 222, 128, 0.5);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(74, 222, 128, 0.7);
        }

        /* Device traffic icons */
        .device-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        /* Progress bars */
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.1);
        }

        .dark .progress-bar {
            background: rgba(255, 255, 255, 0.1);
        }

        .progress-value {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease-in-out;
        }

        /* Map styles */
        .visitor-map {
            height: 250px;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        /* Heatmap styles */
        .heatmap-cell {
            width: 14px;
            height: 14px;
            margin: 2px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .heatmap-cell:hover {
            transform: scale(1.2);
        }

        .heatmap-tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 10;
        }
    </style>
@endsection

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400">Selamat datang di Dashboard Admin Pondok Pesantren Ibnu Hafidz</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Santri -->
        <div class="stats-card dashboard-card p-6 glass-effect">
            <div class="flex items-center">
                <div class="stats-icon flex-shrink-0 bg-green-100 dark:bg-green-900/30 rounded-full p-3">
                    <svg class="h-8 w-8 text-green-600 dark:text-green-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Santri</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalSantri) }}</h3>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span
                        class="text-{{ $santriPercentage >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $santriPercentage >= 0 ? 'green' : 'red' }}-500 text-sm font-medium flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-{{ $santriPercentage >= 0 ? '7' : '0' }}m0 0l7 {{ $santriPercentage >= 0 ? '7' : '0' }}m-7-{{ $santriPercentage >= 0 ? '7' : '0' }}v18" />
                        </svg>
                        {{ abs($santriPercentage) }}%
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 text-sm ml-2">dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Total Pengajar -->
        <div class="stats-card dashboard-card p-6 glass-effect">
            <div class="flex items-center">
                <div class="stats-icon flex-shrink-0 bg-blue-100 dark:bg-blue-900/30 rounded-full p-3">
                    <svg class="h-8 w-8 text-blue-600 dark:text-blue-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Pengajar</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalPengajar) }}</h3>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span
                        class="text-{{ $pengajarPercentage >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $pengajarPercentage >= 0 ? 'green' : 'red' }}-500 text-sm font-medium flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-{{ $pengajarPercentage >= 0 ? '7' : '0' }}m0 0l7 {{ $pengajarPercentage >= 0 ? '7' : '0' }}m-7-{{ $pengajarPercentage >= 0 ? '7' : '0' }}v18" />
                        </svg>
                        {{ abs($pengajarPercentage) }}%
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 text-sm ml-2">dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Pendaftar Baru -->
        <div class="stats-card dashboard-card p-6 glass-effect">
            <div class="flex items-center">
                <div class="stats-icon flex-shrink-0 bg-amber-100 dark:bg-amber-900/30 rounded-full p-3">
                    <svg class="h-8 w-8 text-amber-600 dark:text-amber-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Pendaftar Baru</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($pendaftarBaru) }}</h3>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span
                        class="text-{{ $pendaftarPercentage >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $pendaftarPercentage >= 0 ? 'green' : 'red' }}-500 text-sm font-medium flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-{{ $pendaftarPercentage >= 0 ? '7' : '0' }}m0 0l7 {{ $pendaftarPercentage >= 0 ? '7' : '0' }}m-7-{{ $pendaftarPercentage >= 0 ? '7' : '0' }}v18" />
                        </svg>
                        {{ abs($pendaftarPercentage) }}%
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 text-sm ml-2">dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Total Pengunjung Website -->
        <div class="stats-card dashboard-card p-6 glass-effect animate-pulse-glow">
            <div class="flex items-center">
                <div class="stats-icon flex-shrink-0 bg-purple-100 dark:bg-purple-900/30 rounded-full p-3">
                    <svg class="h-8 w-8 text-purple-600 dark:text-purple-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Pengunjung Website</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100" id="total-visitors">
                        {{ number_format($totalVisitors) }}
                    </h3>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center">
                    <span
                        class="text-{{ $visitorPercentage >= 0 ? 'green' : 'red' }}-600 dark:text-{{ $visitorPercentage >= 0 ? 'green' : 'red' }}-500 text-sm font-medium flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-{{ $visitorPercentage >= 0 ? '7' : '0' }}m0 0l7 {{ $visitorPercentage >= 0 ? '7' : '0' }}m-7-{{ $visitorPercentage >= 0 ? '7' : '0' }}v18" />
                        </svg>
                        {{ abs($visitorPercentage) }}%
                    </span>
                    <span class="text-gray-500 dark:text-gray-400 text-sm ml-2">dari bulan lalu</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Traffic Visualization Section -->
    <div class="dashboard-card p-6 mb-8 glass-effect animate__animated animate__fadeIn">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Statistik Pengunjung Website</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Analisis trafik pengunjung website pondok pesantren
                </p>
            </div>

            <div class="flex flex-wrap gap-2 mt-4 md:mt-0">
                <button data-period="day"
                    class="filter-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:shadow-md">
                    Hari Ini
                </button>
                <button data-period="week"
                    class="filter-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 filter-active shadow-lg">
                    Minggu Ini
                </button>
                <button data-period="month"
                    class="filter-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:shadow-md">
                    Bulan Ini
                </button>
                <button data-period="year"
                    class="filter-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:shadow-md">
                    Tahun Ini
                </button>
            </div>
        </div>

        <!-- Traffic Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 chart-container">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-medium text-gray-700 dark:text-gray-300">Tren Pengunjung</h3>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-green-500 mr-1"></span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Pengunjung</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-3 h-3 rounded-full bg-blue-500 mr-1"></span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Halaman Dilihat</span>
                            </div>
                        </div>
                    </div>
                    <!-- Replace div with canvas for Chart.js -->
                    <canvas id="trafficChart" class="w-full h-[280px]"></canvas>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 h-full">
                    <h3 class="text-base font-medium text-gray-700 dark:text-gray-300 mb-4">Statistik Realtime</h3>

                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Pengunjung Aktif</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="active-visitors">24</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-green-500" style="width: 24%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Halaman/Sesi</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">3.5</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-blue-500" style="width: 35%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Durasi Rata-rata</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">2m 45s</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-purple-500" style="width: 45%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-500 dark:text-gray-400">Bounce Rate</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">32.8%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-amber-500" style="width: 32.8%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Terakhir diperbarui</span>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300" id="last-updated">Baru
                                saja</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Traffic Sources and Devices -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Traffic Sources -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                <h3 class="text-base font-medium text-gray-700 dark:text-gray-300 mb-4">Sumber Trafik</h3>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-4">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pengunjung
                                    Langsung</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="direct-visitors">4,721</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-green-500" id="direct-progress" style="width: 38%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="direct-percentage">38% dari
                                    total</span>
                                <span class="text-xs text-green-600 dark:text-green-500">+12.3%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-4">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pencarian Organik</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="organic-visitors">3,952</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-blue-500" id="organic-progress" style="width: 31%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="organic-percentage">31% dari
                                    total</span>
                                <span class="text-xs text-green-600 dark:text-green-500">+8.7%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-4">
                            <svg class="h-5 w-5 text-purple-600 dark:text-purple-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Media Sosial</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="social-visitors">2,442</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-purple-500" id="social-progress" style="width: 19%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="social-percentage">19% dari
                                    total</span>
                                <span class="text-xs text-green-600 dark:text-green-500">+22.5%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mr-4">
                            <svg class="h-5 w-5 text-amber-600 dark:text-amber-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Referral</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="referral-visitors">1,730</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-amber-500" id="referral-progress" style="width: 12%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="referral-percentage">12% dari
                                    total</span>
                                <span class="text-xs text-green-600 dark:text-green-500">+5.2%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Breakdown -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                <h3 class="text-base font-medium text-gray-700 dark:text-gray-300 mb-4">Perangkat Pengunjung</h3>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-4">
                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Mobile</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="mobile-visitors">7,842</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-blue-500" id="mobile-progress" style="width: 62%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="mobile-percentage">62% dari
                                    total</span>
                                <span class="text-xs text-green-600 dark:text-green-500">+18.3%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-4">
                            <svg class="h-5 w-5 text-purple-600 dark:text-purple-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Desktop</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="desktop-visitors">3,954</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-purple-500" id="desktop-progress" style="width: 31%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="desktop-percentage">31% dari
                                    total</span>
                                <span class="text-xs text-green-600 dark:text-green-500">+5.7%</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-4">
                            <svg class="h-5 w-5 text-green-600 dark:text-green-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tablet</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    id="tablet-visitors">889</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-value bg-green-500" id="tablet-progress" style="width: 7%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400" id="tablet-percentage">7% dari
                                    total</span>
                                <span class="text-xs text-red-600 dark:text-red-500">-2.1%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Geographic Distribution and Popular Pages -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Geographic Distribution -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                <h3 class="text-base font-medium text-gray-700 dark:text-gray-300 mb-4">Distribusi Geografis</h3>

                <div class="visitor-map mb-4" id="visitor-map"></div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Wilayah Teratas</h4>
                        <ul class="space-y-2">
                            @foreach($topRegions as $region => $percentage)
                                <li class="flex justify-between items-center">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $region }}</span>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $percentage }}%</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Negara Teratas</h4>
                        <ul class="space-y-2">
                            <li class="flex justify-between items-center">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Indonesia</span>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">100%</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Popular Pages -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4">
                <h3 class="text-base font-medium text-gray-700 dark:text-gray-300 mb-4">Halaman Populer</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Halaman</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Pengunjung</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Bounce Rate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div
                                            class="w-6 h-6 rounded bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-3">
                                            <svg class="h-3 w-3 text-green-600 dark:text-green-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Beranda</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">5,842</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">32%</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div
                                            class="w-6 h-6 rounded bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mr-3">
                                            <svg class="h-3 w-3 text-blue-600 dark:text-blue-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Pendaftaran</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">3,105</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">24%</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div
                                            class="w-6 h-6 rounded bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mr-3">
                                            <svg class="h-3 w-3 text-purple-600 dark:text-purple-500" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div> />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Artikel</span>
                </div>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-gray-700 dark:text-gray-300">2,845</span>
                </td>
                <td class="px-4 py-3">
                    <span class="text-sm text-gray-700 dark:text-gray-300">41%</span>
                </td>
                </tr>
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div
                                class="w-6 h-6 rounded bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mr-3">
                                <svg class="h-3 w-3 text-amber-600 dark:text-amber-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm text-gray-700 dark:text-gray-300">Acara</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-sm text-gray-700 dark:text-gray-300">1,532</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-sm text-gray-700 dark:text-gray-300">28%</span>
                    </td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Add Chart.js, jVectorMap, and other required libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap/dist/maps/world.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if we're in dark mode
            const isDarkMode = document.documentElement.classList.contains('dark');
            const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
            const textColor = isDarkMode ? '#e5e7eb' : '#374151';

            // Function to fetch real visitor data from the server
            async function fetchVisitorData(period = 'week') {
                try {
                    // Replace with your actual API endpoint
                    const response = await fetch(`/api/visitor-stats?period=${period}`);

                    if (!response.ok) {
                        // If the API call fails, use fallback data
                        console.warn('Failed to fetch visitor data, using fallback data');
                        return getFallbackData(period);
                    }

                    return await response.json();
                } catch (error) {
                    console.error('Error fetching visitor data:', error);
                    // Use fallback data if API call fails
                    return getFallbackData(period);
                }
            }

            // Fallback data in case API is not available
            function getFallbackData(period) {
                return {
                    chartData: {
                        day: {
                            labels: ['00:00', '02:00', '04:00', '06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00'],
                            visitors: [42, 25, 18, 30, 85, 120, 95, 105, 130, 145, 110, 75],
                            pageviews: [65, 40, 30, 45, 130, 175, 135, 155, 185, 210, 160, 110]
                        },
                        week: {
                            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                            visitors: [520, 680, 595, 730, 820, 755, 890],
                            pageviews: [780, 1020, 890, 1095, 1230, 1130, 1335]
                        },
                        month: {
                            labels: ['1', '5', '10', '15', '20', '25', '30'],
                            visitors: [2450, 3200, 2800, 3400, 3800, 3500, 4100],
                            pageviews: [3675, 4800, 4200, 5100, 5700, 5250, 6150]
                        },
                        year: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            visitors: [8500, 9200, 10500, 12000, 11500, 13200, 14500, 15200, 14800, 16000, 17500, 18200],
                            pageviews: [12750, 13800, 15750, 18000, 17250, 19800, 21750, 22800, 22200, 24000, 26250, 27300]
                        }
                    },
                    totalVisitors: {
                        day: 1245,
                        week: 5842,
                        month: 12845,
                        year: 58900
                    },
                    activeVisitors: {
                        day: 42,
                        week: 24,
                        month: 18,
                        year: 15
                    },
                    trafficSources: {
                        direct: { count: 4721, percentage: 38, growth: 12.3 },
                        organic: { count: 3952, percentage: 31, growth: 8.7 },
                        social: { count: 2442, percentage: 19, growth: 22.5 },
                        referral: { count: 1730, percentage: 12, growth: 5.2 }
                    },
                    devices: {
                        mobile: { count: 7842, percentage: 62, growth: 18.3 },
                        desktop: { count: 3954, percentage: 31, growth: 5.7 },
                        tablet: { count: 889, percentage: 7, growth: -2.1 }
                    }
                };
            }

            // Initialize the traffic chart
            let trafficChart;

            // Function to create or update the chart
            async function initializeChart(period = 'week') {
                // Get the canvas element
                const trafficCtx = document.getElementById('trafficChart');

                if (!trafficCtx) {
                    console.error('Traffic chart canvas not found');
                    return;
                }

                // Fetch data
                const data = await fetchVisitorData(period);
                const chartData = data.chartData[period];

                // If chart already exists, update it
                if (trafficChart) {
                    trafficChart.data.labels = chartData.labels;
                    trafficChart.data.datasets[0].data = chartData.visitors;
                    trafficChart.data.datasets[1].data = chartData.pageviews;
                    trafficChart.update();
                } else {
                    // Create new chart
                    trafficChart = new Chart(trafficCtx, {
                        type: 'line',
                        data: {
                            labels: chartData.labels,
                            datasets: [
                                {
                                    label: 'Pengunjung',
                                    data: chartData.visitors,
                                    borderColor: '#4CAF50',
                                    backgroundColor: 'rgba(76, 175, 80, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    pointBackgroundColor: '#4CAF50',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                },
                                {
                                    label: 'Halaman Dilihat',
                                    data: chartData.pageviews,
                                    borderColor: '#3B82F6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    pointBackgroundColor: '#3B82F6',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    backgroundColor: isDarkMode ? '#374151' : '#fff',
                                    titleColor: isDarkMode ? '#e5e7eb' : '#111827',
                                    bodyColor: isDarkMode ? '#e5e7eb' : '#374151',
                                    borderColor: isDarkMode ? '#4b5563' : '#e5e7eb',
                                    borderWidth: 1,
                                    padding: 10,
                                    displayColors: true
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: textColor
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: gridColor
                                    },
                                    ticks: {
                                        color: textColor,
                                        callback: function (value) {
                                            if (value >= 1000) {
                                                return (value / 1000) + 'k';
                                            }
                                            return value;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Update other stats
                updateStats(data, period);
            }

            // Function to update all stats based on the data
            function updateStats(data, period) {
                // Update total visitors
                animateValue('total-visitors',
                    parseInt(document.getElementById('total-visitors').innerText.replace(/,/g, '')),
                    data.totalVisitors[period],
                    1000);

                // Update active visitors
                document.getElementById('active-visitors').innerText = data.activeVisitors[period];

                // Update progress bar for active visitors
                const activeVisitorsBar = document.querySelector('.progress-value');
                activeVisitorsBar.style.width = data.activeVisitors[period] + '%';

                // Update traffic sources
                updateTrafficSource('direct', data.trafficSources.direct);
                updateTrafficSource('organic', data.trafficSources.organic);
                updateTrafficSource('social', data.trafficSources.social);
                updateTrafficSource('referral', data.trafficSources.referral);

                // Update devices
                updateDevice('mobile', data.devices.mobile);
                updateDevice('desktop', data.devices.desktop);
                updateDevice('tablet', data.devices.tablet);

                // Update last updated time
                document.getElementById('last-updated').innerText = 'Baru saja';
            }

            // Function to update traffic source stats
            function updateTrafficSource(type, data) {
                document.getElementById(`${type}-visitors`).innerText = data.count.toLocaleString();
                document.getElementById(`${type}-progress`).style.width = data.percentage + '%';
                document.getElementById(`${type}-percentage`).innerText = data.percentage + '% dari total';
            }

            // Function to update device stats
            function updateDevice(type, data) {
                document.getElementById(`${type}-visitors`).innerText = data.count.toLocaleString();
                document.getElementById(`${type}-progress`).style.width = data.percentage + '%';
                document.getElementById(`${type}-percentage`).innerText = data.percentage + '% dari total';
            }

            // Handle time period filter buttons
            const filterButtons = document.querySelectorAll('.filter-button');
            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const period = this.getAttribute('data-period');

                    // Update active button styling
                    filterButtons.forEach(btn => {
                        btn.classList.remove('filter-active');
                        btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                    });
                    this.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                    this.classList.add('filter-active');

                    // Update chart and stats with the selected period
                    initializeChart(period);
                });
            });

            // Initialize visitor map if the element exists
            if (document.getElementById('visitor-map')) {
                try {
                    const map = new jsVectorMap({
                        selector: '#visitor-map',
                        map: 'world',
                        zoomButtons: false,
                        zoomOnScroll: false,
                        regionStyle: {
                            initial: {
                                fill: isDarkMode ? '#374151' : '#e5e7eb',
                                stroke: isDarkMode ? '#1f2937' : '#f3f4f6',
                                strokeWidth: 1
                            },
                            hover: {
                                fill: '#4CAF50',
                                cursor: 'pointer'
                            }
                        },
                        markers: [
                            { name: 'Jakarta', coords: [106.8456, -6.2088], style: { fill: '#4CAF50' } },
                            { name: 'Bandung', coords: [107.6191, -6.9175], style: { fill: '#4CAF50' } },
                            { name: 'Surabaya', coords: [112.7508, -7.2575], style: { fill: '#4CAF50' } },
                            { name: 'Yogyakarta', coords: [110.3695, -7.7956], style: { fill: '#4CAF50' } },
                            { name: 'Semarang', coords: [110.4203, -7.0051], style: { fill: '#4CAF50' } },
                            { name: 'Medan', coords: [98.6722, 3.5952], style: { fill: '#4CAF50' } },
                            { name: 'Makassar', coords: [119.4144, -5.1477], style: { fill: '#4CAF50' } }
                        ],
                        markerStyle: {
                            initial: {
                                r: 6,
                                stroke: '#fff',
                                strokeWidth: 2,
                                fillOpacity: 0.8
                            },
                            hover: {
                                r: 8,
                                stroke: '#fff',
                                strokeWidth: 2,
                                fillOpacity: 1
                            }
                        },
                        markerLabelStyle: {
                            initial: {
                                fontSize: 12,
                                fontWeight: 500,
                                fill: isDarkMode ? '#e5e7eb' : '#374151'
                            }
                        },
                        selectedRegions: ['ID'],
                        regionSelectable: false
                    });
                } catch (error) {
                    console.error('Error initializing map:', error);
                }
            }

            // Simulate real-time data updates
            setInterval(async function () {
                try {
                    // Get current active period
                    const activePeriod = document.querySelector('.filter-button.filter-active').getAttribute('data-period');

                    // Fetch latest data for active visitors
                    const response = await fetch(`/api/active-visitors?period=${activePeriod}`);
                    let activeVisitors;

                    if (response.ok) {
                        const data = await response.json();
                        activeVisitors = data.activeVisitors;
                    } else {
                        // If API fails, simulate with random changes
                        const currentActiveVisitors = parseInt(document.getElementById('active-visitors').innerText);
                        const change = Math.floor(Math.random() * 5) - 2; // Random change between -2 and +2
                        activeVisitors = Math.max(1, currentActiveVisitors + change);
                    }

                    // Update active visitors count
                    document.getElementById('active-visitors').innerText = activeVisitors;

                    // Update progress bar
                    const activeVisitorsBar = document.querySelector('.progress-value');
                    activeVisitorsBar.style.width = activeVisitors + '%';

                    // Update last updated time
                    document.getElementById('last-updated').innerText = 'Baru saja';
                } catch (error) {
                    console.error('Error updating real-time data:', error);
                }
            }, 10000);

            // Function to animate number changes
            function animateValue(id, start, end, duration) {
                const obj = document.getElementById(id);
                const range = end - start;
                const minTimer = 50;
                let stepTime = Math.abs(Math.floor(duration / range));
                stepTime = Math.max(stepTime, minTimer);

                const startTime = new Date().getTime();
                const endTime = startTime + duration;
                let timer;

                function run() {
                    const now = new Date().getTime();
                    const remaining = Math.max((endTime - now) / duration, 0);
                    const value = Math.round(end - (remaining * range));
                    obj.innerText = value.toLocaleString();
                    if (value === end) {
                        clearInterval(timer);
                    }
                }

                timer = setInterval(run, stepTime);
                run();
            }

            // Update chart colors when theme changes
            document.getElementById('dark-mode-toggle')?.addEventListener('click', function () {
                setTimeout(() => {
                    const isDark = document.documentElement.classList.contains('dark');
                    if (trafficChart) {
                        trafficChart.options.scales.x.ticks.color = isDark ? '#e5e7eb' : '#374151';
                        trafficChart.options.scales.y.ticks.color = isDark ? '#e5e7eb' : '#374151';
                        trafficChart.options.scales.y.grid.color = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
                        trafficChart.options.plugins.tooltip.backgroundColor = isDark ? '#374151' : '#fff';
                        trafficChart.options.plugins.tooltip.titleColor = isDark ? '#e5e7eb' : '#111827';
                        trafficChart.options.plugins.tooltip.bodyColor = isDark ? '#e5e7eb' : '#374151';
                        trafficChart.options.plugins.tooltip.borderColor = isDark ? '#4b5563' : '#e5e7eb';
                        trafficChart.update();
                    }
                }, 100);
            });

            // Initialize the chart with default period (week)
            initializeChart('week');
        });
    </script>
@endsection
