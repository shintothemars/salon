# Dokumentasi Kompetensi — Shinto Salon Reservation System

---

## 1. J.620100.011.01 — Instalasi Software Tools Pemrograman

### Tools yang Diinstal
| Tool | Versi | Fungsi |
|---|---|---|
| PHP | 8.2+ | Bahasa pemrograman backend |
| Composer | 2.x | Package manager PHP |
| Laravel | 12.x | Framework MVC |
| Node.js + npm | 18.x | Build tool frontend |
| MySQL | 5.7+ | Database |
| Git | Latest | Version control |

### Perintah Instalasi
```bash
composer install          # Install dependensi PHP
npm install               # Install dependensi JS
php artisan key:generate  # Generate APP_KEY
php artisan migrate       # Buat tabel database
php artisan serve         # Jalankan server
```

---

## 2. J.620100.016.01 — Menulis Kode dengan Prinsip Guidelines & Best Practices

### Prinsip yang Diterapkan

**a) Naming Convention (PSR-12)**
```php
// Class: PascalCase
class BookingController extends Controller { }
class ServiceController extends Controller { }

// Method: camelCase
public function adminIndex() { }
public function updateStatus() { }
public function calendarEvents() { }

// Variable: camelCase
$bookings = Booking::with(['service','employee'])->latest()->get();
$colorMap  = ['pending' => [...], 'confirmed' => [...]];
```

**b) Validasi Input (Setiap method yang menerima data)**
```php
// BookingController@store
$request->validate([
    'service_id'  => 'required|exists:services,id',
    'employee_id' => 'required|exists:employees,id',
    'name'        => 'required|string|max:100',
    'phone'       => 'required|string|max:20',
    'date'        => 'required|date|after:yesterday',
    'time'        => 'required|string',
]);

// ServiceController@store
$request->validate([
    'name'        => 'required|string|max:100|unique:services,name',
    'price'       => 'required|numeric|min:0',
    'duration'    => 'required|integer|min:5|max:480',
    'description' => 'nullable|string|max:500',
]);
```

**c) Mass Assignment Protection (fillable)**
```php
// Model Booking.php
protected $fillable = [
    'service_id','employee_id','user_id',
    'name','phone','date','time',
    'total_price','booking_code','status'
];
```

**d) Eager Loading (N+1 prevention)**
```php
// BENAR: dengan eager loading
$bookings = Booking::with(['service', 'employee'])->latest()->get();
```

**e) Route Grouping dengan Middleware**
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', ...);
    Route::get('/admin/bookings', ...);
});
```

**f) Flash Message (Feedback ke User)**
```php
return redirect()->route('services.index')
    ->with('success', 'Layanan berhasil ditambahkan!');
```

---

## 3. J.620100.017.02 — Mengimplementasikan Pemrograman Terstruktur

### Pola MVC yang Diterapkan

```
Request → routes/web.php → Controller → Model → Database
                                     ↓
                               View (Blade)
```

### Struktur Kontrol yang Digunakan

**a) Percabangan (if/else)**
```php
// AuthController@login
if (Auth::attempt($credentials)) {
    if (Auth::user()->role === 'admin') {
        return redirect()->intended('admin-dashboard');
    } elseif (Auth::user()->role === 'karyawan') {
        return redirect()->intended('karyawan-dashboard');
    }
    return redirect()->intended('/');
}
```

**b) Pengecekan Konflik (Pencegahan Double Booking)**
```php
// BookingController@store
$conflict = Booking::where('employee_id', $request->employee_id)
    ->whereDate('date', $request->date)
    ->where('time', $request->time)
    ->whereNotIn('status', ['cancelled'])
    ->exists();

if ($conflict) {
    return back()->withInput()->withErrors([
        'time' => 'Stylist sudah memiliki booking pada tanggal dan jam yang sama.'
    ]);
}
```

**c) Perulangan pada View (foreach/forelse)**
```blade
{{-- Loop data layanan --}}
@forelse($bookings as $booking)
    <tr>...</tr>
@empty
    <td colspan="5">Belum ada data</td>
