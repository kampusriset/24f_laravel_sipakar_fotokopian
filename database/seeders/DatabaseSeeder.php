<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
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

        // DATA DUMMY
        // Data Layanan
        Layanan::create(['nama_layanan' => 'Fotocopy Hitam Putih', 'harga_per_lembar' => 500]);
        Layanan::create(['nama_layanan' => 'Print Warna', 'harga_per_lembar' => 1000]);
        Layanan::create(['nama_layanan' => 'Print Hitam Putih', 'harga_per_lembar' => 500]);
        Layanan::create(['nama_layanan' => 'Scan Dokumen', 'harga_per_lembar' => 1500]);
        Layanan::create(['nama_layanan' => 'Pengetikan Dokumen', 'harga_per_lembar' => 500]);

        // Data  Stok Barang
        StokBarang::create(['nama_barang' => 'Kertas HVS A4 70gr', 'kategori' => 'Kertas', 'jumlah_stok' => 2500, 'satuan' => 'Lembar']);
        StokBarang::create(['nama_barang' => 'Kertas HVS F4 70gr', 'kategori' => 'Kertas', 'jumlah_stok' => 1500, 'satuan' => 'Lembar']);
        StokBarang::create(['nama_barang' => 'Tinta Hitam', 'kategori' => 'Tinta', 'jumlah_stok' => 5, 'satuan' => 'Botol']);
        StokBarang::create(['nama_barang' => 'Mika Bening', 'kategori' => 'Perlengkapan Jilid', 'jumlah_stok' => 100, 'satuan' => 'Pcs']);
        StokBarang::create(['nama_barang' => 'Lakban Hitam', 'kategori' => 'Perlengkapan Jilid', 'jumlah_stok' => 10, 'satuan' => 'Roll']);

        // Data Perangkat Printer
        PerangkatPrinter::create(['nama_printer' => 'Printer Canon', 'status' => 'Aktif']);
        PerangkatPrinter::create(['nama_printer' => 'Printer Epson', 'status' => 'Maintenance']);
        PerangkatPrinter::create(['nama_printer' => 'Mesin Fotocopy', 'status' => 'Aktif']);

        // Data Pelaanggan
        Pelanggan::create(['nama' => 'Andika', 'no_hp' => '087961216', 'alamat' => 'Solo']);
        Pelanggan::create(['nama' => 'Nanda', 'no_hp' => '0879561802', 'alamat' => '']);
        Pelanggan::create(['nama' => 'Bayu', 'no_hp' => '08794515852', 'alamat' => 'Mojolaban']);
    }
}
