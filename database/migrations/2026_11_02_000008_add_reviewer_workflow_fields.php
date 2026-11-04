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
            $table->timestamp('disetujui_review_at')->nullable()->after('status_review');
            $table->date('batas_waktu_review')->nullable()->after('disetujui_review_at');
            $table->string('konfirmasi_hasil')->default('setuju')->after('persetujuan_komitmen');
        });

        Schema::table('proposal_final_reports', function (Blueprint $table) {
            $table->string('file_catatan_revisi')->nullable()->after('catatan_reviewer');
            $table->string('konfirmasi_hasil')->default('setuju')->after('file_catatan_revisi');
        });

        Schema::table('proposal_monevs', function (Blueprint $table) {
            $table->string('konfirmasi_hasil')->default('setuju')->after('catatan_reviewer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_reviews', function (Blueprint $table) {
            $table->dropColumn(['disetujui_review_at', 'batas_waktu_review', 'konfirmasi_hasil']);
        });

        Schema::table('proposal_final_reports', function (Blueprint $table) {
            $table->dropColumn(['file_catatan_revisi', 'konfirmasi_hasil']);
        });

        Schema::table('proposal_monevs', function (Blueprint $table) {
            $table->dropColumn(['konfirmasi_hasil']);
        });
    }
};

