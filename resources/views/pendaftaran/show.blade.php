@extends('layouts.dashboard-layout')

@section('styles')
<style>
    /* Custom animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
        100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-pulse-green {
        animation: pulse 2s infinite;
    }

    /* Custom scrollbar for tables */
    .custom-scrollbar::-webkit-scrollbar {
        height: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Glass effect */
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dark .glass-effect {
        background: rgba(17, 24, 39, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Status indicator pulse */
    .status-indicator {
        position: relative;
    }

    .status-indicator::before {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        top: 50%;
        left: 8px;
        transform: translateY(-50%);
    }

    .status-formulir::before {
        background-color: #FCD34D;
        box-shadow: 0 0 0 rgba(252, 211, 77, 0.4);
        animation: pulse 2s infinite;
    }

    .status-verifikasi::before {
        background-color: #A78BFA;
        box-shadow: 0 0 0 rgba(167, 139, 250, 0.4);
        animation: pulse 2s infinite;
    }

    .status-pembayaran::before {
        background-color: #60A5FA;
        box-shadow: 0 0 0 rgba(96, 165, 250, 0.4);
        animation: pulse 2s infinite;
    }

    .status-selesai::before {
        background-color: #34D399;
        box-shadow: 0 0 0 rgba(52, 211, 153, 0.4);
        animation: pulse 2s infinite;
    }

    /* Card hover effects */
    .hover-card-effect {
        transition: all 0.3s ease;
    }

    .hover-card-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Button hover effects */
    .btn-hover-effect {
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-hover-effect::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.2);
        transform: scaleX(0);
        transform-origin: right;
        transition: transform 0.5s ease;
        z-index: -1;
    }

    .btn-hover-effect:hover::after {
        transform: scaleX(1);
        transform-origin: left;
    }

    /* Profile image */
    .profile-image {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto;
        border: 4px solid white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #4CAF50, #2E7D32);
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
    }

    /* Timeline */
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }

    .timeline::after {
        content: '';
        position: absolute;
        width: 3px;
        background-color: #E5E7EB;
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -1.5px;
    }

    .dark .timeline::after {
        background-color: #374151;
    }

    .timeline-container {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }

    .timeline-container::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        right: -10px;
        background-color: white;
        border: 4px solid #4CAF50;
        top: 15px;
        border-radius: 50%;
        z-index: 1;
    }

    .dark .timeline-container::after {
        background-color: #1F2937;
    }

    .left {
        left: 0;
    }

    .right {
        left: 50%;
    }

    .left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid #E5E7EB;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent #E5E7EB;
    }

    .dark .left::before {
        border-color: transparent transparent transparent #374151;
    }

    .right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid #E5E7EB;
        border-width: 10px 10px 10px 0;
        border-color: transparent #E5E7EB transparent transparent;
    }

    .dark .right::before {
        border-color: transparent #374151 transparent transparent;
    }

    .right::after {
        left: -10px;
    }

    .timeline-content {
        padding: 20px;
        background-color: white;
        position: relative;
        border-radius: 10px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .dark .timeline-content {
        background-color: #1F2937;
    }

    /* Responsive timeline */
    @media screen and (max-width: 768px) {
        .timeline::after {
            left: 31px;
        }

        .timeline-container {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }

        .timeline-container::before {
            left: 60px;
            border: medium solid #E5E7EB;
            border-width: 10px 10px 10px 0;
            border-color: transparent #E5E7EB transparent transparent;
        }

        .dark .timeline-container::before {
            border-color: transparent #374151 transparent transparent;
        }

        .left::after, .right::after {
            left: 21px;
        }

        .right {
            left: 0%;
        }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen py-6 dark:bg-gray-900 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with background gradient -->
        <div class="relative rounded-2xl overflow-hidden mb-8 animate-fadeIn" style="animation-delay: 0.1s;">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-400 dark:from-green-800 dark:to-green-600"></div>
            <div class="absolute inset-0 opacity-20 bg-pattern"></div>

            <div class="relative z-10 px-6 py-8 md:px-10 md:py-12 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex-1">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('pendaftaran.index') }}" class="bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-all duration-200 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">Detail Pendaftar</h1>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <div class="text-white/80 text-sm md:text-base">
                            No. Pendaftaran:
                            <span class="font-semibold text-white">
                                {{ $calonSantri->registration_number ?? 'REG-' . str_pad($calonSantri->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <div class="h-4 w-px bg-white/30 mx-2 hidden md:block"></div>

                        <div class="text-white/80 text-sm md:text-base">
                            Terdaftar:
                            <span class="font-semibold text-white">
                                {{ \Carbon\Carbon::parse($calonSantri->created_at)->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-4">
                        @if($calonSantri->status == 'Formulir' || $calonSantri->status == 'formulir')
                            <span class="px-3 py-1 inline-flex items-center text-xs md:text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 status-indicator status-formulir pl-6">
                                Formulir
                            </span>
                        @elseif($calonSantri->status == 'Verifikasi' || $calonSantri->status == 'checking')
                            <span class="px-3 py-1 inline-flex items-center text-xs md:text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 status-indicator status-verifikasi pl-6">
                                Verifikasi
                            </span>
                        @elseif($calonSantri->status == 'Pembayaran' || $calonSantri->status == 'pembayaran')
                            <span class="px-3 py-1 inline-flex items-center text-xs md:text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 status-indicator status-pembayaran pl-6">
                                Pembayaran
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex items-center text-xs md:text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 status-indicator status-selesai pl-6">
                                Selesai
                            </span>
                        @endif

                        @if($calonSantri->payment_type == 'Lunas')
                            <span class="px-3 py-1 inline-flex items-center text-xs md:text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4" />
                                </svg>
                                Lunas
                            </span>
                        @elseif($calonSantri->payment_type == 'Cicilan')
                            <span class="px-3 py-1 inline-flex items-center text-xs md:text-sm leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Cicilan
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-6 md:mt-0 relative">
                    <div class="profile-image">
                        <div class="profile-image-placeholder">
                            {{ strtoupper(substr($calonSantri->nama, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left column - Personal Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden hover-card-effect animate-fadeIn" style="animation-delay: 0.2s;">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Data Pribadi
                        </h3>
                        <a href="{{ route('pendaftaran.edit', $calonSantri->id) }}" class="text-sm text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Nama Lengkap</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">{{ $calonSantri->nama }}</p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tempat, Tanggal Lahir</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($calonSantri->tanggal_lahir)->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Jenis Kelamin</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->jenis_kelamin }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Alamat</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->alamat }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Asal Sekolah</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->asal_sekolah }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent Information Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden hover-card-effect animate-fadeIn" style="animation-delay: 0.3s;">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Data Orang Tua & Kontak
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Nama Ayah</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->nama_ayah }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Nama Ibu</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->nama_ibu }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">No. WhatsApp</p>
                                    <div class="flex items-center">
                                        <p class="text-base font-medium text-gray-900 dark:text-white mr-2">
                                            {{ $calonSantri->no_whatsapp }}
                                        </p>
                                        @php
                                            // Format WhatsApp number for URL
                                            $whatsappNumber = preg_replace('/[^0-9]/', '', $calonSantri->no_whatsapp);
                                            // Add country code if not present
                                            if (substr($whatsappNumber, 0, 1) === '0') {
                                                $whatsappNumber = '62' . substr($whatsappNumber, 1);
                                            } elseif (substr($whatsappNumber, 0, 2) !== '62') {
                                                $whatsappNumber = '62' . $whatsappNumber;
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank"
                                            class="inline-flex items-center justify-center p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200 animate-pulse-green">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>

                                @if($calonSantri->verified_by_name)
                                    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Diverifikasi Oleh</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-white">
                                            {{ $calonSantri->verified_by_name }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Progress Timeline -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden hover-card-effect animate-fadeIn" style="animation-delay: 0.4s;">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            Progress Pendaftaran
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="relative flex items-center justify-between mb-12">
                            <!-- Progress bar -->
                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 dark:bg-gray-700"></div>

                            <!-- Step 1: Formulir -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="{{ in_array($calonSantri->status, ['Formulir', 'formulir', 'Verifikasi', 'checking', 'Pembayaran', 'pembayaran', 'Selesai', 'selesai']) ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} rounded-full h-10 w-10 flex items-center justify-center text-white font-bold">
                                    @if(in_array($calonSantri->status, ['Formulir', 'formulir', 'Verifikasi', 'checking', 'Pembayaran', 'pembayaran', 'Selesai', 'selesai']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        1
                                    @endif
                                </div>
                                <span class="text-xs font-medium mt-2 text-gray-600 dark:text-gray-400">Formulir</span>
                            </div>

                            <!-- Step 2: Verifikasi -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="{{ in_array($calonSantri->status, ['Verifikasi', 'checking', 'Pembayaran', 'pembayaran', 'Selesai', 'selesai']) ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} rounded-full h-10 w-10 flex items-center justify-center text-white font-bold">
                                    @if(in_array($calonSantri->status, ['Verifikasi', 'checking', 'Pembayaran', 'pembayaran', 'Selesai', 'selesai']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        2
                                    @endif
                                </div>
                                <span class="text-xs font-medium mt-2 text-gray-600 dark:text-gray-400">Verifikasi</span>
                            </div>

                            <!-- Step 3: Pembayaran -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="{{ in_array($calonSantri->status, ['Pembayaran', 'pembayaran', 'Selesai', 'selesai']) ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} rounded-full h-10 w-10 flex items-center justify-center text-white font-bold">
                                    @if(in_array($calonSantri->status, ['Pembayaran', 'pembayaran', 'Selesai', 'selesai']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        3
                                    @endif
                                </div>
                                <span class="text-xs font-medium mt-2 text-gray-600 dark:text-gray-400">Pembayaran</span>
                            </div>

                            <!-- Step 4: Selesai -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="{{ in_array($calonSantri->status, ['Selesai', 'selesai']) ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }} rounded-full h-10 w-10 flex items-center justify-center text-white font-bold">
                                    @if(in_array($calonSantri->status, ['Selesai', 'selesai']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        4
                                    @endif
                                </div>
                                <span class="text-xs font-medium mt-2 text-gray-600 dark:text-gray-400">Selesai</span>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-wrap gap-3 justify-center">
                            @if($calonSantri->status == 'Formulir' || $calonSantri->status == 'formulir')
                                <form action="{{ route('pendaftaran.checking') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="calon_santri_id" value="{{ $calonSantri->id }}">
                                    <input type="hidden" name="admin_action" value="1">
                                    <button type="submit"
                                        class="bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 btn-hover-effect">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                        Verifikasi
                                    </button>
                                </form>
                            @endif

                            @if($calonSantri->status == 'Verifikasi' || $calonSantri->status == 'checking')
                                <form action="{{ route('pendaftaran.pembayaran') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="calon_santri_id" value="{{ $calonSantri->id }}">
                                    <input type="hidden" name="admin_action" value="1">
                                    <button type="submit"
                                        class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 btn-hover-effect">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Pembayaran
                                    </button>
                                </form>
                            @endif

                            @if($calonSantri->status == 'Pembayaran' || $calonSantri->status == 'pembayaran')
                                <form action="{{ route('pendaftaran.berhasil', $calonSantri->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="admin_action" value="1">
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2 btn-hover-effect">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Selesai
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column - Payment Information -->
            <div class="space-y-6">
                <!-- Payment Information Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden hover-card-effect animate-fadeIn" style="animation-delay: 0.5s;">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Informasi Pembayaran
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @if($calonSantri->payment_type)
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                                    <div class="flex-shrink-0 mr-4">
                                        @if($calonSantri->payment_type == 'Lunas')
                                            <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4M9 8h6m-5 0a2 2 0 110 4h5a2 2 0 100-4" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Pembayaran</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $calonSantri->payment_type }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if($calonSantri->payment_proof)
                                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Bukti Pembayaran</p>
                                    <div class="relative overflow-hidden rounded-lg h-48 bg-gray-200 dark:bg-gray-700">
                                        <a href="{{ route('pendaftaran.viewPaymentProof', $calonSantri->id) }}" target="_blank" class="block w-full h-full">
                                            <img src="{{ asset('storage/' . $calonSantri->payment_proof) }}" alt="Bukti Pembayaran" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                                                <div class="bg-white dark:bg-gray-800 rounded-full p-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($calonSantri->payment_type == 'Cicilan')
                                <div class="mt-4">
                                    <a href="{{ route('pendaftaran.viewInstallments', $calonSantri->id) }}"
                                        class="w-full bg-orange-600 hover:bg-orange-700 dark:bg-orange-700 dark:hover:bg-orange-800 text-white px-4 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 btn-hover-effect">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        Lihat Riwayat Cicilan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden hover-card-effect animate-fadeIn" style="animation-delay: 0.6s;">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Aksi Cepat
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3">
                            <a href="{{ route('pendaftaran.edit', $calonSantri->id) }}"
                                class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 btn-hover-effect">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Data
                            </a>

                            <button type="button" onclick="printData()" class="w-full bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 text-white px-4 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 btn-hover-effect">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Cetak Data
                            </button>

                            <form action="{{ route('pendaftaran.destroy', $calonSantri->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 btn-hover-effect">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add background pattern
    document.addEventListener('DOMContentLoaded', function() {
        const bgPattern = document.querySelector('.bg-pattern');
        if (bgPattern) {
            bgPattern.style.backgroundImage = "url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.2\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')";
        }
    });

    // Print functionality
    function printData() {
        const printWindow = window.open('', '_blank');

        // Get student data
        const studentName = "{{ $calonSantri->nama }}";
        const regNumber = "{{ $calonSantri->registration_number ?? 'REG-' . str_pad($calonSantri->id, 5, '0', STR_PAD_LEFT) }}";
        const birthInfo = "{{ $calonSantri->tempat_lahir }}, {{ \Carbon\Carbon::parse($calonSantri->tanggal_lahir)->format('d M Y') }}";
        const gender = "{{ $calonSantri->jenis_kelamin }}";
        const address = "{{ $calonSantri->alamat }}";
        const school = "{{ $calonSantri->asal_sekolah }}";
        const fatherName = "{{ $calonSantri->nama_ayah }}";
        const motherName = "{{ $calonSantri->nama_ibu }}";
        const whatsapp = "{{ $calonSantri->no_whatsapp }}";
        const paymentType = "{{ $calonSantri->payment_type }}";
        const status = "{{ $calonSantri->status }}";

        // Create print content
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Data Pendaftar - ${studentName}</title>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 30px;
                        padding-bottom: 20px;
                        border-bottom: 2px solid #4CAF50;
                    }
                    .logo {
                        font-size: 24px;
                        font-weight: bold;
                        color: #4CAF50;
                        margin-bottom: 10px;
                    }
                    h1 {
                        font-size: 22px;
                        margin: 0;
                    }
                    .reg-number {
                        font-size: 16px;
                        color: #666;
                        margin-top: 5px;
                    }
                    .section {
                        margin-bottom: 30px;
                    }
                    .section-title {
                        font-size: 18px;
                        font-weight: bold;
                        margin-bottom: 15px;
                        color: #4CAF50;
                        border-bottom: 1px solid #eee;
                        padding-bottom: 5px;
                    }
                    .data-row {
                        display: flex;
                        margin-bottom: 10px;
                    }
                    .data-label {
                        width: 150px;
                        font-weight: bold;
                    }
                    .data-value {
                        flex: 1;
                    }
                    .status-badge {
                        display: inline-block;
                        padding: 5px 10px;
                        border-radius: 15px;
                        font-size: 14px;
                        font-weight: bold;
                        margin-top: 5px;
                    }
                    .status-formulir {
                        background-color: #FEF3C7;
                        color: #92400E;
                    }
                    .status-verifikasi {
                        background-color: #EDE9FE;
                        color: #5B21B6;
                    }
                    .status-pembayaran {
                        background-color: #DBEAFE;
                        color: #1E40AF;
                    }
                    .status-selesai {
                        background-color: #D1FAE5;
                        color: #065F46;
                    }
                    .footer {
                        margin-top: 50px;
                        text-align: center;
                        font-size: 14px;
                        color: #666;
                    }
                    @media print {
                        body {
                            padding: 0;
                            margin: 0;
                        }
                        .no-print {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="logo">Pondok Pesantren Ibnu Hafidz</div>
                    <h1>Data Pendaftar</h1>
                    <div class="reg-number">${regNumber}</div>
                </div>

                <div class="section">
                    <div class="section-title">Data Pribadi</div>
                    <div class="data-row">
                        <div class="data-label">Nama Lengkap:</div>
                        <div class="data-value">${studentName}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">TTL:</div>
                        <div class="data-value">${birthInfo}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Jenis Kelamin:</div>
                        <div class="data-value">${gender}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Alamat:</div>
                        <div class="data-value">${address}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Asal Sekolah:</div>
                        <div class="data-value">${school}</div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">Data Orang Tua & Kontak</div>
                    <div class="data-row">
                        <div class="data-label">Nama Ayah:</div>
                        <div class="data-value">${fatherName}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Nama Ibu:</div>
                        <div class="data-value">${motherName}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">No. WhatsApp:</div>
                        <div class="data-value">${whatsapp}</div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">Informasi Pendaftaran</div>
                    <div class="data-row">
                        <div class="data-label">Jenis Pembayaran:</div>
                        <div class="data-value">${paymentType}</div>
                    </div>
                    <div class="data-row">
                        <div class="data-label">Status:</div>
                        <div class="data-value">
                            <span class="status-badge status-${status.toLowerCase()}">${status}</span>
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <p>Dicetak pada: ${new Date().toLocaleString()}</p>
                    <p>Pondok Pesantren Ibnu Hafidz</p>
                </div>

                <div class="no-print" style="text-align: center; margin-top: 30px;">
                    <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                        Cetak Dokumen
                    </button>
                    <button onclick="window.close()" style="padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-left: 10px;">
                        Tutup
                    </button>
                </div>
            </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.focus();
    }
</script>
@endsection
