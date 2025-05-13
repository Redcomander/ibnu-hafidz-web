@extends('layouts.dashboard-layout')

@section('content')
    <div class="py-6 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Bukti Pembayaran</h2>
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

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-medium text-gray-800 dark:text-white">Bukti Pembayaran</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            No. Pendaftaran: <span class="font-medium">{{ $calonSantri->registration_number ?? 'REG-' . str_pad($calonSantri->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </p>
                    </div>
                    <div>
                        @if($calonSantri->payment_type == 'Cicilan')
                            <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                                Cicilan
                            </span>
                        @elseif($calonSantri->payment_type == 'Lunas')
                            <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                Lunas
                            </span>
                        @else
                            <span class="px-3 py-1.5 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                Belum Terverifikasi
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col">
                        <div class="mb-6 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">Informasi Pendaftar</h4>
                                    <div class="mt-2 space-y-1">
                                        <p class="text-gray-600 dark:text-gray-400">Nama: <span class="font-medium text-gray-900 dark:text-white">{{ $calonSantri->nama }}</span></p>
                                        <p class="text-gray-600 dark:text-gray-400">Status:
                                            @if($calonSantri->status == 'Formulir' || $calonSantri->status == 'formulir')
                                                <span class="font-medium text-yellow-600 dark:text-yellow-400">Formulir</span>
                                            @elseif($calonSantri->status == 'Verifikasi' || $calonSantri->status == 'checking')
                                                <span class="font-medium text-purple-600 dark:text-purple-400">Verifikasi</span>
                                            @elseif($calonSantri->status == 'Pembayaran' || $calonSantri->status == 'pembayaran')
                                                <span class="font-medium text-blue-600 dark:text-blue-400">Pembayaran</span>
                                            @else
                                                <span class="font-medium text-green-600 dark:text-green-400">Selesai</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-base font-medium text-gray-700 dark:text-gray-300">Informasi Pembayaran</h4>
                                    <div class="mt-2 space-y-1">
                                        <p class="text-gray-600 dark:text-gray-400">Jenis Pembayaran:
                                            @if($calonSantri->payment_type == 'Cicilan')
                                                <span class="font-medium text-orange-600 dark:text-orange-400">Cicilan</span>
                                            @elseif($calonSantri->payment_type == 'Lunas')
                                                <span class="font-medium text-green-600 dark:text-green-400">Lunas</span>
                                            @else
                                                <span class="font-medium text-gray-600 dark:text-gray-400">Belum Terverifikasi</span>
                                            @endif
                                        </p>

                                        @if($calonSantri->payment_date)
                                            <p class="text-gray-600 dark:text-gray-400">Tanggal Pembayaran: <span class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($calonSantri->payment_date)->format('d M Y') }}</span></p>
                                        @endif

                                        @if($calonSantri->verified_by_name)
                                            <p class="text-gray-600 dark:text-gray-400">Diverifikasi Oleh: <span class="font-medium text-gray-900 dark:text-white">{{ $calonSantri->verified_by_name }}</span></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($calonSantri->payment_type == 'Cicilan')
                            <div class="mb-6 bg-orange-50 dark:bg-orange-900/20 rounded-lg p-4 border border-orange-200 dark:border-orange-800/30">
                                <h4 class="text-base font-medium text-orange-700 dark:text-orange-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Informasi Cicilan
                                </h4>
                                <p class="mt-2 text-orange-600 dark:text-orange-400">
                                    Pembayaran dilakukan secara cicilan. Bukti pembayaran ini merupakan bukti pembayaran cicilan
                                    @if(isset($calonSantri->installment_number))
                                        ke-{{ $calonSantri->installment_number }}
                                    @else
                                        pertama
                                    @endif.
                                </p>

                                @if(isset($calonSantri->installment_amount))
                                    <p class="mt-1 text-orange-600 dark:text-orange-400">
                                        Jumlah Pembayaran: <span class="font-medium">Rp {{ number_format($calonSantri->installment_amount, 0, ',', '.') }}</span>
                                    </p>
                                @endif

                                @if(isset($calonSantri->remaining_amount))
                                    <p class="mt-1 text-orange-600 dark:text-orange-400">
                                        Sisa Pembayaran: <span class="font-medium">Rp {{ number_format($calonSantri->remaining_amount, 0, ',', '.') }}</span>
                                    </p>
                                @endif
                            </div>

                            <!-- Payment History for Installments -->
                            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <h4 class="text-base font-medium text-gray-700 dark:text-gray-300 p-4 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                                    Riwayat Pembayaran Cicilan
                                </h4>
                                <div class="p-4">
                                    @if(isset($paymentHistory) && count($paymentHistory) > 0)
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-50 dark:bg-gray-800">
                                                    <tr>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cicilan Ke</th>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach($paymentHistory as $payment)
                                                        <tr>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $payment->installment_number }}</td>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                                                @if($payment->status == 'verified')
                                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                                        Terverifikasi
                                                                    </span>
                                                                @else
                                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                                                        Menunggu Verifikasi
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                                <a href="{{ route('pendaftaran.viewPaymentProof', $payment->id) }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                                    Lihat Bukti
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                            Belum ada riwayat pembayaran cicilan.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Upload New Installment Form -->
                            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <h4 class="text-base font-medium text-gray-700 dark:text-gray-300 p-4 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                                    Unggah Bukti Pembayaran Cicilan Berikutnya
                                </h4>
                                <div class="p-4">
                                    <form action="{{ route('pendaftaran.uploadInstallment', $calonSantri->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label for="installment_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Pembayaran</label>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 dark:text-gray-400">Rp</span>
                                                    </div>
                                                    <input type="number" name="installment_amount" id="installment_amount" required
                                                        class="pl-10 w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                                        placeholder="Masukkan jumlah pembayaran">
                                                </div>
                                            </div>

                                            <div>
                                                <label for="installment_proof" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bukti Pembayaran</label>
                                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg">
                                                    <div class="space-y-1 text-center">
                                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                                            <label for="installment_proof" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                                <span>Unggah file</span>
                                                                <input id="installment_proof" name="installment_proof" type="file" class="sr-only" accept="image/*" required>
                                                            </label>
                                                            <p class="pl-1">atau seret dan lepas</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            PNG, JPG, JPEG hingga 5MB
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <label for="installment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Pembayaran</label>
                                                <input type="date" name="installment_date" id="installment_date" required
                                                    class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>

                                            <div>
                                                <label for="installment_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan (Opsional)</label>
                                                <textarea name="installment_notes" id="installment_notes" rows="3"
                                                    class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white py-3 px-4 text-base shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                                    placeholder="Tambahkan catatan jika diperlukan"></textarea>
                                            </div>

                                            <div class="flex justify-end">
                                                <button type="submit" class="bg-orange-600 hover:bg-orange-700 dark:bg-orange-700 dark:hover:bg-orange-800 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                                    </svg>
                                                    Unggah Bukti Cicilan
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @elseif($calonSantri->payment_type == 'Lunas')
                            <div class="mb-6 bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800/30">
                                <h4 class="text-base font-medium text-green-700 dark:text-green-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Pembayaran Lunas
                                </h4>
                                <p class="mt-2 text-green-600 dark:text-green-400">
                                    Pembayaran telah dilunasi sepenuhnya. Tidak ada pembayaran tambahan yang diperlukan.
                                </p>

                                @if(isset($calonSantri->payment_amount))
                                    <p class="mt-1 text-green-600 dark:text-green-400">
                                        Jumlah Pembayaran: <span class="font-medium">Rp {{ number_format($calonSantri->payment_amount, 0, ',', '.') }}</span>
                                    </p>
                                @endif
                            </div>
                        @endif

                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <h4 class="text-base font-medium text-gray-700 dark:text-gray-300 p-4 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                                Bukti Pembayaran
                            </h4>

                            <div class="p-4 flex flex-col items-center">
                                <div class="max-w-full overflow-hidden rounded-lg shadow-lg">
                                    <img src="{{ asset('storage/' . $calonSantri->payment_proof) }}" alt="Bukti Pembayaran"
                                        class="max-w-full h-auto">
                                </div>

                                <div class="mt-6 flex gap-3">
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
        </div>
    </div>
@endsection
