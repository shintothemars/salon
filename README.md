# Salon Reservation System

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![MySQL](https://img.shields.io/badge/Database-MySQL-orange.svg)](https://www.mysql.com)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)

Sistem reservasi salon modern yang dibangun dengan **Laravel 12**. Aplikasi ini memungkinkan pelanggan untuk memesan layanan salon secara online, serta memberikan panel manajemen bagi administrator untuk mengelola layanan, karyawan (stylist), dan reservasi secara real-time.

---

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#️-teknologi-yang-digunakan)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Cara Instalasi](#-cara-instalasi)
- [Konfigurasi Database](#️-konfigurasi-database)
- [Struktur Database](#-struktur-database)
- [Struktur Folder](#-struktur-folder)
- [Alur Penggunaan Aplikasi](#-alur-penggunaan-aplikasi)
- [Daftar Endpoint (Routing)](#-daftar-endpoint-routing)
- [Pengujian CRUD dengan Postman](#-pengujian-crud-dengan-postman)
- [Akun Default](#-akun-default)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## ✨ Fitur Utama

### 👤 Untuk Pelanggan (Tanpa Login)
- **Halaman Beranda**: Tampilan utama salon dengan informasi layanan unggulan.
- **Daftar Layanan**: Menampilkan berbagai layanan salon dengan harga dan durasi.
- **Reservasi Mudah**: Form booking intuitif dengan pemilihan tanggal & waktu menggunakan **Flatpickr**.
- **Validasi Double Booking**: Sistem otomatis mencegah jadwal bentrok untuk stylist yang sama.
- **Konfirmasi Pemesanan**: Halaman ringkasan sebelum reservasi diproses.
- **Tiket Digital**: Struk/tiket reservasi dengan kode unik setelah booking berhasil.
- **Invoice PDF**: Download invoice reservasi dalam format PDF (A5).

### 🔐 Untuk Admin
- **Dashboard Admin**: Ringkasan statistik (total, pending, confirmed, done, cancelled).
- **Kalender Interaktif**: Visualisasi semua booking via **FullCalendar** dengan kode warna per status.
- **Manajemen Reservasi**: Tabel booking lengkap dengan filter dan pencarian via **DataTables**.
- **Update Status Real-time**: Ubah status booking (pending → confirmed → done → cancelled) via AJAX tanpa reload.
- **Manajemen Layanan**: CRUD lengkap untuk layanan salon (nama, harga, durasi, deskripsi).
- **Manajemen Stylist**: CRUD lengkap untuk data karyawan/stylist.

### 👔 Untuk Karyawan
- **Dashboard Karyawan**: Melihat jadwal booking hari ini yang ditugaskan kepada stylist tersebut.

---

## 🛠️ Teknologi yang Digunakan

| Kategori | Teknologi |
|---|---|
| **Backend Framework** | [Laravel 12](https://laravel.com) |
| **Bahasa Pemrograman** | PHP 8.2+ |
| **Database** | MySQL / SQLite |
| **Templating** | Blade (Laravel) |
| **CSS Framework** | Bootstrap 5 |
| **Notifikasi** | [SweetAlert2](https://sweetalert2.github.io/) |
| **Date Picker** | [Flatpickr](https://flatpickr.js.org/) |
| **Kalender** | [FullCalendar](https://fullcalendar.io/) |
| **Tabel Dinamis** | [DataTables](https://datatables.net/) |
| **PDF Generator** | [Barryvdh/DomPDF](https://github.com/barryvdh/laravel-dompdf) |

---

## 💻 Persyaratan Sistem

Pastikan perangkat Anda memenuhi persyaratan berikut sebelum instalasi:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & **npm** >= 9.x
- **MySQL** >= 5.7 atau **MariaDB** >= 10.3
- **Web Server**: Apache / Nginx (atau gunakan server bawaan Laravel)
- **PHP Extensions**: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`

---

## 🚀 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal:

### 1. Clone Repository
```bash
git clone https://github.com/username/salon-reservation.git
cd salon
```

### 2. Instal Dependensi PHP
```bash
composer install
```

### 3. Instal Dependensi Frontend
```bash
npm install
```

### 4. Konfigurasi Environment
Salin file `.env.example` ke `.env` dan sesuaikan konfigurasi database Anda:
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfigurasi Database
Buka file `.env` dan ubah bagian berikut:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=salon
DB_USERNAME=root
DB_PASSWORD=
```
> Pastikan database dengan nama `salon` sudah dibuat di MySQL Anda terlebih dahulu.

### 6. Migrasi Database
```bash
php artisan migrate
```

Jika tersedia seeder (data awal):
```bash
php artisan migrate --seed
```

### 7. Jalankan Aplikasi
Buka dua terminal secara bersamaan:

**Terminal 1 — Server Laravel:**
```bash
php artisan serve
```

**Terminal 2 — Build Asset Frontend (Vite):**
```bash
npm run dev
```

Akses aplikasi di: **http://localhost:8000**

---

## ⚙️ Konfigurasi Database

File konfigurasi database berada di dua tempat:

| File | Kegunaan |
|---|---|
| `.env` | Variabel environment aktif (tidak di-commit ke Git) |
| `.env.example` | Template konfigurasi untuk instalasi baru |
| `config/database.php` | Pengaturan koneksi database default Laravel |

**Koneksi yang digunakan proyek ini:**
```
DB_CONNECTION = mysql
DB_HOST       = 127.0.0.1
DB_PORT       = 3306
DB_DATABASE   = salon
DB_USERNAME   = root
DB_PASSWORD   = (kosong untuk XAMPP default)
```

---

## 🗄️ Struktur Database

Proyek ini memiliki **4 tabel utama** yang saling berelasi:

### Diagram Relasi
```
users (id, name, email, password, role)
  │
  └──< bookings (id, service_id, employee_id, user_id, name, phone, date, time, ...)
         │              │
         │           services (id, name, description, price, duration)
         │
      employees (id, name, email, phone, user_id)
```

### Detail Tabel

#### `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint (PK) | Primary Key |
| `name` | varchar | Nama pengguna |
| `email` | varchar (UNIQUE) | Email pengguna |
| `password` | varchar | Password ter-hash (bcrypt) |
| `role` | varchar | Role: `admin` / `karyawan` |
| `timestamps` | datetime | `created_at`, `updated_at` |

#### `services` (Layanan Salon)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint (PK) | Primary Key |
| `name` | varchar | Nama layanan |
| `description` | text (nullable) | Deskripsi layanan |
| `price` | integer | Harga (dalam rupiah) |
| `duration` | integer | Durasi layanan (dalam menit) |
| `timestamps` | datetime | `created_at`, `updated_at` |

#### `employees` (Stylist/Karyawan)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint (PK) | Primary Key |
| `name` | varchar | Nama stylist |
| `email` | varchar (nullable) | Email stylist |
| `phone` | varchar (nullable) | Nomor telepon |
| `user_id` | bigint (FK, nullable) | Relasi ke tabel `users` |
| `timestamps` | datetime | `created_at`, `updated_at` |

#### `bookings` (Reservasi)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint (PK) | Primary Key |
| `service_id` | bigint (FK) | Relasi ke `services` |
| `employee_id` | bigint (FK) | Relasi ke `employees` |
| `user_id` | bigint (FK, nullable) | Relasi ke `users` (opsional) |
| `name` | varchar | Nama pelanggan |
| `phone` | varchar | Nomor telepon pelanggan |
| `date` | date | Tanggal reservasi |
| `time` | time | Jam reservasi |
| `total_price` | integer | Total harga |
| `booking_code` | varchar (UNIQUE) | Kode unik booking (format: `GLW-XXXX`) |
| `status` | enum | `pending` / `confirmed` / `done` / `cancelled` |
| `timestamps` | datetime | `created_at`, `updated_at` |

---

## 📂 Struktur Folder

```
salon/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php        # Login & Logout
│   │   │   ├── BookingController.php     # Logika reservasi & admin booking
│   │   │   ├── EmployeeController.php    # CRUD stylist (admin)
│   │   │   ├── HomeController.php        # Halaman beranda
│   │   │   ├── KaryawanController.php    # Dashboard karyawan
│   │   │   └── ServiceController.php    # CRUD layanan salon
│   │   └── Middleware/
│   └── Models/
│       ├── Booking.php                   # Model reservasi + relasi
│       ├── Employee.php                  # Model stylist + relasi
│       ├── Service.php                   # Model layanan + relasi
│       └── User.php                      # Model user (auth)
│
├── database/
│   └── migrations/                       # Skema tabel database
│       ├── ..._create_users_table.php
│       ├── ..._create_services_table.php
│       ├── ..._create_employees_table.php
│       └── ..._create_bookings_table.php
│
├── resources/
│   └── views/                            # Tampilan Blade
│       ├── layouts/app.blade.php         # Layout utama
│       ├── home.blade.php                # Halaman beranda
│       ├── booking.blade.php             # Form reservasi
│       ├── confirmation.blade.php        # Halaman konfirmasi
│       ├── success.blade.php             # Tiket/struk
│       ├── admin/                        # Halaman admin
│       │   ├── dashboard.blade.php
│       │   ├── bookings.blade.php
│       │   └── employees/
│       ├── services/                     # Halaman layanan
│       └── booking/                      # Invoice PDF
│           ├── invoice.blade.php
│           └── invoice-pdf.blade.php
│
├── routes/
│   └── web.php                           # Definisi semua rute URL
│
├── .env                                  # Konfigurasi environment (lokal)
├── .env.example                          # Template konfigurasi
├── composer.json                         # Dependensi PHP
└── package.json                          # Dependensi frontend
```

---

## 🔄 Alur Penggunaan Aplikasi

### Alur Pelanggan (Booking)
```
Beranda (/)
    │
    ▼
List Layanan (/services)
    │  Pilih layanan
    ▼
Form Booking (/booking/{id})
    │  Isi nama, telepon, tanggal, jam, stylist
    ▼
Sistem cek double booking ──(konflik?)──► Error, kembali ke form
    │ (tidak konflik)
    ▼
Halaman Konfirmasi (/booking/{id}/confirmation)
    │  Klik "Konfirmasi Sekarang"
    ▼
Halaman Sukses / Tiket (/success/{id})
    │
    ▼
Download Invoice PDF (/booking/{id}/invoice/download)
```

### Alur Admin
```
Login (/login) ──► Admin Dashboard (/admin-dashboard)
    │
    ├──► Kelola Booking (/admin/bookings)
    │        └── Update Status (AJAX PATCH)
    │
    ├──► Kelola Layanan (/services)
    │        └── Tambah / Edit / Hapus
    │
    └──► Kelola Stylist (/admin/employees)
             └── Tambah / Edit / Hapus
```

---

## 🌐 Daftar Endpoint (Routing)

### Auth
| Method | URL | Keterangan |
|---|---|---|
| `GET` | `/login` | Halaman login |
| `POST` | `/login` | Proses login |
| `POST` | `/logout` | Logout |

### Frontend (Publik)
| Method | URL | Keterangan |
|---|---|---|
| `GET` | `/` | Halaman beranda |
| `GET` | `/services` | List semua layanan |
| `GET` | `/services/create` | Form tambah layanan |
| `POST` | `/services` | Simpan layanan baru |
| `GET` | `/services/{id}/edit` | Form edit layanan |
| `PUT` | `/services/{id}` | Update layanan |
| `DELETE` | `/services/{id}` | Hapus layanan |
| `GET` | `/booking/{id}` | Form reservasi untuk layanan tertentu |
| `POST` | `/booking` | Simpan reservasi baru |
| `GET` | `/booking/{id}/confirmation` | Halaman konfirmasi reservasi |
| `POST` | `/booking/{id}/confirm` | Konfirmasi & selesaikan reservasi |
| `GET` | `/success/{id}` | Halaman sukses / tiket digital |
| `GET` | `/booking/{id}/invoice` | Preview invoice |
| `GET` | `/booking/{id}/invoice/download` | Download invoice PDF |

### API (AJAX)
| Method | URL | Keterangan |
|---|---|---|
| `GET` | `/api/calendar-events` | Data events untuk FullCalendar |

### Admin (Perlu Login sebagai `admin`)
| Method | URL | Keterangan |
|---|---|---|
| `GET` | `/admin-dashboard` | Dashboard admin |
| `GET` | `/admin/bookings` | List semua reservasi |
| `PATCH` | `/admin/bookings/{id}/status` | Update status booking (AJAX) |
| `GET` | `/admin/employees` | List semua stylist |
| `GET` | `/admin/employees/create` | Form tambah stylist |
| `POST` | `/admin/employees` | Simpan stylist baru |
| `GET` | `/admin/employees/{id}/edit` | Form edit stylist |
| `PUT` | `/admin/employees/{id}` | Update stylist |
| `DELETE` | `/admin/employees/{id}` | Hapus stylist |

### Karyawan (Perlu Login sebagai `karyawan`)
| Method | URL | Keterangan |
|---|---|---|
| `GET` | `/karyawan-dashboard` | Dashboard jadwal harian |

---

## 🧪 Pengujian CRUD dengan Postman

### Persiapan
1. Jalankan aplikasi: `php artisan serve`
2. Buka Postman dan buat **Collection** baru bernama `Shinto Salon API`
3. Untuk endpoint yang memerlukan login, lakukan login via browser terlebih dahulu atau gunakan session cookie dari browser

### Contoh Request: Membuat Booking Baru

**POST** `http://localhost:8000/booking`

```json
// Body (form-data atau x-www-form-urlencoded):
{
  "service_id":  1,
  "employee_id": 1,
  "name":        "Budi Santoso",
  "phone":       "081234567890",
  "date":        "2026-05-10",
  "time":        "10:00",
  "_token":      "<csrf_token_dari_browser>"
}
```

> **Catatan CSRF**: Laravel memerlukan CSRF token untuk request POST/PUT/PATCH/DELETE. Gunakan browser atau tambahkan header `X-CSRF-TOKEN` di Postman.

### Contoh Request: Update Status Booking (Admin AJAX)

**PATCH** `http://localhost:8000/admin/bookings/1/status`

```json
// Body:
{
  "status": "confirmed"
}
```

**Response sukses:**
```json
{
  "success": true,
  "message": "Status berhasil diperbarui menjadi Confirmed",
  "status": "confirmed"
}
```

### Contoh Request: Data Kalender

**GET** `http://localhost:8000/api/calendar-events?start=2026-05-01&end=2026-05-31`

**Response:**
```json
[
  {
    "id": 1,
    "title": "Budi Santoso — Keriting",
    "start": "2026-05-10T10:00",
    "backgroundColor": "#d4a017",
    "borderColor": "#b8860b",
    "extendedProps": {
      "booking_code": "GLW-XXXXX",
      "service": "Keriting",
      "employee": "Dewi",
      "status": "pending"
    }
  }
]
```

### Skenario Uji CRUD Lengkap

| # | Skenario | Method | URL | Expected |
|---|---|---|---|---|
| 1 | Lihat list layanan | GET | `/services` | 200 + list layanan |
| 2 | Tambah layanan baru | POST | `/services` | Redirect ke `/services` |
| 3 | Edit layanan | PUT | `/services/1` | Redirect ke `/services` |
| 4 | Hapus layanan | DELETE | `/services/1` | Redirect ke `/services` |
| 5 | Buat booking baru | POST | `/booking` | Redirect ke konfirmasi |
| 6 | Cek double booking | POST | `/booking` (jadwal sama) | Error validasi |
| 7 | Update status admin | PATCH | `/admin/bookings/1/status` | JSON response |
| 8 | Data kalender | GET | `/api/calendar-events` | JSON array events |

---

## 🔑 Akun Default

Setelah menjalankan `php artisan migrate --seed`, akun berikut tersedia:

| Role | Email | Password |
|---|---|---|
| Admin | admin@salon.com | password |
| Karyawan | karyawan@salon.com | password |

> **Penting**: Segera ganti password default setelah instalasi di lingkungan produksi.

Untuk membuat akun admin secara manual via Tinker:
```bash
php artisan tinker
```
```php
App\Models\User::create([
    'name'     => 'Administrator',
    'email'    => 'admin@salon.com',
    'password' => bcrypt('password'),
    'role'     => 'admin',
]);
```

---

## 🐛 Troubleshooting

| Masalah | Solusi |
|---|---|
| Error `APP_KEY` tidak ada | Jalankan `php artisan key:generate` |
| Halaman 500 / error database | Cek konfigurasi `.env` dan pastikan database `salon` sudah dibuat |
| Asset CSS/JS tidak tampil | Jalankan `npm run dev` di terminal terpisah |
| Double booking lolos | Pastikan migration sudah dijalankan dengan benar (`php artisan migrate:fresh`) |
| Error permission storage | Jalankan `php artisan storage:link` dan cek izin folder `storage/` |

---

## 📂 Struktur Folder Utama

- `app/Http/Controllers/` — Logika bisnis aplikasi (controller)
- `app/Models/` — Representasi struktur data (User, Service, Employee, Booking)
- `resources/views/` — File tampilan (UI) menggunakan Blade template
- `routes/web.php` — Definisi semua rute/URL aplikasi
- `database/migrations/` — Skema tabel database

---

## 🤝 Kontribusi

Jika Anda ingin berkontribusi, silakan lakukan **fork** pada repository ini dan ajukan **Pull Request**. Segala bentuk kontribusi sangat dihargai!

Langkah kontribusi:
1. Fork repository ini
2. Buat branch baru: `git checkout -b fitur/nama-fitur`
3. Commit perubahan: `git commit -m 'Tambah fitur X'`
4. Push ke branch: `git push origin fitur/nama-fitur`
5. Buat Pull Request

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">Made with ❤️ for a better Salon Experience</p>
<p align="center">© 2026 Shinto Salon. All Rights Reserved.</p>
