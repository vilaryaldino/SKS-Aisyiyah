# SKS-AISYIYAH 6 Candi (Sistem Keuangan Siswa)

Aplikasi web manajemen keuangan dan administrasi siswa untuk **TK Aisyiyah 6 Candi**, dibangun menggunakan framework **CodeIgniter 4** dan **MySQL**.

---

## 📖 Panduan Lengkap Instalasi & Penggunaan

Untuk petunjuk lengkap mengenai:
- Kebutuhan sistem dan ekstensi PHP
- Langkah instalasi database & web server
- Cara menjalankan program
- Kredensial akun default (Admin & Siswa)
- Panduan operasional fitur (SPP, DPP, Gaji Guru, dsb.)
- Troubleshooting / pemecahan masalah

Silakan baca file panduan utama:  
👉 **[PANDUAN_INSTALASI_DAN_PENGGUNAAN.md](PANDUAN_INSTALASI_DAN_PENGGUNAAN.md)**

---

## Ringkasan Cepat Menjalankan Aplikasi

1. Nyalakan **Apache** & **MySQL** di XAMPP Control Panel.
2. Buat database `sks-aisyiyah` di `http://localhost/phpmyadmin` dan import file `sks-aisyiyah.sql`.
3. Jalankan server lokal melalui terminal:
   ```bash
   php spark serve
   ```
4. Buka peramban di `http://localhost:8080`.

---

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
