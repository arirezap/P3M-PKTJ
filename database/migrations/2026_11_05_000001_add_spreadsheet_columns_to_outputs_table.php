<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outputs', function (Blueprint $table) {
            $table->text('author_inventor')->change();
            $table->text('nama_jurnal_penerbit')->nullable()->change();
            $table->text('link_dokumen')->nullable()->change();

            $table->string('penulis_korespondensi')->nullable()->after('author_inventor');
            $table->text('anggota_dosen')->nullable()->after('penulis_korespondensi');
            $table->text('anggota_taruna')->nullable()->after('anggota_dosen');
            $table->string('indeksasi_nasional')->nullable()->after('nama_jurnal_penerbit');
            $table->string('indeksasi_internasional')->nullable()->after('indeksasi_nasional');
            $table->string('kategori_kpi')->nullable()->after('indeksasi_internasional');
            $table->string('tanggal_publikasi')->nullable()->after('kategori_kpi');
            $table->string('status_publikasi', 30)->default('terbit')->after('tanggal_publikasi');
            $table->string('isbn', 50)->nullable()->after('nomor_registrasi_hki');
            $table->string('tempat_terbit')->nullable()->after('isbn');
            $table->unsignedInteger('jumlah_halaman')->nullable()->after('tempat_terbit');
            $table->string('jenis_ciptaan')->nullable()->after('jumlah_halaman');
            $table->string('pemegang_hki')->nullable()->after('jenis_ciptaan');
            $table->string('tanggal_permohonan')->nullable()->after('pemegang_hki');
            $table->string('tanggal_diumumkan')->nullable()->after('tanggal_permohonan');
        });
    }

    public function down(): void
    {
        Schema::table('outputs', function (Blueprint $table) {
            $table->dropColumn([
                'penulis_korespondensi',
                'anggota_dosen',
                'anggota_taruna',
                'indeksasi_nasional',
                'indeksasi_internasional',
                'kategori_kpi',
                'tanggal_publikasi',
                'status_publikasi',
                'isbn',
                'tempat_terbit',
                'jumlah_halaman',
                'jenis_ciptaan',
                'pemegang_hki',
                'tanggal_permohonan',
                'tanggal_diumumkan',
            ]);
        });
    }
};

