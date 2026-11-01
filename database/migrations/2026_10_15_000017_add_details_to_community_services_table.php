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
        Schema::table('community_services', function (Blueprint $table) {
            $table->text('ringkasan')->nullable()->after('judul');
            $table->string('lokasi_kegiatan')->nullable()->after('mitra');
            $table->string('berkas_laporan')->nullable()->after('anggaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('community_services', function (Blueprint $table) {
            $table->dropColumn(['ringkasan', 'lokasi_kegiatan', 'berkas_laporan']);
        });
    }
};
