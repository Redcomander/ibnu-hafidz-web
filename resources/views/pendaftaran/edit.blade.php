@extends('layouts.dashboard-layout')

@section('content')
    <div class="py-6 dark:bg-gray-900">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Data Pendaftar</h2>
                <a href="{{ route('pendaftaran.show', $calonSantri->id) }}"
                    class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2.5 rounded-lg transition-all duration-200 flex items-center gap-2 text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-4 mb-6 rounded-lg">
                    <div class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-medium text-base">Terjadi kesalahan:</p>
                            <ul class="mt-2 ml-5 list-disc list-inside text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('pendaftaran.update', $calonSantri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div
                        class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                        <div class="flex flex-col">
                            <h3 class="text-xl font-medium text-gray-800 dark:text-white">Informasi Pendaftar</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                No. Pendaftaran: <span
                                    class="font-medium">{{ $calonSantri->registration_number ?? 'REG-' . str_pad($calonSantri->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </p>
                        </div>
                        <div class="flex flex-col items-end gap-3">
                            <div>
                                @if($calonSantri->status == 'Formulir' || $calonSantri->status == 'formulir')
                                    <span
                                        class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                        Formulir
                                    </span>
                                @elseif($calonSantri->status == 'Verifikasi' || $calonSantri->status == 'checking')
                                    <span
                                        class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                        Verifikasi
                                    </span>
                                @elseif($calonSantri->status == 'Pembayaran' || $calonSantri->status == 'pembayaran')
                                    <span
                                        class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                        Pembayaran
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                        Selesai
                                    </span>
                                @endif
                            </div>

                            @if($calonSantri->payment_type)
                                <div class="flex gap-4 bg-gray-100 dark:bg-gray-800 p-2 rounded-lg">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="payment_type" value="Lunas" class="form-radio h-5 w-5 text-green-600 border-2" {{ $calonSantri->payment_type == 'Lunas' ? 'checked' : '' }}>
                                        <span class="ml-2 text-base text-gray-700 dark:text-gray-300">Lunas</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="payment_type" value="Cicilan" class="form-radio h-5 w-5 text-orange-600 border-2" {{ $calonSantri->payment_type == 'Cicilan' ? 'checked' : '' }}>
                                        <span class="ml-2 text-base text-gray-700 dark:text-gray-300">Cicilan</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <h4 class="text-lg font-semibold mb-5 text-gray-800 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">Data Pribadi</h4>
                                <div class="space-y-5">
                                    <div>
                                        <label for="nama" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                                        <input type="text" name="nama" id="nama" value="{{ old('nama', $calonSantri->nama) }}"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="tempat_lahir" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $calonSantri->tempat_lahir) }}"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="tanggal_lahir" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                            value="{{ old('tanggal_lahir', $calonSantri->tanggal_lahir ? \Carbon\Carbon::parse($calonSantri->tanggal_lahir)->format('Y-m-d') : '') }}"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="jenis_kelamin" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" id="jenis_kelamin"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                            <option value="Laki-laki" {{ old('jenis_kelamin', $calonSantri->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin', $calonSantri->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="alamat" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat</label>
                                        <textarea name="alamat" id="alamat" rows="4"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">{{ old('alamat', $calonSantri->alamat) }}</textarea>
                                    </div>
                                    <div>
                                        <label for="asal_sekolah" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Asal Sekolah</label>
                                        <input type="text" name="asal_sekolah" id="asal_sekolah" value="{{ old('asal_sekolah', $calonSantri->asal_sekolah) }}"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold mb-5 text-gray-800 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">Data Orang Tua & Kontak</h4>
                                <div class="space-y-5">
                                    <div>
                                        <label for="nama_ayah" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Ayah</label>
                                        <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah', $calonSantri->nama_ayah) }}"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="nama_ibu" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu', $calonSantri->nama_ibu) }}"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="no_whatsapp" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">No. WhatsApp</label>
                                        <div class="flex items-center">
                                            <input type="text" name="no_whatsapp" id="no_whatsapp" value="{{ old('no_whatsapp', $calonSantri->no_whatsapp) }}"
                                                class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
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
                                                class="ml-3 inline-flex items-center justify-center p-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="status" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                        <select name="status" id="status"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                            <option value="formulir" {{ old('status', $calonSantri->status) == 'formulir' || old('status', $calonSantri->status) == 'Formulir' ? 'selected' : '' }}>Formulir</option>
                                            <option value="checking" {{ old('status', $calonSantri->status) == 'checking' || old('status', $calonSantri->status) == 'Verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                            <option value="pembayaran" {{ old('status', $calonSantri->status) == 'pembayaran' || old('status', $calonSantri->status) == 'Pembayaran' ? 'selected' : '' }}>Pembayaran</option>
                                            <option value="berhasil" {{ old('status', $calonSantri->status) == 'berhasil' || old('status', $calonSantri->status) == 'Berhasil' || old('status', $calonSantri->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>

                                    @if($calonSantri->verified_by_name)
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Diverifikasi Oleh</p>
                                            <p class="text-base font-medium text-gray-900 dark:text-white mt-1">
                                                {{ $calonSantri->verified_by_name }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4">
                                        <label for="payment_proof" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Bukti Pembayaran</label>
                                        <div class="flex flex-col space-y-3">
                                            <input type="file" name="payment_proof" id="payment_proof" accept="image/*"
                                                class="block w-full text-base text-gray-700 dark:text-gray-300
                                                file:mr-4 file:py-2.5 file:px-4
                                                file:rounded-md file:border-0
                                                file:text-sm file:font-medium
                                                file:bg-blue-50 file:text-blue-700
                                                dark:file:bg-blue-900/20 dark:file:text-blue-300
                                                hover:file:bg-blue-100 dark:hover:file:bg-blue-900/30
                                                cursor-pointer">

                                            @if($calonSantri->payment_proof)
                                                <a href="{{ route('pendaftaran.viewPaymentProof', $calonSantri->id) }}" target="_blank"
                                                    class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium flex items-center gap-2 bg-green-50 dark:bg-green-900/20 p-2 rounded-lg self-start">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    Lihat Bukti Lama
                                                </a>
                                            @endif
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah bukti pembayaran</p>
                                    </div>

                                    <div>
                                        <label for="registration_number_display" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Nomor Pendaftaran</label>
                                        <input type="text" id="registration_number_display"
                                            value="{{ $calonSantri->registration_number ?? 'REG-' . str_pad($calonSantri->id, 5, '0', STR_PAD_LEFT) }}"
                                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm bg-gray-100 dark:bg-gray-800 cursor-not-allowed"
                                            disabled>
                                        <input type="hidden" name="registration_number" value="{{ $calonSantri->registration_number ?? 'REG-' . str_pad($calonSantri->id, 5, '0', STR_PAD_LEFT) }}">
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nomor pendaftaran tidak dapat diubah</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 border-t border-gray-200 dark:border-gray-700 pt-6">
                            <div class="flex flex-col sm:flex-row justify-between gap-4">
                                <button type="submit"
                                    class="bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 text-white px-6 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-base font-medium shadow-sm hover:shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Perubahan
                                </button>

                                <a href="{{ route('pendaftaran.show', $calonSantri->id) }}"
                                    class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-all duration-200 flex items-center justify-center gap-2 text-base font-medium shadow-sm hover:shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
