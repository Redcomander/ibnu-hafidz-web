@extends('layouts.dashboard-layout')

@section('content')
    <div class="py-6 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Bukti Pembayaran</h2>
                <a href="{{ route('pendaftaran.show', $calonSantri->id) }}"
                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white">Bukti Pembayaran {{ $calonSantri->nama }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col items-center">
                        <div class="mb-4 text-center">
                            <p class="text-gray-600 dark:text-gray-400">Bukti pembayaran untuk pendaftaran santri:</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $calonSantri->nama }}</p>
                        </div>

                        <div class="max-w-full overflow-hidden rounded-lg shadow-lg">
                            <img src="{{ asset('storage/' . $calonSantri->payment_proof) }}" alt="Bukti Pembayaran"
                                class="max-w-full h-auto">
                        </div>

                        <div class="mt-6">
                            <a href="{{ asset('storage/' . $calonSantri->payment_proof) }}" target="_blank"
                                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Buka Gambar di Tab Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
