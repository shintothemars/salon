@extends('layouts.app')

@section('title', 'Stylist Dashboard')

@section('content')
<div class="container py-5">
    @php
        $employee = \App\Models\Employee::where('user_id', auth()->id())->first();
        $todayBookings = $employee 
            ? \App\Models\Booking::where('employee_id', $employee->id)->whereDate('date', now())->orderBy('time')->get()
            : collect();
        $monthCount = $employee
            ? \App\Models\Booking::where('employee_id', $employee->id)
                ->whereBetween('date', [\Carbon\Carbon::now()->startOfMonth(), \Carbon\Carbon::now()->endOfMonth()])
                ->count()
            : 0;
    @endphp

    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="page-title mb-1">Halo, <span style="font-style:italic;">{{ auth()->user()->name }}</span></h1>
            <p class="text-muted">Berikut adalah jadwal reservasi Anda untuk hari ini.</p>
        </div>
        <div class="badge-gold py-2 px-3">
            <i class="bi bi-calendar3 me-2"></i> {{ now()->format('d M Y') }}
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card-custom p-4 d-flex align-items-center gap-4">
                <div style="width: 64px; height: 64px; background: rgba(201, 169, 110, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.8rem;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary);">{{ $todayBookings->count() }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Jadwal Hari Ini</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-custom p-4 d-flex align-items-center gap-4">
                <div style="width: 64px; height: 64px; background: rgba(76, 175, 125, 0.1); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: var(--success); font-size: 1.8rem;">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div>
                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary);">{{ $monthCount }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Total Reservasi Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <h5 class="mb-4 text-white"><i class="bi bi-list-check me-2 text-primary"></i>Daftar Antrean Hari Ini</h5>
    <div class="card-custom overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0" style="background: transparent;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--bg-border);">
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Pelanggan</th>
                        <th class="px-4 py-3">Layanan</th>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayBookings as $booking)
                    <tr style="border-bottom: 1px solid var(--bg-border);">
                        <td class="px-4 py-3">
                            <span class="badge-gold py-1 px-3" style="font-size: 0.9rem;">
                                {{ \Carbon\Carbon::parse($booking->time)->format('H:i') }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-white fw-600">{{ $booking->name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $booking->phone }}</div>
                        </td>
                        <td class="px-4 py-3 text-muted">{{ $booking->service->name }}</td>
                        <td class="px-4 py-3"><code>{{ $booking->booking_code }}</code></td>
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                            Tidak ada jadwal reservasi untuk hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

