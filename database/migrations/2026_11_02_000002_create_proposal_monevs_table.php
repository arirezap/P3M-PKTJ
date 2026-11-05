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
        Schema::create('proposal_monevs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // 7 Pertanyaan Pilihan Ganda (Capaian Kinerja)
            $table->string('capaian_penelitian', 50);
            $table->string('publikasi_ilmiah', 50);
            $table->string('pemakalah_ilmiah', 50);
            $table->string('hki', 50);
            $table->string('teknologi_tepat_guna', 50);
            $table->string('produk_purwarupa', 50);
            $table->string('buku_ajar', 50);

            // 7 Pertanyaan Essai (Evaluasi Pelaksanaan)
            $table->text('kegiatan_terlaksana');
            $table->text('kesesuaian_waktu');
            $table->text('kesesuaian_metode');
            $table->text('kesesuaian_personalia');
            $table->text('kesesuaian_anggaran');
            $table->text('kesesuaian_sarpras');
            $table->text('kesesuaian_target');

            // Lampiran & Status Evaluasi
            $table->string('file_bukti_luaran')->nullable();
            $table->string('status_monev', 50)->default('terkirim');
            $table->decimal('total_skor_monev', 5, 2)->nullable();
            $table->text('catatan_reviewer')->nullable();
            $table->timestamp('tanggal_monev')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_monevs');
    }
};
