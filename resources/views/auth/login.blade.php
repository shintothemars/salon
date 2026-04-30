@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="col-lg-5 col-md-8">
            <div class="text-center mb-4">
                <h1 class="page-title mb-1">Glow<span>Salon</span></h1>
                <p class="text-muted">Masuk untuk mengelola reservasi Anda</p>
            </div>

            <div class="card-custom p-4">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    @if($errors->any())
                        <div class="alert-custom alert-danger-custom mb-4">
                            @foreach($errors->all() as $error)
                                <div style="font-size: 0.88rem;">{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label-custom" for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control-custom form-control" placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom" for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" class="form-control-custom form-control" placeholder="••••••••" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" style="background-color: var(--bg-surface); border-color: var(--bg-border);">
                            <label class="form-check-label text-muted" for="remember" style="font-size: 0.88rem;">Ingat Saya</label>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn-gold py-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center mt-4">
                <p class="text-muted" style="font-size: 0.9rem;">
                    Belum punya akun? <a href="/#services" style="color: var(--primary); text-decoration: none; font-weight: 600;">Reservasi Dulu</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
