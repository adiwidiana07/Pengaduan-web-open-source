# Pengaduan - Layanan Aspirasi & Pengaduan Online

Platform pengaduan dan aspirasi masyarakat berbasis web yang memungkinkan pengguna menyampaikan pendapat secara **anonim, transparan, dan real-time**.

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

- **Backend:** Laravel 13, PHP 8.3+
- **Frontend:** Tailwind CSS v4, Vite, Alpine.js-like vanilla JS
- **Database:** MySQL
- **Auth:** Session-based authentication

## Persyaratan Sistem

- PHP 8.3 atau lebih baru
- Composer
- Node.js & npm
- MySQL 8.0+

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

Setelah menjalankan seeder:

| Field    | Value              |
|----------|--------------------|
| Email    | admin@pengaduan.id |
| Password | password           |

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
## Donate 
Jika project ini bermanfaat, Anda dapat mendukung pengembang melalui Saweria:
https://saweria.co/Adiiiwidi

##ThankYou

