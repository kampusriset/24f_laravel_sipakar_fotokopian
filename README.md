<div align="center">
  <img src="https://cdn-icons-png.flaticon.com/512/3063/3063822.png" alt="Logo" width="100">

  <h1 align="center">Sistem Point of Sale (POS) Fotocopy & Print</h1>

  <p align="center">
    Aplikasi kasir modern untuk mempermudah manajemen transaksi, stok, dan pelaporan usaha fotokopi serta percetakan.
    <br />
    <br />
    <a href="#-fitur-utama"><strong>Jelajahi Fitur »</strong></a>
    <br />
    <br />
    <a href="#">Lihat Demo</a>
    ·
    <a href="#">Laporkan Bug</a>
    ·
    <a href="#">Minta Fitur Tambahan</a>
  </p>
</div>

---

## 🚀 Tentang Proyek
**Sistem Point of Sale (POS) Fotocopy & Print** dirancang khusus untuk mengatasi kompleksitas transaksi di usaha percetakan. Sistem ini tidak hanya mencatat penjualan, tetapi juga mengelola antrean cetak, menghitung harga berdasarkan jenis kertas/layanan, dan menyediakan *dashboard* laporan yang intuitif.

*Ps: Dibangun dengan dedikasi tinggi (dan banyak begadang sebelum masalah terpecahkan).* ☕

### 🛠️ Teknologi yang Digunakan
* [![Laravel][Laravel.com]][Laravel-url]
* [![Tailwind][Tailwind.com]][Tailwind-url]
* [![MySQL][MySQL.com]][MySQL-url]
* [![Filament][Filament.com]][Filament-url]

---

## ✨ Fitur Utama
* **Manajemen Transaksi Cepat:** Hitung otomatis biaya fotokopi, jilid, dan *print* warna/hitam-putih.
* **Manajemen Stok Barang:** Pantau stok kertas, tinta, dan alat tulis kantor (ATK).
* **Dashboard & Laporan:** Analitik pendapatan harian dan bulanan dengan tampilan modern.
* **Manajemen Pengguna (Role-based):** Akses untuk Admin.

---

### Databases

   ```bash
CREATE DATABASE sistem-pos-fotocopy-print

#Create Table Pelanggan
CREATE TABLE pelanggan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    no_hp VARCHAR(15) NULL,
    alamat TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

#Create Table Operator
#Create Table Layanan
#Create Table Perangkat Printer
#Create Table Transaksi 
#Create Table Detail Layanan
#Create Table Pembayaran
#Create Table Stok Barang
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
