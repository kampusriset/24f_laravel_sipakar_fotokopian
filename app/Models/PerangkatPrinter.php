<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatPrinter extends Model
{
    protected $table = 'perangkat_printer';
    protected $fillable = [
        'nama_printer', 
        'status'
    ];
}
