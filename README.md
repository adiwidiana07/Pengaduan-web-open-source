<div align="center">

# 📢 Pengaduan

### Layanan Aspirasi & Pengaduan Online

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-8-646CFF?style=flat&logo=vite&logoColor=white)](https://vite.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com)

Platform pengaduan dan aspirasi masyarakat berbasis web. Warga bisa menyampaikan pendapat secara **anonim dan transparan**, sementara admin mengelola laporan tanpa pernah tahu siapa penulisnya.

</div>

---

## Daftar Isi

- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Testing](#testing)
- [Akun Admin Default](#akun-admin-default)
- [Struktur Direktori](#struktur-direktori)
- [Keamanan & Anonimitas](#keamanan--anonimitas)
- [Tentang Tech Stack](#tentang-tech-stack)
- [Dukung Proyek Ini](#dukung-proyek-ini)

---

## Fitur

### Masyarakat

- **Akun Masyarakat**: daftar dan masuk untuk mengirim aspirasi. Aspirasi tetap tampil sebagai *Anonim*.
- **Buat Aspirasi**: sampaikan aspirasi atau pengaduan dari akun Anda.
- **Voting**: dukung atau tolak aspirasi secara anonim.
- **Komentar**: diskusikan aspirasi melalui kolom komentar.
- **Cari & Filter**: temukan aspirasi berdasarkan kata kunci, kategori, atau popularitas.
- **Aspirasi Saya**: daftar aspirasi milik akun Anda.
- **Edit / Hapus**: ubah atau hapus aspirasi milik sendiri.
- **Laporkan**: laporkan aspirasi bermasalah (satu kali per akun, tidak bisa melaporkan milik sendiri).

### Admin Dashboard

- **Ringkasan**: statistik total aspirasi, voting, dan kategori.
- **Kelola Aspirasi**: lihat seluruh aspirasi dengan pencarian, filter, dan urutan laporan terbanyak.
- **Laporan**: tinjau alasan laporan, lalu hapus aspirasi (hanya setelah mencapai ambang `REPORT_THRESHOLD`) atau tolak laporannya.
- **Kategori**: CRUD kategori pengelompokan aspirasi.
- **Statistik**: grafik voting, distribusi kategori, dan tren bulanan.
- **Profil**: ubah data akun dan kata sandi administrator.

## Tech Stack

| Komponen    | Teknologi                                                                          |
| ----------- | ---------------------------------------------------------------------------------- |
| Backend     | [Laravel 13](https://laravel.com), PHP 8.3+                                        |
| Template    | [Blade](https://laravel.com/docs/blade)                                            |
| Styling     | [Tailwind CSS v4](https://tailwindcss.com)                                         |
| Build tool  | [Vite 8](https://vite.dev) + [Laravel Vite Plugin](https://laravel.com/docs/vite)  |
| JavaScript  | Vanilla JS (tanpa framework)                                                       |
| Database    | MySQL 8.0+ (SQLite in-memory untuk testing)                                        |
| Autentikasi | Session-based, peran `admin` dan `user`                                            |
| Testing     | [PHPUnit 12](https://phpunit.de)                                                   |
| Code style  | [Laravel Pint](https://laravel.com/docs/pint)                                      |
| Font        | Instrument Sans & Source Serif 4 via [Bunny Fonts](https://fonts.bunny.net)        |

Penjelasan singkat tiap teknologi ada di bagian [Tentang Tech Stack](#tentang-tech-stack).

## Persyaratan Sistem

> [!IMPORTANT]
> Pastikan sudah terinstal:
> - **PHP 8.3** atau lebih baru, dengan ekstensi `pdo_mysql` (dan `pdo_sqlite` untuk menjalankan test)
> - **Composer**
> - **Node.js** & npm
> - **MySQL 8.0** atau lebih baru

## Instalasi

Kode aplikasi Laravel berada di folder `pengaduan/`.

```bash
# 1. Clone repositori
git clone https://github.com/adiwidiana07/Pengaduan-web-open-source.git
cd Pengaduan-web-open-source/pengaduan

# 2. Salin file environment, lalu atur koneksi database di .env
cp .env.example .env

# 3. Install dependency, buat APP_KEY & IDENTITY_HASH_KEY, migrasi, dan build aset
composer setup

# 4. Buat akun admin
php artisan db:seed
```

<details>
<summary>Langkah manual (tanpa <code>composer setup</code>)</summary>

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan identity:key      # kunci penyamaran identitas, wajib
php artisan migrate
php artisan db:seed           # akun admin
npm run build
```

</details>

> [!WARNING]
> `php artisan identity:key` menulis `IDENTITY_HASH_KEY` ke `.env`. **Simpan cadangan kunci ini.** Jika diganti atau hilang, semua aspirasi kehilangan pemiliknya. Lihat [Keamanan & Anonimitas](#keamanan--anonimitas).

## Konfigurasi

Variabel penting di `.env`:

| Variabel            | Bawaan               | Keterangan                                                                 |
| ------------------- | -------------------- | -------------------------------------------------------------------------- |
| `DB_DATABASE`       | `pengaduan`          | Nama database MySQL (buat dulu sebelum migrasi)                            |
| `DB_USERNAME`       | `root`               | User database                                                              |
| `DB_PASSWORD`       | *(kosong)*           | Password database                                                          |
| `IDENTITY_HASH_KEY` | *(kosong)*           | Kunci HMAC penyamaran identitas, dibuat dengan `php artisan identity:key`  |
| `REPORT_THRESHOLD`  | `50`                 | Jumlah laporan minimal sebelum admin boleh menghapus aspirasi              |
| `ADMIN_EMAIL`       | `admin@pengaduan.id` | Email admin yang dibuat seeder                                             |
| `ADMIN_PASSWORD`    | `password`           | Password admin yang dibuat seeder                                          |

## Menjalankan Aplikasi

```bash
# Server, queue worker, dan Vite sekaligus
composer dev
```

Atau jalankan terpisah:

```bash
php artisan serve   # http://localhost:8000
npm run dev         # Vite dengan hot reload
```

Untuk produksi, jalankan `npm run build` lalu arahkan web server ke folder `pengaduan/public`.

## Testing

```bash
composer test
```

Test memakai SQLite in-memory (lihat `phpunit.xml`), jadi tidak menyentuh database MySQL Anda.

Untuk mencoba alur penghapusan berdasarkan ambang laporan, tersedia seeder yang membuat 50 laporan:

```bash
php artisan db:seed --class=ReportThresholdSeeder
```

## Akun Admin Default

Setelah menjalankan `php artisan db:seed`:

| Field    | Value                |
| -------- | -------------------- |
| Email    | `admin@pengaduan.id` |
| Password | `password`           |

> [!CAUTION]
> Ganti password admin segera setelah login, atau atur `ADMIN_EMAIL` dan `ADMIN_PASSWORD` di `.env` sebelum menjalankan seeder.

## Struktur Direktori

```
pengaduan/
├── app/
│   ├── Console/Commands/
│   │   └── IdentityKeyCommand.php    # php artisan identity:key
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                # Dashboard, Aspirasi, Laporan, Kategori, Statistik, Profil
│   │   │   ├── Auth/                 # Login & Register
│   │   │   ├── AspirationController.php
│   │   │   ├── CommentController.php
│   │   │   ├── MyAspirationController.php
│   │   │   ├── ReportController.php
│   │   │   └── VoteController.php
│   │   └── Middleware/
│   │       └── EnsureRole.php        # Pemisahan peran admin / user
│   ├── Models/                       # Aspiration, Category, Comment, Report, User, Vote
│   ├── Policies/
│   │   └── AspirationPolicy.php
│   └── Support/
│       └── AnonymousIdentity.php     # Hash HMAC identitas penulis & pelapor
├── config/
│   └── pengaduan.php                 # Kunci identitas, ambang & alasan laporan
├── database/
│   ├── migrations/
│   └── seeders/                      # DatabaseSeeder, ReportThresholdSeeder
├── resources/
│   ├── css/app.css                   # Tailwind CSS v4
│   ├── js/app.js                     # Vanilla JS
│   └── views/
│       ├── admin/                    # Halaman admin (aspirasi, laporan)
│       ├── aspiration/               # Halaman publik aspirasi
│       ├── components/               # Navbar, footer
│       ├── kategori/                 # Kelola kategori
│       └── layouts/                  # Layout app & admin
├── routes/web.php
└── tests/Feature/                    # Test fitur
```

## Keamanan & Anonimitas

- **Admin tidak bisa melihat penulis atau pelapor aspirasi.** Tabel `aspirations` dan `reports` tidak menyimpan `user_id`, hanya HMAC-SHA256 dari id akun dengan kunci `IDENTITY_HASH_KEY`. Isi database pun tidak bisa dihubungkan ke akun tanpa kunci tersebut.
- Hash penulis dan hash pelapor memakai tujuan berbeda, jadi laporan seseorang tidak bisa dicocokkan dengan aspirasinya sendiri.
- **Jangan mengganti atau menghilangkan `IDENTITY_HASH_KEY`** setelah ada pengguna: semua aspirasi akan kehilangan pemiliknya.
- Peran `admin` dan `user` dipisah: masyarakat tidak bisa membuka dashboard, admin tidak bisa membuat, mengubah, atau melaporkan aspirasi.
- Admin hanya bisa menghapus aspirasi yang laporannya sudah mencapai ambang.
- Rate limit: login 5×/menit per email+IP, daftar 10×/menit per IP, kirim aspirasi/komentar/laporan 10×/menit per akun.
- Voting dan komentar tetap anonim memakai token sesi.

Menemukan celah keamanan? Mohon laporkan secara pribadi ke pengelola repositori, jangan lewat issue publik.

## Tentang Tech Stack

Ringkasan berikut diadaptasi dari README resmi masing-masing proyek.

### Laravel

Laravel adalah framework aplikasi web dengan sintaks yang ekspresif dan elegan. Laravel memudahkan pekerjaan yang umum ada di hampir semua proyek web, seperti:

- [Routing yang sederhana dan cepat](https://laravel.com/docs/routing)
- [Dependency injection container yang kuat](https://laravel.com/docs/container)
- Beragam back-end untuk [session](https://laravel.com/docs/session) dan [cache](https://laravel.com/docs/cache)
- [Migrasi skema](https://laravel.com/docs/migrations) yang tidak bergantung pada jenis database
- [Pemrosesan job di latar belakang](https://laravel.com/docs/queues)
- [Event broadcasting real-time](https://laravel.com/docs/broadcasting)

Belajar: [Dokumentasi Laravel](https://laravel.com/docs) · [Laravel Learn](https://laravel.com/learn) · [Laracasts](https://laracasts.com)<br>
Lisensi: MIT · Repositori: [laravel/framework](https://github.com/laravel/framework)

### Tailwind CSS

Framework CSS *utility-first* untuk membangun antarmuka kustom dengan cepat. Proyek ini memakai Tailwind v4 lewat plugin `@tailwindcss/vite`, dengan konfigurasi tema langsung di `resources/css/app.css` (blok `@theme`), tanpa `tailwind.config.js`.

Dokumentasi: [tailwindcss.com](https://tailwindcss.com) · Diskusi: [GitHub Discussions](https://github.com/tailwindlabs/tailwindcss/discussions)<br>
Lisensi: MIT · Repositori: [tailwindlabs/tailwindcss](https://github.com/tailwindlabs/tailwindcss)

### Vite

*Next Generation Frontend Tooling.* Vite (bahasa Prancis untuk "cepat", dibaca "vit") adalah build tool yang membuat pengembangan web modern lebih cepat dan ringan. Vite terdiri dari dua bagian utama:

- **Dev server** berbasis [native ES modules](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Guide/Modules) dengan [Hot Module Replacement (HMR)](https://vite.dev/guide/features#hot-module-replacement) yang sangat cepat.
- **Perintah build** yang membundel kode dengan [Rolldown](https://rolldown.rs) menjadi aset statis yang teroptimasi untuk produksi.

Dokumentasi: [vite.dev](https://vite.dev)<br>
Lisensi: MIT · Repositori: [vitejs/vite](https://github.com/vitejs/vite)

### Laravel Vite Plugin

Plugin yang mengonfigurasi Vite agar bekerja dengan back-end Laravel: menentukan *entry point* (`resources/css/app.css`, `resources/js/app.js`), memuat aset lewat direktif `@vite` di Blade, dan me-*refresh* halaman otomatis saat file Blade berubah. Di proyek ini plugin juga memuat font dari Bunny Fonts.

Dokumentasi: [laravel.com/docs/vite](https://laravel.com/docs/vite)<br>
Lisensi: MIT · Repositori: [laravel/vite-plugin](https://github.com/laravel/vite-plugin)

### MySQL

Sistem manajemen basis data relasional open source. Laravel terhubung ke MySQL lewat PDO, dan skema tabel dikelola dengan migrasi di `database/migrations/`.

Dokumentasi: [dev.mysql.com/doc](https://dev.mysql.com/doc/)

## Dukung Proyek Ini

Jika proyek ini bermanfaat, Anda dapat mendukung pengembang melalui Saweria:

[![Saweria](https://img.shields.io/badge/Dukung_via-Saweria-FAAE2B?style=for-the-badge)](https://saweria.co/Adiiiwidi)

---

<div align="center">

Terima kasih telah menggunakan **Pengaduan**! 🙏

</div>
