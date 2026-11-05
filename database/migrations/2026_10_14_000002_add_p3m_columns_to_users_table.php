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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'dosen', 'reviewer'])->default('dosen')->after('email');
            $table->string('nidn_nip', 30)->nullable()->after('role');
            $table->foreignId('prodi_id')->nullable()->after('nidn_nip')->constrained('prodis')->nullOnDelete();
            $table->string('no_telp', 20)->nullable()->after('prodi_id');
            $table->string('avatar')->nullable()->after('no_telp');
            $table->string('sinta_id', 50)->nullable()->after('avatar');
            $table->string('google_scholar')->nullable()->after('sinta_id');
            $table->string('scopus_id', 50)->nullable()->after('google_scholar');
            $table->string('keahlian')->nullable()->after('scopus_id');
            $table->boolean('status_aktif')->default(true)->after('keahlian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn([
                'role',
                'nidn_nip',
                'prodi_id',
                'no_telp',
                'avatar',
                'sinta_id',
                'google_scholar',
                'scopus_id',
                'keahlian',
                'status_aktif',
            ]);
        });
    }
};
