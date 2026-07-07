<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\foundation\Auth\User as Authenticatable;

class Operator extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'operator';
    protected $fillable = [
        'nama',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
