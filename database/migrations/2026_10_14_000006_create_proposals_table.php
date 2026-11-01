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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('kode_usulan', 50)->unique();
            $table->enum('jenis', ['penelitian', 'pengabdian']);
            $table->text('judul');
            $table->text('abstrak')->nullable();
            $table->foreignId('prodi_id')->constrained('prodis');
            $table->foreignId('user_id')->constrained('users'); // Ketua Peneliti / Pengusul
            $table->year('tahun_anggaran');
            $table->string('skema');
            $table->string('sumber_dana')->default('DIPA PKTJ');
            $table->decimal('total_anggaran', 15, 2)->default(0);
            $table->string('file_proposal')->nullable();
            $table->string('file_revisi')->nullable();
            $table->enum('status', [
                'draft',
                'diajukan',
                'verifikasi_administrasi',
                'sedang_direview',
                'revisi',
                'diterima',
                'ditolak'
            ])->default('draft');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
