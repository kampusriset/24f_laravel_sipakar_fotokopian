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
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->integer('jumlah_halaman');
            $table->integer('subtotal')->nullable(); 
            
            // --- Kebutuhan Database AI ---
            $table->string('file_dokumen')->nullable();
            $table->timestamp('waktu_deadline')->nullable();
            $table->float('skor_prioritas')->nullable(); // Output dari rumus Fuzzy Tsukamoto
            $table->string('status_antrean', 20)->default('Menunggu'); 
            
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
