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
        Schema::table('proposal_members', function (Blueprint $table) {
            $table->string('kategori_anggota', 30)->default('internal')->after('peran');
            $table->string('asal_instansi')->nullable()->after('kategori_anggota');
            $table->string('negara', 100)->default('Indonesia')->after('asal_instansi');
            $table->string('peran', 50)->default('dosen_anggota')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_members', function (Blueprint $table) {
            $table->dropColumn(['kategori_anggota', 'asal_instansi', 'negara']);
        });
    }
};

