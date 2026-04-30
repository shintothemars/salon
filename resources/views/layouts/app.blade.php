<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GlowSalon - Platform reservasi salon terpercaya. Pesan layanan kecantikan profesional dengan mudah dan cepat.">
    <title>@yield('title', 'GlowSalon') | GlowSalon</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;1,500&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">

    <style>
        :root {
            --primary: #c9a96e;
            --primary-dark: #a8813f;
            --primary-light: #e8d5b0;
            --accent: #f0e6d3;
            --bg-dark: #0d0d0d;
            --bg-card: #161616;
            --bg-surface: #1e1e1e;
            --bg-border: #2a2a2a;
            --text-primary: #f5f5f5;
            --text-secondary: #a0a0a0;
            --text-muted: #666;
            --danger: #e05252;
            --success: #4caf7d;
            --info: #5b9bd5;
            --gradient-gold: linear-gradient(135deg, #c9a96e 0%, #e8c98a 50%, #c9a96e 100%);
            --gradient-dark: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 100%);
            --shadow-gold: 0 8px 32px rgba(201, 169, 110, 0.2);
            --shadow-card: 0 4px 24px rgba(0, 0, 0, 0.4);
            --radius: 16px;
            --radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: rgba(13, 13, 13, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--bg-border);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 1050;
            transition: var(--transition);
        }

        .navbar-brand-custom {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 600;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .navbar-brand-custom span {
            font-style: italic;
        }

        .nav-link-custom {
            color: var(--text-secondary) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 16px !important;
            border-radius: var(--radius-sm);
            transition: var(--transition);
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: var(--primary) !important;
            background: rgba(201, 169, 110, 0.1);
        }

        .btn-nav-primary {
            background: var(--gradient-gold);
            color: #0d0d0d !important;
            font-weight: 600;
            padding: 8px 20px !important;
            border-radius: 50px;
            border: none;
            transition: var(--transition);
            font-size: 0.88rem;
        }

        .btn-nav-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-gold);
            color: #0d0d0d !important;
        }

        /* ===== BUTTONS ===== */
        .btn-gold {
            background: var(--gradient-gold);
            color: #0d0d0d;
            font-weight: 600;
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            transition: var(--transition);
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.3px;
            cursor: pointer;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-gold);
            color: #0d0d0d;
        }

        .btn-ghost {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            padding: 11px 28px;
            border-radius: 50px;
            transition: var(--transition);
            font-weight: 500;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: rgba(201, 169, 110, 0.1);
            color: var(--primary);
        }

        .btn-danger-soft {
            background: rgba(224, 82, 82, 0.12);
            color: var(--danger);
            border: 1px solid rgba(224, 82, 82, 0.25);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 0.85rem;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-danger-soft:hover {
            background: rgba(224, 82, 82, 0.22);
            color: var(--danger);
        }

        .btn-edit-soft {
            background: rgba(91, 155, 213, 0.12);
            color: var(--info);
            border: 1px solid rgba(91, 155, 213, 0.25);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 0.85rem;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-edit-soft:hover {
            background: rgba(91, 155, 213, 0.22);
            color: var(--info);
        }

        /* ===== CARDS ===== */
        .card-custom {
            background: var(--bg-card);
            border: 1px solid var(--bg-border);
            border-radius: var(--radius);
            transition: var(--transition);
            overflow: hidden;
        }

        .card-custom:hover {
            border-color: rgba(201, 169, 110, 0.3);
            transform: translateY(-4px);
            box-shadow: var(--shadow-card);
        }

        /* ===== FORM INPUTS ===== */
        .form-control-custom, .form-select-custom {
            background: var(--bg-surface) !important;
            border: 1.5px solid var(--bg-border) !important;
            color: var(--text-primary) !important;
            border-radius: var(--radius-sm) !important;
            padding: 12px 16px !important;
            font-family: 'Outfit', sans-serif !important;
            font-size: 0.95rem !important;
            transition: var(--transition) !important;
        }

        .form-control-custom:focus, .form-select-custom:focus {
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.15) !important;
            background: var(--bg-surface) !important;
            color: var(--text-primary) !important;
            outline: none !important;
        }

        .form-control-custom::placeholder {
            color: var(--text-muted) !important;
        }

        .form-label-custom {
            color: var(--text-secondary);
            font-size: 0.88rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            margin-bottom: 8px;
        }

        /* ===== BADGE ===== */
        .badge-gold {
            background: rgba(201, 169, 110, 0.15);
            color: var(--primary);
            border: 1px solid rgba(201, 169, 110, 0.3);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: rgba(76, 175, 125, 0.15);
            color: var(--success);
            border: 1px solid rgba(76, 175, 125, 0.3);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            padding: 60px 0 40px;
            position: relative;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: radial-gradient(ellipse at 20% 50%, rgba(201, 169, 110, 0.05) 0%, transparent 60%);
            pointer-events: none;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 600;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* ===== DIVIDER ===== */
        .divider-gold {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary), transparent);
            opacity: 0.3;
            margin: 40px 0;
        }

        /* ===== FOOTER ===== */
        .footer-custom {
            background: var(--bg-card);
            border-top: 1px solid var(--bg-border);
            padding: 40px 0 20px;
            margin-top: 80px;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-text {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.7;
        }

        .footer-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-link:hover { color: var(--primary); }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-dark); }
        ::-webkit-scrollbar-thumb { background: var(--bg-border); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .animate-fade-up { animation: fadeInUp 0.5s ease forwards; }
        .animate-fade { animation: fadeIn 0.4s ease forwards; }

        /* ===== ALERT ===== */
        .alert-custom {
            background: var(--bg-surface);
            border: 1px solid var(--bg-border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            padding: 14px 18px;
        }

        .alert-success-custom {
            background: rgba(76, 175, 125, 0.1);
            border-color: rgba(76, 175, 125, 0.3);
            color: var(--success);
        }

        .alert-danger-custom {
            background: rgba(224, 82, 82, 0.1);
            border-color: rgba(224, 82, 82, 0.3);
            color: var(--danger);
        }

        /* ===== MOBILE ===== */
        .navbar-toggler-custom {
            border: 1px solid var(--bg-border);
            padding: 6px 10px;
            border-radius: var(--radius-sm);
            background: transparent;
            color: var(--text-secondary);
        }

        @media (max-width: 768px) {
            .page-title { font-size: 1.7rem; }
            .navbar-collapse { 
                background: var(--bg-card); 
                padding: 16px; 
                border-radius: var(--radius); 
                margin-top: 12px;
                border: 1px solid var(--bg-border);
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar-custom">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <a href="/" class="navbar-brand-custom">Glow<span>Salon</span></a>

                <button class="navbar-toggler-custom d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" id="navToggler">
                    <i class="bi bi-list fs-5"></i>
                </button>

                <div class="collapse navbar-collapse d-md-flex align-items-center gap-1" id="navMenu">
                    @auth
                        <div class="dropdown ms-md-2">
                            <button class="nav-link-custom dropdown-toggle border-0 bg-transparent" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark" style="background: var(--bg-card); border: 1px solid var(--bg-border);">
                                @if(Auth::user()->role === 'admin')
                                    <li><a class="dropdown-item" href="/admin-dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                                @elseif(Auth::user()->role === 'karyawan')
                                    <li><a class="dropdown-item" href="/karyawan-dashboard"><i class="bi bi-person-badge me-2"></i>Dashboard Karyawan</a></li>
                                @endif
                                <li><hr class="dropdown-divider" style="border-color: var(--bg-border);"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="/login" class="nav-link-custom ms-md-2">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert-custom alert-success-custom d-flex align-items-center gap-2 animate-fade">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert-custom alert-danger-custom d-flex align-items-center gap-2 animate-fade">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-custom">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="footer-brand mb-3">GlowSalon</div>
                    <p class="footer-text">Platform reservasi salon terpercaya. Nikmati layanan kecantikan profesional dengan mudah dan nyaman.</p>
                </div>
                <div class="col-md-2 col-6">
                    <p class="text-white fw-600 mb-3" style="font-weight:600; font-size:0.9rem;">Halaman</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="/" class="footer-link">Beranda</a>
                        <a href="/services" class="footer-link">Layanan</a>
                        <a href="/#services" class="footer-link">Reservasi</a>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <p class="text-white fw-600 mb-3" style="font-weight:600; font-size:0.9rem;">Kontak</p>
                    <div class="d-flex flex-column gap-2">
                        <span class="footer-text"><i class="bi bi-telephone me-2" style="color: var(--primary)"></i>+62 812-3456-7890</span>
                        <span class="footer-text"><i class="bi bi-envelope me-2" style="color: var(--primary)"></i>hello@glowsalon.id</span>
                        <span class="footer-text"><i class="bi bi-geo-alt me-2" style="color: var(--primary)"></i>Jakarta, Indonesia</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="text-white fw-600 mb-3" style="font-weight:600; font-size:0.9rem;">Jam Operasional</p>
                    <div class="d-flex flex-column gap-1">
                        <span class="footer-text">Senin – Jumat: 09.00 – 20.00</span>
                        <span class="footer-text">Sabtu – Minggu: 08.00 – 21.00</span>
                    </div>
                </div>
            </div>
            <hr style="border-color: var(--bg-border); margin-top: 32px;">
            <p class="footer-text text-center" style="margin-top: 16px;">© {{ date('Y') }} GlowSalon. Hak cipta dilindungi.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Intersection Observer for animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = (i * 0.1) + 's';
                    entry.target.classList.add('animate-fade-up');
                    entry.target.style.opacity = '1';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('[data-animate]').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });
    </script>

    @stack('scripts')
</body>
</html>
