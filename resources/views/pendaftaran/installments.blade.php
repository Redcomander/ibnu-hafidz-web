@extends('layouts.dashboard-layout')

@section('content')
    <div class="py-6 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Riwayat Pembayaran Cicilan</h2>
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

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white">Informasi Pendaftar</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No. Pendaftaran: <span
                                class="font-medium">{{ $calonSantri->registration_number ?? 'REG-' . str_pad($calonSantri->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </p>
                    </div>
                    <div>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Cicilan
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Data Pribadi</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">{{ $calonSantri->nama }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No. WhatsApp</p>
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
                                            class="inline-flex items-center justify-center p-1.5 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Informasi Pembayaran</h4>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Biaya</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Dibayarkan</p>
                                    <p class="text-base font-medium text-green-600 dark:text-green-400">
                                        Rp {{ number_format($totalPaid, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Sisa Pembayaran</p>
                                    <p class="text-base font-medium {{ $remainingAmount > 0 ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        Rp {{ number_format($remainingAmount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                    <p class="text-base font-medium text-gray-900 dark:text-white">
                                        @if($remainingAmount <= 0)
                                            <span class="text-green-600 dark:text-green-400">Lunas</span>
                                        @else
                                            <span class="text-orange-600 dark:text-orange-400">Belum Lunas</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white">Riwayat Pembayaran Cicilan</h3>
                </div>
                <div class="p-6">
                    @if($installments->isEmpty())
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada pembayaran cicilan yang tercatat.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            No. Cicilan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Jumlah
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Bukti
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($installments as $installment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $installment->installment_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($installment->payment_date)->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                Rp {{ number_format($installment->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($installment->status == 'verified')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                        Terverifikasi
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                                        Menunggu Verifikasi
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <a href="{{ asset('storage/' . $installment->payment_proof) }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($installment->status != 'verified')
                                                    <form action="{{ route('pendaftaran.verifyInstallment', $installment->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                            Verifikasi
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 dark:text-gray-500">Sudah Diverifikasi</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('pendaftaran.show', $calonSantri->id) }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition-all duration-200 flex items-center gap-2">
                    Kembali ke Detail Pendaftar
                </a>
            </div>
        </div>
    </div>
@endsection
