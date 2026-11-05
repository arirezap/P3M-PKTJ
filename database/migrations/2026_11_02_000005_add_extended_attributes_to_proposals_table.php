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
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('kata_kunci')->nullable()->after('abstrak');
            $table->string('bidang_fokus')->nullable()->after('skema');
            $table->unsignedTinyInteger('lama_kegiatan_tahun')->default(1)->after('tahun_anggaran');
            $table->string('topik_kegiatan')->nullable()->after('bidang_fokus');
            $table->string('lokasi_kegiatan')->nullable()->after('topik_kegiatan');
            $table->string('bank_nama', 100)->nullable()->after('total_anggaran');
            $table->string('bank_rekening', 50)->nullable()->after('bank_nama');
            $table->string('bank_pemilik', 150)->nullable()->after('bank_rekening');
            $table->string('nama_mitra')->nullable()->after('file_revisi');
            $table->string('kontribusi_mitra')->nullable()->after('nama_mitra');
            $table->string('file_mitra')->nullable()->after('kontribusi_mitra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn([
                'kata_kunci',
                'bidang_fokus',
                'lama_kegiatan_tahun',
                'topik_kegiatan',
                'lokasi_kegiatan',
                'bank_nama',
                'bank_rekening',
                'bank_pemilik',
                'nama_mitra',
                'kontribusi_mitra',
                'file_mitra',
            ]);
        });
    }
};
