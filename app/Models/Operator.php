<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\foundation\Auth\User as Authenticatable;

// class Operator extends Authenticatable
class Operator extends Model
{
    protected $table = 'operator';
    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}