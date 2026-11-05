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
            $table->json('luaran_target')->nullable()->after('file_mitra');
            $table->json('jadwal_kegiatan')->nullable()->after('luaran_target');
            $table->decimal('dana_mitra', 15, 2)->nullable()->after('kontribusi_mitra');
            $table->decimal('dana_tambahan', 15, 2)->nullable()->after('dana_mitra');
            $table->string('nama_berkas_proposal')->nullable()->after('file_proposal');
            $table->boolean('persetujuan_konfirmasi')->default(false)->after('status');
        });

        Schema::table('proposal_budgets', function (Blueprint $table) {
            $table->unsignedTinyInteger('tahun_ke')->default(1)->after('kategori_belanja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn([
                'luaran_target',
                'jadwal_kegiatan',
                'dana_mitra',
                'dana_tambahan',
                'nama_berkas_proposal',
                'persetujuan_konfirmasi',
            ]);
        });

        Schema::table('proposal_budgets', function (Blueprint $table) {
            $table->dropColumn('tahun_ke');
        });
    }
};
