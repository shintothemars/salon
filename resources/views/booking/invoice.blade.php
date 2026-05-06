@extends('layouts.app')

@section('title', 'Invoice - ' . $booking->booking_code)

@push('styles')
<style>
    .invoice-header {
        background: var(--bg-card);
        border-bottom: 1px solid var(--bg-border);
        padding: 40px 0;
    }
    .invoice-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
        max-width: 680px;
        margin: 0 auto;
    }
    .invoice-top {
        background: linear-gradient(135deg, #1a1208, #2a1e0c);
        padding: 32px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
    }
    .invoice-brand {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .invoice-meta { text-align: right; }
    .invoice-code {
        font-family: monospace;
        font-size: 1rem;
        color: var(--primary);
        font-weight: 700;
    }
    .invoice-body { padding: 32px; }
    .invoice-section-title {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 12px;
    }
    .invoice-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--bg-border);
        font-size: 0.9rem;
    }
    .invoice-row:last-child { border-bottom: none; }
    .invoice-row-label { color: var(--text-muted); }
    .invoice-row-value { font-weight: 600; color: var(--text-primary); text-align: right; }
    .invoice-total {
        background: rgba(201,169,110,0.08);
        border: 1px solid rgba(201,169,110,0.2);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    .invoice-total-label { font-weight: 600; color: var(--text-secondary); }
    .invoice-total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .invoice-footer {
        background: var(--bg-surface);
        padding: 20px 32px;
        border-top: 1px solid var(--bg-border);
        text-align: center;
    }
    .status-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px; border-radius: 50px;
        font-size: 0.8rem; font-weight: 600;
    }
    .qr-section {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }
    .qr-box {
        background: white;
        padding: 12px;
        border-radius: 12px;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="invoice-header" data-aos="fade-down">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="page-title mb-1">Invoice <span style="font-style:italic;">Reservasi</span></h1>
                <p class="page-subtitle">Bukti pemesanan layanan GlowSalon</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('booking.invoice.download', $booking->id) }}"
                   class="btn-gold text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Download PDF
                </a>
                <a href="javascript:window.print()"
                   class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-printer"></i> Print
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="invoice-card" data-aos="fade-up">

        <!-- TOP -->
        <div class="invoice-top">
            <div>
                <div class="invoice-brand">GlowSalon</div>
                <div style="font-size:0.82rem; color: rgba(201,169,110,0.6); margin-top:4px;">
                    Platform Reservasi Kecantikan Profesional
                </div>
                <div style="font-size:0.78rem; color:var(--text-muted); margin-top:8px; line-height:1.6;">
                    <i class="bi bi-geo-alt me-1"></i> Jakarta, Indonesia<br>
                    <i class="bi bi-envelope me-1"></i> hello@glowsalon.id
                </div>
            </div>
            <div class="invoice-meta">
                <div style="font-size:0.75rem; color:var(--text-muted); margin-bottom:6px; text-transform:uppercase; letter-spacing:1px;">Invoice</div>
                <div class="invoice-code">{{ $booking->booking_code }}</div>
                <div style="font-size:0.8rem; color:var(--text-muted); margin-top:6px;">
                    Dibuat: {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                </div>
                @php
                    $statusMap = [
                        'pending'   => ['bg' => 'rgba(212,160,23,0.2)',  'color' => '#d4a017', 'label' => 'Pending'],
                        'confirmed' => ['bg' => 'rgba(59,130,246,0.2)',  'color' => '#3b82f6', 'label' => 'Confirmed'],
                        'done'      => ['bg' => 'rgba(34,197,94,0.2)',   'color' => '#22c55e', 'label' => 'Selesai'],
                        'cancelled' => ['bg' => 'rgba(107,114,128,0.2)','color' => '#9ca3af', 'label' => 'Dibatalkan'],
                    ];
                    $st = $statusMap[$booking->status] ?? $statusMap['pending'];
                @endphp
                <div style="margin-top:8px;">
                    <span class="status-pill" style="background:{{ $st['bg'] }}; color:{{ $st['color'] }}; border: 1px solid {{ $st['color'] }}40;">
                        <span style="width:6px;height:6px;border-radius:50%;background:{{ $st['color'] }};display:inline-block;"></span>
                        {{ $st['label'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="invoice-body">

            <!-- Info Pemesan -->
            <div style="margin-bottom:28px;">
                <div class="invoice-section-title">Data Pemesan</div>
                <div class="invoice-row">
                    <span class="invoice-row-label">Nama</span>
                    <span class="invoice-row-value">{{ $booking->name }}</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-row-label">No. HP</span>
                    <span class="invoice-row-value">{{ $booking->phone }}</span>
                </div>
            </div>

            <!-- Info Reservasi -->
            <div style="margin-bottom:28px;">
                <div class="invoice-section-title">Detail Reservasi</div>
                <div class="invoice-row">
                    <span class="invoice-row-label">Layanan</span>
                    <span class="invoice-row-value">{{ $booking->service->name }}</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-row-label">Durasi</span>
                    <span class="invoice-row-value">{{ $booking->service->duration }} Menit</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-row-label">Stylist</span>
                    <span class="invoice-row-value">{{ $booking->employee->name }}</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-row-label">Tanggal</span>
                    <span class="invoice-row-value">{{ \Carbon\Carbon::parse($booking->date)->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
                <div class="invoice-row">
                    <span class="invoice-row-label">Waktu</span>
                    <span class="invoice-row-value">{{ $booking->time }} WIB</span>
                </div>
            </div>

            <!-- QR Code (JavaScript) -->
            <div class="qr-section">
                <div>
                    <div class="qr-box" id="qrcode"></div>
                    <div style="text-align:center; font-size:0.75rem; color:var(--text-muted); margin-top:6px;">
                        Scan untuk verifikasi
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="invoice-total">
                <div class="invoice-total-label">Total Pembayaran</div>
                <div class="invoice-total-amount">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="invoice-footer">
            <p style="font-size:0.8rem; color:var(--text-muted); margin:0;">
                Terima kasih telah mempercayakan kecantikan Anda kepada <strong style="color:var(--primary);">GlowSalon</strong>.
                Harap tiba 10 menit sebelum jadwal.
            </p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('booking.success', $booking->id) }}" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2" style="font-size:0.88rem;">
            <i class="bi bi-arrow-left"></i> Kembali ke Tiket
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
/* QR Code khusus agar terlihat di dark mode */
#qrcode canvas, #qrcode img { border-radius: 8px; display: block; }
</style>
@endpush

@push('scripts')
<!-- QRCode.js library (tidak perlu ext-gd) -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        QRCode.toCanvas(
            document.createElement('canvas'),
            '{{ $booking->booking_code }}',
            { width: 130, margin: 1, color: { dark: '#1a1208', light: '#ffffff' } },
            function (error, canvas) {
                if (!error) {
                    document.getElementById('qrcode').appendChild(canvas);
                }
            }
        );
    });
</script>
@endpush
