<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'pelanggan_id', 
        'operator_id', 
        'tanggal'
    ];

    public function pelanggan() {
        return $this->pelangganTo(Pelanggan::class);
    }

    public function operator() {
        return $this->belongsTo(Operator::class);
    }
}
