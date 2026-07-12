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
        Schema::create('detail_layanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('restrict');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('restrict');
            $table->integer('jumlah_halaman');
            $table->integer('harga_satuan');
            $table->integer('subtotal')->NotNull();
            
            // Kebutuhan Database AI 
            $table->string('file_dokumen', 255)->NotNull();
            $table->timestamp('waktu_deadline')->NotNull();
            $table->float('skor_prioritas')->nullable(); // Output dari rumus Fuzzy Tsukamoto
            $table->string('status_antrean', 50)->default('Menunggu'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_layanan');
    }
};
