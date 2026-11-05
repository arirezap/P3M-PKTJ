<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('community_services', function (Blueprint $table) {
            $table->text('berkas_laporan')->nullable()->change();

            $table->string('waktu_pelaksanaan')->nullable()->after('lokasi_kegiatan');
            $table->string('jenis_diklat', 60)->nullable()->after('skema');
            $table->string('angkatan', 40)->nullable()->after('jenis_diklat');
            $table->string('kategori_peserta', 100)->nullable()->after('angkatan');
            $table->unsignedInteger('target_peserta')->nullable()->after('waktu_pelaksanaan');
            $table->unsignedInteger('realisasi_peserta')->nullable()->after('target_peserta');
            $table->unsignedInteger('peserta_l')->nullable()->after('realisasi_peserta');
            $table->unsignedInteger('peserta_p')->nullable()->after('peserta_l');
            $table->text('link_foto')->nullable()->after('berkas_laporan');
            $table->text('link_laporan')->nullable()->after('link_foto');
        });

        Schema::table('community_service_outputs', function (Blueprint $table) {
            $table->text('link_dokumen')->nullable()->change();
            $table->text('berkas_luaran')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('community_services', function (Blueprint $table) {
            $table->dropColumn([
                'waktu_pelaksanaan',
                'jenis_diklat',
                'angkatan',
                'kategori_peserta',
                'target_peserta',
                'realisasi_peserta',
                'peserta_l',
                'peserta_p',
                'link_foto',
                'link_laporan',
            ]);
        });
    }
};

