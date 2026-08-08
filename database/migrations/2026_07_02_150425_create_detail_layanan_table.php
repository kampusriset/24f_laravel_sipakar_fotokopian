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
            $table->integer('harga_satuan');
            $table->integer('subtotal')->NotNull();
            $table->string('ukuran_kertas', 50)->nullable();
            $table->string('warna_cetak', 50)->nullable();
            
            $table->string('file_dokumen', 255)->NotNull();
            $table->timestamp('waktu_deadline')->NotNull();
            $table->float('skor_prioritas')->nullable(); 
            $table->string('tingkat_prioritas')->default('Normal');
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