@endforelse
```

---

## 4. J.620100.004.02 — Menggunakan Struktur Data (Array)

### Array di PHP (Backend)

**a) Array Asosiatif — `$statsData` (admin/dashboard.blade.php, baris 149–156)**
```php
$statsData = [
    ['icon' => 'bi-scissors',       'val' => Service::count(),  'label' => 'Layanan'],
    ['icon' => 'bi-calendar-check', 'val' => Booking::count(),  'label' => 'Total Reservasi'],
    ['icon' => 'bi-people',         'val' => Employee::count(), 'label' => 'Stylist'],
    ['icon' => 'bi-clock',          'val' => Booking::where('status','pending')->count(), 'label' => 'Pending'],
    ['icon' => 'bi-check-circle',   'val' => Booking::where('status','confirmed')->count(), 'label' => 'Confirmed'],
    ['icon' => 'bi-patch-check',    'val' => Booking::where('status','done')->count(), 'label' => 'Selesai'],
];
// Dipakai: @foreach($statsData as $i => $s)
```

**b) Array Asosiatif — `$statusMap` (admin/dashboard.blade.php, baris 276–281)**
```php
$statusMap = [
    'pending'   => ['pending',   '#d4a017'],
    'confirmed' => ['confirmed', '#3b82f6'],
    'done'      => ['selesai',   '#22c55e'],
    'cancelled' => ['batal',     '#9ca3af'],
];
// Destructuring: [$label, $color] = $statusMap[$booking->status];
```

**c) Array Asosiatif — `$pillStats` (admin/bookings.blade.php, baris 140–146)**
```php
$pillStats = [
    ['val' => $stats['total'],     'label' => 'Total',     'color' => 'var(--primary)'],
    ['val' => $stats['pending'],   'label' => 'Pending',   'color' => '#d4a017'],
    ['val' => $stats['confirmed'], 'label' => 'Confirmed', 'color' => '#3b82f6'],
    ['val' => $stats['done'],      'label' => 'Selesai',   'color' => '#22c55e'],
    ['val' => $stats['cancelled'], 'label' => 'Batal',     'color' => '#9ca3af'],
];
```

**d) Array Indexed — `$times` / Slot Waktu (booking.blade.php, baris 413)**
```php
$times = [
    '09:00','09:30','10:00','10:30','11:00','11:30',
    '13:00','13:30','14:00','14:30','15:00','15:30',
    '16:00','16:30','17:00','17:30','18:00','18:30'
];
// Dipakai: @foreach($times as $t) → render tombol slot waktu
```

**e) Array Warna Status — `$colorMap` (BookingController.php, baris 179–184)**
```php
$colorMap = [
    'pending'   => ['bg' => '#d4a017', 'border' => '#b8860b'],
    'confirmed' => ['bg' => '#3b82f6', 'border' => '#2563eb'],
    'done'      => ['bg' => '#22c55e', 'border' => '#16a34a'],
    'cancelled' => ['bg' => '#6b7280', 'border' => '#4b5563'],
];
// Dipakai: format data event untuk FullCalendar AJAX
```

**f) Array `$stats` — Data Statistik Booking (BookingController.php, baris 125–131)**
```php
$stats = [
    'total'     => Booking::count(),
    'pending'   => Booking::where('status', 'pending')->count(),
    'confirmed' => Booking::where('status', 'confirmed')->count(),
    'done'      => Booking::where('status', 'done')->count(),
    'cancelled' => Booking::where('status', 'cancelled')->count(),
];
// Dipakai di: view admin.bookings → tampilkan statistik
```

**g) Array `$fillable` — Mass Assignment (Semua Model)**
```php
// Booking.php
protected $fillable = [
    'service_id','employee_id','user_id',
    'name','phone','date','time',
    'total_price','booking_code','status'
];
```

### Array di JavaScript (Frontend)

**h) Object/Array Status — JavaScript (admin/bookings.blade.php, baris 282–287)**
```javascript
const statusClass = {
    pending:   'status-badge-pending',
    confirmed: 'status-badge-confirmed',
    done:      'status-badge-done',
    cancelled: 'status-badge-cancelled',
};
// Dipakai: badge.className = `status-badge ${statusClass[status]}`;
```

**i) Object Status Badge — JavaScript (admin/dashboard.blade.php, baris 403–408)**
```javascript
const statusColors = {
    pending:   ['status-badge-pending',   'Pending'],
    confirmed: ['status-badge-confirmed', 'Confirmed'],
    done:      ['status-badge-done',      'Selesai'],
    cancelled: ['status-badge-cancelled', 'Dibatalkan'],
};
// Dipakai: isi modal detail event kalender
```

---

## 5. J.620100.019.002 — Menggunakan Library / Komponen Pre-Existing

### Library Backend (PHP/Composer)

| Library | Fungsi | Cara Pakai |
|---|---|---|
| **Laravel 12** | Framework MVC | `use App\Http\Controllers\...` |
| **Barryvdh/DomPDF** | Generate PDF invoice | `Pdf::loadView()->download()` |
| **Carbon** | Format tanggal | `Carbon::parse($date)->format('d M Y')` |

**Contoh DomPDF:**
```php
// BookingController@downloadInvoice
use Barryvdh\DomPDF\Facade\Pdf;

