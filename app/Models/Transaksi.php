<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'pelanggan_id', 
        'operator_id', 
        // 'tanggal',
        'total_harga'
    ];

    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function operator() {
        return $this->belongsTo(Operator::class);
    }

    public function detail_layanan() { 
        return $this->hasOne(DetailLayanan::class, 'transaksi_id'); 
    }

    public function pembayaran() {
        return $this->hasOne(Pembayaran::class, 'transaksi_id');
    }
}