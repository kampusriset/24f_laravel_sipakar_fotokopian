<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facedes\Hash;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Layanan;
use App\Models\Operator;
use App\Models\Pelanggan;
use App\Models\PerangkatPrinter;
use App\Models\StokBarang;


class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Operator::create([
            'nama' => 'Admin',
            'email' => 'admin@fotcop.com',
            'password' => Hash::make('admin123')
        ]);

        // Data Layanan
        Layanan::create(['nama_layanan' => 'Fotocopy Hitam Putih', 'harga_per_lembar' => 500]);
        Layanan::create(['nama_layanan' => 'Print Warna', 'harga_per_lembar' => 1000]);
        Layanan::create(['nama_layanan' => 'Print Hitam Putih', 'harga_per_lembar' => 500]);
        Layanan::create(['nama_layanan' => 'Scan Dokumen', 'harga_per_lembar' => 1500]);
        Layanan::create(['nama_layanan' => 'Pengetikan Dokumen', 'harga_per_lembar' => 500]);

        // Data 
    }
}