$pdf = Pdf::loadView('booking.invoice-pdf', compact('booking'))
    ->setPaper('a5', 'portrait');
return $pdf->download('Invoice-' . $booking->booking_code . '.pdf');
```

**Contoh Carbon:**
```php
\Carbon\Carbon::parse($booking->date)->isoFormat('D MMMM YYYY')
\Carbon\Carbon::parse($request->date)->format('Y-m-d')
```

---

### Library Frontend (CDN)

**a) Bootstrap 5.3.2**
- **Fungsi**: Layout grid, komponen UI (navbar, modal, badge, tabel)
- **Dipasang di**: `layouts/app.blade.php` baris 16
- **Contoh**: Modal detail reservasi, grid card statistik

```html
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
```

**b) SweetAlert2**
- **Fungsi**: Dialog konfirmasi dan notifikasi premium
- **Dipasang di**: `layouts/app.blade.php` baris 22 & 629
- **Contoh penggunaan**:
```javascript
// Konfirmasi ubah status booking
Swal.fire({
    title: 'Ubah Status?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#c9a96e',
}).then((result) => {
    if (result.isConfirmed) { /* proses */ }
});

// Notifikasi error kalender
Swal.fire({ icon: 'error', title: 'Gagal memuat kalender' });
```

**c) Flatpickr**
- **Fungsi**: Date picker modern dengan tema gelap
- **Dipasang di**: `layouts/app.blade.php` baris 25–26, 632–633
- **Contoh penggunaan** (`booking.blade.php`, baris 627–636):
```javascript
flatpickr("#date_picker", {
    altInput: true,
    altFormat: "j F Y",   // Tampilan: "5 Mei 2026"
    dateFormat: "Y-m-d",  // Format simpan: "2026-05-05"
    minDate: "today",     // Tidak bisa pilih masa lalu
    locale: "id",         // Bahasa Indonesia
    onChange: function(selectedDates, dateStr) {
        updateSummary();
    }
});
```

**d) FullCalendar 6.1.11**
- **Fungsi**: Kalender interaktif untuk visualisasi jadwal booking
- **Dipasang di**: `layouts/app.blade.php` baris 43 & 645
- **Contoh penggunaan** (`admin/dashboard.blade.php`, baris 367–436):
```javascript
const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'id',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
    },
    events: {
        url: '/api/calendar-events', // AJAX dari BookingController@calendarEvents
        method: 'GET',
    },
    eventClick: function(info) {
        // Tampilkan modal detail booking saat event diklik
        const props = info.event.extendedProps;
        document.getElementById('modalName').textContent = props.name;
        const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
        modal.show();
    }
});
calendar.render();
```

**e) DataTables 1.13.8**
- **Fungsi**: Tabel dinamis dengan fitur search, sort, dan paginasi otomatis
- **Dipasang di**: `layouts/app.blade.php` baris 39–40 & 639–642
- **Contoh penggunaan** (`admin/bookings.blade.php`, baris 241–261):
```javascript
$('#bookingsTable').DataTable({
    responsive: true,
    pageLength: 10,
    order: [[0, 'asc']],
    language: {
        search:       'Cari:',
        lengthMenu:   'Tampilkan _MENU_ data',
        info:         'Menampilkan _START_–_END_ dari _TOTAL_ reservasi',
        zeroRecords:  'Tidak ada data yang cocok',
        emptyTable:   'Belum ada data reservasi'
    },
    columnDefs: [
        { orderable: false, targets: [8] } // Kolom aksi tidak bisa diurutkan
    ]
});
```

**f) Select2 4.1.0**
- **Fungsi**: Dropdown dengan fitur search dan tema yang bisa dikustomisasi
- **Dipasang di**: `layouts/app.blade.php` baris 35–36 & 636
- **Contoh penggunaan** (`booking.blade.php`, baris 642–668):
```javascript
// Dropdown Stylist
$('#employeeSelect').select2({
    theme: 'bootstrap-5',
    placeholder: '-- Pilih Stylist --',
    allowClear: true,
    width: '100%',
}).on('change', function() {
    // Update ringkasan pesanan saat stylist dipilih
    document.getElementById('summaryEmployee').textContent =
        $(this).find('option:selected').text();
});

