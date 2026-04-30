@extends('layouts.app')

@section('title', 'Beranda')
@section('nav_home', 'active')

@push('styles')
<style>
    /* ===== HERO ===== */
    .hero-section {
        min-height: 88vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding: 60px 0;
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 80% 60% at 70% 50%, rgba(201, 169, 110, 0.08) 0%, transparent 60%),
            radial-gradient(ellipse 50% 70% at 10% 80%, rgba(201, 169, 110, 0.04) 0%, transparent 50%);
        pointer-events: none;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(201, 169, 110, 0.1);
        border: 1px solid rgba(201, 169, 110, 0.25);
        color: var(--primary);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 24px;
    }

    .hero-badge::before {
        content: '';
        width: 6px; height: 6px;
        background: var(--primary);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.8); }
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 6vw, 4.2rem);
        line-height: 1.15;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .hero-title .gradient-text {
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        background-size: 200%;
        animation: shimmer 3s linear infinite;
    }

    .hero-desc {
        color: var(--text-secondary);
        font-size: 1.1rem;
        line-height: 1.8;
        max-width: 520px;
        margin-bottom: 36px;
    }

    .hero-stats {
        display: flex;
        gap: 32px;
        margin-top: 48px;
        padding-top: 36px;
        border-top: 1px solid var(--bg-border);
    }

    .hero-stat-num {
        font-size: 2rem;
        font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    .hero-stat-label {
        color: var(--text-muted);
        font-size: 0.82rem;
        margin-top: 4px;
        font-weight: 500;
    }

    .hero-image-wrapper { position: relative; padding: 24px; }

    .hero-image-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 24px;
        overflow: hidden;
        position: relative;
    }

    .hero-image-badge {
        position: absolute;
        bottom: 28px;
        left: 28px;
        right: 28px;
        background: rgba(13, 13, 13, 0.85);
        backdrop-filter: blur(12px);
        border: 1px solid var(--bg-border);
        border-radius: 12px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .hero-floating-card {
        position: absolute;
        top: 40px;
        right: -10px;
        background: var(--bg-card);
        border: 1px solid rgba(201, 169, 110, 0.25);
        border-radius: 16px;
        padding: 16px 20px;
        min-width: 160px;
        box-shadow: var(--shadow-gold);
        animation: floatY 3s ease-in-out infinite;
    }

    @keyframes floatY {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* ===== SECTIONS ===== */
    .section-eyebrow {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 10px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        font-weight: 600;
        line-height: 1.25;
        margin-bottom: 16px;
    }

    .section-title .highlight {
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===== SERVICE CARD ===== */
    .service-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
        transition: var(--transition);
        height: 100%;
        cursor: pointer;
    }

    .service-card:hover {
        border-color: rgba(201, 169, 110, 0.35);
        transform: translateY(-6px);
        box-shadow: 0 20px 48px rgba(0,0,0,0.5), var(--shadow-gold);
    }

    .service-card-img-wrapper {
        overflow: hidden;
        position: relative;
    }

    .service-card-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 40%, rgba(13,13,13,0.7) 100%);
    }

    .service-badge-overlay {
        position: absolute;
        top: 12px;
        right: 12px;
    }

    .service-body { padding: 20px; }

    .service-name {
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 6px;
        color: var(--text-primary);
    }

    .service-desc {
        font-size: 0.88rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin-bottom: 16px;
    }

    .service-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 16px;
        border-top: 1px solid var(--bg-border);
    }

    .service-price {
        font-size: 1.15rem;
        font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .service-duration {
        color: var(--text-muted);
        font-size: 0.82rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .service-book-btn {
        display: block;
        width: 100%;
        text-align: center;
        background: rgba(201, 169, 110, 0.1);
        border: 1px solid rgba(201, 169, 110, 0.2);
        color: var(--primary);
        padding: 10px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: var(--transition);
        margin-top: 14px;
    }

    .service-book-btn:hover {
        background: var(--gradient-gold);
        border-color: transparent;
        color: #0d0d0d;
    }

    /* ===== STEPS ===== */
    .step-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        padding: 32px 28px;
        text-align: center;
        transition: var(--transition);
    }

    .step-card:hover {
        border-color: rgba(201, 169, 110, 0.3);
        transform: translateY(-4px);
    }

    .step-number {
        width: 52px;
        height: 52px;
        background: var(--gradient-gold);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        font-weight: 700;
        color: #0d0d0d;
        margin: 0 auto 20px;
    }

    .step-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .step-desc {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.7;
    }

    /* ===== CTA ===== */
    .cta-section {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 28px;
        padding: 60px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: 50%;
        transform: translateX(-50%);
        width: 600px;
        height: 300px;
        background: radial-gradient(ellipse, rgba(201,169,110,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }
</style>
@endpush

@section('content')

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-animate>
                <div class="hero-badge">
                    <i class="bi bi-stars"></i>
                    Salon Terpercaya #1 di Jakarta
                </div>

                <h1 class="hero-title">
                    Tampil <span class="gradient-text">Memukau</span><br>
                    Dengan Sentuhan<br>
                    <em style="font-style:italic; color: var(--text-secondary)">Profesional</em>
                </h1>

                <p class="hero-desc">
                    Reservasi layanan salon terbaik dengan mudah. Pilih layanan favorit Anda, tentukan waktu, dan biarkan tim profesional kami merawat Anda.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#services" class="btn-gold text-decoration-none">
                        <i class="bi bi-calendar-check me-2"></i>Pesan Sekarang
                    </a>
                    <a href="/services" class="btn-ghost text-decoration-none">
                        Lihat Semua Layanan
                    </a>
                </div>

                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-num">500+</div>
                        <div class="hero-stat-label">Pelanggan Puas</div>
                    </div>
                    <div style="width:1px; background: var(--bg-border);"></div>
                    <div>
                        <div class="hero-stat-num">20+</div>
                        <div class="hero-stat-label">Layanan Tersedia</div>
                    </div>
                    <div style="width:1px; background: var(--bg-border);"></div>
                    <div>
                        <div class="hero-stat-num">5★</div>
                        <div class="hero-stat-label">Rating Pelanggan</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 d-none d-lg-block" data-animate>
                <div class="hero-image-wrapper">
                    <div class="hero-floating-card">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-shield-check" style="color: var(--success); font-size: 1.1rem;"></i>
                            <span style="font-size: 0.82rem; font-weight: 600; color: var(--text-primary)">Booking Terkonfirmasi</span>
                        </div>
                        <div style="font-size: 0.78rem; color: var(--text-muted)">Hari ini, 14:00 WIB</div>
                    </div>

                    <div class="hero-image-card">
                        <div style="width:100%; height:460px; background: linear-gradient(135deg, #1a1208 0%, #2d1f0a 30%, #1a1510 60%, #0d0d0d 100%); display:flex; align-items:center; justify-content:center; position:relative;">
                            <div style="position:absolute; top:40px; left:40px; width:80px; height:80px; border-radius:50%; background: rgba(201,169,110,0.1); border: 1px solid rgba(201,169,110,0.2);"></div>
                            <div style="position:absolute; bottom:80px; right:40px; width:120px; height:120px; border-radius:50%; background: rgba(201,169,110,0.06); border: 1px solid rgba(201,169,110,0.15);"></div>
                            <div style="text-align:center; position:relative; z-index:2;">
                                <div style="font-size: 6rem; margin-bottom: 16px;">💆‍♀️</div>
                                <div style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--primary);">Premium Care</div>
                                <div style="color: var(--text-muted); font-size: 0.9rem; margin-top: 6px;">Professional Salon Services</div>
                            </div>
                        </div>

                        <div class="hero-image-badge">
                            <div style="width: 40px; height: 40px; background: var(--gradient-gold); border-radius: 10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="bi bi-award-fill" style="color: #0d0d0d; font-size: 1.1rem;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary)">Top Rated Salon</div>
                                <div style="font-size: 0.78rem; color: var(--text-muted)">Certified & Professional</div>
                            </div>
                            <div class="ms-auto">
                                <span style="color: #ffd700; font-size: 0.9rem;">★★★★★</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container"><div class="divider-gold"></div></div>

<!-- SERVICES -->
<section class="py-5" id="services">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-5">
            <div class="col-lg-6" data-animate>
                <div class="section-eyebrow">Layanan Kami</div>
                <h2 class="section-title">Pilih <span class="highlight">Layanan</span> Favoritmu</h2>
                <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.7; max-width: 440px;">
                    Berbagai layanan perawatan kecantikan profesional tersedia untuk Anda.
                </p>
            </div>
            <div class="col-lg-auto" data-animate>
                <a href="/services" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                    Kelola Layanan <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        @if($services->count() > 0)
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6" data-animate>
                <div class="service-card">
                    <div class="service-card-img-wrapper">
                        <div style="width:100%; height:200px; background: linear-gradient(135deg, #1a1208, #2a1e0c); display:flex; align-items:center; justify-content:center; position:relative;">
                            <span style="font-size: 3.5rem;">
                                @if(stripos($service->name, 'creambath') !== false || stripos($service->name, 'rambut') !== false) 💇‍♀️
                                @elseif(stripos($service->name, 'facial') !== false || stripos($service->name, 'wajah') !== false) 💆‍♀️
                                @elseif(stripos($service->name, 'nail') !== false || stripos($service->name, 'kuku') !== false) 💅
                                @elseif(stripos($service->name, 'massage') !== false || stripos($service->name, 'pijat') !== false) 🧖‍♀️
                                @elseif(stripos($service->name, 'make') !== false) 💄
                                @else ✨ @endif
                            </span>
                            <div class="service-card-img-overlay"></div>
                        </div>
                        <div class="service-badge-overlay">
                            <span class="badge-gold">{{ $service->duration }} Menit</span>
                        </div>
                    </div>

                    <div class="service-body">
                        <div class="service-name">{{ $service->name }}</div>
                        <div class="service-desc">{{ Str::limit($service->description ?? 'Layanan kecantikan profesional dengan tenaga ahli berpengalaman.', 80) }}</div>

                        <div class="service-meta">
                            <div class="service-price">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                            <div class="service-duration">
                                <i class="bi bi-clock"></i> {{ $service->duration }} mnt
                            </div>
                        </div>

                        <a href="/booking/{{ $service->id }}" class="service-book-btn" id="book-service-{{ $service->id }}">
                            <i class="bi bi-calendar-plus me-2"></i>Reservasi Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <div style="font-size:3rem;margin-bottom:16px;">📋</div>
            <h5 style="color:var(--text-secondary);margin-bottom:8px;">Belum Ada Layanan</h5>
            <p style="margin-bottom:20px;">Tambahkan layanan pertama untuk mulai menerima reservasi.</p>
            <a href="/services/create" class="btn-gold text-decoration-none">
                <i class="bi bi-plus-lg me-2"></i>Tambah Layanan
            </a>
        </div>
        @endif
    </div>
</section>

<div class="container"><div class="divider-gold"></div></div>

<!-- HOW IT WORKS -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5" data-animate>
            <div class="section-eyebrow">Cara Mudah</div>
            <h2 class="section-title">Reservasi dalam <span class="highlight">3 Langkah</span></h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-animate>
                <div class="step-card">
                    <div class="step-number">1</div>
                    <div class="step-title">Pilih Layanan</div>
                    <div class="step-desc">Jelajahi berbagai layanan salon profesional dan pilih yang sesuai kebutuhan Anda.</div>
                </div>
            </div>
            <div class="col-md-4" data-animate>
                <div class="step-card">
                    <div class="step-number">2</div>
                    <div class="step-title">Isi Data & Jadwal</div>
                    <div class="step-desc">Masukkan biodata Anda, pilih tanggal, waktu, dan stylist favorit dengan mudah.</div>
                </div>
            </div>
            <div class="col-md-4" data-animate>
                <div class="step-card">
                    <div class="step-number">3</div>
                    <div class="step-title">Konfirmasi & Datang</div>
                    <div class="step-desc">Dapatkan tiket konfirmasi, tunjukkan kepada kami, dan nikmati layanan premium!</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5">
    <div class="container">
        <div class="cta-section" data-animate>
            <div class="section-eyebrow" style="text-align:center;">Siap Tampil Memukau?</div>
            <h2 class="section-title" style="text-align:center; margin-bottom:16px;">
                Mulai Reservasi <span class="highlight">Sekarang</span>
            </h2>
            <p style="color:var(--text-muted);max-width:480px;margin:0 auto 32px;line-height:1.8;font-size:0.95rem;">
                Tim profesional kami siap melayani Anda setiap hari.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="#services" class="btn-gold text-decoration-none">
                    <i class="bi bi-calendar-check me-2"></i>Pesan Layanan
                </a>
                <a href="tel:+6281234567890" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                    <i class="bi bi-telephone"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
