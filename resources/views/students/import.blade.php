@extends('layouts.dashboard-layout')

@section('content')
    <div
        class="py-6 min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Decorative elements -->
            <div
                class="absolute top-10 right-10 w-64 h-64 bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-3xl -z-10 animate-float">
            </div>
            <div class="absolute bottom-10 left-10 w-72 h-72 bg-purple-500/10 dark:bg-purple-500/20 rounded-full blur-3xl -z-10 animate-float"
                style="animation-delay: 2s;"></div>

            <!-- Page header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1
                            class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500 dark:from-indigo-400 dark:to-purple-400 inline-block">
                            Impor Data Siswa
                        </h1>
                        <p class="mt-1 text-slate-600 dark:text-slate-400">
                            Unggah file Excel untuk mengimpor data siswa
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('student.index') }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Import Form -->
            <div
                class="bg-white/70 dark:bg-slate-800/70 shadow-lg border border-slate-200/50 dark:border-slate-700/50 rounded-xl p-6 mb-8">
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('student.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label for="file" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">File
                            Excel</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-slate-600 dark:text-slate-400">
                                    <label for="file"
                                        class="relative cursor-pointer bg-white dark:bg-slate-700 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Unggah file</span>
                                        <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv">
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    Excel atau CSV hingga 10MB
                                </p>
                            </div>
                        </div>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-700/30 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Petunjuk:</h3>
                        <ul class="list-disc pl-5 text-sm text-slate-600 dark:text-slate-400 space-y-1">
                            <li>Format file yang didukung: Excel (.xlsx, .xls) dan CSV</li>
                            <li>Baris pertama harus berisi header kolom</li>
                            <li>Kolom tanggal harus dalam format DD-MM-YYYY</li>
                            <li>Kolom jenis kelamin harus berisi "Laki-laki" atau "Perempuan"</li>
                            <li>Kolom status santri harus berisi "Baru", "Pindahan", atau "Lain-lain"</li>
                            <li>Kolom penerima_kps dan terima_fisik harus berisi "Ya" atau "Tidak"</li>
                            <li>Kolom kartu_jaminan harus berisi "KIS", "BPJS", "Jamkesmas", atau "Jamkesda"</li>
                            <li>Ukuran file maksimal 10MB</li>
                        </ul>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('student.template') }}"
                            class="inline-flex items-center px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg shadow-sm text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-slate-500 dark:text-slate-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh Template
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            Impor Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Display file name when selected
        document.getElementById('file').addEventListener('change', function (e) {
            const fileName = e.target.files[0].name;
            const fileSize = (e.target.files[0].size / 1024 / 1024).toFixed(2);
            const fileInfo = document.createElement('p');
            fileInfo.classList.add('mt-2', 'text-sm', 'text-slate-600', 'dark:text-slate-400');
            fileInfo.textContent = `File dipilih: ${fileName} (${fileSize} MB)`;

            // Remove previous file info if exists
            const previousInfo = this.parentElement.parentElement.parentElement.querySelector('p:not(.text-xs)');
            if (previousInfo) {
                previousInfo.remove();
            }

            this.parentElement.parentElement.parentElement.appendChild(fileInfo);
        });
    </script>
@endsection
