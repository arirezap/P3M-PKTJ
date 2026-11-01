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
        Schema::table('collaborations', function (Blueprint $table) {
            $table->string('judul_kerjasama')->after('nama_mitra')->nullable();
            $table->enum('kategori_mitra', ['pemerintah', 'bumn', 'industri', 'perguruan_tinggi', 'lainnya'])->default('industri')->after('jenis_kegiatan');
            $table->foreignId('prodi_id')->nullable()->after('kategori_mitra')->constrained('prodis')->nullOnDelete();
            $table->text('deskripsi')->nullable()->after('prodi_id');
            $table->date('tanggal_mulai')->nullable()->after('deskripsi');
            $table->date('tanggal_berakhir')->nullable()->after('tanggal_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collaborations', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn([
                'judul_kerjasama',
                'kategori_mitra',
                'prodi_id',
                'deskripsi',
                'tanggal_mulai',
                'tanggal_berakhir',
            ]);
        });
    }
};
