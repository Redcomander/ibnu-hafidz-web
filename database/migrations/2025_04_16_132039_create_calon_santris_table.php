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

            // Updated status enum with new values for the new flow
            $table->enum('status', ['formulir', 'checking', 'pembayaran', 'berhasil'])->default('formulir');

            // New fields for the updated registration flow
            $table->enum('payment_type', ['Lunas', 'Cicilan'])->nullable();
            $table->string('nomor_pendaftaran')->nullable();

            // Keeping these fields for backward compatibility and admin functionality
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
