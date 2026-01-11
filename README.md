# 🛍️ Lungsurin - Marketplace Barang Bekas Mahasiswa

<p align="center">
  <strong>Platform jual-beli barang bekas khusus untuk mahasiswa dengan sistem COD di kampus</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
</p>

## 📋 Deskripsi

Lungsurin adalah aplikasi marketplace barang bekas yang dirancang khusus untuk mahasiswa. Platform ini memudahkan mahasiswa untuk menjual dan membeli barang bekas dengan sistem COD (Cash on Delivery) di lokasi kampus. Aplikasi ini dibangun menggunakan Laravel 12 dengan fitur-fitur modern seperti autentikasi OAuth Google, sistem slot untuk posting barang, integrasi GPS untuk lokasi COD, dan UI yang responsif dengan dark mode support.

## ✨ Fitur Utama

- 🔐 **Autentikasi Ganda**: Login dengan email/password atau Google OAuth.
- 📦 **Sistem Slot**: Setiap user memiliki kuota slot untuk posting barang (default 3 slot).
- 🔍 **Pencarian & Filter**: Filter berdasarkan lokasi kampus, rentang harga, dan kata kunci.
- 📍 **Integrasi GPS**: Deteksi lokasi untuk menentukan titik COD.
- 💬 **Manajemen Profil**: Lengkapi profil dengan nomor HP, lokasi kampus, dan informasi default
- 🎨 **UI Modern**: Desain responsif dengan dark mode support
- 🏫 **Multi Kampus**: Support untuk berbagai lokasi kampus dan asrama

## 🚀 Instalasi

### Prerequisites

- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- SQLite (atau database lain yang didukung Laravel)

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd lungsurin
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Jalankan migration**
   ```bash
   php artisan migrate
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Jalankan server**
   ```bash
   php artisan serve
   ```

Aplikasi akan berjalan di `http://localhost:8000`

## ⚙️ Konfigurasi

### Setup Google OAuth Login

Untuk menggunakan fitur login dengan Google, ikuti langkah berikut:

1. **Buat Google OAuth Credentials:**
   - Buka [Google Cloud Console](https://console.cloud.google.com/)
   - Buat project baru atau pilih project yang sudah ada
   - Aktifkan Google+ API
   - Buka "Credentials" → "Create Credentials" → "OAuth client ID"
   - Pilih "Web application"
   - Tambahkan Authorized redirect URIs: `http://localhost:8000/auth/google/callback` (untuk development)
   - Salin Client ID dan Client Secret

2. **Update file `.env`:**
   ```env
   GOOGLE_CLIENT_ID=your-google-client-id
   GOOGLE_CLIENT_SECRET=your-google-client-secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
   ```

3. **Jalankan migration:**
   ```bash
   php artisan migrate
   ```

4. **Test login dengan Google:**
   - Buka halaman login atau register
   - Klik tombol "Masuk dengan Google" atau "Daftar dengan Google"
   - Ikuti proses OAuth dari Google

**Catatan:** Untuk production, pastikan untuk:
- Menggunakan HTTPS
- Update `GOOGLE_REDIRECT_URI` dengan domain production Anda
- Menambahkan domain production di Google Cloud Console

### Konfigurasi Database

Aplikasi menggunakan SQLite secara default. Untuk menggunakan database lain, edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lungsurin
DB_USERNAME=root
DB_PASSWORD=
```

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Authentication**: Laravel Breeze, Laravel Socialite (Google OAuth)
- **Storage**: Local Filesystem

## 📁 Struktur Proyek

```
lungsurin/
├── app/
│   ├── Http/Controllers/     # Controllers untuk handling requests
│   ├── Models/               # Eloquent models
│   └── Providers/            # Service providers
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Stylesheets
│   └── js/                   # JavaScript files
├── routes/
│   ├── web.php               # Web routes
│   └── auth.php              # Authentication routes
└── public/                   # Public assets
```

## 🧪 Testing

```bash
php artisan test
```

## 📝 Lisensi

Proyek ini menggunakan lisensi MIT.

## 👥 Kontribusi

Kontribusi sangat diterima! Silakan buat issue atau pull request untuk perbaikan dan fitur baru.

---

**Dibuat dengan ❤️ untuk komunitas mahasiswa**

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
