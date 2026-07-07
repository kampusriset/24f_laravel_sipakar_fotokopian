<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerangkatPrinter extends Model
{
    use HasFactory;
    
    protected $table = 'perangkat_printer';
    protected $fillable = [
        'nama_printer', 
        'status'
    ];
}
