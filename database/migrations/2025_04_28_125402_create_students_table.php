<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nip')->nullable();
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('no_kk')->nullable();
            $table->string('nik')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_akte')->nullable();
            $table->string('agama')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->year('tahun_lahir_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->year('tahun_lulus_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->year('tahun_lahir_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->year('tahun_lulus_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_hp_telpon')->nullable();
            $table->string('rombel_ads')->nullable();
            $table->string('rombel_kelas')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->year('tahun_kelulusan')->nullable();
            $table->string('no_peserta_un')->nullable();
            $table->string('no_seri_ijazah')->nullable();
            $table->string('no_skhun')->nullable();
            $table->enum('status_santri', ['Baru', 'Pindahan', 'Lain-lain'])->nullable(); // Enum with 3 possible values
            $table->text('status_santri_other')->nullable(); // Text field for custom input when 'Lain-lain' is chosen
            $table->date('tanggal_masuk_pondok')->nullable();
            $table->float('tinggi_badan')->nullable();
            $table->float('berat_badan')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_anak')->nullable();
            $table->string('status_anak')->nullable();
            $table->string('no_kks')->nullable();
            $table->enum('penerima_kps', ['Ya', 'Tidak'])->nullable();
            $table->string('no_kps')->nullable();
            $table->string('no_kip')->nullable();
            $table->string('nama_di_kip')->nullable();
            $table->enum('terima_fisik', ['Ya', 'Tidak'])->nullable();
            $table->enum('kartu_jaminan', ['KIS', 'BPJS', 'Jamkesmas', 'Jamkesda'])->nullable();
            $table->string('email')->nullable();
            $table->string('jenis_pendaftaran')->nullable();
            $table->text('ket')->nullable();
            $table->string('kelas_lama')->nullable();
            $table->string('anbk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
