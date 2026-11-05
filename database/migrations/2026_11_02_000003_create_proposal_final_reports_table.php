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
        Schema::create('proposal_final_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Atribut Berkas & Deskripsi
            $table->string('file_laporan_akhir');
            $table->string('file_revisi_laporan')->nullable();
            $table->text('ringkasan_hasil')->nullable();
            $table->text('perubahan_anggota')->nullable();

            // Realisasi Anggaran 100%
            $table->decimal('total_realisasi_anggaran', 15, 2)->default(0);
            $table->json('rincian_realisasi')->nullable();
            $table->string('file_bukti_spj')->nullable();

            // Capaian Luaran Akhir Definitif
            $table->json('capaian_luaran')->nullable();

            // Status Evaluasi Laporan Akhir
            $table->string('status_laporan', 50)->default('terkirim');
            $table->decimal('total_skor_laporan', 5, 2)->nullable();
            $table->text('catatan_reviewer')->nullable();
            $table->timestamp('tanggal_penyerahan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_final_reports');
    }
};
