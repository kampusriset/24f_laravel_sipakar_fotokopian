<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillabel = [
        'nama', 
        'no_hp', 
        'alamat'
    ];
}
