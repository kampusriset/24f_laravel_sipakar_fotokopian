<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    protected $table = 'stok_barang';
    
    protected $fillable = [
        'nama_barang', 
        'kategori', 
        'jumlah_stok', 
        'satuan'
    ];
}
