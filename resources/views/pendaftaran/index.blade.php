@extends('layouts.dashboard-layout')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        /* Improve responsiveness */
        @media (max-width: 640px) {
            .dashboard-header {
                padding: 1rem;
            }

            .stats-card {
                padding: 0.75rem;
            }

            .table-container {
                margin: 0 -1rem;
                width: calc(100% + 2rem);
                border-radius: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div
        class="py-4 min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
            <!-- Redesigned Dashboard Header -->
            <div class="mb-6 animate__animated animate__fadeIn dashboard-header">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                    <div>
                        <h2
                            class="text-2xl md:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300 tracking-tight">
                            Pendaftaran Santri
                        </h2>
                        <p class="mt-1 text-sm md:text-base text-gray-600 dark:text-gray-300">
                            Kelola dan verifikasi pendaftaran calon santri baru
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                        <form action="{{ route('pendaftaran.index') }}" method="GET"
                            class="flex flex-col sm:flex-row gap-2 w-full">
                            <div class="relative flex-grow">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari pendaftar..."
                                    class="w-full pl-9 pr-3 py-2 text-sm border-2 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-gray-400 dark:text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>

                            <select name="status" onchange="this.form.submit()"
                                class="text-sm border-2 border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-all duration-200 appearance-none pr-8 relative">
                                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>
                                    Semua Status</option>
                                <option value="formulir" {{ request('status') == 'formulir' ? 'selected' : '' }}>Formulir
                                </option>
                                <option value="checking" {{ request('status') == 'checking' ? 'selected' : '' }}>Checking Data
                                </option>
                                <option value="pembayaran" {{ request('status') == 'pembayaran' ? 'selected' : '' }}>
                                    Pembayaran</option>
                                <option value="berhasil" {{ request('status') == 'berhasil' ? 'selected' : '' }}>Berhasil
                                </option>
                            </select>

                            <select name="payment_type" onchange="this.form.submit()"
                                class="text-sm border-2 border-gray-200 dark:border-gray-700 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition-all duration-200 appearance-none pr-8 relative">
                                <option value="all" {{ request('payment_type') == 'all' || !request('payment_type') ? 'selected' : '' }}>Semua Pembayaran</option>
                                <option value="Lunas" {{ request('payment_type') == 'Lunas' ? 'selected' : '' }}>Lunas
                                </option>
                                <option value="Cicilan" {{ request('payment_type') == 'Cicilan' ? 'selected' : '' }}>Cicilan
                                </option>
                            </select>
                        </form>

                        <a href="{{ route('pendaftaran.create') }}"
                            class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-3 py-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-center gap-1.5 whitespace-nowrap text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span class="font-medium">Tambah</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-200 p-3 mb-4 rounded-lg shadow-sm animate__animated animate__fadeInDown"
                    role="alert">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500 dark:text-green-400"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-3 mb-4 rounded-lg shadow-sm animate__animated animate__fadeInDown"
                    role="alert">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-red-500 dark:text-red-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                <!-- Total Pendaftar Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md stats-card">
                    <div class="relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                        <div class="p-3 sm:p-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-2 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium">Total</h3>
                                    <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $calonsantri->total() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulir Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md stats-card">
                    <div class="relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-amber-500"></div>
                        <div class="p-3 sm:p-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-yellow-500 to-amber-500 p-2 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium">Formulir</h3>
                                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                                        {{ App\Models\CalonSantri::where('status', 'formulir')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md stats-card">
                    <div class="relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-indigo-500"></div>
                        <div class="p-3 sm:p-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-purple-500 to-indigo-500 p-2 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium">Pembayaran</h3>
                                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                                        {{ App\Models\CalonSantri::where('status', 'pembayaran')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Berhasil Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md stats-card">
                    <div class="relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
                        <div class="p-3 sm:p-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-emerald-500 to-teal-500 p-2 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium">Berhasil</h3>
                                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                                        {{ App\Models\CalonSantri::where('status', 'berhasil')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Type Stats Cards -->
            <div class="grid grid-cols-2 gap-3 mb-4">
                <!-- Lunas Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md stats-card">
                    <div class="relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
                        <div class="p-3 sm:p-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-green-500 to-green-600 p-2 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium">Pembayaran Lunas</h3>
                                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                                        {{ App\Models\CalonSantri::where('payment_type', 'Lunas')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cicilan Card -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 transition-all duration-300 hover:shadow-md stats-card">
                    <div class="relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-orange-600"></div>
                        <div class="p-3 sm:p-4">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-2 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-gray-500 dark:text-gray-400 text-xs font-medium">Pembayaran Cicilan</h3>
                                    <p class="text-xl font-bold text-gray-800 dark:text-white">
                                        {{ App\Models\CalonSantri::where('payment_type', 'Cicilan')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Registration Progress Chart with Functional Filters -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 mb-4">
                <div
                    class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white">Statistik Pendaftaran</h3>
                    <div class="flex flex-wrap gap-1.5">
                        <button id="chartFilterWeek"
                            class="px-2.5 py-1 text-xs font-medium rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">Minggu</button>
                        <button id="chartFilterMonth"
                            class="px-2.5 py-1 text-xs font-medium rounded-lg bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors duration-200">Bulan</button>
                        <button id="chartFilterYear"
                            class="px-2.5 py-1 text-xs font-medium rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">Tahun</button>
                    </div>
                </div>
                <div class="p-4">
                    <div id="registrationChart" class="w-full h-56 sm:h-64"></div>
                </div>
            </div>

            <!-- Applicants Table with Functional Filters -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700 table-container">
                <div
                    class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-emerald-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Daftar Calon Santri
                    </h3>
                    <div class="flex items-center gap-2">
                        <select id="tableFilter"
                            class="text-xs border border-gray-200 dark:border-gray-700 rounded-lg px-2.5 py-1 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="all">Semua Data</option>
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="az">A-Z</option>
                            <option value="za">Z-A</option>
                        </select>
                    </div>
                </div>

                @if(count($calonsantri) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        No. Pendaftaran</th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Nama</th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">
                                        Info Pribadi</th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">
                                        Orang Tua</th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">
                                        Kontak</th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Pembayaran</th>
                                    <th scope="col"
                                        class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($calonsantri as $calon)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $calon->nomor_pendaftaran }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                                    {{ substr($calon->nama, 0, 1) }}
                                                </div>
                                                <div class="ml-2.5">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $calon->nama }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 sm:hidden">
                                                        {{ $calon->no_whatsapp }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 hidden sm:table-cell">
                                            <div class="text-xs text-gray-900 dark:text-white flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-blue-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($calon->tanggal_lahir)->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-purple-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $calon->jenis_kelamin }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 hidden md:table-cell">
                                            <div class="text-xs text-gray-900 dark:text-white flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-blue-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $calon->nama_ayah }}
                                            </div>
                                            <div class="text-xs text-gray-900 dark:text-white flex items-center mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-pink-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                {{ $calon->nama_ibu }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-xs text-gray-900 dark:text-white flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-green-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $calon->no_whatsapp }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($calon->status == 'formulir')
                                                <span
                                                    class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-800/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Formulir
                                                </span>
                                            @elseif($calon->status == 'checking')
                                                <span
                                                    class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-200 border border-purple-200 dark:border-purple-800/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                    </svg>
                                                    Checking Data
                                                </span>
                                            @elseif($calon->status == 'pembayaran')
                                                <span
                                                    class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                    Pembayaran
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Berhasil
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($calon->payment_type == 'Lunas')
                                                <span
                                                    class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4" />
                                                    </svg>
                                                    Lunas
                                                </span>
                                            @elseif($calon->payment_type == 'Cicilan')
                                                <span
                                                    class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-200 border border-orange-200 dark:border-orange-800/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Cicilan
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full bg-gray-100 dark:bg-gray-900/50 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-800/50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    Belum Ada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right text-xs font-medium">
                                            <div class="flex justify-end space-x-1">
                                                <a href="{{ route('pendaftaran.show', $calon->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 p-1 rounded-md transition-colors duration-200"
                                                    title="Detail">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                @if($calon->status == 'formulir')
                                                    <form action="{{ route('pendaftaran.checking') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="calon_santri_id" value="{{ $calon->id }}">
                                                        <input type="hidden" name="admin_action" value="1">
                                                        <button type="submit"
                                                            class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 bg-purple-100 dark:bg-purple-900/30 hover:bg-purple-200 dark:hover:bg-purple-900/50 p-1 rounded-md transition-colors duration-200"
                                                            title="Checking Data">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($calon->status == 'checking')
                                                    <form action="{{ route('pendaftaran.pembayaran') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="calon_santri_id" value="{{ $calon->id }}">
                                                        <input type="hidden" name="payment_type" value="Lunas">
                                                        <input type="hidden" name="admin_action" value="1">
                                                        <button type="submit"
                                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 p-1 rounded-md transition-colors duration-200"
                                                            title="Pembayaran">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($calon->payment_proof)
                                                    <a href="{{ route('pendaftaran.viewPaymentProof', $calon->id) }}"
                                                        class="text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300 bg-amber-100 dark:bg-amber-900/30 hover:bg-amber-200 dark:hover:bg-amber-900/50 p-1 rounded-md transition-colors duration-200"
                                                        title="Lihat Bukti Pembayaran">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </a>
                                                @endif

                                                <form action="{{ route('pendaftaran.destroy', $calon->id) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 p-1 rounded-md transition-colors duration-200"
                                                        title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 flex justify-between sm:hidden">
                                @if($calonsantri->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 cursor-not-allowed">
                                        Sebelumnya
                                    </span>
                                @else
                                    <a href="{{ $calonsantri->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        Sebelumnya
                                    </a>
                                @endif

                                @if($calonsantri->hasMorePages())
                                    <a href="{{ $calonsantri->nextPageUrl() }}"
                                        class="ml-3 relative inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        Selanjutnya
                                    </a>
                                @else
                                    <span
                                        class="ml-3 relative inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 cursor-not-allowed">
                                        Selanjutnya
                                    </span>
                                @endif
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-xs text-gray-700 dark:text-gray-300">
                                        Menampilkan <span class="font-medium">{{ $calonsantri->firstItem() ?? 0 }}</span> sampai
                                        <span class="font-medium">{{ $calonsantri->lastItem() ?? 0 }}</span> dari <span
                                            class="font-medium">{{ $calonsantri->total() }}</span> hasil
                                    </p>
                                </div>
                                <div>
                                    {{ $calonsantri->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10 dark:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400 dark:text-gray-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Tidak ada data pendaftar</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada calon santri yang mendaftar.</p>
                        <div class="mt-5">
                            <a href="{{ route('pendaftaran.create') }}"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 dark:focus:ring-offset-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-1.5 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Pendaftar
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to get actual registration data based on time filter
            function getRegistrationData(timeFilter) {
                // Get actual data from the database
                // For this example, we'll create data based on the controller's logic

                // Get current date for calculations
                const now = new Date();

                // Weekly data - last 7 days
                const weekData = {
                    labels: ['7 hari', '6 hari', '5 hari', '4 hari', '3 hari', '2 hari', 'Hari ini'],
                    formulir: [
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereDate('created_at', now()->subDays(6))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereDate('created_at', now()->subDays(5))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereDate('created_at', now()->subDays(4))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereDate('created_at', now()->subDays(3))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereDate('created_at', now()->subDays(2))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereDate('created_at', now()->subDays(1))->count() }},
                        {{ App\Models\CalonSantri::where('status', 'formulir')->whereDate('created_at', now())->count() }}
                    ],
                    checking: [
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereDate('created_at', now()->subDays(6))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereDate('created_at', now()->subDays(5))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereDate('created_at', now()->subDays(4))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereDate('created_at', now()->subDays(3))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereDate('created_at', now()->subDays(2))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereDate('created_at', now()->subDays(1))->count() }},
                        {{ App\Models\CalonSantri::where('status', 'checking')->whereDate('created_at', now())->count() }}
                    ],
                    pembayaran: [
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereDate('created_at', now()->subDays(6))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereDate('created_at', now()->subDays(5))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereDate('created_at', now()->subDays(4))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereDate('created_at', now()->subDays(3))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereDate('created_at', now()->subDays(2))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereDate('created_at', now()->subDays(1))->count() }},
                        {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereDate('created_at', now())->count() }}
                    ],
                    berhasil: [
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereDate('created_at', now()->subDays(6))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereDate('created_at', now()->subDays(5))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereDate('created_at', now()->subDays(4))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereDate('created_at', now()->subDays(3))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereDate('created_at', now()->subDays(2))->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereDate('created_at', now()->subDays(1))->count() }},
                        {{ App\Models\CalonSantri::where('status', 'berhasil')->whereDate('created_at', now())->count() }}
                    ]
                };

                // Monthly data - current month by week
                const monthData = {
                    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu ini'],
                    formulir: [
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereBetween('created_at', [now()->startOfMonth(), now()->startOfMonth()->addDays(6)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereBetween('created_at', [now()->startOfMonth()->addDays(7), now()->startOfMonth()->addDays(13)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereBetween('created_at', [now()->startOfMonth()->addDays(14), now()->startOfMonth()->addDays(20)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereBetween('created_at', [now()->startOfMonth()->addDays(21), now()->startOfMonth()->addDays(27)])->count() }},
                        {{ App\Models\CalonSantri::where('status', 'formulir')->whereBetween('created_at', [now()->startOfMonth()->addDays(28), now()->endOfMonth()])->count() }}
                    ],
                    checking: [
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereBetween('created_at', [now()->startOfMonth(), now()->startOfMonth()->addDays(6)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereBetween('created_at', [now()->startOfMonth()->addDays(7), now()->startOfMonth()->addDays(13)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereBetween('created_at', [now()->startOfMonth()->addDays(14), now()->startOfMonth()->addDays(20)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereBetween('created_at', [now()->startOfMonth()->addDays(21), now()->startOfMonth()->addDays(27)])->count() }},
                        {{ App\Models\CalonSantri::where('status', 'checking')->whereBetween('created_at', [now()->startOfMonth()->addDays(28), now()->endOfMonth()])->count() }}
                    ],
                    pembayaran: [
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereBetween('created_at', [now()->startOfMonth(), now()->startOfMonth()->addDays(6)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereBetween('created_at', [now()->startOfMonth()->addDays(7), now()->startOfMonth()->addDays(13)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereBetween('created_at', [now()->startOfMonth()->addDays(14), now()->startOfMonth()->addDays(20)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereBetween('created_at', [now()->startOfMonth()->addDays(21), now()->startOfMonth()->addDays(27)])->count() }},
                        {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereBetween('created_at', [now()->startOfMonth()->addDays(28), now()->endOfMonth()])->count() }}
                    ],
                    berhasil: [
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereBetween('created_at', [now()->startOfMonth(), now()->startOfMonth()->addDays(6)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereBetween('created_at', [now()->startOfMonth()->addDays(7), now()->startOfMonth()->addDays(13)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereBetween('created_at', [now()->startOfMonth()->addDays(14), now()->startOfMonth()->addDays(20)])->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereBetween('created_at', [now()->startOfMonth()->addDays(21), now()->startOfMonth()->addDays(27)])->count() }},
                        {{ App\Models\CalonSantri::where('status', 'berhasil')->whereBetween('created_at', [now()->startOfMonth()->addDays(28), now()->endOfMonth()])->count() }}
                    ]
                };

                // Yearly data - by month
                const yearData = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    formulir: [
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '01')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '02')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '03')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '04')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '05')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '06')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '07')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '08')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '09')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '10')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '11')->whereYear('created_at', now()->year)->count() }},
                        {{ App\Models\CalonSantri::where('status', 'formulir')->whereMonth('created_at', '12')->whereYear('created_at', now()->year)->count() }}
                    ],
                    checking: [
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '01')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '02')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '03')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '04')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '05')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '06')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '07')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '08')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '09')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '10')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '11')->whereYear('created_at', now()->year)->count() }},
                        {{ App\Models\CalonSantri::where('status', 'checking')->whereMonth('created_at', '12')->whereYear('created_at', now()->year)->count() }}
                    ],
                    pembayaran: [
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '01')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '02')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '03')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '04')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '05')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '06')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '07')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '08')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '09')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '10')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '11')->whereYear('created_at', now()->year)->count() }},
                        {{ App\Models\CalonSantri::where('status', 'pembayaran')->whereMonth('created_at', '12')->whereYear('created_at', now()->year)->count() }}
                    ],
                    berhasil: [
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '01')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '02')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '03')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '04')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '05')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '06')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '07')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '08')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '09')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '10')->whereYear('created_at', now()->year)->count() }},
                    {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '11')->whereYear('created_at', now()->year)->count() }},
                        {{ App\Models\CalonSantri::where('status', 'berhasil')->whereMonth('created_at', '12')->whereYear('created_at', now()->year)->count() }}
                    ]
                };

                switch (timeFilter) {
                    case 'week':
                        return weekData;
                    case 'month':
                        return monthData;
                    case 'year':
                        return yearData;
                    default:
                        return monthData; // Default to month view
                }
            }

            // Initialize chart with month data by default
            let currentData = getRegistrationData('month');

            // Chart configuration
            const options = {
                chart: {
                    type: 'area',
                    height: 256,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    },
                    background: 'transparent'
                },
                colors: ['#f59e0b', '#8b5cf6', '#3b82f6', '#10b981'],
                series: [
                    {
                        name: 'Formulir',
                        data: currentData.formulir
                    },
                    {
                        name: 'Checking Data',
                        data: currentData.checking
                    },
                    {
                        name: 'Pembayaran',
                        data: currentData.pembayaran
                    },
                    {
                        name: 'Berhasil',
                        data: currentData.berhasil
                    }
                ],
                xaxis: {
                    categories: currentData.labels,
                    labels: {
                        style: {
                            colors: document.querySelector('html').classList.contains('dark') ? '#9ca3af' : '#6b7280',
                            fontSize: '10px',
                            fontWeight: 500
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: document.querySelector('html').classList.contains('dark') ? '#9ca3af' : '#6b7280',
                            fontSize: '10px',
                            fontWeight: 500
                        },
                        formatter: function (value) {
                            return Math.round(value);
                        }
                    }
                },
                grid: {
                    show: true,
                    borderColor: document.querySelector('html').classList.contains('dark') ? '#374151' : '#e5e7eb',
                    strokeDashArray: 4,
                    position: 'back'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '10px',
                    labels: {
                        colors: document.querySelector('html').classList.contains('dark') ? '#d1d5db' : '#4b5563'
                    },
                    itemMargin: {
                        horizontal: 8
                    }
                },
                tooltip: {
                    theme: document.querySelector('html').classList.contains('dark') ? 'dark' : 'light',
                    y: {
                        formatter: function (value) {
                            return value + ' pendaftar';
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                responsive: [{
                    breakpoint: 640,
                    options: {
                        chart: {
                            height: 200
                        },
                        legend: {
                            position: 'bottom',
                            horizontalAlign: 'center',
                            itemMargin: {
                                horizontal: 6,
                                vertical: 1
                            }
                        }
                    }
                }]
            };

            // Initialize chart
            const chart = new ApexCharts(document.getElementById('registrationChart'), options);
            chart.render();

            // Chart filter functionality
            document.getElementById('chartFilterWeek').addEventListener('click', function () {
                updateChartFilter('week', this);
            });

            document.getElementById('chartFilterMonth').addEventListener('click', function () {
                updateChartFilter('month', this);
            });

            document.getElementById('chartFilterYear').addEventListener('click', function () {
                updateChartFilter('year', this);
            });

            function updateChartFilter(timeFilter, buttonElement) {
                // Update active button styling
                document.querySelectorAll('#chartFilterWeek, #chartFilterMonth, #chartFilterYear').forEach(btn => {
                    btn.classList.remove('bg-emerald-100', 'dark:bg-emerald-900/30', 'text-emerald-700', 'dark:text-emerald-300');
                    btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                });

                buttonElement.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
                buttonElement.classList.add('bg-emerald-100', 'dark:bg-emerald-900/30', 'text-emerald-700', 'dark:text-emerald-300');

                // Update chart data
                const newData = getRegistrationData(timeFilter);
                chart.updateOptions({
                    xaxis: {
                        categories: newData.labels
                    }
                });

                chart.updateSeries([
                    {
                        name: 'Formulir',
                        data: newData.formulir
                    },
                    {
                        name: 'Checking Data',
                        data: newData.checking
                    },
                    {
                        name: 'Pembayaran',
                        data: newData.pembayaran
                    },
                    {
                        name: 'Berhasil',
                        data: newData.berhasil
                    }
                ]);
            }

            // Table filter functionality
            document.getElementById('tableFilter').addEventListener('change', function () {
                const filterValue = this.value;

                // In a real implementation, you would reload the data or sort it
                // For this demo, we'll just show a message that it would work
                console.log('Table filter changed to: ' + filterValue);

                // You would typically implement this with AJAX or form submission
                // window.location.href = '{{ route("pendaftaran.index") }}?sort=' + filterValue;

                // For demo purposes, let's add a visual indicator that the filter was applied
                const tableHeader = document.querySelector('.bg-gray-50.dark\\:bg-gray-900');
                tableHeader.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    tableHeader.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            });

            // Handle dark mode toggle for chart
            const darkModeObserver = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.attributeName === 'class') {
                        const isDarkMode = document.querySelector('html').classList.contains('dark');
                        chart.updateOptions({
                            grid: {
                                borderColor: isDarkMode ? '#374151' : '#e5e7eb'
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        colors: isDarkMode ? '#9ca3af' : '#6b7280'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        colors: isDarkMode ? '#9ca3af' : '#6b7280'
                                    }
                                }
                            },
                            tooltip: {
                                theme: isDarkMode ? 'dark' : 'light'
                            },
                            legend: {
                                labels: {
                                    colors: isDarkMode ? '#d1d5db' : '#4b5563'
                                }
                            }
                        });
                    }
                });
            });

            darkModeObserver.observe(document.querySelector('html'), {
                attributes: true
            });
        });
    </script>
@endsection

<Actions>
    <Action name="Add export to Excel functionality"
        description="Add a button to export registration data to Excel/CSV" />
    <Action name="Implement batch processing"
        description="Add functionality to process multiple registrations at once" />
    <Action name="Create detailed payment reports" description="Add a page to view payment statistics and reports" />
    <Action name="Add registration certificate generator"
        description="Create a feature to generate and print registration certificates" />
    <Action name="Implement email notifications" description="Add automatic email notifications for status changes" />
</Actions>
