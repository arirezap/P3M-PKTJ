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
        Schema::create('community_service_outputs', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['publikasi', 'ttg', 'modul', 'hki', 'desa_binaan']);
            $table->text('judul');
            $table->foreignId('community_service_id')->nullable()->constrained('community_services')->nullOnDelete();
            $table->foreignId('prodi_id')->constrained('prodis');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('pelaksana');
            $table->year('tahun');
            $table->string('mitra_sasaran')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('deskripsi_manfaat')->nullable();
            $table->string('indikator_keberhasilan')->nullable();
            $table->string('tingkat_kepuasan_mitra')->nullable();
            $table->string('link_dokumen')->nullable();
            $table->string('berkas_luaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_service_outputs');
    }
};
