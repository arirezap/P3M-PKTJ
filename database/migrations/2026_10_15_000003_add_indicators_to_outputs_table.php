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
        Schema::table('outputs', function (Blueprint $table) {
            $table->string('lisensi')->nullable()->after('tingkat_kesiapan_terapan');
            $table->string('fase_roadmap')->nullable()->after('lisensi');
            $table->text('deskripsi_kemanfaatan')->nullable()->after('fase_roadmap');
            $table->string('mitra_kerjasama')->nullable()->after('deskripsi_kemanfaatan');
            $table->string('sumber_dana')->nullable()->after('mitra_kerjasama');
            $table->decimal('realisasi_dana', 15, 2)->default(0)->nullable()->after('sumber_dana');
            $table->string('berkas_luaran')->nullable()->after('link_dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outputs', function (Blueprint $table) {
            $table->dropColumn([
                'lisensi',
                'fase_roadmap',
                'deskripsi_kemanfaatan',
                'mitra_kerjasama',
                'sumber_dana',
                'realisasi_dana',
                'berkas_luaran',
            ]);
        });
    }
};
