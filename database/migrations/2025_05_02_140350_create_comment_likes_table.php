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
        Schema::create('comment_likes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('comment_id')
                ->constrained()
                ->onDelete('cascade');

            // Store either Google ID or IP address for guest likes
            $table->string('google_id')->nullable();
            $table->string('ip_address')->nullable();

            $table->timestamps();

            // Prevent duplicate likes
            $table->unique(['comment_id', 'google_id']);
            $table->unique(['comment_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_likes');
    }
};
