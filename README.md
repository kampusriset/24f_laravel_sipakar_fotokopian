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
* [![Bootstrap][Bootstrap.com]][Bootstrap-url]
* [![MySQL][MySQL.com]][MySQL-url]

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

#1. Create Table Pelanggan
CREATE TABLE pelanggan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    no_hp VARCHAR(15) NULL,
    alamat TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

#2. Create Table Operator
CREATE TABLE operator (
    id BIGINT UMSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR (100) UNIQUE,
    password VARCHAR (255),
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
);

#3. Create Table Layanan
CREATE TABLE layanan (
    id BIGINT UMSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_layanan VARCHAR(255) NOT NULL,
    harga_per_lembar INT,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
);

#4. Create Table Perangkat Printer
CREATE TABLE perangkat_printer (
    id BIGINT UMSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_printer VARCHAR(255) NOT NULL,
    status enum ['Aktif', 'Perbaikan'],
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
);

#5. Create Table Transaksi
CREATE TABLE transaksi (
    id BIGINT UMSIGNED AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id BIGINT UNSIGNED NOT NULL,
    operator_id BIGINT UNSIGNED NOT NULL,
    tanggal TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    tota_harga INT NOT NULL,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,

    CONSTRAINT fk_transaksi_pelanggan
        FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE RESTRICT,
    CONSTRAINT fk_transaksi_operator
        FOREIGN KEY (opearator_id) REFERENCES operator(id) ON DELETE RESTRICT,
    
);

#6. Create Table Detail Layanan
CREATE TABLE detail_layanan (
    id BIGINT UMSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaksi_id BIGINT UNSIGNED NOT NULL,  
    layanan_id BIGINT UNSIGNED NOT NULL,
    jumlah_halaman INT NOT NULL,
    harga_satuan INT NOT NULL,
    subtotal INT NULL,

    file_dokumen VARCHAR (255) NOT NULL,
    waktu_deadline TIMESTAMP NOT NULL,
    skor_prioritas FLOAT NOT NULL,
    status_antrean varchar (50) NOT NULL DEFAULT 'Menunggu',
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,

    CONSTRAINT fk_detail_layanan_transaksi
        FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE RESTRICT,
    CONSTRAINT fk_detail_layanan_layanan
        FOREIGN KEY (layanan_id) REFERENCES layanan(id) ON DELETE RESTRICT,
);

#7. Create Table Pembayaran
CREATE TABLE pembayaran (
    id BIGINT UNSIGNED AUTO_INCREAMENT PRIMARY KEY,
    transaksi_id BIGINT UNSIGNED NOT NULL,
    total_bayar INT NOT NULL,
    metode VARCHAR (50) NOT NULL,
    tanggal_bayar timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,

    CONSTRAINT fk_pembayaran_transaksi
        FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE RESTRICT,
);

#8. Create Table Stok Barang
CREATE TABLE stok_barang (
    id BIGINT UNSIGNED AUTO_INCREAMENT PRIMARY KEY,
    nama_barang VARCHAR (255) NOT NULL,
    kategori VARCHAR (255) NOT NULL,
    jumlah_stok INT NOT NULL,
    satuan VARHAR (100) NOT NULL,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
);
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
