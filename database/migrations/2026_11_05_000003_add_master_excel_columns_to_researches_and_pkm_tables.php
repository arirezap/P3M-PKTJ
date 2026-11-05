<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('researches', function (Blueprint $table) {
            $table->string('kode_penelitian', 50)->nullable()->after('id');
            $table->text('target_luaran')->nullable()->after('berkas_laporan');
            $table->string('relevansi_prodi', 255)->nullable()->after('status');
        });

        Schema::table('community_services', function (Blueprint $table) {
            $table->string('kode_pkm', 50)->nullable()->after('id');
            $table->string('relevansi_prodi', 255)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('researches', function (Blueprint $table) {
            $table->dropColumn(['kode_penelitian', 'target_luaran', 'relevansi_prodi']);
        });

        Schema::table('community_services', function (Blueprint $table) {
            $table->dropColumn(['kode_pkm', 'relevansi_prodi']);
        });
    }
};

