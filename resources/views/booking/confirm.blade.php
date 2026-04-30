@extends('app')

@section('title', 'Konfirmasi Reservasi')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">✓ Konfirmasi Reservasi Anda</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Kode Reservasi:</strong> <span class="badge bg-primary">{{ $booking->booking_code }}</span>
                </div>

                <h6 class="text-muted mb-3">DETAIL LAYANAN</h6>
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-6">
                        <strong>Nama Layanan</strong>
                        <p>{{ $booking->service->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Harga</strong>
                        <p>Rp {{ number_format($booking->service->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <h6 class="text-muted mb-3">DETAIL PEMESAN</h6>
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-6">
                        <strong>Nama Pemesan</strong>
                        <p>{{ $booking->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Nomor Telepon</strong>
                        <p>{{ $booking->phone }}</p>
                    </div>
                </div>

                <h6 class="text-muted mb-3">JADWAL RESERVASI</h6>
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-6">
                        <strong>Tanggal</strong>
                        <p>{{ \Carbon\Carbon::parse($booking->date)->locale('id_ID')->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Waktu</strong>
                        <p>{{ \Carbon\Carbon::parse($booking->time)->format('H:i') }} WIB</p>
                    </div>
                </div>

                <h6 class="text-muted mb-3">KARYAWAN YANG DITUGASKAN</h6>
                <div class="row mb-4 pb-3 border-bottom">
                    <div class="col-md-12">
                        <strong>Nama Karyawan</strong>
                        <p>{{ $booking->employee->name }}</p>
                    </div>
                </div>

                <h6 class="text-muted mb-3">RINGKASAN BIAYA</h6>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga Layanan</span>
                            <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak (0%)</span>
                            <strong>Rp 0</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between" style="font-size: 1.2rem;">
                            <span><strong>Total</strong></span>
                            <strong class="text-success">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mb-4">
                    <strong>⚠️ Perhatian:</strong> Harap lakukan pembayaran sebelum jadwal reservasi untuk mengonfirmasi pesanan Anda.
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                    <a href="{{ route('booking.success', $booking->id) }}" class="btn btn-success btn-lg">
                        Konfirmasi & Lanjutkan
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body text-muted small">
                <p><strong>Catatan:</strong></p>
                <ul class="mb-0">
                    <li>Simpan kode reservasi Anda: <strong>{{ $booking->booking_code }}</strong></li>
                    <li>Anda akan menerima email konfirmasi jika pembayaran berhasil</li>
                    <li>Untuk pembatalan, hubungi customer service kami</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
