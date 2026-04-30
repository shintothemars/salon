@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan')

@push('styles')
<style>
    .confirm-hero {
        background: var(--bg-card);
        border-bottom: 1px solid var(--bg-border);
        padding: 40px 0;
    }

    .confirm-main-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 24px;
        overflow: hidden;
    }

    .confirm-top-banner {
        background: linear-gradient(135deg, #1a1208 0%, #2d1f0a 40%, #1a1510 100%);
        padding: 32px;
        position: relative;
        overflow: hidden;
    }

    .confirm-top-banner::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        border-radius: 50%;
        border: 1px solid rgba(201,169,110,0.1);
    }

    .confirm-top-banner::after {
        content: '';
        position: absolute;
        bottom: -60px; right: 40px;
        width: 280px; height: 280px;
        border-radius: 50%;
        border: 1px solid rgba(201,169,110,0.06);
    }

    .confirm-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 193, 7, 0.15);
        border: 1px solid rgba(255, 193, 7, 0.3);
        color: #ffc107;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
    }

    .confirm-code {
        font-family: 'Outfit', monospace;
        font-size: 2rem;
        font-weight: 800;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 4px;
    }

    .confirm-body { padding: 32px; }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--bg-border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .detail-cell {
        background: var(--bg-surface);
        padding: 16px 20px;
    }

    .detail-cell-label {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .detail-cell-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .booking-service-block {
        background: rgba(201,169,110,0.07);
        border: 1px solid rgba(201,169,110,0.2);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .booking-service-emoji {
        width: 56px;
        height: 56px;
        background: rgba(201,169,110,0.15);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        flex-shrink: 0;
    }

    .price-confirm-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-radius: 10px;
        border: 1px solid var(--bg-border);
        background: var(--bg-surface);
        margin-bottom: 10px;
    }

    .price-confirm-total {
        background: var(--gradient-gold);
        border-color: transparent;
        padding: 18px 20px;
    }

    .price-confirm-total .price-label { color: rgba(0,0,0,0.7); font-weight: 700; }
    .price-confirm-total .price-val { color: #0d0d0d; font-size: 1.4rem; font-weight: 800; }
    .price-label { font-size: 0.9rem; color: var(--text-muted); }
    .price-val { font-size: 1rem; font-weight: 700; color: var(--text-primary); }

    /* Action sidebar */
    .action-sidebar { position: sticky; top: 80px; }

    .action-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .action-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--bg-border);
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-card-body { padding: 20px; }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--bg-border);
    }

    .info-item:last-child { border-bottom: none; }

    .info-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(201,169,110,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .info-text { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.5; }
    .info-text strong { color: var(--text-primary); display: block; margin-bottom: 1px; font-size: 0.85rem; }

    /* QR placeholder */
    .qr-placeholder {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        position: relative;
    }

    .qr-inner {
        width: 90px;
        height: 90px;
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        grid-template-rows: repeat(7, 1fr);
        gap: 1px;
    }

    .qr-cell { background: #111; border-radius: 1px; }
    .qr-cell.white { background: white; }
</style>
@endpush

@section('content')

<div class="confirm-hero">
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-bottom:8px;">
            <ol class="breadcrumb" style="font-size:0.82rem;color:var(--text-muted);margin:0;">
                <li class="breadcrumb-item"><a href="/" style="color:var(--text-muted);text-decoration:none;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/booking/{{ $booking->service_id }}" style="color:var(--text-muted);text-decoration:none;">Reservasi</a></li>
                <li class="breadcrumb-item active" style="color:var(--primary);">Konfirmasi</li>
            </ol>
        </nav>
        <h1 class="page-title mb-1">Konfirmasi <span style="font-style:italic;">Pemesanan</span></h1>
        <p class="page-subtitle">Periksa kembali detail reservasi Anda sebelum melanjutkan</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">

        <!-- MAIN DETAIL -->
        <div class="col-lg-8">
            <div class="confirm-main-card">

                <!-- Top Banner -->
                <div class="confirm-top-banner">
                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                        <div>
                            <div class="confirm-status-badge mb-3">
                                <i class="bi bi-hourglass-split"></i>
                                Menunggu Konfirmasi
                            </div>
                            <div style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--text-primary);margin-bottom:8px;font-style:italic;">
                                Detail Reservasi
                            </div>
                            <div style="color:var(--text-muted);font-size:0.88rem;">Kode pemesanan Anda:</div>
                            <div class="confirm-code">{{ $booking->booking_code ?? 'GLW-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:4px;">Dibuat pada</div>
                            <div style="font-size:0.9rem;font-weight:600;color:var(--text-primary);">{{ $booking->created_at->format('d M Y') }}</div>
                            <div style="font-size:0.82rem;color:var(--text-muted);">{{ $booking->created_at->format('H:i') }} WIB</div>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="confirm-body">

                    <!-- Service Info -->
                    <div class="booking-service-block">
                        <div class="booking-service-emoji">
                            @if(stripos($booking->service->name, 'creambath') !== false || stripos($booking->service->name, 'rambut') !== false) 💇‍♀️
                            @elseif(stripos($booking->service->name, 'facial') !== false || stripos($booking->service->name, 'wajah') !== false) 💆‍♀️
                            @elseif(stripos($booking->service->name, 'nail') !== false || stripos($booking->service->name, 'kuku') !== false) 💅
                            @elseif(stripos($booking->service->name, 'massage') !== false || stripos($booking->service->name, 'pijat') !== false) 🧖‍♀️
                            @elseif(stripos($booking->service->name, 'make') !== false) 💄
                            @else ✨ @endif
                        </div>
                        <div>
                            <div style="font-weight:700;font-size:1.1rem;color:var(--text-primary);margin-bottom:4px;">{{ $booking->service->name }}</div>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <span class="badge-gold">{{ $booking->service->duration }} Menit</span>
                                @if($booking->employee)
                                <span style="background:rgba(91,155,213,0.12);color:var(--info);border:1px solid rgba(91,155,213,0.25);padding:4px 12px;border-radius:50px;font-size:0.78rem;font-weight:600;">
                                    Stylist: {{ $booking->employee->name }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Detail Grid -->
                    <div style="margin-bottom:8px;font-size:0.78rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--primary);">Detail Reservasi</div>
                    <div class="detail-grid mb-4">
                        <div class="detail-cell">
                            <div class="detail-cell-label">Pemesan</div>
                            <div class="detail-cell-value">{{ $booking->name }}</div>
                        </div>
                        <div class="detail-cell">
                            <div class="detail-cell-label">No. HP</div>
                            <div class="detail-cell-value">{{ $booking->phone }}</div>
                        </div>
                        <div class="detail-cell">
                            <div class="detail-cell-label">Tanggal</div>
                            <div class="detail-cell-value">
                                {{ \Carbon\Carbon::parse($booking->date)->isoFormat('dddd, D MMMM YYYY') }}
                            </div>
                        </div>
                        <div class="detail-cell">
                            <div class="detail-cell-label">Waktu</div>
                            <div class="detail-cell-value">{{ $booking->time }} WIB</div>
                        </div>
                        <div class="detail-cell">
                            <div class="detail-cell-label">Stylist</div>
                            <div class="detail-cell-value">{{ $booking->employee->name ?? 'Siapapun' }}</div>
                        </div>
                        <div class="detail-cell">
                            <div class="detail-cell-label">Status</div>
                            <div class="detail-cell-value">
                                <span class="badge-gold">{{ ucfirst($booking->status ?? 'pending') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div style="margin-bottom:8px;font-size:0.78rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--primary);">Rincian Pembayaran</div>
                    <div class="price-confirm-row">
                        <span class="price-label">Harga Layanan</span>
                        <span class="price-val">Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-confirm-row">
                        <span class="price-label">Biaya Administrasi</span>
                        <span class="price-val">Rp 0</span>
                    </div>
                    <div class="price-confirm-row price-confirm-total">
                        <span class="price-label">Total Pembayaran</span>
                        <span class="price-val">Rp {{ number_format($booking->total_price ?? $booking->service->price, 0, ',', '.') }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 mt-4 flex-wrap">
                        <form method="POST" action="/booking/{{ $booking->id }}/confirm" class="d-flex gap-3">
                            @csrf
                            <button type="submit" class="btn-gold d-inline-flex align-items-center gap-2" id="confirmBookingBtn">
                                <i class="bi bi-check-circle"></i>
                                Konfirmasi & Bayar
                            </button>
                        </form>
                        <a href="/booking/{{ $booking->service_id }}" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                            <i class="bi bi-pencil"></i> Ubah Data
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- SIDEBAR -->
        <div class="col-lg-4">
            <div class="action-sidebar">

                <!-- Kebijakan -->
                <div class="action-card">
                    <div class="action-card-header">
                        <i class="bi bi-info-circle" style="color:var(--primary);"></i>
                        Informasi Penting
                    </div>
                    <div class="action-card-body">
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-clock-history"></i></div>
                            <div class="info-text">
                                <strong>Datang Tepat Waktu</strong>
                                Harap tiba 10 menit sebelum jadwal reservasi Anda.
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-x-circle"></i></div>
                            <div class="info-text">
                                <strong>Kebijakan Pembatalan</strong>
                                Pembatalan dapat dilakukan hingga 2 jam sebelum jadwal.
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-telephone"></i></div>
                            <div class="info-text">
                                <strong>Butuh Bantuan?</strong>
                                Hubungi kami di +62 812-3456-7890
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="action-card">
                    <div class="action-card-header">
                        <i class="bi bi-geo-alt" style="color:var(--primary);"></i>
                        Lokasi Salon
                    </div>
                    <div class="action-card-body">
                        <div style="background:var(--bg-surface);border:1px solid var(--bg-border);border-radius:10px;padding:16px;text-align:center;margin-bottom:12px;">
                            <div style="font-size:2rem;margin-bottom:6px;">📍</div>
                            <div style="font-weight:600;color:var(--text-primary);margin-bottom:4px;">GlowSalon Jakarta</div>
                            <div style="font-size:0.82rem;color:var(--text-muted);">Jl. Sudirman No. 45, Jakarta Pusat</div>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="btn-ghost text-decoration-none d-block text-center" style="font-size:0.88rem;">
                            <i class="bi bi-map me-2"></i>Buka di Google Maps
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
