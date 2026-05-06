# 📚 Penjelasan Konsep Pemrograman & Debugging

Dokumen ini menjelaskan implementasi konsep Modular, Prosedural, dan penanganan Syntax Error pada proyek Shinto Salon.

---

## 1. Pemrograman Modular (Modular Programming)
**Konsep:** Membagi program menjadi bagian-bagian kecil (modul) yang memiliki fungsi spesifik dan dapat digunakan kembali.

### Implementasi di Proyek Ini:
Proyek ini menggunakan framework Laravel yang secara alami bersifat modular:

*   **Modularitas Fungsi (Controller):** Logika dipisah berdasarkan objeknya.
    *   `BookingController.php` khusus mengurus pesanan.
    *   `ServiceController.php` khusus mengurus layanan.
    *   `EmployeeController.php` khusus mengurus karyawan.
*   **Modularitas Tampilan (Blade Layouts):** Menggunakan sistem template agar bagian yang sama tidak ditulis berulang kali.
    *   **File:** `resources/views/layouts/app.blade.php` (Sebagai kerangka utama/modul besar).
    *   **Penggunaan:** `@extends('layouts.app')` pada halaman lain. Ini adalah bentuk modularitas UI.
*   **Modularitas Data (Models):** Setiap tabel database memiliki modulnya sendiri di folder `app/Models/`.

---

## 2. Pemrograman Prosedural (Procedural Programming)
**Konsep:** Menjalankan instruksi berdasarkan urutan langkah-langkah (prosedur) dari atas ke bawah untuk menyelesaikan tugas.

### Implementasi di Proyek Ini:
Meskipun Laravel menggunakan OOP (Object-Oriented), isi di dalam setiap *function/method* dijalankan secara **prosedural**.

**Contoh Prosedural pada `BookingController.php` (Method `store`):**
1.  **Langkah 1:** Validasi input dari user.
2.  **Langkah 2:** Cek apakah waktu booking sudah lewat (Logika baru kita).
3.  **Langkah 3:** Cek apakah ada bentrok (Double booking).
4.  **Langkah 4:** Jika aman, simpan data ke database.
5.  **Langkah 5:** Redirect user ke halaman konfirmasi.

Urutan 1 sampai 5 ini adalah alur prosedural di dalam sebuah fungsi.

---

## 3. Syntax Error (Kesalahan Sintaks)
**Konsep:** Kesalahan dalam penulisan aturan bahasa pemrograman (seperti salah ketik, kurang tanda baca, dll) yang menyebabkan kode tidak bisa dijalankan.

### Contoh Umum Syntax Error:
1.  **Missing Semicolon (Kurang Titik Koma):**
    ```php
    $booking = Booking::all() // Error karena tidak ada ; di akhir
    ```
2.  **Unclosed Brackets (Kurung Tidak Tertutup):**
    ```php
    if ($conflict) {
        return back();
    // Error karena kurang tutup kurung kurawal }
    ```
3.  **Variable Undefined (Salah Ketik Nama Variabel):**
    ```php
    $name = $request->nama; 
    return view('success', compact('namee')); // Error karena variabelnya $name, bukan $namee
    ```

---

## 4. Tahapan Cara Memperbaiki Error (Debugging)

Jika terjadi error, berikut adalah langkah-langkah standar untuk memperbaikinya:

### Langkah 1: Identifikasi Pesan Error
*   **Di Browser:** Laravel akan menampilkan halaman error (Whoops!) yang memberitahu jenis error-nya (misal: `SyntaxError` atau `MethodNotFound`).
*   **Di Console (JavaScript):** Klik kanan -> Inspect -> Console untuk melihat error JS (misal: `Unexpected token`).

### Langkah 2: Cari Lokasi File & Baris
*   Pesan error biasanya menyebutkan **File Path** dan **Line Number** (Nomor Baris). 
*   Buka file tersebut dan pergi ke baris yang disebutkan.

### Langkah 3: Analisis Kode
*   Periksa tanda baca sekitar baris tersebut (apakah `;`, `}`, atau `)` lengkap?).
*   Gunakan perintah `dd($variabel);` di PHP untuk mengintip isi data sebelum error terjadi.

### Langkah 4: Perbaiki & Uji Kembali
*   Setelah diperbaiki, lakukan **Refresh** halaman.
*   Jika error hilang, berarti masalah selesai. Jika muncul error baru, ulangi dari Langkah 1.

---

### Tips Debugging di Laravel:
*   Cek file log di: `storage/logs/laravel.log` untuk melihat riwayat error yang lebih detail.
*   Pastikan server berjalan: `php artisan serve`.
