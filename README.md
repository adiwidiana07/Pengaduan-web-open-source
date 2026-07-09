# Pengaduan - Layanan Aspirasi & Pengaduan Online

Platform pengaduan dan aspirasi masyarakat berbasis web yang memungkinkan pengguna menyampaikan pendapat secara **anonim, transparan, dan real-time**.

## Fitur

### Publik
- **Buat Aspirasi** - Sampaikan aspirasi/pengaduan tanpa perlu registrasi
- **Voting** - Dukung atau tolak aspirasi secara anonim
- **Komentar** - Diskusikan aspirasi melalui kolom komentar
- **Cari & Filter** - Temukan aspirasi berdasarkan kata kunci, kategori, atau popularitas
- **Aspirasi Saya** - Kelola aspirasi yang telah dibuat menggunakan token kepemilikan
- **Edit/Hapus** - Ubah atau hapus aspirasi menggunakan token rahasia

### Admin Dashboard
- **Ringkasan** - Statistik total aspirasi, voting, dan kategori
- **Kelola Aspirasi** - Lihat seluruh aspirasi dengan pencarian dan filter
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

- Aspirasi bersifat anonim - tidak ada data pribadi yang tersimpan
- Token UUID digunakan untuk verifikasi kepemilikan
- Voting menggunakan token sesi untuk mencegah duplikasi
- Admin dashboard dilindungi autentikasi sesi

