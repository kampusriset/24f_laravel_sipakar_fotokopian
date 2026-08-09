<div align="center">

  <!-- <img src="https://lakasir.com/assets/logo/image.png" alt="logo" width="200" height="auto" /> -->
  <h1>Point Of Sale FOTOCOPY & PRINT (1HZS FOTOCOPY & PRINT)</h1>
  
</div>
## Tentang Project:
1HZS Fotocopy & Print merupakan aplikasi berbasis web yang dibuat untuk membantu proses pengelolaan usaha fotocopy dan percetakan. Aplikasi ini berfungsi sebagai sistem kasir yang dapat digunakan untuk mencatat transaksi, mengelola antrean pesanan, menghitung harga layanan, serta melihat laporan melalui dashboard.
Selain digunakan untuk mengelola transaksi, aplikasi ini juga memiliki fitur AI yang digunakan untuk membantu menentukan prioritas pesanan. Metode yang digunakan adalah Fuzzy Logic Tsukamoto. Metode ini digunakan untuk menentukan pesanan mana yang perlu didahulukan berdasarkan beberapa kondisi dari setiap pesanan.
Aplikasi ini dibuat untuk membantu mengurangi masalah dalam menentukan urutan pengerjaan pesanan, terutama ketika terdapat banyak pesanan dengan jumlah halaman, jenis layanan, antrean, dan tenggat waktu yang berbeda.



## Latar Belakang:
Pada usaha fotocopy dan percetakan, kasir biasanya harus mengatur banyak pesanan dalam waktu yang bersamaan. Setiap pesanan juga memiliki kondisi yang berbeda, seperti jumlah halaman, jenis layanan, panjang antrean, dan batas waktu pengerjaan.
Jika urutan pengerjaan hanya ditentukan secara manual, ada kemungkinan pesanan yang memiliki tenggat waktu lebih dekat belum dikerjakan terlebih dahulu. Oleh karena itu, pada aplikasi ini dibuat fitur penentuan prioritas menggunakan Fuzzy Logic Tsukamoto.
Hasil dari proses tersebut berupa nilai prioritas yang dapat digunakan sebagai pertimbangan dalam menentukan urutan pengerjaan pesanan.

## Screenshots

<!-- <div style="display:inline-block" align="center">
  <img src="./readme/Screenshot/cashier-menu.png" alt="Product Detail" width="400" />
  &emsp;
  <img src="./readme/Screenshot/product-detail.png" alt="Product Detail" width="400"/>  
</div> -->
<!-- ![Lakasir Screenshot](./readme/Screenshot/product-detail.png) -->

# Fitur: 
### Sistem Kasir
1. Mencatat transaksi pelanggan
2. Mengelola data pesanan
3. Menghitung harga berdasarkan layanan
4. Mengelola jenis layanan fotocopy dan print
5. Mengelola data pelanggan
### Antrean Pesanan
1. Menampilkan daftar pesanan
2. Menampilkan informasi pesanan
3. Menampilkan tenggat waktu
4. Mengatur status pengerjaan
5. Menampilkan tingkat prioritas pesanan
### Penentuan Prioritas
1. Menggunakan metode Fuzzy Logic Tsukamoto
2. Mengolah beberapa variabel dari pesanan
3. Menghasilkan nilai prioritas
4. Mengelompokkan hasil menjadi Rendah, Normal, dan Tinggi
### Dashboard dan Laporan
1. Menampilkan informasi transaksi
2. Menampilkan data pesanan
3. Melihat kondisi antrean
4. Menampilkan laporan dari aktivitas sistem

## Metode AI:
Pada fitur penentuan prioritas digunakan metode Fuzzy Logic Tsukamoto. Metode ini digunakan untuk mendapatkan nilai prioritas berdasarkan beberapa variabel yang terdapat pada pesanan.
### Variabel yang digunakan antara lain:
1. Jumlah halaman
2. Tenggat waktu
3. Jenis layanan
4. Panjang antrean
5. Setelah proses perhitungan dilakukan, sistem menghasilkan nilai prioritas yang kemudian digunakan untuk menentukan kategori pesanan.
Kategori yang digunakan adalah:

### Nilai Prioritas
Rendah : 0 - 50  
Normal  : 25 - 75 
Tinggi    : 50 - 100 

Nilai dan aturan fuzzy yang digunakan dalam sistem disesuaikan dengan kebutuhan dari permasalahan yang ingin diselesaikan.

## Teknologi yang Digunakan:
1. PHP 8.3.30
2. MySQL 8.4.3
3. Laravel 13
4. Filament 5
5. Fuzzy Logic Tsukamoto
6. Python 3.13.0

## Instalasi: 

