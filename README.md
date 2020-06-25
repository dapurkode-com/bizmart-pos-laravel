# Bizmart Point of Sales (Laravel Based)

Aplikasi ini merupakan aplikasi point of sales (aplikasi kasir) yang menggunakan framework [Laravel](https://laravel.com/). Fitur dasar dari aplikasi ini adalah :

-   Catatan Penjualan
-   Catatan Pembelian
-   CRUD Member
-   CRUD Barang
-   CRUD Suplier
-   CRUD Akun
-   Stock Opname
-   Pencatatan Arus Stok
-   Pencatatan Arus Kas (coming soon)

## Requirement Aplikasi

Pastikan Anda sudah menginstall :

-   [PHP ( _min 7.4.\*_ )](https://www.php.net/downloads.php)
-   [MySQL Server](https://dev.mysql.com/downloads/mysql/)
-   [Composer](https://getcomposer.org/download/)

## Langkah-langkah dalam pengaplikasian sistem

Berikut adalah langkah-langkah yang harus dilakukan untuk mengaplikasikan sistem ini.

**1. Download vendor-vendor PHP.**

Jalankan sintaks _**composer install**_.

**2. Buat file _.env_**

Buat file baru dengan nama _.env_ dengan isi file menyalin konten dari file _.env.example_ . Sesuaikan pada bagian konfigurasi database.

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

**3. Generate key.**

Generate key encryption aplikasi dengan menjalankan sintaks _**php artisan key:generate**_

**4. Jalankan migrasi database dan seeder.**

Jalankan sintaks _**php artisan migration --seed**_ untuk melakukan migrasi database dan seeding.

**5. Jalankan aplikasi.**

Jalankan aplikasi dengan menggunakan sintaks _**php artisan serve**_ .