// Dropdown Gender (tanpa search box)
$('#gender').select2({
    theme: 'bootstrap-5',
    minimumResultsForSearch: -1,
    width: '100%',
});
```

**g) Axios**
- **Fungsi**: HTTP client untuk request AJAX (non-jQuery)
- **Dipasang di**: `layouts/app.blade.php` baris 648
- **Contoh penggunaan 1 — Cek Double Booking** (`booking.blade.php`, baris 737–747):
```javascript
const res = await axios.get('/api/calendar-events', {
    params: { start: dateVal, end: dateVal }
});
const conflict = res.data.some(ev =>
    ev.extendedProps.time === selectedTimeValue &&
    ev.start.startsWith(dateVal)
);
```
- **Contoh penggunaan 2 — Update Status** (`admin/bookings.blade.php`, baris 277–299):
```javascript
axios.patch(`/admin/bookings/${id}/status`, { status })
    .then(res => {
        if (res.data.success) {
            // Update badge tanpa reload halaman
            badge.className = `status-badge ${statusClass[status]}`;
            Swal.fire({ icon: 'success', text: res.data.message });
        }
    });
```

**h) AOS (Animate On Scroll) 2.3.4**
- **Fungsi**: Animasi elemen saat scroll
- **Dipasang di**: `layouts/app.blade.php` baris 29 & 651
- **Inisialisasi**:
```javascript
AOS.init({ duration: 700, once: true, offset: 60 });
```
- **Contoh pakai di HTML**:
```html
<div data-aos="fade-up" data-aos-delay="100">...</div>
<div data-aos="fade-down">...</div>
```

**i) jQuery 3.7.1**
- **Fungsi**: DOM manipulation, dibutuhkan DataTables & Select2
- **Dipasang di**: `layouts/app.blade.php` baris 623
- **Contoh**:
```javascript
$(document).ready(function() { ... });
$('#bookingsTable').DataTable({ ... });
$('#employeeSelect').select2({ ... });
```

**j) Google Fonts**
- **Font**: `Outfit` (body) + `Playfair Display` (heading/brand)
- **Dipasang di**: `layouts/app.blade.php` baris 13

---

## 6. J.620100.023.02 — Membuat Dokumen Kode Program

### Komentar di Controller

**BookingController.php** — Setiap method memiliki DocBlock:
```php
/**
 * Form reservasi: pilih service -> isi data
 */
public function create($id) { ... }

/**
 * Simpan reservasi -> cek double booking -> tampil konfirmasi
 */
public function store(Request $request) { ... }

/**
 * Admin: tampil semua reservasi dengan DataTables
 */
public function adminIndex() { ... }

/**
 * API endpoint untuk FullCalendar events
 */
public function calendarEvents(Request $request) { ... }

/**
 * Download invoice sebagai PDF menggunakan DomPDF
 */
