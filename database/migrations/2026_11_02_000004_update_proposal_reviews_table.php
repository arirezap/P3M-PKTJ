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
        Schema::table('proposal_reviews', function (Blueprint $table) {
            $table->string('file_catatan_revisi')->nullable()->after('catatan_reviewer');
            $table->json('detail_nilai')->nullable()->after('total_skor');
            $table->boolean('persetujuan_komitmen')->default(true)->after('status_review');
            $table->string('rekomendasi', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_reviews', function (Blueprint $table) {
            $table->dropColumn(['file_catatan_revisi', 'detail_nilai', 'persetujuan_komitmen']);
        });
    }
};

