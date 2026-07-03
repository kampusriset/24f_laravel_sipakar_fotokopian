<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $fillable = [
        'transaksi_id', 
        'total_bayar', 
        'metode', 
        'tanggal_bayar'
    ];
}
