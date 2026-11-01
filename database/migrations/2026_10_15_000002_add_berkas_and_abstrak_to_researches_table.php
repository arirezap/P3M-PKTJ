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
        Schema::table('researches', function (Blueprint $table) {
            $table->text('abstrak')->nullable()->after('judul');
            $table->string('berkas_laporan')->nullable()->after('anggaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('researches', function (Blueprint $table) {
            $table->dropColumn(['abstrak', 'berkas_laporan']);
        });
    }
};
