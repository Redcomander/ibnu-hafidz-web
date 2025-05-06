@extends('layouts.dashboard-layout')

@section('head')
    <style>
        .form-card {
            transition: all 0.3s ease;
            border-radius: 1rem;
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .form-section {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .form-section-header {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
        }

        .form-input {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            border: 1px solid rgba(209, 213, 219, 0.5);
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .form-input.dark {
            background-color: rgba(30, 41, 59, 0.5);
            border-color: rgba(71, 85, 105, 0.5);
            color: white;
        }

        .form-input.dark:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2);
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            display: block;
        }

        .required::after {
            content: "*";
            color: #ef4444;
            margin-left: 0.25rem;
        }

        .form-hint {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .form-error {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.25rem;
        }

        .btn-primary {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #4338ca, #6d28d9);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: transparent;
            border: 1px solid #d1d5db;
            color: #4b5563;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }

        .btn-secondary.dark {
            border-color: #4b5563;
            color: #e5e7eb;
        }

        .btn-secondary.dark:hover {
            background-color: rgba(75, 85, 99, 0.2);
        }

        .progress-bar {
            height: 0.5rem;
            border-radius: 9999px;
            overflow: hidden;
            background-color: #e5e7eb;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            transition: width 0.3s ease;
        }
    </style>
@endsection

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
                            Add New Student
                        </h1>
                        <p class="mt-1 text-slate-600 dark:text-slate-400">
                            Enter student information to create a new record
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('student.index') }}"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Progress -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Form Completion</span>
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400"
                        id="progress-percentage">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-bar-fill" id="progress-bar-fill" style="width: 0%"></div>
                </div>
            </div>

            <!-- Form Card -->
            <div
                class="bg-white/70 dark:bg-slate-800/70 shadow-lg border border-slate-200/50 dark:border-slate-700/50 rounded-xl p-6 form-card">
                <form action="{{ route('student.store') }}" method="POST" id="student-form">
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="mb-8 form-section">
                        <div class="form-section-header px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-white">Personal Information</h2>
                        </div>
                        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-b-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="nama_lengkap"
                                        class="form-label text-slate-700 dark:text-slate-300 required">Full Name</label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                                        class="form-input w-full dark:form-input-dark @error('nama_lengkap') border-red-500 @enderror"
                                        value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nis"
                                        class="form-label text-slate-700 dark:text-slate-300 required">NIS</label>
                                    <input type="text" name="nis" id="nis"
                                        class="form-input w-full dark:form-input-dark @error('nis') border-red-500 @enderror"
                                        value="{{ old('nis') }}" required>
                                    @error('nis')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nisn"
                                        class="form-label text-slate-700 dark:text-slate-300 required">NISN</label>
                                    <input type="text" name="nisn" id="nisn"
                                        class="form-input w-full dark:form-input-dark @error('nisn') border-red-500 @enderror"
                                        value="{{ old('nisn') }}" required>
                                    @error('nisn')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jenis_kelamin"
                                        class="form-label text-slate-700 dark:text-slate-300 required">Gender</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin"
                                        class="form-input w-full dark:form-input-dark @error('jenis_kelamin') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Gender</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tempat_lahir"
                                        class="form-label text-slate-700 dark:text-slate-300 required">Place of
                                        Birth</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                        class="form-input w-full dark:form-input-dark @error('tempat_lahir') border-red-500 @enderror"
                                        value="{{ old('tempat_lahir') }}" required>
                                    @error('tempat_lahir')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tanggal_lahir"
                                        class="form-label text-slate-700 dark:text-slate-300 required">Date of Birth</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-input w-full dark:form-input-dark @error('tanggal_lahir') border-red-500 @enderror"
                                        value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="agama"
                                        class="form-label text-slate-700 dark:text-slate-300 required">Religion</label>
                                    <select name="agama" id="agama"
                                        class="form-input w-full dark:form-input-dark @error('agama') border-red-500 @enderror"
                                        required>
                                        <option value="">Select Religion</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen
                                        </option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik
                                        </option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha
                                        </option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                        </option>
                                    </select>
                                    @error('agama')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nik" class="form-label text-slate-700 dark:text-slate-300">NIK</label>
                                    <input type="text" name="nik" id="nik"
                                        class="form-input w-full dark:form-input-dark @error('nik') border-red-500 @enderror"
                                        value="{{ old('nik') }}">
                                    @error('nik')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_kk" class="form-label text-slate-700 dark:text-slate-300">Family Card
                                        Number</label>
                                    <input type="text" name="no_kk" id="no_kk"
                                        class="form-input w-full dark:form-input-dark @error('no_kk') border-red-500 @enderror"
                                        value="{{ old('no_kk') }}">
                                    @error('no_kk')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_akte" class="form-label text-slate-700 dark:text-slate-300">Birth
                                        Certificate Number</label>
                                    <input type="text" name="no_akte" id="no_akte"
                                        class="form-input w-full dark:form-input-dark @error('no_akte') border-red-500 @enderror"
                                        value="{{ old('no_akte') }}">
                                    @error('no_akte')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kewarganegaraan"
                                        class="form-label text-slate-700 dark:text-slate-300">Nationality</label>
                                    <input type="text" name="kewarganegaraan" id="kewarganegaraan"
                                        class="form-input w-full dark:form-input-dark @error('kewarganegaraan') border-red-500 @enderror"
                                        value="{{ old('kewarganegaraan', 'Indonesia') }}">
                                    @error('kewarganegaraan')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="form-label text-slate-700 dark:text-slate-300">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-input w-full dark:form-input-dark @error('email') border-red-500 @enderror"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_hp_telpon" class="form-label text-slate-700 dark:text-slate-300">Phone
                                        Number</label>
                                    <input type="text" name="no_hp_telpon" id="no_hp_telpon"
                                        class="form-input w-full dark:form-input-dark @error('no_hp_telpon') border-red-500 @enderror"
                                        value="{{ old('no_hp_telpon') }}">
                                    @error('no_hp_telpon')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information Section -->
                    <div class="mb-8 form-section">
                        <div class="form-section-header px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-white">Address Information</h2>
                        </div>
                        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-b-lg">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="alamat"
                                        class="form-label text-slate-700 dark:text-slate-300">Address</label>
                                    <textarea name="alamat" id="alamat" rows="3"
                                        class="form-input w-full dark:form-input-dark @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div>
                                        <label for="rt" class="form-label text-slate-700 dark:text-slate-300">RT</label>
                                        <input type="text" name="rt" id="rt"
                                            class="form-input w-full dark:form-input-dark @error('rt') border-red-500 @enderror"
                                            value="{{ old('rt') }}">
                                        @error('rt')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="rw" class="form-label text-slate-700 dark:text-slate-300">RW</label>
                                        <input type="text" name="rw" id="rw"
                                            class="form-input w-full dark:form-input-dark @error('rw') border-red-500 @enderror"
                                            value="{{ old('rw') }}">
                                        @error('rw')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="desa_kelurahan"
                                            class="form-label text-slate-700 dark:text-slate-300">Village/Ward</label>
                                        <input type="text" name="desa_kelurahan" id="desa_kelurahan"
                                            class="form-input w-full dark:form-input-dark @error('desa_kelurahan') border-red-500 @enderror"
                                            value="{{ old('desa_kelurahan') }}">
                                        @error('desa_kelurahan')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kecamatan"
                                            class="form-label text-slate-700 dark:text-slate-300">District</label>
                                        <input type="text" name="kecamatan" id="kecamatan"
                                            class="form-input w-full dark:form-input-dark @error('kecamatan') border-red-500 @enderror"
                                            value="{{ old('kecamatan') }}">
                                        @error('kecamatan')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kabupaten_kota"
                                            class="form-label text-slate-700 dark:text-slate-300">City/Regency</label>
                                        <input type="text" name="kabupaten_kota" id="kabupaten_kota"
                                            class="form-input w-full dark:form-input-dark @error('kabupaten_kota') border-red-500 @enderror"
                                            value="{{ old('kabupaten_kota') }}">
                                        @error('kabupaten_kota')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="provinsi"
                                            class="form-label text-slate-700 dark:text-slate-300">Province</label>
                                        <input type="text" name="provinsi" id="provinsi"
                                            class="form-input w-full dark:form-input-dark @error('provinsi') border-red-500 @enderror"
                                            value="{{ old('provinsi') }}">
                                        @error('provinsi')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="kode_pos" class="form-label text-slate-700 dark:text-slate-300">Postal
                                            Code</label>
                                        <input type="text" name="kode_pos" id="kode_pos"
                                            class="form-input w-full dark:form-input-dark @error('kode_pos') border-red-500 @enderror"
                                            value="{{ old('kode_pos') }}">
                                        @error('kode_pos')
                                            <p class="form-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parents Information Section -->
                    <div class="mb-8 form-section">
                        <div class="form-section-header px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-white">Parents Information</h2>
                        </div>
                        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-b-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Father's Information -->
                                <div>
                                    <h3 class="text-md font-medium text-slate-800 dark:text-slate-200 mb-4">Father's
                                        Information</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="nama_ayah"
                                                class="form-label text-slate-700 dark:text-slate-300">Father's Name</label>
                                            <input type="text" name="nama_ayah" id="nama_ayah"
                                                class="form-input w-full dark:form-input-dark @error('nama_ayah') border-red-500 @enderror"
                                                value="{{ old('nama_ayah') }}">
                                            @error('nama_ayah')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="nik_ayah"
                                                class="form-label text-slate-700 dark:text-slate-300">Father's NIK</label>
                                            <input type="text" name="nik_ayah" id="nik_ayah"
                                                class="form-input w-full dark:form-input-dark @error('nik_ayah') border-red-500 @enderror"
                                                value="{{ old('nik_ayah') }}">
                                            @error('nik_ayah')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="tahun_lahir_ayah"
                                                class="form-label text-slate-700 dark:text-slate-300">Father's Birth
                                                Year</label>
                                            <input type="number" name="tahun_lahir_ayah" id="tahun_lahir_ayah"
                                                class="form-input w-full dark:form-input-dark @error('tahun_lahir_ayah') border-red-500 @enderror"
                                                value="{{ old('tahun_lahir_ayah') }}" min="1900" max="{{ date('Y') }}">
                                            @error('tahun_lahir_ayah')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pendidikan_ayah"
                                                class="form-label text-slate-700 dark:text-slate-300">Father's
                                                Education</label>
                                            <select name="pendidikan_ayah" id="pendidikan_ayah"
                                                class="form-input w-full dark:form-input-dark @error('pendidikan_ayah') border-red-500 @enderror">
                                                <option value="">Select Education</option>
                                                <option value="SD" {{ old('pendidikan_ayah') == 'SD' ? 'selected' : '' }}>SD
                                                </option>
                                                <option value="SMP" {{ old('pendidikan_ayah') == 'SMP' ? 'selected' : '' }}>
                                                    SMP</option>
                                                <option value="SMA" {{ old('pendidikan_ayah') == 'SMA' ? 'selected' : '' }}>
                                                    SMA</option>
                                                <option value="D1" {{ old('pendidikan_ayah') == 'D1' ? 'selected' : '' }}>D1
                                                </option>
                                                <option value="D2" {{ old('pendidikan_ayah') == 'D2' ? 'selected' : '' }}>D2
                                                </option>
                                                <option value="D3" {{ old('pendidikan_ayah') == 'D3' ? 'selected' : '' }}>D3
                                                </option>
                                                <option value="D4" {{ old('pendidikan_ayah') == 'D4' ? 'selected' : '' }}>D4
                                                </option>
                                                <option value="S1" {{ old('pendidikan_ayah') == 'S1' ? 'selected' : '' }}>S1
                                                </option>
                                                <option value="S2" {{ old('pendidikan_ayah') == 'S2' ? 'selected' : '' }}>S2
                                                </option>
                                                <option value="S3" {{ old('pendidikan_ayah') == 'S3' ? 'selected' : '' }}>S3
                                                </option>
                                            </select>
                                            @error('pendidikan_ayah')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pekerjaan_ayah"
                                                class="form-label text-slate-700 dark:text-slate-300">Father's
                                                Occupation</label>
                                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah"
                                                class="form-input w-full dark:form-input-dark @error('pekerjaan_ayah') border-red-500 @enderror"
                                                value="{{ old('pekerjaan_ayah') }}">
                                            @error('pekerjaan_ayah')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Mother's Information -->
                                <div>
                                    <h3 class="text-md font-medium text-slate-800 dark:text-slate-200 mb-4">Mother's
                                        Information</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="nama_ibu"
                                                class="form-label text-slate-700 dark:text-slate-300">Mother's Name</label>
                                            <input type="text" name="nama_ibu" id="nama_ibu"
                                                class="form-input w-full dark:form-input-dark @error('nama_ibu') border-red-500 @enderror"
                                                value="{{ old('nama_ibu') }}">
                                            @error('nama_ibu')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="nik_ibu"
                                                class="form-label text-slate-700 dark:text-slate-300">Mother's NIK</label>
                                            <input type="text" name="nik_ibu" id="nik_ibu"
                                                class="form-input w-full dark:form-input-dark @error('nik_ibu') border-red-500 @enderror"
                                                value="{{ old('nik_ibu') }}">
                                            @error('nik_ibu')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="tahun_lahir_ibu"
                                                class="form-label text-slate-700 dark:text-slate-300">Mother's Birth
                                                Year</label>
                                                <input type="number" name="tahun_lahir_ibu" id="tahun_lahir_ibu"
                                                class="form-input w-full dark:form-input-dark @error('tahun_lahir_ibu') border-red-500 @enderror"
                                                value="{{ old('tahun_lahir_ibu') }}" min="1900" max="{{ date('Y') }}">

                                            @error('tahun_lahir_ibu')
                                                <p> class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pendidikan_ibu"
                                                class="form-label text-slate-700 dark:text-slate-300">Mother's
                                                Education</label>
                                            <select name="pendidikan_ibu" id="pendidikan_ibu"
                                                class="form-input w-full dark:form-input-dark @error('pendidikan_ibu') border-red-500 @enderror">
                                                <option value="">Select Education</option>
                                                <option value="SD" {{ old('pendidikan_ibu') == 'SD' ? 'selected' : '' }}>SD
                                                </option>
                                                <option value="SMP" {{ old('pendidikan_ibu') == 'SMP' ? 'selected' : '' }}>SMP
                                                </option>
                                                <option value="SMA" {{ old('pendidikan_ibu') == 'SMA' ? 'selected' : '' }}>SMA
                                                </option>
                                                <option value="D1" {{ old('pendidikan_ibu') == 'D1' ? 'selected' : '' }}>D1
                                                </option>
                                                <option value="D2" {{ old('pendidikan_ibu') == 'D2' ? 'selected' : '' }}>D2
                                                </option>
                                                <option value="D3" {{ old('pendidikan_ibu') == 'D3' ? 'selected' : '' }}>D3
                                                </option>
                                                <option value="D4" {{ old('pendidikan_ibu') == 'D4' ? 'selected' : '' }}>D4
                                                </option>
                                                <option value="S1" {{ old('pendidikan_ibu') == 'S1' ? 'selected' : '' }}>S1
                                                </option>
                                                <option value="S2" {{ old('pendidikan_ibu') == 'S2' ? 'selected' : '' }}>S2
                                                </option>
                                                <option value="S3" {{ old('pendidikan_ibu') == 'S3' ? 'selected' : '' }}>S3
                                                </option>
                                            </select>
                                            @error('pendidikan_ibu')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="pekerjaan_ibu"
                                                class="form-label text-slate-700 dark:text-slate-300">Mother's
                                                Occupation</label>
                                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu"
                                                class="form-input w-full dark:form-input-dark @error('pekerjaan_ibu') border-red-500 @enderror"
                                                value="{{ old('pekerjaan_ibu') }}">
                                            @error('pekerjaan_ibu')
                                                <p class="form-error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Educational Information Section -->
                    <div class="mb-8 form-section">
                        <div class="form-section-header px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-white">Educational Information</h2>
                        </div>
                        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-b-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="rombel_kelas"
                                        class="form-label text-slate-700 dark:text-slate-300">Class</label>
                                    <select name="rombel_kelas" id="rombel_kelas"
                                        class="form-input w-full dark:form-input-dark @error('rombel_kelas') border-red-500 @enderror">
                                        <option value="">Select Class</option>
                                        <option value="X" {{ old('rombel_kelas') == 'X' ? 'selected' : '' }}>X</option>
                                        <option value="XI" {{ old('rombel_kelas') == 'XI' ? 'selected' : '' }}>XI</option>
                                        <option value="XII" {{ old('rombel_kelas') == 'XII' ? 'selected' : '' }}>XII</option>
                                    </select>
                                    @error('rombel_kelas')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="rombel_ads" class="form-label text-slate-700 dark:text-slate-300">Study
                                        Group</label>
                                    <input type="text" name="rombel_ads" id="rombel_ads"
                                        class="form-input w-full dark:form-input-dark @error('rombel_ads') border-red-500 @enderror"
                                        value="{{ old('rombel_ads') }}">
                                    @error('rombel_ads')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="sekolah_asal" class="form-label text-slate-700 dark:text-slate-300">Previous
                                        School</label>
                                    <input type="text" name="sekolah_asal" id="sekolah_asal"
                                        class="form-input w-full dark:form-input-dark @error('sekolah_asal') border-red-500 @enderror"
                                        value="{{ old('sekolah_asal') }}">
                                    @error('sekolah_asal')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tahun_kelulusan"
                                        class="form-label text-slate-700 dark:text-slate-300">Graduation Year</label>
                                    <input type="number" name="tahun_kelulusan" id="tahun_kelulusan"
                                        class="form-input w-full dark:form-input-dark @error('tahun_kelulusan') border-red-500 @enderror"
                                        value="{{ old('tahun_kelulusan') }}" min="1900" max="{{ date('Y') }}">
                                    @error('tahun_kelulusan')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_peserta_un"
                                        class="form-label text-slate-700 dark:text-slate-300">National Exam Participant
                                        Number</label>
                                    <input type="text" name="no_peserta_un" id="no_peserta_un"
                                        class="form-input w-full dark:form-input-dark @error('no_peserta_un') border-red-500 @enderror"
                                        value="{{ old('no_peserta_un') }}">
                                    @error('no_peserta_un')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_seri_ijazah"
                                        class="form-label text-slate-700 dark:text-slate-300">Diploma Serial Number</label>
                                    <input type="text" name="no_seri_ijazah" id="no_seri_ijazah"
                                        class="form-input w-full dark:form-input-dark @error('no_seri_ijazah') border-red-500 @enderror"
                                        value="{{ old('no_seri_ijazah') }}">
                                    @error('no_seri_ijazah')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_skhun" class="form-label text-slate-700 dark:text-slate-300">SKHUN
                                        Number</label>
                                    <input type="text" name="no_skhun" id="no_skhun"
                                        class="form-input w-full dark:form-input-dark @error('no_skhun') border-red-500 @enderror"
                                        value="{{ old('no_skhun') }}">
                                    @error('no_skhun')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="mb-8 form-section">
                        <div class="form-section-header px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-white">Additional Information</h2>
                        </div>
                        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-b-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="status_santri" class="form-label text-slate-700 dark:text-slate-300">Student
                                        Status</label>
                                    <select name="status_santri" id="status_santri"
                                        class="form-input w-full dark:form-input-dark @error('status_santri') border-red-500 @enderror">
                                        <option value="">Select Status</option>
                                        <option value="Baru" {{ old('status_santri') == 'Baru' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="Pindahan" {{ old('status_santri') == 'Pindahan' ? 'selected' : '' }}>
                                            Transfer</option>
                                        <option value="Lain-lain" {{ old('status_santri') == 'Lain-lain' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                    @error('status_santri')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="status_santri_other_container" style="display: none;">
                                    <label for="status_santri_other"
                                        class="form-label text-slate-700 dark:text-slate-300">Other Status</label>
                                    <input type="text" name="status_santri_other" id="status_santri_other"
                                        class="form-input w-full dark:form-input-dark @error('status_santri_other') border-red-500 @enderror"
                                        value="{{ old('status_santri_other') }}">
                                    @error('status_santri_other')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tanggal_masuk_pondok"
                                        class="form-label text-slate-700 dark:text-slate-300">Entry Date</label>
                                    <input type="date" name="tanggal_masuk_pondok" id="tanggal_masuk_pondok"
                                        class="form-input w-full dark:form-input-dark @error('tanggal_masuk_pondok') border-red-500 @enderror"
                                        value="{{ old('tanggal_masuk_pondok') }}">
                                    @error('tanggal_masuk_pondok')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tinggi_badan" class="form-label text-slate-700 dark:text-slate-300">Height
                                        (cm)</label>
                                    <input type="number" name="tinggi_badan" id="tinggi_badan"
                                        class="form-input w-full dark:form-input-dark @error('tinggi_badan') border-red-500 @enderror"
                                        value="{{ old('tinggi_badan') }}" step="0.1">
                                    @error('tinggi_badan')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="berat_badan" class="form-label text-slate-700 dark:text-slate-300">Weight
                                        (kg)</label>
                                    <input type="number" name="berat_badan" id="berat_badan"
                                        class="form-input w-full dark:form-input-dark @error('berat_badan') border-red-500 @enderror"
                                        value="{{ old('berat_badan') }}" step="0.1">
                                    @error('berat_badan')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="anak_ke" class="form-label text-slate-700 dark:text-slate-300">Child
                                        Number</label>
                                    <input type="number" name="anak_ke" id="anak_ke"
                                        class="form-input w-full dark:form-input-dark @error('anak_ke') border-red-500 @enderror"
                                        value="{{ old('anak_ke') }}" min="1">
                                    @error('anak_ke')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="jumlah_anak" class="form-label text-slate-700 dark:text-slate-300">Number of
                                        Siblings</label>
                                    <input type="number" name="jumlah_anak" id="jumlah_anak"
                                        class="form-input w-full dark:form-input-dark @error('jumlah_anak') border-red-500 @enderror"
                                        value="{{ old('jumlah_anak') }}" min="1">
                                    @error('jumlah_anak')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status_anak" class="form-label text-slate-700 dark:text-slate-300">Child
                                        Status</label>
                                    <select name="status_anak" id="status_anak"
                                        class="form-input w-full dark:form-input-dark @error('status_anak') border-red-500 @enderror">
                                        <option value="">Select Status</option>
                                        <option value="Kandung" {{ old('status_anak') == 'Kandung' ? 'selected' : '' }}>
                                            Biological</option>
                                        <option value="Tiri" {{ old('status_anak') == 'Tiri' ? 'selected' : '' }}>Step Child
                                        </option>
                                        <option value="Angkat" {{ old('status_anak') == 'Angkat' ? 'selected' : '' }}>Adopted
                                        </option>
                                    </select>
                                    @error('status_anak')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Assistance Information Section -->
                    <div class="mb-8 form-section">
                        <div class="form-section-header px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-white">Social Assistance Information</h2>
                        </div>
                        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-b-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="no_kks" class="form-label text-slate-700 dark:text-slate-300">KKS
                                        Number</label>
                                    <input type="text" name="no_kks" id="no_kks"
                                        class="form-input w-full dark:form-input-dark @error('no_kks') border-red-500 @enderror"
                                        value="{{ old('no_kks') }}">
                                    @error('no_kks')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="penerima_kps" class="form-label text-slate-700 dark:text-slate-300">KPS
                                        Recipient</label>
                                    <select name="penerima_kps" id="penerima_kps"
                                        class="form-input w-full dark:form-input-dark @error('penerima_kps') border-red-500 @enderror">
                                        <option value="">Select</option>
                                        <option value="Ya" {{ old('penerima_kps') == 'Ya' ? 'selected' : '' }}>Yes</option>
                                        <option value="Tidak" {{ old('penerima_kps') == 'Tidak' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('penerima_kps')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="no_kps_container" style="display: none;">
                                    <label for="no_kps" class="form-label text-slate-700 dark:text-slate-300">KPS
                                        Number</label>
                                    <input type="text" name="no_kps" id="no_kps"
                                        class="form-input w-full dark:form-input-dark @error('no_kps') border-red-500 @enderror"
                                        value="{{ old('no_kps') }}">
                                    @error('no_kps')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_kip" class="form-label text-slate-700 dark:text-slate-300">KIP
                                        Number</label>
                                    <input type="text" name="no_kip" id="no_kip"
                                        class="form-input w-full dark:form-input-dark @error('no_kip') border-red-500 @enderror"
                                        value="{{ old('no_kip') }}">
                                    @error('no_kip')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="nama_di_kip" class="form-label text-slate-700 dark:text-slate-300">Name on
                                        KIP</label>
                                    <input type="text" name="nama_di_kip" id="nama_di_kip"
                                        class="form-input w-full dark:form-input-dark @error('nama_di_kip') border-red-500 @enderror"
                                        value="{{ old('nama_di_kip') }}">
                                    @error('nama_di_kip')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="terima_fisik" class="form-label text-slate-700 dark:text-slate-300">Received
                                        Physical Card</label>
                                    <select name="terima_fisik" id="terima_fisik"
                                        class="form-input w-full dark:form-input-dark @error('terima_fisik') border-red-500 @enderror">
                                        <option value="">Select</option>
                                        <option value="Ya" {{ old('terima_fisik') == 'Ya' ? 'selected' : '' }}>Yes</option>
                                        <option value="Tidak" {{ old('terima_fisik') == 'Tidak' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('terima_fisik')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="kartu_jaminan"
                                        class="form-label text-slate-700 dark:text-slate-300">Insurance Card</label>
                                    <select name="kartu_jaminan" id="kartu_jaminan"
                                        class="form-input w-full dark:form-input-dark @error('kartu_jaminan') border-red-500 @enderror">
                                        <option value="">Select</option>
                                        <option value="KIS" {{ old('kartu_jaminan') == 'KIS' ? 'selected' : '' }}>KIS</option>
                                        <option value="BPJS" {{ old('kartu_jaminan') == 'BPJS' ? 'selected' : '' }}>BPJS
                                        </option>
                                        <option value="Jamkesmas" {{ old('kartu_jaminan') == 'Jamkesmas' ? 'selected' : '' }}>
                                            Jamkesmas</option>
                                        <option value="Jamkesda" {{ old('kartu_jaminan') == 'Jamkesda' ? 'selected' : '' }}>
                                            Jamkesda</option>
                                    </select>
                                    @error('kartu_jaminan')
                                        <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mb-8 form-section">
                        <div class="form-section-header px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-white">Additional Notes</h2>
                        </div>
                        <div class="bg-white/50 dark:bg-slate-800/50 p-6 rounded-b-lg">
                            <div>
                                <label for="ket" class="form-label text-slate-700 dark:text-slate-300">Notes</label>
                                <textarea name="ket" id="ket" rows="3"
                                    class="form-input w-full dark:form-input-dark @error('ket') border-red-500 @enderror">{{ old('ket') }}</textarea>
                                @error('ket')
                                    <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 mt-8">
                        <a href="{{ route('student.index') }}" class="btn-secondary dark:btn-secondary-dark">
                            Cancel
                        </a>
                        <button type="submit" class="btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show/hide conditional fields
        document.addEventListener('DOMContentLoaded', function () {
            // Status Santri Other field
            const statusSantri = document.getElementById('status_santri');
            const statusSantriOtherContainer = document.getElementById('status_santri_other_container');

            statusSantri.addEventListener('change', function () {
                if (this.value === 'Lain-lain') {
                    statusSantriOtherContainer.style.display = 'block';
                } else {
                    statusSantriOtherContainer.style.display = 'none';
                }
            });

            // Trigger on page load if value is already set
            if (statusSantri.value === 'Lain-lain') {
                statusSantriOtherContainer.style.display = 'block';
            }

            // KPS Number field
            const penerimaKps = document.getElementById('penerima_kps');
            const noKpsContainer = document.getElementById('no_kps_container');

            penerimaKps.addEventListener('change', function () {
                if (this.value === 'Ya') {
                    noKpsContainer.style.display = 'block';
                } else {
                    noKpsContainer.style.display = 'none';
                }
            });

            // Trigger on page load if value is already set
            if (penerimaKps.value === 'Ya') {
                noKpsContainer.style.display = 'block';
            }

            // Form progress calculation
            const form = document.getElementById('student-form');
            const progressBar = document.getElementById('progress-bar-fill');
            const progressPercentage = document.getElementById('progress-percentage');
            const requiredFields = form.querySelectorAll('[required]');
            const totalRequiredFields = requiredFields.length;

            function updateProgress() {
                let filledFields = 0;
                requiredFields.forEach(field => {
                    if (field.value.trim() !== '') {
                        filledFields++;
                    }
                });

                const progress = Math.round((filledFields / totalRequiredFields) * 100);
                progressBar.style.width = `${progress}%`;
                progressPercentage.textContent = `${progress}%`;
            }

            // Update progress when any field changes
            form.addEventListener('input', updateProgress);

            // Initial progress calculation
            updateProgress();
        });
    </script>
@endsection
