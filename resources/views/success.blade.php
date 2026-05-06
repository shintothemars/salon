@extends('layouts.app')

@section('title', 'Reservasi Berhasil!')

@push('styles')
<style>
    .success-page {
        min-height: 90vh;
        display: flex;
        flex-direction: column;
        padding: 60px 0;
    }

    /* Confetti animation */
    .confetti-wrapper {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        pointer-events: none;
        z-index: 9999;
        overflow: hidden;
    }

    .confetti-piece {
        position: absolute;
        width: 8px;
        height: 8px;
        top: -20px;
        border-radius: 2px;
        animation: confettiFall linear forwards;
    }

    @keyframes confettiFall {
        0% { transform: translateY(0) rotate(0deg); opacity: 1; }
        80% { opacity: 1; }
        100% { transform: translateY(110vh) rotate(720deg); opacity: 0; }
    }

    /* Ticket card */
    .ticket-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 24px;
        overflow: hidden;
        max-width: 720px;
        margin: 0 auto;
        box-shadow: 0 32px 80px rgba(0,0,0,0.6);
        position: relative;
    }

    /* Ticket top section */
    .ticket-top {
        background: linear-gradient(135deg, #1a1208 0%, #2d1e08 40%, #1a1208 100%);
        padding: 40px 40px 60px;
        position: relative;
        overflow: hidden;
    }

    .ticket-top::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 280px; height: 280px;
        border-radius: 50%;
        border: 1px solid rgba(201,169,110,0.1);
    }

    .ticket-top::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 30px;
        width: 200px; height: 200px;
        border-radius: 50%;
        border: 1px solid rgba(201,169,110,0.07);
    }

    .ticket-success-icon {
        width: 72px;
        height: 72px;
        background: var(--gradient-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #0d0d0d;
        margin: 0 auto 20px;
        position: relative;
        z-index: 1;
        animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
    }

    @keyframes popIn {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .ticket-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--text-primary);
        text-align: center;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }

    .ticket-subtitle {
        text-align: center;
        color: var(--text-muted);
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    /* Ticket cut */
    .ticket-cut {
        position: relative;
        height: 28px;
        background: var(--bg-card);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 8px;
    }

    .ticket-cut::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0; right: 0;
        height: 1px;
        border-top: 2px dashed var(--bg-border);
        transform: translateY(-50%);
    }

    .ticket-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--bg-dark);
        z-index: 1;
        flex-shrink: 0;
    }

    /* Ticket body */
    .ticket-body { padding: 32px 40px; }

    .ticket-code-section {
        text-align: center;
        margin-bottom: 28px;
    }

    .ticket-code {
        display: inline-block;
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: 6px;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Outfit', monospace;
        background-size: 200%;
        animation: shimmer 3s linear infinite;
    }

    .ticket-code-label {
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    /* QR Code visual */
    .qr-code-container {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .qr-box {
        background: white;
        padding: 14px;
        border-radius: 12px;
        display: inline-block;
    }

    .qr-grid {
        width: 100px;
        height: 100px;
        display: grid;
        grid-template-columns: repeat(10, 1fr);
        grid-template-rows: repeat(10, 1fr);
        gap: 1.5px;
    }

    .qr-px { border-radius: 1px; }

    /* Ticket details */
    .ticket-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--bg-border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .ticket-detail-cell {
        background: var(--bg-surface);
        padding: 14px 18px;
    }

    .ticket-detail-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 3px;
    }

    .ticket-detail-value {
        font-size: 0.92rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .ticket-service-banner {
        background: rgba(201,169,110,0.08);
        border: 1px solid rgba(201,169,110,0.2);
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 24px;
    }

    .ticket-service-icon {
        width: 50px;
        height: 50px;
        background: rgba(201,169,110,0.15);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
    }

    .ticket-total {
        background: var(--gradient-gold);
        border-radius: 12px;
        padding: 18px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .ticket-total-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: rgba(0,0,0,0.7);
    }

    .ticket-total-price {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0d0d0d;
    }

    /* Footer actions */
    .ticket-footer {
        padding: 24px 40px;
        border-top: 1px dashed var(--bg-border);
        background: var(--bg-surface);
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .action-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .action-badge i { color: var(--primary); }

    /* Share buttons */
    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 50px;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        border: none;
    }

    .share-wa {
        background: rgba(37,211,102,0.15);
        color: #25d366;
        border: 1px solid rgba(37,211,102,0.25);
    }

    .share-wa:hover {
        background: rgba(37,211,102,0.25);
        color: #25d366;
    }

    .print-btn {
        background: rgba(201,169,110,0.12);
        color: var(--primary);
        border: 1px solid rgba(201,169,110,0.25);
    }

    .print-btn:hover {
        background: rgba(201,169,110,0.22);
        color: var(--primary);
    }

    @media print {
        .no-print { display: none !important; }
        .ticket-card { box-shadow: none; border: 1px solid #ccc; }
        body { background: white !important; color: black !important; }
    }
</style>
@endpush

@section('content')

<!-- Confetti -->
<div class="confetti-wrapper" id="confettiWrapper"></div>

<div class="success-page">
    <div class="container">

        <!-- Ticket Card -->
        <div class="ticket-card animate-fade-up" style="animation-delay:0.2s;">

            <!-- Ticket Top -->
            <div class="ticket-top">
                <div class="ticket-success-icon">
                    <i class="bi bi-check-lg"></i>
                </div>
                <h1 class="ticket-title">Reservasi Berhasil! 🎉</h1>
                <p class="ticket-subtitle">Pemesanan Anda telah dikonfirmasi. Tiket telah disiapkan di bawah.</p>
            </div>

            <!-- Tear Cut -->
            <div class="ticket-cut">
                <div class="ticket-circle"></div>
                <div class="ticket-circle"></div>
            </div>

            <!-- Ticket Body -->
            <div class="ticket-body">

                <!-- Booking Code -->
                <div class="ticket-code-section">
                    <div class="ticket-code-label">Kode Booking</div>
                    <div class="ticket-code">{{ $booking->booking_code ?? 'GLW-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>

                <!-- QR Code Visual -->
                <div class="qr-code-container">
                    <div class="qr-box" title="QR Code untuk check-in">
                        <div class="qr-grid" id="qrGrid"></div>
                    </div>
                </div>
                <p style="text-align:center;color:var(--text-muted);font-size:0.78rem;margin-top:8px;margin-bottom:24px;">Tunjukkan QR Code ini saat datang ke salon</p>

                <!-- Service Banner -->
                <div class="ticket-service-banner">
                    <div class="ticket-service-icon">
                        @if(stripos($booking->service->name, 'creambath') !== false || stripos($booking->service->name, 'rambut') !== false) 💇‍♀️
                        @elseif(stripos($booking->service->name, 'facial') !== false || stripos($booking->service->name, 'wajah') !== false) 💆‍♀️
                        @elseif(stripos($booking->service->name, 'nail') !== false || stripos($booking->service->name, 'kuku') !== false) 💅
                        @elseif(stripos($booking->service->name, 'massage') !== false || stripos($booking->service->name, 'pijat') !== false) 🧖‍♀️
                        @elseif(stripos($booking->service->name, 'make') !== false) 💄
                        @else ✨ @endif
                    </div>
                    <div>
                        <div style="font-weight:700;font-size:1.05rem;color:var(--text-primary);margin-bottom:4px;">{{ $booking->service->name }}</div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <span class="badge-gold">{{ $booking->service->duration }} Menit</span>
                            <span class="badge-success">Terkonfirmasi</span>
                        </div>
                    </div>
                </div>

                <!-- Detail Cells -->
                <div class="ticket-details">
                    <div class="ticket-detail-cell">
                        <div class="ticket-detail-label">Nama Pemesan</div>
                        <div class="ticket-detail-value">{{ $booking->name }}</div>
                    </div>
                    <div class="ticket-detail-cell">
                        <div class="ticket-detail-label">No. HP</div>
                        <div class="ticket-detail-value">{{ $booking->phone }}</div>
                    </div>
                    <div class="ticket-detail-cell">
                        <div class="ticket-detail-label">Tanggal</div>
                        <div class="ticket-detail-value">
                            {{ \Carbon\Carbon::parse($booking->date)->isoFormat('D MMMM YYYY') }}
                        </div>
                    </div>
                    <div class="ticket-detail-cell">
                        <div class="ticket-detail-label">Waktu</div>
                        <div class="ticket-detail-value">{{ $booking->time }} WIB</div>
                    </div>
                    <div class="ticket-detail-cell">
                        <div class="ticket-detail-label">Stylist</div>
                        <div class="ticket-detail-value">{{ $booking->employee->name ?? 'Siapapun' }}</div>
                    </div>
                    <div class="ticket-detail-cell">
                        <div class="ticket-detail-label">Durasi</div>
                        <div class="ticket-detail-value">± {{ $booking->service->duration }} menit</div>
                    </div>
                </div>

                <!-- Total -->
                <div class="ticket-total">
                    <div class="ticket-total-label">Total Pembayaran</div>
                    <div class="ticket-total-price">Rp {{ number_format($booking->total_price ?? $booking->service->price, 0, ',', '.') }}</div>
                </div>

                <!-- Info Badges -->
                <div class="d-flex gap-2 flex-wrap justify-content-center mb-4">
                    <div class="action-badge"><i class="bi bi-clock"></i> Tiba 10 mnt sebelumnya</div>
                    <div class="action-badge"><i class="bi bi-geo-alt"></i> Jl. Sudirman No. 45, Jakarta</div>
                    <div class="action-badge"><i class="bi bi-telephone"></i> +62 812-3456-7890</div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 justify-content-center flex-wrap no-print">
                    <a href="https://wa.me/6281234567890?text=Halo%2C+saya+{{ urlencode($booking->name) }}+dengan+kode+booking+{{ $booking->booking_code ?? 'GLW-'.str_pad($booking->id,5,'0',STR_PAD_LEFT) }}"
                        target="_blank"
                        class="share-btn share-wa">
                        <i class="bi bi-whatsapp"></i> Chat via WhatsApp
                    </a>
                    <a href="{{ route('booking.invoice.download', $booking->id) }}"
                        class="share-btn print-btn">
                        <i class="bi bi-file-earmark-pdf"></i> Download Invoice
                    </a>
                    <button onclick="window.print()" class="share-btn print-btn">
                        <i class="bi bi-printer"></i> Cetak Tiket
                    </button>
                    <a href="/" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                        <i class="bi bi-house"></i> Ke Beranda
                    </a>
                </div>

            </div>

            <!-- Ticket Footer -->
            <div class="ticket-footer no-print">
                <span style="font-size:0.82rem;color:var(--text-muted);">
                    <i class="bi bi-shield-check" style="color:var(--success);"></i>
                    Tiket ini valid dan telah terkonfirmasi oleh sistem GlowSalon
                </span>
            </div>

        </div>

        <!-- Back to home -->
        <div class="text-center mt-5 no-print" data-animate>
            <p style="color:var(--text-muted);font-size:0.9rem;margin-bottom:16px;">Ingin memesan layanan lain?</p>
            <a href="/" class="btn-gold text-decoration-none">
                <i class="bi bi-grid me-2"></i>Lihat Layanan Lainnya
            </a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    // Generate QR visual
    (function() {
        const grid = document.getElementById('qrGrid');
        if (!grid) return;
        const pattern = [
            1,1,1,1,1,1,1,0,1,0,
            1,0,0,0,0,0,1,0,0,1,
            1,0,1,1,1,0,1,0,1,0,
            1,0,1,1,1,0,1,0,1,1,
            1,0,1,1,1,0,1,0,0,0,
            1,0,0,0,0,0,1,0,1,0,
            1,1,1,1,1,1,1,0,1,1,
            0,0,0,0,0,0,0,0,0,0,
            1,1,0,1,0,1,0,1,1,0,
            0,1,1,0,1,0,1,0,0,1,
        ];
        pattern.forEach(v => {
            const cell = document.createElement('div');
            cell.className = 'qr-px';
            cell.style.background = v ? '#111' : 'white';
            grid.appendChild(cell);
        });
    })();

    // Confetti
    (function() {
        const wrapper = document.getElementById('confettiWrapper');
        const colors = ['#c9a96e', '#e8c98a', '#f0e6d3', '#4caf7d', '#ffffff'];
        const shapes = ['square', 'circle'];

        for (let i = 0; i < 80; i++) {
            const el = document.createElement('div');
            el.className = 'confetti-piece';
            const color = colors[Math.floor(Math.random() * colors.length)];
            const left = Math.random() * 100;
            const delay = Math.random() * 3;
            const duration = 2.5 + Math.random() * 2;
            const size = 6 + Math.random() * 8;
            el.style.cssText = `
                left: ${left}vw;
                width: ${size}px;
                height: ${size}px;
                background: ${color};
                border-radius: ${shapes[Math.floor(Math.random() * 2)] === 'circle' ? '50%' : '2px'};
                animation-duration: ${duration}s;
                animation-delay: ${delay}s;
                opacity: 0.85;
            `;
            wrapper.appendChild(el);
        }

        // Remove confetti after 6 seconds
        setTimeout(() => {
            wrapper.style.opacity = '0';
            wrapper.style.transition = 'opacity 1s ease';
            setTimeout(() => wrapper.remove(), 1000);
        }, 5000);
    })();
</script>
@endpush