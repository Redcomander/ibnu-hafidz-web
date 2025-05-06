<div class="steps-container" data-aos="fade-up" data-aos-delay="300">
    <div
        class="step {{ $currentStep == 'formulir' ? 'active' : '' }} {{ in_array($currentStep, ['verifikasi', 'pembayaran', 'selesai']) ? 'completed' : '' }}">
        1
        <span class="step-label">Formulir</span>
    </div>
    <div
        class="step {{ $currentStep == 'verifikasi' ? 'active' : '' }} {{ in_array($currentStep, ['pembayaran', 'selesai']) ? 'completed' : '' }}">
        2
        <span class="step-label">Verifikasi</span>
    </div>
    <div
        class="step {{ $currentStep == 'pembayaran' ? 'active' : '' }} {{ in_array($currentStep, ['selesai']) ? 'completed' : '' }}">
        3
        <span class="step-label">Pembayaran</span>
    </div>
    <div class="step {{ $currentStep == 'selesai' ? 'active' : '' }}">
        4
        <span class="step-label">Selesai</span>
    </div>
</div>

<section id="form-pendaftaran" class="py-16 md:py-24 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Formulir Pendaftaran</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Silakan lengkapi formulir pendaftaran di bawah ini dengan informasi yang benar
            </p>
        </div>

        <!-- Steps indicator -->
        @include('pendaftaran.components.steps-indicator', ['currentStep' => 'formulir'])

        <!-- Information Card -->
        <div class="info-card" data-aos="fade-up" data-aos-delay="400">
            <div class="info-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi Penting
            </div>
            <p class="info-card-text">
                • Pastikan semua data yang diisi sesuai dengan dokumen resmi (Akta Kelahiran, Kartu Keluarga, dll).
            </p>
            <p class="info-card-text">
                • Setelah mengisi formulir, Anda akan diarahkan ke tahap verifikasi dan pembayaran biaya pendaftaran.
            </p>
            <p class="info-card-text">
                • Jika ada pertanyaan, silakan hubungi kami di nomor WhatsApp: <span
                    class="font-semibold">0812-3456-7890</span>
            </p>
        </div>

        <!-- Registration Form -->
        <div class="form-container" data-aos="fade-up" data-aos-delay="500">
            <div class="form-header">
                <h3 class="text-xl font-bold">Data Calon Santri</h3>
            </div>
            <div class="form-body">
                <form id="formulir-form" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="nama" class="form-label required-field">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama lengkap"
                            required>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="tempat_lahir" class="form-label required-field">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input"
                                placeholder="Masukkan tempat lahir" required>
                        </div>

                        <div class="form-group">
                            <label for="tanggal_lahir" class="form-label required-field">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat" class="form-label required-field">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-textarea" placeholder="Masukkan alamat lengkap"
                            required></textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="nama_ayah" class="form-label required-field">Nama Ayah</label>
                            <input type="text" id="nama_ayah" name="nama_ayah" class="form-input"
                                placeholder="Masukkan nama ayah" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_ibu" class="form-label required-field">Nama Ibu</label>
                            <input type="text" id="nama_ibu" name="nama_ibu" class="form-input"
                                placeholder="Masukkan nama ibu" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="no_whatsapp" class="form-label required-field">No WhatsApp</label>
                        <input type="tel" id="no_whatsapp" name="no_whatsapp" class="form-input"
                            placeholder="Contoh: 08123456789" required>
                    </div>

                    <div class="form-group">
                        <label for="asal_sekolah" class="form-label required-field">Asal Sekolah</label>
                        <input type="text" id="asal_sekolah" name="asal_sekolah" class="form-input"
                            placeholder="Masukkan asal sekolah" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label required-field">Jenis Kelamin</label>
                        <div class="radio-group">
                            <div class="radio-option">
                                <input type="radio" id="laki_laki" name="jenis_kelamin" value="Laki-laki"
                                    class="radio-input" required>
                                <label for="laki_laki">Laki-laki</label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan"
                                    class="radio-input">
                                <label for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <button type="submit" class="submit-btn" id="submit-formulir">
                            <span class="btn-text">Kirim Pendaftaran</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Mengirim...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="form-pendaftaran" class="py-16 md:py-24 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Verifikasi Data</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Silakan periksa kembali data yang telah Anda masukkan
            </p>
        </div>

        <!-- Steps indicator -->
        @include('pendaftaran.components.steps-indicator', ['currentStep' => 'verifikasi'])

        <!-- Information Card -->
        <div class="info-card" data-aos="fade-up" data-aos-delay="400">
            <div class="info-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi Verifikasi
            </div>
            <p class="info-card-text">
                • Pastikan semua data yang Anda masukkan sudah benar sebelum melanjutkan ke tahap pembayaran.
            </p>
            <p class="info-card-text">
                • Jika ada kesalahan, silakan kembali ke halaman sebelumnya untuk memperbaiki data.
            </p>
        </div>

        <!-- Verification Form -->
        <div class="form-container" data-aos="fade-up" data-aos-delay="500">
            <div class="form-header">
                <h3 class="text-xl font-bold">Data Calon Santri</h3>
            </div>
            <div class="form-body">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Data Pribadi</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-500">Nama:</span>
                                <p class="font-medium" id="verifikasi-nama"></p>
                            </div>
                            <div>
                                <span class="text-gray-500">Tempat, Tanggal Lahir:</span>
                                <p class="font-medium" id="verifikasi-tempat-tanggal-lahir"></p>
                            </div>
                            <div>
                                <span class="text-gray-500">Jenis Kelamin:</span>
                                <p class="font-medium" id="verifikasi-jenis-kelamin"></p>
                            </div>
                            <div>
                                <span class="text-gray-500">Alamat:</span>
                                <p class="font-medium" id="verifikasi-alamat"></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-4">Data Orang Tua & Kontak</h4>
                        <div class="space-y-3">
                            <div>
                                <span class="text-gray-500">Nama Ayah:</span>
                                <p class="font-medium" id="verifikasi-nama-ayah"></p>
                            </div>
                            <div>
                                <span class="text-gray-500">Nama Ibu:</span>
                                <p class="font-medium" id="verifikasi-nama-ibu"></p>
                            </div>
                            <div>
                                <span class="text-gray-500">No. WhatsApp:</span>
                                <p class="font-medium" id="verifikasi-no-whatsapp"></p>
                            </div>
                            <div>
                                <span class="text-gray-500">Asal Sekolah:</span>
                                <p class="font-medium" id="verifikasi-asal-sekolah"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="flex items-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-gray-700">
                            Dengan melanjutkan, saya menyatakan bahwa data yang saya masukkan adalah benar dan dapat
                            dipertanggungjawabkan.
                        </p>
                    </div>

                    <div class="mt-8 text-center">
                        <button type="button" class="submit-btn" id="submit-verifikasi">
                            <span class="btn-text">Lanjutkan ke Pembayaran</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="form-pendaftaran" class="py-16 md:py-24 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Pembayaran Biaya
                Pendaftaran</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Silakan lakukan pembayaran biaya pendaftaran dan unggah bukti pembayaran
            </p>
        </div>

        <!-- Steps indicator -->
        @include('pendaftaran.components.steps-indicator', ['currentStep' => 'pembayaran'])

        <!-- Information Card -->
        <div class="info-card" data-aos="fade-up" data-aos-delay="400">
            <div class="info-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi Pembayaran
            </div>
            <p class="info-card-text">
                • Biaya pendaftaran sebesar <span class="font-semibold">Rp 500.000</span>
            </p>
            <p class="info-card-text">• Pembayaran dapat dilakukan melalui transfer bank ke rekening berikut:</p>
            <div class="bg-white p-4 rounded-lg mt-2 mb-2">
                <p class="font-medium">Bank BRI</p>
                <p class="font-semibold text-lg">1234-5678-9012-3456</p>
                <p>a.n. Yayasan Pondok Pesantren Ibnu Hafidz</p>
            </div>
            <p class="info-card-text">
                • Setelah melakukan pembayaran, silakan unggah bukti pembayaran di bawah ini.
            </p>
        </div>

        <!-- Payment Form -->
        <div class="form-container" data-aos="fade-up" data-aos-delay="500">
            <div class="form-header">
                <h3 class="text-xl font-bold">Unggah Bukti Pembayaran</h3>
            </div>
            <div class="form-body">
                <form id="pembayaran-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="calon_santri_id" name="calon_santri_id">

                    <div class="form-group">
                        <label for="payment_proof" class="form-label required-field">Bukti Pembayaran</label>
                        <div class="mt-2">
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition-colors">
                                <input type="file" id="payment_proof" name="payment_proof" accept="image/*"
                                    class="hidden" required>
                                <label for="payment_proof"
                                    class="cursor-pointer flex flex-col items-center justify-center">
                                    <div id="preview-container" class="mb-4 hidden">
                                        <img id="preview-image" src="/placeholder.svg" alt="Preview bukti pembayaran"
                                            class="max-h-64 rounded-lg">
                                    </div>
                                    <div id="upload-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700" id="upload-text">Klik untuk
                                        mengunggah bukti pembayaran</span>
                                    <span class="text-xs text-gray-500 mt-1">JPG, PNG, atau JPEG (Maks. 5MB)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <button type="submit" class="submit-btn" id="submit-pembayaran">
                            <span class="btn-text">Kirim Bukti Pembayaran</span>
                            <span class="btn-loading hidden">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Mengunggah...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section id="form-pendaftaran" class="py-16 md:py-24 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text" data-aos="fade-up">Pendaftaran Selesai</h2>
            <div class="w-24 h-1 bg-green-500 mx-auto mb-8" data-aos="fade-up" data-aos-delay="100"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
                Terima kasih telah mendaftar di Pondok Pesantren Ibnu Hafidz
            </p>
        </div>

        <!-- Steps indicator -->
        @include('pendaftaran.components.steps-indicator', ['currentStep' => 'selesai'])

        <!-- Completion Message -->
        <div class="form-container" data-aos="fade-up" data-aos-delay="500">
            <div class="form-body text-center py-12">
                <div class="flex justify-center mb-6">
                    <div class="bg-green-100 p-4 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-4">Pendaftaran Berhasil!</h3>

                <p class="text-gray-600 mb-8 max-w-lg mx-auto">
                    Pendaftaran Anda telah berhasil diproses. Kami akan menghubungi Anda melalui WhatsApp untuk
                    informasi
                    selanjutnya.
                </p>

                <div class="bg-gray-50 p-6 rounded-lg mb-8 max-w-md mx-auto">
                    <h4 class="font-semibold text-gray-700 mb-2">Nomor Pendaftaran:</h4>
                    <p class="text-2xl font-bold text-green-600 mb-4" id="nomor-pendaftaran"></p>
                    <p class="text-sm text-gray-500">Simpan nomor pendaftaran ini untuk keperluan selanjutnya</p>
                </div>

                <div class="space-y-4 text-left max-w-md mx-auto mb-8">
                    <h4 class="font-semibold text-gray-700">Langkah Selanjutnya:</h4>
                    <ol class="list-decimal list-inside space-y-2 text-gray-600">
                        <li>Tim kami akan memverifikasi pembayaran Anda (1-2 hari kerja)</li>
                        <li>Anda akan menerima jadwal tes seleksi melalui WhatsApp</li>
                        <li>Hadir pada jadwal tes seleksi yang telah ditentukan</li>
                        <li>Pengumuman hasil seleksi akan diinformasikan melalui WhatsApp</li>
                    </ol>
                </div>

                <div class="flex justify-center">
                    <a href="/"
                        class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-lg hover:bg-green-700 transition duration-300">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
