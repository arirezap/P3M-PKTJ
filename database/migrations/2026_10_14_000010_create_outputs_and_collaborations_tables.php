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
        Schema::create('outputs', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['publikasi', 'hki', 'produk']);
            $table->text('judul');
            $table->foreignId('prodi_id')->constrained('prodis');
            $table->string('author_inventor');
            $table->year('tahun');
            $table->string('nama_jurnal_penerbit')->nullable();
            $table->string('nomor_registrasi_hki')->nullable();
            $table->string('tingkat_kesiapan_terapan')->nullable(); // TKT 1-9
            $table->string('link_dokumen')->nullable();
            $table->timestamps();
        });

        Schema::create('collaborations', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mitra');
            $table->enum('jenis_kegiatan', ['penelitian', 'pengabdian', 'keduanya'])->default('penelitian');
            $table->string('nomor_mou_pks')->nullable();
            $table->year('tahun');
            $table->enum('status_kerjasama', ['aktif', 'selesai'])->default('aktif');
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborations');
        Schema::dropIfExists('outputs');
    }
};
