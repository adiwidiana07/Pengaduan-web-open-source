<div align="center">

# 📢 Pengaduan

### Layanan Aspirasi & Pengaduan Online

[![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-v4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green)](https://opensource.org/licenses/MIT)

Platform pengaduan dan aspirasi masyarakat berbasis web yang memungkinkan pengguna menyampaikan pendapat secara **anonim, transparan, dan real-time**.

</div>

---

## Daftar Isi

- [Fitur](#fitur)
- [Tech Stack](#tech-stack)
- [Instalasi](#instalasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akun Admin Default](#akun-admin-default)
- [Struktur Direktori](#struktur-direktori-utama)
- [Keamanan](#keamanan)
- [Lisensi](#lisensi)

---

## Fitur

### Publik
- **Akun Masyarakat** - Daftar dan masuk untuk mengirim aspirasi; aspirasi tetap tampil sebagai Anonim
- **Buat Aspirasi** - Sampaikan aspirasi/pengaduan dari akun Anda
- **Voting** - Dukung atau tolak aspirasi secara anonim
- **Komentar** - Diskusikan aspirasi melalui kolom komentar
- **Cari & Filter** - Temukan aspirasi berdasarkan kata kunci, kategori, atau popularitas
- **Aspirasi Saya** - Daftar aspirasi milik akun Anda
- **Edit/Hapus** - Ubah atau hapus aspirasi milik sendiri
- **Laporkan** - Laporkan aspirasi bermasalah (satu kali per akun, tidak bisa melaporkan milik sendiri)

### Admin Dashboard
- **Ringkasan** - Statistik total aspirasi, voting, dan kategori
- **Kelola Aspirasi** - Lihat seluruh aspirasi dengan pencarian, filter, dan urutan laporan terbanyak
- **Laporan** - Tinjau alasan laporan; hapus aspirasi hanya setelah mencapai ambang (`REPORT_THRESHOLD`, bawaan 50), atau tolak laporannya
- **Kategori** - CRUD kategori pengelompokan aspirasi
- **Statistik** - Grafik voting, distribusi kategori, dan tren bulanan
- **Profil** - Ubah data akun dan kata sandi administrator

## Tech Stack

| Komponen   | Teknologi                          |
| ---------- | ---------------------------------- |
| Backend    | Laravel 13, PHP 8.3+              |
| Frontend   | Tailwind CSS v4, Vite, vanilla JS |
| Database   | MySQL                              |
| Auth       | Session-based authentication      |

## Persyaratan Sistem

> [!IMPORTANT]
> Pastikan komputer Anda sudah terinstal:
> - **PHP 8.3** atau lebih baru
> - **Composer**
> - **Node.js** & npm
> - **MySQL 8.0** atau lebih baru

## Instalasi

```bash
# Clone repositori
git clone https://github.com/username/pengaduan.git
cd pengaduan

# Install dependencies PHP
composer install

# Install dependencies frontend
npm install

# Copy environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Kunci penyamaran identitas penulis & pelapor (wajib, simpan cadangannya)
php artisan identity:key

# Konfigurasi database di .env
# DB_DATABASE=pengaduan
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migrasi
php artisan migrate

# (Opsional) Seeder admin
php artisan db:seed

# Build assets
npm run build
```

## Menjalankan Aplikasi

```bash
# Development server
php artisan serve

# Watch assets (development)
npm run dev
```

## Akun Admin Default

> [!NOTE]
> Setelah menjalankan seeder, gunakan akun berikut untuk login:
>
> | Field    | Value              |
> |----------|--------------------|
> | 📧 Email | admin@pengaduan.id |
> | 🔑 Password | password       |

## Struktur Direktori Utama

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           # Admin controllers
│   │   │   ├── AspirationController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProfileController.php
│   │   │   └── StatisticController.php
│   │   ├── Auth/            # Auth controllers
│   │   │   └── LoginController.php
│   │   ├── AspirationController.php
│   │   ├── CommentController.php
│   │   ├── MyAspirationController.php
│   │   └── VoteController.php
│   └── Models/
│       ├── Aspiration.php
│       ├── Category.php
│       ├── Comment.php
│       ├── User.php
│       └── Vote.php
resources/
└── views/
    ├── admin/aspiration/    # Admin aspiration views
    ├── aspiration/          # Public aspiration views
    ├── components/          # Navbar & footer
    ├── kategori/            # Category management views
    └── layouts/             # App & admin layouts
routes/
└── web.php
```

## Keamanan

- Admin tidak dapat melihat siapa penulis atau pelapor sebuah aspirasi. Tabel `aspirations` dan `reports` tidak menyimpan `user_id`, hanya HMAC-SHA256 dari id akun dengan kunci `IDENTITY_HASH_KEY`, sehingga isi database pun tidak bisa dihubungkan ke akun tanpa kunci tersebut
- Hash penulis dan hash pelapor memakai tujuan berbeda, jadi laporan seseorang tidak bisa dicocokkan dengan aspirasinya sendiri
- **Jangan mengganti atau menghilangkan `IDENTITY_HASH_KEY`** setelah ada pengguna: semua aspirasi akan kehilangan pemiliknya
- Peran `admin` dan `user` dipisah: masyarakat tidak bisa membuka dashboard, admin tidak bisa membuat, mengubah, atau melaporkan aspirasi
- Admin hanya bisa menghapus aspirasi yang laporannya sudah mencapai ambang
- Rate limit pada login, daftar, kirim aspirasi, dan laporan
- Voting dan komentar tetap anonim memakai token sesi

## Lisensi

[MIT](https://opensource.org/licenses/MIT)

---

<div align="center">

**Dibuat dengan ❤️ menggunakan Laravel**

</div>
