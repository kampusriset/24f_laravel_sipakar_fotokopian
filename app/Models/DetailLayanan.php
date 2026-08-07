<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailLayanan extends Model
{
    protected $table = 'detail_layanan';
    protected $fillable = [
        'transaksi_id', 
        'layanan_id', 
        'jumlah_halaman', 
        'harga_satuan',
        'subtotal',
        'file_dokumen', 
        'waktu_deadline', 
        'skor_prioritas', 
        'tingkat_prioritas', 
        'status_antrean',
        'ukuran_kertas',
        'warna_cetak'
    ];

    public function layanan() {
        return $this->belongsTo(Layanan::class);
    }

    public function Transaksi() {
        return $this->belongsTo(Transaksi::class);
    }
}
