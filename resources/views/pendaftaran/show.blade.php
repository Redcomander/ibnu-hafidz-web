@extends('layouts.dashboard-layout')

@section('content')
    <div class="py-6 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Pendaftar</h2>
                <a href="{{ route('pendaftaran.index') }}"
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
                <div
                    class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white">Informasi Pendaftar</h3>
                    <div>
                        @if($calonSantri->status == 'Formulir')
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                Formulir
                            </span>
                        @elseif($calonSantri->status == 'Verifikasi')
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                Verifikasi
                            </span>
                        @elseif($calonSantri->status == 'Pembayaran')
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                Pembayaran
                            </span>
                        @else
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                Selesai
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Data Pribadi</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">{{ $calonSantri->nama }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($calonSantri->tanggal_lahir)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Jenis Kelamin</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->jenis_kelamin }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Alamat</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->alamat }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Asal Sekolah</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->asal_sekolah }}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Data Orang Tua & Kontak
                            </h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Ayah</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->nama_ayah }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Ibu</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->nama_ibu }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No. WhatsApp</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        {{ $calonSantri->no_whatsapp }}</p>
                                </div>

                                @if($calonSantri->verified_by_name)
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Diverifikasi Oleh</p>
                                        <p class="text-base font-medium text-gray-900 dark:text-white">
                                            {{ $calonSantri->verified_by_name }}</p>
                                    </div>
                                @endif

                                @if($calonSantri->payment_proof)
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Bukti Pembayaran</p>
                                        <a href="{{ route('pendaftaran.viewPaymentProof', $calonSantri->id) }}"
                                            class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Lihat Bukti Pembayaran
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex justify-between">
                            <a href="{{ route('pendaftaran.edit', $calonSantri->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Data
                            </a>

                            <div class="flex gap-2">
                                @if($calonSantri->status == 'Formulir')
                                    <form action="{{ route('pendaftaran.storeVerifikasi') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="calon_santri_id" value="{{ $calonSantri->id }}">
                                        <input type="hidden" name="admin_action" value="1">
                                        <button type="submit"
                                            class="bg-purple-600 hover:bg-purple-700 dark:bg-purple-700 dark:hover:bg-purple-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                            </svg>
                                            Verifikasi
                                        </button>
                                    </form>
                                @endif

                                @if($calonSantri->status == 'Verifikasi')
                                    <form action="{{ route('pendaftaran.storePembayaran') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="calon_santri_id" value="{{ $calonSantri->id }}">
                                        <input type="hidden" name="admin_action" value="1">
                                        <button type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Pembayaran
                                        </button>
                                    </form>
                                @endif

                                @if($calonSantri->status == 'Pembayaran')
                                    <form action="{{ route('pendaftaran.selesai', $calonSantri->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="admin_action" value="1">
                                        <button type="submit"
                                            class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Selesai
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('pendaftaran.destroy', $calonSantri->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
