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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            // Article relationship
            $table->foreignId('article_id')
                ->constrained()
                ->onDelete('cascade');

            // Comment hierarchy (for replies)
            $table->foreignId('parent_id')
                ->nullable()
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');

            // Google authenticated commenter information
            $table->string('name');
            $table->string('email');
            $table->string('profile_picture')->nullable();
            $table->string('google_id')->nullable();

            // Comment content
            $table->text('body');

            // Additional fields
            $table->boolean('is_approved')->default(false);
            $table->integer('likes_count')->default(0);

            $table->timestamps();

            // Indexes for better performance
            $table->index('article_id');
            $table->index('parent_id');
            $table->index('google_id');
            $table->index('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