public function downloadInvoice($id) { ... }
```

**Komentar inline penting:**
```php
// BUG FIX: Validasi Double Booking (tanggal + jam + stylist)
// Warna berdasarkan status: pending → kuning, confirmed → biru
// Filter by date range (dari FullCalendar)
```

**Model Booking.php:**
```php
// Relasi ke Service
public function service() { ... }
// Relasi ke Employee
public function employee() { ... }
// Relasi ke User (pelanggan)
public function user() { ... }
```

### Komentar di JavaScript
```javascript
// Inisialisasi DataTables
// Update status booking via Axios (AJAX)
// Flatpickr - FIX: minDate "today" artinya hari ini bisa dipilih
// CEK DOUBLE BOOKING via Axios SEBELUM submit
// Setup Axios CSRF Token
// Init AOS
// Smooth scroll for anchor links
```

### README.md
File `README.md` di root proyek berisi:
- Deskripsi proyek & fitur
- Persyaratan sistem
- Langkah instalasi lengkap
- Konfigurasi database
- Struktur database & relasi
- Daftar semua endpoint/routing
- Panduan pengujian CRUD (Postman)
- Akun default
- Troubleshooting

---

## 7. J.620100.025.02 — Melakukan Debugging

### Bug yang Ditemukan & Diperbaiki

**Bug 1: Validasi Tanggal (after:today vs after:yesterday)**
```php
// SEBELUM (bug): hari ini tidak bisa dipilih
'date' => 'required|date|after:today'

// SESUDAH (fix): hari ini & besok bisa booking
'date' => 'required|date|after:yesterday'
// Komentar: // FIX: after:yesterday → hari ini & besok bisa booking
```

**Bug 2: Double Booking**
```php
// Ditambahkan validasi di BookingController@store:
$conflict = Booking::where('employee_id', $request->employee_id)
    ->whereDate('date', $request->date)
    ->where('time', $request->time)
    ->whereNotIn('status', ['cancelled'])
    ->exists();
```

**Bug 3: CSRF Token Axios**
```javascript
// Tanpa ini, semua PATCH/POST via Axios akan gagal 419
axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');
```

### Endpoint yang Diuji

| Endpoint | Method | Skenario Uji |
|---|---|---|
| `/services` | GET | Tampil list layanan |
| `/services` | POST | Tambah layanan baru |
| `/services/{id}` | PUT | Update layanan |
| `/services/{id}` | DELETE | Hapus layanan |
| `/booking` | POST | Booking normal |
| `/booking` | POST | Double booking (harus error) |
| `/admin/bookings/{id}/status` | PATCH | Update status via AJAX |
| `/api/calendar-events` | GET | Data kalender FullCalendar |
| `/booking/{id}/invoice/download` | GET | Download PDF |

---

## 8. J.620100.005.01 — Mengimplementasikan User Interface

### Halaman yang Diimplementasikan

| # | Halaman | File | Keterangan |
|---|---|---|---|
| 1 | Beranda | `home.blade.php` | Landing page salon |
| 2 | List Layanan | `services/index.blade.php` | Daftar semua layanan |
| 3 | Form Booking | `booking.blade.php` | Isi data + pilih waktu/stylist |
| 4 | Konfirmasi | `confirmation.blade.php` | Review sebelum konfirmasi |
| 5 | Tiket/Sukses | `success.blade.php` | Bukti booking |
| 6 | Invoice | `booking/invoice.blade.php` | Preview invoice |
| 7 | Admin Dashboard | `admin/dashboard.blade.php` | Statistik + FullCalendar |
| 8 | Admin Bookings | `admin/bookings.blade.php` | DataTables + update status |
| 9 | Login | `auth/login.blade.php` | Form login |

### Fitur UI yang Diimplementasikan

**Dark Mode Premium:**
```css
:root {
    --primary: #c9a96e;           /* Warna emas */
    --bg-dark: #0d0d0d;           /* Background utama */
    --bg-card: #161616;           /* Background card */
    --gradient-gold: linear-gradient(135deg, #c9a96e 0%, #e8c98a 50%, #c9a96e 100%);
}
```

**Responsive Design:**
```css
@media (max-width: 768px) {
    .page-title { font-size: 1.7rem; }
    /* Grid menyesuaikan layar mobile */
}
```

**Micro-Animations:**
```javascript
// AOS — fade-up saat scroll
// Hover effect pada kartu
// Transition status badge tanpa reload
// Spinner loading saat cek jadwal
```

**Fitur Interaktif:**
- Time slot UI (klik untuk pilih jam)
- Ringkasan pesanan real-time (update saat isi form)
- Kalender FullCalendar dengan modal popup
- Update status booking tanpa reload (AJAX)
- SweetAlert2 konfirmasi sebelum aksi penting
