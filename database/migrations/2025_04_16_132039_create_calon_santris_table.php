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
        Schema::create('calon_santris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('no_whatsapp');
            $table->string('asal_sekolah');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);

            $table->enum('status', ['Formulir', 'Verifikasi', 'Pembayaran', 'Selesai'])->default('Formulir');
            $table->unsignedBigInteger('verified_by_id')->nullable(); // internal reference (optional)
            $table->string('verified_by_name')->nullable();           // keeps name even if user is deleted
            $table->string('payment_proof')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_santris');
    }
};
