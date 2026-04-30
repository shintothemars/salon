# Salon Reservation System

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)

Sistem reservasi salon modern yang dibangun dengan Laravel. Aplikasi ini memungkinkan pelanggan untuk memesan layanan salon secara online, serta memberikan panel manajemen bagi administrator untuk mengelola layanan dan karyawan (stylist).

---

## ✨ Fitur Utama

### 👤 Untuk Pelanggan
- **Daftar Layanan**: Menampilkan berbagai layanan salon dengan harga dan deskripsi yang menarik.
- **Reservasi Mudah**: Form booking yang intuitif dengan pemilihan tanggal dan waktu.
- **Konfirmasi Pemesanan**: Halaman konfirmasi sebelum pesanan diproses.
- **Tiket Digital**: Struk/tiket reservasi setelah berhasil melakukan booking.

### 🔐 Untuk Admin & Karyawan
- **Multi-role Auth**: Login terpisah untuk Admin dan Karyawan.
- **Manajemen Layanan**: CRUD (Create, Read, Update, Delete) untuk layanan salon.
- **Manajemen Stylist**: Mengelola data karyawan/stylist yang tersedia.
- **Dashboard Admin**: Ringkasan data dan kontrol penuh aplikasi.

---

## 🛠️ Teknologi yang Digunakan

- **Framework**: [Laravel 12](https://laravel.com)
- **Frontend**: Tailwind CSS & Blade Templating
- **Database**: MySQL / SQLite
- **Plugins**:
  - [SweetAlert2](https://sweetalert2.github.io/) - Untuk notifikasi yang premium.
  - [Flatpickr](https://flatpickr.js.org/) - Pemilihan tanggal yang modern.
  - [Filament PHP](https://filamentphp.com/) - Admin panel yang powerful.

---

## 🚀 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project ini di komputer lokal Anda:

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/salon-reservation.git
   cd salon
   ```

2. **Instal Dependensi PHP**
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` ke `.env` dan atur koneksi database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Aplikasi**
   Jalankan server Laravel dan build asset frontend:
   ```bash
   # Terminal 1
   php artisan serve

   # Terminal 2
   npm run dev
   ```
   Akses aplikasi di `http://localhost:8000`.

---

## 📂 Struktur Folder Utama

- `app/Http/Controllers`: Logika bisnis aplikasi.
- `app/Models`: Representasi struktur data (User, Service, Employee, Booking).
- `resources/views`: File tampilan (UI) menggunakan Blade.
- `routes/web.php`: Definisi semua rute/URL aplikasi.
- `database/migrations`: Skema tabel database.

---

## 🤝 Kontribusi

Jika Anda ingin berkontribusi, silakan lakukan fork pada repository ini dan ajukan Pull Request. Segala bentuk kontribusi sangat dihargai!

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">Made with ❤️ for a better Salon Experience</p>
