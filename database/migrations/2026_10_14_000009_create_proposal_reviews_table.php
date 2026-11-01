<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposal_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users');
            $table->decimal('skor_urgensi', 5, 2)->nullable();
            $table->decimal('skor_metodologi', 5, 2)->nullable();
            $table->decimal('skor_kelayakan_rab', 5, 2)->nullable();
            $table->decimal('skor_luaran', 5, 2)->nullable();
            $table->decimal('total_skor', 5, 2)->nullable();
            $table->text('catatan_reviewer')->nullable();
            $table->enum('rekomendasi', ['diterima', 'diterima_dengan_revisi', 'ditolak'])->nullable();
            $table->enum('status_review', ['menunggu', 'selesai'])->default('menunggu');
            $table->timestamp('tanggal_review')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_reviews');
    }
};
