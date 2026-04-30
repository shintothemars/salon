@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="page-title mb-1">Admin <span style="font-style:italic;">Dashboard</span></h1>
            <p class="text-muted">Selamat datang di pusat kendali GlowSalon</p>
        </div>
        <div class="badge-gold py-2 px-3">
            <i class="bi bi-clock-history me-2"></i> {{ now()->format('d M Y, H:i') }}
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card-custom p-4 text-center">
                <div style="font-size: 2rem; color: var(--primary); margin-bottom: 8px;">
                    <i class="bi bi-scissors"></i>
                </div>
                <div style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary);">{{ \App\Models\Service::count() }}</div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">Layanan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-4 text-center">
                <div style="font-size: 2rem; color: var(--success); margin-bottom: 8px;">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary);">{{ \App\Models\Booking::count() }}</div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">Total Reservasi</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-4 text-center">
                <div style="font-size: 2rem; color: var(--primary); margin-bottom: 8px;">
                    <i class="bi bi-people"></i>
                </div>
                <div style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary);">{{ \App\Models\Employee::count() }}</div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">Stylist</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-custom p-4 text-center">
                <div style="font-size: 2rem; color: var(--info); margin-bottom: 8px;">
                    <i class="bi bi-clock"></i>
                </div>
                <div style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary);">{{ \App\Models\Booking::where('status', 'pending')->count() }}</div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">Pending</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-md-4">
            <h5 class="mb-3 text-white">Aksi Cepat</h5>
            <div class="d-grid gap-3">
                <a href="{{ route('services.index') }}" class="card-custom p-3 text-decoration-none d-flex align-items-center gap-3 hover-effect">
                    <div style="width: 48px; height: 48px; background: rgba(201, 169, 110, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i class="bi bi-gear fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white fw-600">Kelola Layanan</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Tambah atau edit daftar layanan</div>
                    </div>
                </a>
                <a href="{{ route('admin.employees.index') }}" class="card-custom p-3 text-decoration-none d-flex align-items-center gap-3 hover-effect">
                    <div style="width: 48px; height: 48px; background: rgba(76, 175, 125, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--success);">
                        <i class="bi bi-person-badge fs-4"></i>
                    </div>
                    <div>
                        <div class="text-white fw-600">Kelola Stylist</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Manajemen tim profesional Anda</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="col-md-8">
            <h5 class="mb-3 text-white">Reservasi Terbaru</h5>
            <div class="card-custom overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0" style="background: transparent;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--bg-border);">
                                <th class="px-4 py-3">Kode</th>
                                <th class="px-4 py-3">Pemesan</th>
                                <th class="px-4 py-3">Layanan</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $bookings = \App\Models\Booking::with('service')->latest()->take(5)->get();
                            @endphp
                            @forelse($bookings as $booking)
                            <tr style="border-bottom: 1px solid var(--bg-border);">
                                <td class="px-4 py-3"><code>{{ $booking->booking_code }}</code></td>
                                <td class="px-4 py-3">
                                    <div class="text-white fw-500">{{ $booking->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $booking->date }}</div>
                                </td>
                                <td class="px-4 py-3 text-muted">{{ $booking->service->name }}</td>
                                <td class="px-4 py-3">
                                    @if($booking->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada data reservasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-effect:hover {
        background: rgba(201, 169, 110, 0.05) !important;
        border-color: var(--primary) !important;
    }
</style>
@endsection