Sebelum menjalankan project, pastikan sudah terinstall:
1. PHP 8.3 atau lebih baru
2. Composer
3. MySQL
4. Python
5. Git
### 1. Clone Repository
git clone https://github.com/kampusriset/24f_laravel_sipakar_fotokopian.git
Masuk ke folder project:
cd 24f_laravel_sipakar_fotokopian 
### 2. Install Dependency
composer install
### 3. Konfigurasi Environment
Salin file .env.example menjadi .env.
Windows:
copy .env.example .env
Linux/macOS:
cp .env.example .env
Kemudian sesuaikan konfigurasi database pada file .env.
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
### 4. Generate Application Key
php artisan key:generate
### 5. Menjalankan Migration
php artisan migrate
php artisan db:seed
atau: php artisan migrate --seed
### 6. Menjalankan Project
php artisan serve
### Kemudian buka:
http://127.0.0.1:8000

## Database:
```
CREATE DATABASE sistem_pos_fotocopy_print

User 
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    google_id VARCHAR(255) NULL DEFAULT NULL,
    role ENUM('admin', 'kasir') NOT NULL DEFAULT 'kasir',
    remember_token VARCHAR(100) NULL DEFAULT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

Sessions
CREATE TABLE sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL DEFAULT NULL,
    user_agent TEXT NULL DEFAULT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,    

    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
);

Operator
CREATE TABLE operator (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id)
);

Layanan
CREATE TABLE layanan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_layanan VARCHAR(255) NOT NULL,
    harga_per_lembar INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

Stok_barang
CREATE TABLE stok_barang (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(255) NOT NULL,
    kategori VARCHAR(255) NOT NULL,
    jumlah_stok INT NOT NULL,
    satuan VARCHAR(100) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);

Transaksi
CREATE TABLE transaksi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id BIGINT UNSIGNED NOT NULL,
    operator_id BIGINT UNSIGNED NOT NULL,
    total_harga INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE CASCADE,
    FOREIGN KEY (operator_id) REFERENCES operator(id) ON DELETE CASCADE
);

Detail Layanan
CREATE TABLE detail_layanan (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaksi_id BIGINT UNSIGNED NOT NULL,
    layanan_id BIGINT UNSIGNED NOT NULL,
    jumlah_halaman INT NOT NULL,
    harga_satuan INT NOT NULL,
    subtotal INT NOT NULL,
    ukuran_kertas VARCHAR(255) NULL,
    warna_cetak VARCHAR(255) NULL,
    file_dokumen VARCHAR(255) NOT NULL,
    waktu_deadline TIMESTAMP NOT NULL,
    skor_prioritas FLOAT NULL DEFAULT NULL,
    tingkat_prioritas VARCHAR(255) NOT NULL DEFAULT 'Normal',
    status_antrean VARCHAR(50) NOT NULL DEFAULT 'Menunggu',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (layanan_id) REFERENCES layanan(id) ON DELETE CASCADE
);

Pembayaran
CREATE TABLE pembayaran (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    transaksi_id BIGINT UNSIGNED NOT NULL,
    total_bayar INT NOT NULL,
    metode VARCHAR(50) NOT NULL,
    tanggal_bayar TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE
);

Perangkat Keras
CREATE TABLE perangkat_printer (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_printer VARCHAR(255) NOT NULL,
    status ENUM('Aktif', 'Perbaikan') NOT NULL DEFAULT 'Aktif',
    created_at TIMESTAMP NULL DEFAULT NULL,
    updated_at TIMESTAMP NULL DEFAULT NULL
);
```



## Alur Sistem
Secara umum proses sistem berjalan seperti berikut:
Pelanggan
    |
    v
Input Pesanan
    |
    v
Sistem Kasir
    |
    +----------------------+
    |                      |
    v                      v
Perhitungan Harga     Fuzzy Tsukamoto
                           |
                           v
                    Nilai Prioritas
                           |
                           v
                    Kategori Prioritas
                           |
                           v
                    Antrean Pesanan
                           |
                           v
                     Proses Cetak
                           |
                           v
                         Selesai

## Screenshot
CONTOH: ![Dashboard](docs/screenshots/dashboard.png)

## Tujuan
Project ini dibuat untuk menerapkan sistem informasi berbasis web pada usaha fotocopy dan percetakan serta menerapkan metode Fuzzy Logic Tsukamoto untuk membantu menentukan prioritas pengerjaan pesanan.
Dengan adanya sistem ini, proses pencatatan transaksi dan pengelolaan antrean diharapkan dapat dilakukan dengan lebih teratur. Fitur penentuan prioritas juga dapat membantu kasir atau operator dalam menentukan pesanan yang perlu dikerjakan terlebih dahulu.

## Status Project
Project ini dibuat untuk keperluan akademik dan masih dapat dikembangkan lebih lanjut.
Beberapa pengembangan yang dapat dilakukan antara lain:
1. Integrasi notifikasi WhatsApp
2. Manajemen stok
3. Riwayat pelanggan
4. Integrasi pembayaran digital
5. Pengembangan laporan keuangan
6. Pengembangan dan pengujian metode penentuan prioritas

## License
Project ini dibuat untuk keperluan akademik dan pembelajaran.
© 2026 1HZS Fotocopy & Print
