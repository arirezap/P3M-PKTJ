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
        Schema::create('researches', function (Blueprint $table) {
            $table->id();
            $table->text('judul');
            $table->foreignId('prodi_id')->constrained('prodis');
            $table->string('ketua_peneliti');
            $table->text('anggota')->nullable();
            $table->year('tahun');
            $table->string('skema')->nullable();
            $table->string('sumber_dana');
            $table->decimal('anggaran', 15, 2)->default(0);
            $table->enum('status', ['Berjalan', 'Selesai'])->default('Selesai');
            $table->timestamps();
        });

        Schema::create('community_services', function (Blueprint $table) {
            $table->id();
            $table->text('judul');
            $table->foreignId('prodi_id')->constrained('prodis');
            $table->string('ketua_pelaksana');
            $table->text('anggota')->nullable();
            $table->year('tahun');
            $table->string('skema')->nullable();
            $table->string('mitra')->nullable();
            $table->string('sumber_dana');
            $table->decimal('anggaran', 15, 2)->default(0);
            $table->enum('status', ['Berjalan', 'Selesai'])->default('Selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_services');
        Schema::dropIfExists('researches');
    }
};
