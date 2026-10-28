# 📘 PANDUAN INSTALASI & PENGGUNAAN SISTEM
# SKS-AISYIYAH (Sistem Manajemen Keuangan Siswa TK Aisyiyah 6 Candi)

Dokumen ini berisi panduan teknis dan operasional lengkap untuk instalasi, konfigurasi, serta tata cara penggunaan sistem **SKS-AISYIYAH**.

---

## 📋 Daftar Isi
1. [Tentang Sistem](#1-tentang-sistem)
2. [Kebutuhan Sistem (System Requirements)](#2-kebutuhan-sistem-system-requirements)
3. [Langkah-Langkah Instalasi](#3-langkah-langkah-instalasi)
4. [Cara Menjalankan Sistem](#4-cara-menjalankan-sistem)
5. [Hak Akses & Kredensial Login Default](#5-hak-akses--kredensial-login-default)
6. [Panduan Operasional & Alur Penggunaan (Manual Book)](#6-panduan-operasional--alur-penggunaan-manual-book)
   - [A. Peran Administrator](#a-peran-administrator)
   - [B. Peran Siswa / Wali Murid](#b-peran-siswa--wali-murid)
7. [Panduan Import Data Menggunakan Excel](#7-panduan-import-data-menggunakan-excel)
8. [Pemecahan Masalah (Troubleshooting)](#8-pemecahan-masalah-troubleshooting)
9. [Prosedur Pencadangan (Backup & Maintenance)](#9-prosedur-pencadangan-backup--maintenance)

---

## 1. Tentang Sistem

**SKS-AISYIYAH** adalah aplikasi berbasis web yang dirancang khusus untuk mempermudah tata kelola administrasi dan keuangan di **TK Aisyiyah 6 Candi**. Sistem ini mencakup pengelolaan pembayaran iuran siswa (SPP, DPP, Kegiatan, Pendaftaran, Seragam, dll.), pencatatan operasional sekolah, manajemen gaji tenaga pendidik (guru), hingga transparansi rincian keuangan yang dapat dipantau langsung oleh orang tua siswa.

### Spesifikasi Teknologi:
- **Framework Web**: [CodeIgniter 4](https://codeigniter.com/) (PHP)
- **Database**: MySQL / MariaDB
- **User Interface**: Bootstrap 5, AdminLTE / Custom Theme, FontAwesome, SweetAlert2
- **Library Pendukung**: PhpSpreadsheet (Import & Export data Excel)

---

## 2. Kebutuhan Sistem (System Requirements)

Pastikan lingkungan server lokal (komputer/laptop) telah memenuhi syarat berikut:

| Komponen | Spesifikasi Minimum / Rekomendasi |
| :--- | :--- |
| **Sistem Operasi** | Windows 10/11, Linux, atau macOS |
| **Web Server** | Apache (tersedia via XAMPP) |
| **PHP** | Versi **8.1** atau **8.2** |
| **Database** | MySQL 5.7+ atau MariaDB 10.4+ |
| **Ekstensi PHP Wajib** | `php-intl`, `php-mbstring`, `php-mysqli`, `php-gd`, `php-curl`, `php-zip` |
| **Package Manager** | Composer (opsional, jika folder `vendor/` sudah tersedia) |
| **Browser** | Google Chrome, Mozilla Firefox, Microsoft Edge (versi terbaru) |

> ⚠️ **Catatan Penting untuk Ekstensi PHP:**
> CodeIgniter 4 membutuhkan ekstensi `intl` dan `mbstring`. Jika menggunakan XAMPP di Windows:
> 1. Buka file `php.ini` melalui XAMPP Control Panel (Tombol **Config** di baris Apache -> `php.ini`).
> 2. Cari baris `;extension=intl` dan ubah menjadi `extension=intl` (hapus tanda titik koma `;`).
> 3. Simpan file lalu **Restart Apache**.

---

## 3. Langkah-Langkah Instalasi

Ikuti langkah-langkah berikut secara berurutan untuk memasang sistem pada komputer lokal:

### Langkah 1: Tempatkan Source Code di Direktori Server
Pastikan folder project sistem ini berada di dalam direktori `htdocs` web server lokal Anda.
- **Lokasi Default XAMPP**: `C:\xampp\htdocs\SKS-AISYIYAH`

### Langkah 2: Nyalakan Layanan XAMPP
1. Buka aplikasi **XAMPP Control Panel**.
2. Klik tombol **Start** pada modul **Apache**.
3. Klik tombol **Start** pada modul **MySQL**.
4. Pastikan status kedua modul berubah warna menjadi hijau.

### Langkah 3: Import Database
1. Buka peramban (browser) dan akses alamat:
   ```
   http://localhost/phpmyadmin
   ```
2. Klik menu **New** (Baru) di bilah navigasi kiri.
3. Masukkan nama database: `sks-aisyiyah` (gunakan huruf kecil dan tanda hubung sesuai standar).
4. Klik tombol **Create** (Buat).
5. Pilih database `sks-aisyiyah` yang baru dibuat, lalu klik tab **Import** di menu atas.
6. Klik tombol **Choose File** / **Pilih File**, lalu arahkan ke file SQL yang berada di dalam folder proyek:
   ```
   C:\xampp\htdocs\SKS-AISYIYAH\sks-aisyiyah.sql
   ```
7. Gulir ke bawah dan klik tombol **Import** / **Kirim**.
8. Tunggu hingga muncul pesan hijau sukses dan seluruh tabel terbentuk.

### Langkah 4: Konfigurasi File Environment (`.env`)
1. Di direktori proyek `C:\xampp\htdocs\SKS-AISYIYAH\`, periksa file `.env`. (Jika belum ada, salin file `env` dan beri nama `.env`).
2. Buka file `.env` menggunakan teks editor (VS Code, Notepad++, Sublime Text).
3. Sesuaikan parameter koneksi database dan environment berikut:
   ```ini
   CI_ENVIRONMENT = development

   # Pengaturan Database
   database.default.hostname = localhost
   database.default.database = sks-aisyiyah
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```
   *(Secara default pada XAMPP, username database adalah `root` dan password dikosongkan).*

4. Konfigurasi `app/Config/Database.php` secara otomatis telah disinkronkan dengan nama database `sks-aisyiyah`.

### Langkah 5: Pengaturan Izin Direktori (Permissions)
Pastikan folder `writable` memiliki izin tulis (writeable):
- Folder cache, logs, dan uploads berada di folder: `writable/`
- Di sistem operasi Windows izin biasanya sudah terbuka secara otomatis. Jika di Linux/Mac, jalankan perintah:
  ```bash
  chmod -R 777 writable
  ```

---

## 4. Cara Menjalankan Sistem

Anda dapat menjalankan aplikasi menggunakan salah satu dari dua cara berikut:

### Opsi A: Menggunakan Server Bawaan CodeIgniter (Sangat Direkomendasikan)
Cara ini paling stabil dan menghindari masalah penulisan path URL:
1. Buka terminal (PowerShell / Command Prompt).
2. Arahkan ke folder project:
   ```powershell
   cd C:\xampp\htdocs\SKS-AISYIYAH
   ```
3. Jalankan perintah:
   ```bash
   php spark serve
   ```
4. Buka browser dan akses alamat:
   ```
   http://localhost:8080
   ```

### Opsi B: Menggunakan Apache XAMPP Langsung
1. Pastikan Apache di XAMPP menyala.
2. Karena CodeIgniter 4 menempatkan file `index.php` pada folder `public/`, akses URL melalui browser dengan alamat:
   ```
   http://localhost/SKS-AISYIYAH/public/
   ```
3. Jika menggunakan Opsi B, sesuaikan variabel `$baseURL` pada file `app/Config/App.php` menjadi:
   ```php
   public string $baseURL = 'http://localhost/SKS-AISYIYAH/public/';
   ```

---

## 5. Hak Akses & Kredensial Login Default

Sistem ini memiliki 2 (dua) tipe hak akses:

### 1. Akun Administrator (Pengelola Sekolah / Keuangan)
Digunakan oleh petugas Tata Usaha (TU) atau Bendahara sekolah.
- **Halaman Login**: Halaman utama sistem (`/`)
- **Username Default**: `admin`
- **Password Default**: Hubungi pengembang / administrator utama sekolah.
- *(Catatan: Password admin tersimpan dalam format hash bcrypt pada tabel `admins`. Password juga dapat di-reset melalui fitur kelola admin atau script `reset_password.php`).*

### 2. Akun Siswa / Wali Murid
Digunakan oleh orang tua / wali murid untuk memantau status pembayaran sekolah anaknya.
- **Halaman Login**: Form login utama yang sama
- **Username**: **Nomor Induk Siswa Nasional (NISN)** siswa bersangkutan
- **Password**: **Nomor Induk Siswa Nasional (NISN)** yang sama
- **Contoh Akun Testing**:
  - Username: `3213525587`
  - Password: `3213525587`
  *(Siswa atas nama QIANA WIJAYA, Kelas Abu Bakar)*

---

## 6. Panduan Operasional & Alur Penggunaan (Manual Book)

### A. Peran Administrator

Setelah berhasil masuk sebagai Administrator, sistem akan mengarahkan Anda ke Dashboard Admin (`/dashboard`). Berikut fitur-fitur dan cara penggunaannya:

```
+-------------------------------------------------------------------------------+
|                             DASHBOARD ADMIN                                   |
+-------------------------------------------------------------------------------+
|  [Data Siswa]  --> Tambah, Edit, Hapus, Import/Export Excel, Kirim Notifikasi  |
|  [Pos Masuk]   --> SPP, DPP, Kegiatan, Pendaftaran, Seragam/Tas, LKS, dll.   |
|  [Operasional] --> Pencatatan Pengeluaran Rutin Sekolah                       |
|  [Gaji Guru]   --> Data Pendidik, Input Honor & Tunjangan, Cetak Slip Gaji    |
|  [Laporan]     --> Rekap Global, Cetak Kwitansi/Slip, Ekspor Excel            |
|  [Kelola User] --> Manajemen Akun Admin Tambahan                              |
+-------------------------------------------------------------------------------+
```

#### 1. Manajemen Data Siswa (`/data-siswa`)
- **Menambah Siswa Manual**: Klik tombol **Tambah Siswa**, isi data lengkap (NISN, Nama Lengkap, Kelas, NIK, Jenis Kelamin, Tanggal Lahir, Alamat, No WhatsApp Wali, Nama Orang Tua, Tahun Akademik).
- **Import Siswa dari Excel**: Jika data siswa berjumlah banyak, gunakan tombol **Import Excel** untuk mengunggah berkas format `.xlsx` atau `.xls`.
- **Export Data Siswa**: Klik tombol **Export** untuk mengunduh rekap daftar siswa ke format Excel.
- **Kirim Notifikasi**: Admin dapat mengirimkan pesan/pengumuman langsung ke dashboard siswa tertentu via tombol notifikasi.

#### 2. Transaksi Pos Pembayaran Siswa
Sistem menyediakan menu transaksi per pos pembayaran pada sidebar kiri:
- **Pendaftaran** (`/pendaftaran`)
- **SPP (Sumbangan Pembinaan Pendidikan)** (`/spp`)
- **DPP (Dana Pengembangan Pendidikan)** (`/dpp`)
- **Biaya Kegiatan** (`/kegiatan`)
- **Peralatan** (`/peralatan`)
- **Lembar Kerja Siswa / LKS** (`/lks`)
- **Seragam & Tas** (`/seragam_tas`)
- **UIS / UIM (Ujian/Evaluasi)** (`/uis_uim`)

**Cara Input Pembayaran:**
1. Masuk ke menu pos yang diinginkan (misalnya: **SPP**).
2. Klik tombol **Tambah Data / Simpan Pembayaran**.
3. Pilih nama siswa / masukkan NISN, tanggal pembayaran, nominal yang dibayarkan, dan keterangan/status (Lunas / Angsuran).
4. Klik **Simpan**. Saldo dan status tagihan siswa akan otomatis terbarui di sistem.

#### 3. Rekapitulasi & Laporan Keuangan (`/rekap`)
- Menampilkan ringkasan seluruh dana yang masuk dari berbagai pos dan dana yang keluar dari operasional.
- **Filter Laporan**: Pilih rentang tanggal, bulan, atau tahun tertentu untuk melihat performa kas.
- **Export ke Excel**: Klik **Export Excel** untuk mengunduh tabel rekapitulasi ke berkas `.xlsx`.
- **Cetak / Print**: Klik tombol **Cetak Rekap** untuk membuka tampilan cetak/print preview yang rapi dan siap dicetak atau disimpan ke file PDF.

#### 4. Pengeluaran Operasional Sekolah (`/operasional`)
- Digunakan untuk mencatat setiap pengeluaran kas sekolah (misal: ATK, listrik, internet, perbaikan sarana, konsumsi).
- Klik tombol **Tambah Operasional**, pilih kategori, masukkan tanggal, jumlah nominal rupiah, dan rincian keterangannya.

#### 5. Manajemen Guru & Penggajian (Payroll) (`/gaji-guru`)
- **Kelola Data Guru**: Tambah profil guru, jabatan, dan status kepegawaian.
- **Perhitungan Gaji**: Masukkan komponen gaji pokok, tunjangan kehadiran, lembur, dan potongan kasbon jika ada.
- **Cetak Slip Gaji (`/cetak-slip`)**: Sistem dapat mencetak slip gaji individual per guru lengkap dengan rincian penerimaan untuk diserahkan kepada pendidik.

#### 6. Manajemen Akun Administrator (`/admin/users`)
- Kepala Sekolah atau Administrator utama dapat menambahkan akun admin baru atau mengganti password admin yang sudah terdaftar.

---

### B. Peran Siswa / Wali Murid

Akun siswa dirancang dengan antarmuka yang bersih dan mudah dipahami oleh orang tua murid untuk transparansi administrasi sekolah:

1. **Login Siswa**: Masukkan NISN pada kolom Username dan NISN pada kolom Password, lalu klik **Masuk Sekarang**.
2. **Dashboard Siswa (`/dashboard-siswa`)**:
   - Menampilkan biodata siswa, kelas aktif, dan tahun akademik.
   - Menampilkan ringkasan status kelunasan (SPP, DPP, Kegiatan, Seragam, dll.).
3. **Rincian Keuangan Siswa (`/rincian-keuangan-siswa`)**:
   - Menampilkan riwayat transaksi setiap pembayaran yang telah dibayarkan oleh wali murid ke pihak sekolah.
   - Menampilkan tanggal bayar, nomor kuitansi, jumlah nominal, dan sisa tanggungan jika ada.
4. **Notifikasi**:
   - Memeriksa pemberitahuan tagihan atau pengumuman penting dari sekolah yang dikirim oleh admin.
5. **Logout**: Klik foto profil / tombol logout di sudut kanan atas untuk keluar dari sistem setelah selesai.

---

## 7. Panduan Import Data Menggunakan Excel

Untuk mempercepat pengisian data siswa dan rekap pos pembayaran secara massal, manfaatkan fitur **Import Excel**:

### Format Kolom File Excel Data Siswa:
Pastikan baris pertama (Header) memuat kolom berikut:
1. `NISN` (Contoh: `3213525587`)
2. `Nama` (Contoh: `QIANA WIJAYA`)
3. `Kelas` (Contoh: `Abu Bakar` atau `KB`)
4. `NIK` (Nomor Induk Kependudukan 16 digit)
5. `Jenis Kelamin` (`L` untuk Laki-laki, `P` untuk Perempuan)
6. `Tanggal Lahir` (Format: `YYYY-MM-DD`, contoh: `2021-05-29`)
7. `Alamat`
8. `No WhatsApp` (Contoh: `081234567890`)
9. `Nama Orang Tua`
10. `Tahun Akademik` (Contoh: `2025/2026`)

### Ketentuan Import:
- Gunakan ekstensi `.xlsx` atau `.xls`.
- Pastikan tidak ada spasi di awal/akhir NISN.
- Kolom NISN wajib unik (tidak boleh ada NISN ganda).

---

## 8. Pemecahan Masalah (Troubleshooting)

| Gejala Masalah | Penyebab Umum | Solusi / Cara Mengatasi |
| :--- | :--- | :--- |
| **Error: `Call to undefined function intl_...`** | Ekstensi PHP `intl` belum aktif di server. | Buka `php.ini` di XAMPP, hilangkan tanda `;` pada baris `;extension=intl`, simpan, lalu restart Apache. |
| **Database Connection Exception (Unable to connect to database)** | MySQL mati atau nama database keliru. | 1. Pastikan modul MySQL di XAMPP berstatus aktif (hijau).<br>2. Pastikan database `sks-aisyiyah` sudah dibuat dan di-import di phpMyAdmin.<br>3. Cek parameter database di `.env`. |
| **Halaman 404 Not Found saat klik menu** | Modul `mod_rewrite` Apache belum aktif atau Base URL belum tepat. | 1. Jika menggunakan Apache XAMPP, pastikan ekstensi `mod_rewrite` di file `httpd.conf` dalam keadaan aktif.<br>2. Gunakan perintah `php spark serve` dan akses `http://localhost:8080`. |
| **Tampilan CSS / Gambar Rusak atau Tidak Muncul** | Konfigurasi `$baseURL` tidak cocok dengan URL peramban. | 1. Buka `app/Config/App.php`.<br>2. Ubah `public string $baseURL = 'http://localhost:8080/';` (jika menggunakan `spark`) atau `'http://localhost/SKS-AISYIYAH/public/'` (jika menggunakan Apache). |
| **Gagal Login Admin (Password Salah)** | Password akun admin terlupa atau belum ter-hash dengan benar. | Buka phpMyAdmin, buka tabel `admins`, ubah kolom `password` menjadi teks biasa (sistem mendukung fallback migrasi otomatis ke hash saat login pertama kali), atau jalankan kueri update password baru. |
| **Siswa Tidak Bisa Login** | NISN belum terdaftar atau salah ketik. | Pastikan data siswa telah diinput ke tabel `data_siswa`. Password siswa secara default sama dengan NISN-nya. |

---

## 9. Prosedur Pencadangan (Backup & Maintenance)

Untuk menjaga keamanan data keuangan sekolah dari risiko kehilangan atau kerusakan perangkat keras, lakukan pencadangan rutin:

### 1. Backup Database Rutin:
1. Buka `http://localhost/phpmyadmin`.
2. Klik database `sks-aisyiyah`.
3. Klik tab **Export** (Ekspor), pilih metode **Quick** (Cepat), format **SQL**.
4. Klik tombol **Export** dan simpan file `.sql` di media penyimpanan eksternal (Google Drive / Flashdisk) secara berkala (misal: setiap akhir pekan/bulan).

### 2. Backup Berkas Sistem:
Salin (copy) folder `C:\xampp\htdocs\SKS-AISYIYAH` secara berkala ke media penyimpanan cadangan.

---

> 🏫 **TK Aisyiyah 6 Candi**  
> Sistem Manajemen Keuangan Siswa (SKS-AISYIYAH)  
> *Dikembangkan untuk transparansi dan ketertiban tata kelola administrasi pendidikan.*

