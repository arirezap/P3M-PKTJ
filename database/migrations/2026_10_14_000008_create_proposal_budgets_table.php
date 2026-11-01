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
        Schema::create('proposal_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained('proposals')->cascadeOnDelete();
            $table->enum('kategori_belanja', [
                'bahan_habis_pakai',
                'sewa_alat',
                'perjalanan_lapangan',
                'honorarium',
                'publikasi_diseminasi',
                'lainnya'
            ])->default('bahan_habis_pakai');
            $table->string('uraian');
            $table->decimal('volume', 10, 2)->default(1);
            $table->string('satuan', 50)->default('paket');
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_budgets');
    }
};
