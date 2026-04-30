@extends('app')

@section('title', 'Reservasi Berhasil')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- Success Banner -->
        <div class="alert alert-success" style="text-align: center;">
            <h2 class="mb-2">✓ Reservasi Berhasil!</h2>
            <p class="mb-0">Terima kasih telah melakukan pemesanan. Berikut adalah detail reservasi Anda.</p>
        </div>

        <!-- Ticket/Invoice -->
        <div class="card border-2" style="border-color: #28a745;">
            <div class="card-header text-white" style="background-color: #28a745;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-0">🎫 TIKET RESERVASI</h4>
                    </div>
                    <div class="col-md-4 text-end">
                        <strong>{{ $booking->booking_code }}</strong>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Booking Code Section -->
                <div class="alert alert-info mb-4">
                    <strong>Kode Reservasi Anda:</strong>
                    <div class="mt-2" style="font-size: 1.5rem; font-weight: bold; font-family: monospace;">
                        {{ $booking->booking_code }}
                    </div>
                    <small class="text-muted">Simpan kode ini untuk keperluan referensi</small>
                </div>

                <!-- Service Information -->
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-6">
                        <h6 class="text-muted">LAYANAN</h6>
                        <h5>{{ $booking->service->name }}</h5>
                        @if($booking->service->description)
                            <small class="text-muted">{{ $booking->service->description }}</small>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">DURASI</h6>
                        <h5>{{ $booking->service->duration }} Menit</h5>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-6">
                        <h6 class="text-muted">NAMA PEMESAN</h6>
                        <h5>{{ $booking->name }}</h5>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">NOMOR TELEPON</h6>
                        <h5>{{ $booking->phone }}</h5>
                    </div>
                </div>

                <!-- Schedule -->
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-6">
                        <h6 class="text-muted">TANGGAL RESERVASI</h6>
                        <h5>{{ \Carbon\Carbon::parse($booking->date)->locale('id_ID')->isoFormat('dddd') }}</h5>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($booking->date)->locale('id_ID')->isoFormat('D MMMM YYYY') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">WAKTU RESERVASI</h6>
                        <h5>{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }} WIB</h5>
                    </div>
                </div>

                <!-- Assigned Employee -->
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-12">
                        <h6 class="text-muted">KARYAWAN YANG DITUGASKAN</h6>
                        <h5>{{ $booking->employee->name }}</h5>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-3">RINGKASAN PEMBAYARAN</h6>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <td>Harga Layanan</td>
                                    <td class="text-end"><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td>Diskon</td>
                                    <td class="text-end">Rp 0</td>
                                </tr>
                                <tr>
                                    <td>Pajak</td>
                                    <td class="text-end">Rp 0</td>
                                </tr>
                                <tr class="border-top">
                                    <td><strong>TOTAL PEMBAYARAN</strong></td>
                                    <td class="text-end"><strong style="font-size: 1.2rem; color: #28a745;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="alert alert-info mb-0">
                    <strong>Status Reservasi:</strong>
                    <span class="badge bg-warning text-dark">{{ ucfirst($booking->status) }}</span>
                </div>
            </div>
            <div class="card-footer text-muted small">
                <p class="mb-1">Tanggal dan Waktu Reservasi: {{ \Carbon\Carbon::now()->locale('id_ID')->isoFormat('D MMMM YYYY - H:mm') }} WIB</p>
                <p class="mb-0">Terima kasih telah menggunakan layanan kami!</p>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="card mt-4 border-warning">
            <div class="card-header bg-warning">
                <h6 class="mb-0">⚠️ Informasi Penting</h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Harap tiba 15 menit sebelum waktu reservasi</li>
                    <li>Bawa identitas diri dan bukti pembayaran</li>
                    <li>Untuk pembatalan atau perubahan, hubungi kami sebelum 24 jam dari jadwal reservasi</li>
                    <li>Email konfirmasi telah dikirim ke email Anda (jika tersedia)</li>
                    <li>Hubungi Customer Service: 0812345678 atau info@reservasi.com</li>
                </ul>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4">
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <button class="btn btn-primary" onclick="window.print()">
                    🖨️ Cetak Tiket
                </button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    Kembali ke Beranda
                </a>
            </div>
        </div>

        <!-- Share/Download Section -->
        <div class="card mt-4 bg-light">
            <div class="card-body text-center">
                <p class="mb-2"><strong>Simpan tiket ini untuk referensi</strong></p>
                <small class="text-muted">Gunakan tombol Cetak di atas untuk mencetak tiket ini, atau ambil screenshot untuk dibagikan.</small>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .alert-success, .card-footer {
            display: none;
        }
        body {
            background-color: white;
        }
        .card {
            border: 2px solid #28a745 !important;
        }
    }
</style>
@endsection
