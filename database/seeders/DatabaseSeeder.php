<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Layanan;
use App\Models\Operator;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\StokBarang;
use App\Models\Pembayaran;
use App\Models\DetailLayanan;
use App\Models\PerangkatPrinter;


class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserOperatorSeeder::class,
        ]);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // DATA DUMMY
        // User::create([
        //     'name' => 'Owner',
        //     'email' => 'admin@kasir.com',
        //     'password' => Hash::make('rahasia123')
        // ]);

         // Data Pelanggan
        // $pelanggan = Pelanggan::create(['nama' => 'Nindi','no_hp' => '0879845215','alamat' => null]);
        // Pelanggan::create(['nama' => 'Andika', 'no_hp' => '087961216', 'alamat' => 'Solo']);
        // Pelanggan::create(['nama' => 'Nanda', 'no_hp' => '0879561802', 'alamat' => '']);
        // Pelanggan::create(['nama' => 'Bayu', 'no_hp' => '08794515852', 'alamat' => 'Mojolaban']);

        // Data Operator
        // Operator::create([
        //     'nama' => 'Admin',
        //     'email' => 'admin@fotcop.com',
        //     'password' => \Illuminate\Support\Facades\Hash::make('admin123')
        // ]);

        // Data Transaksi
        // $transaksi = Transaksi::create([
        //     'pelanggan_id' => $pelanggan->id,
        //     'operator_id' => 1,
        //     'tanggal' => Carbon::now(),
        //     'total_harga' => 52500
        // ]);

        // Data Pembayaran
        // Pembayaran::create([
        //     'transaksi_id' => $transaksi->id,
        //     'total_bayar' => 52500,
        //     'metode' => 'Cash',
        //     'tanggal_bayar' => Carbon::now()
        // ]);

        // Data Layanan
        // Layanan::create(['nama_layanan' => 'Fotocopy Hitam Putih', 'harga_per_lembar' => 500]);
        // Layanan::create(['nama_layanan' => 'Print Warna', 'harga_per_lembar' => 1000]);
        // Layanan::create(['nama_layanan' => 'Print Hitam Putih', 'harga_per_lembar' => 500]);
        // Layanan::create(['nama_layanan' => 'Scan Dokumen', 'harga_per_lembar' => 1500]);
        // Layanan::create(['nama_layanan' => 'Pengetikan Dokumen', 'harga_per_lembar' => 500]);

        // Data  Stok Barang
        // StokBarang::create(['nama_barang' => 'Kertas HVS A4 70gr', 'kategori' => 'Kertas', 'jumlah_stok' => 2500, 'satuan' => 'Lembar']);
        // StokBarang::create(['nama_barang' => 'Kertas HVS F4 70gr', 'kategori' => 'Kertas', 'jumlah_stok' => 1500, 'satuan' => 'Lembar']);
        // StokBarang::create(['nama_barang' => 'Tinta Hitam', 'kategori' => 'Tinta', 'jumlah_stok' => 5, 'satuan' => 'Botol']);
        // StokBarang::create(['nama_barang' => 'Mika Bening', 'kategori' => 'Perlengkapan Jilid', 'jumlah_stok' => 100, 'satuan' => 'Pcs']);
        // StokBarang::create(['nama_barang' => 'Lakban Hitam', 'kategori' => 'Perlengkapan Jilid', 'jumlah_stok' => 10, 'satuan' => 'Roll']);

        // Data Perangkat Printer
        // PerangkatPrinter::create(['nama_printer' => 'Printer Canon', 'status' => 'Aktif']);
        // PerangkatPrinter::create(['nama_printer' => 'Printer Epson', 'status' => 'Perbaikan']);
        // PerangkatPrinter::create(['nama_printer' => 'Mesin Fotocopy', 'status' => 'Aktif']);

        // Data Detail Layanan
        // DetailLayanan::create([
        //     'transaksi_id' => $transaksi->id,
        //     'layanan_id' => 1,
        //     'jumlah_halaman' => 100,
        //     'harga_satuan' => 500,
        //     'subtotal' => 50000,
        //     'file_dokumen' => 'tugas_pekan1.pdf',
        //     'waktu_deadline' => Carbon::now()->addHours(2),
        //     'status_antrean' => 'Menunggu',
        // ]);

        // Data Detail Layanan 2
        // DetailLayanan::create([
        //     'transaksi_id' => $transaksi->id,
        //     'layanan_id' => 2,
        //     'jumlah_halaman' => 5,
        //     'harga_satuan' => 1000,
        //     'subtotal' => 50000,
        //     'file_dokumen' => 'tugas_akhir.pdf',
        //     'waktu_deadline' => Carbon::now()->addMinutes(30),
        //     'status_antrean' => 'Menunggu',
        // ]);
    }
}
