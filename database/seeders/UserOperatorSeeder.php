<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Operator;
use Illuminate\Support\Facades\Hash;

class UserOperatorSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        $adminUser = User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), 
            'role' => 'admin',
        ]);

        // Jembatani ke tabel Operator untuk Admin
        Operator::create([
            'user_id' => $adminUser->id,
            'name' => 'Admin',
        ]);

        // Akun Kasir 
        $kasirUser = User::create([
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
        ]);

        Operator::create([
            'user_id' => $kasirUser->id,
            'name' => 'Roni',
        ]);
    }
}