@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('styles')
<style>
    .dashboard-header {
        background: var(--bg-card);
        border-bottom: 1px solid var(--bg-border);
        padding: 40px 0;
    }
    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 16px;
        padding: 24px;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        border-radius: 50%;
        opacity: 0.07;
        transform: translate(20px, -20px);
    }
    .stat-card:hover {
        border-color: rgba(201,169,110,0.3);
        transform: translateY(-3px);
        box-shadow: var(--shadow-card);
    }
    .stat-icon {
        width: 50px; height: 50px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 16px;
    }
    .stat-value {
        font-size: 2rem; font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1; margin-bottom: 6px;
    }
    .stat-label {
        font-size: 0.82rem; color: var(--text-muted);
        font-weight: 500; text-transform: uppercase; letter-spacing: 1px;
    }
    .calendar-wrapper {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        padding: 24px;
    }
    .legend-dot {
        width: 12px; height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    /* Event detail modal */
    .event-modal .modal-content {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        color: var(--text-primary);
    }
    .event-modal .modal-header {
        border-bottom: 1px solid var(--bg-border);
        padding: 20px 24px;
    }
    .event-modal .modal-body { padding: 24px; }
    .event-modal .modal-footer {
        border-top: 1px solid var(--bg-border);
        padding: 16px 24px;
    }
    .event-detail-row {
        display: flex; justify-content: space-between;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid var(--bg-border);
    }
    .event-detail-row:last-child { border-bottom: none; }
    .event-detail-label { font-size: 0.82rem; color: var(--text-muted); min-width: 110px; }
    .event-detail-value { font-weight: 600; color: var(--text-primary); text-align: right; font-size: 0.9rem; }
    .status-badge-pending   { background: rgba(212,160,23,0.2); color: #d4a017; border: 1px solid rgba(212,160,23,0.3); }
    .status-badge-confirmed { background: rgba(59,130,246,0.2); color: #3b82f6; border: 1px solid rgba(59,130,246,0.3); }
    .status-badge-done      { background: rgba(34,197,94,0.2);  color: #22c55e; border: 1px solid rgba(34,197,94,0.3);  }
    .status-badge-cancelled { background: rgba(107,114,128,0.2);color: #9ca3af; border: 1px solid rgba(107,114,128,0.3);}
    .status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 50px;
        font-size: 0.78rem; font-weight: 600; text-transform: capitalize;
    }
    .hover-effect:hover {
        background: rgba(201, 169, 110, 0.05) !important;
        border-color: var(--primary) !important;
    }
    .quick-action-card {
        display: flex; align-items: center; gap: 12px;
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 12px;
        padding: 16px;
        text-decoration: none;
        transition: var(--transition);
    }
    .quick-action-card:hover {
        border-color: rgba(201,169,110,0.4);
        background: rgba(201,169,110,0.04);
    }
    .quick-action-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; flex-shrink: 0;
    }
</style>
@endpush

@section('content')

<!-- DASHBOARD HEADER -->
<div class="dashboard-header" data-aos="fade-down">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h1 class="page-title mb-1">Admin <span style="font-style:italic;">Dashboard</span></h1>
                <p class="page-subtitle">Selamat datang di pusat kendali GlowSalon</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="badge-gold py-2 px-3">
                    <i class="bi bi-clock-history me-2"></i> {{ now()->format('d M Y, H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">

    <!-- STATS CARDS -->
    <div class="row g-4 mb-5">
        @php
            $statsData = [
                ['icon' => 'bi-scissors',       'color' => 'rgba(201,169,110,0.15)', 'val' => \App\Models\Service::count(),                              'label' => 'Layanan',         'iconColor' => 'var(--primary)'],
                ['icon' => 'bi-calendar-check', 'color' => 'rgba(76,175,125,0.15)',  'val' => \App\Models\Booking::count(),                              'label' => 'Total Reservasi', 'iconColor' => 'var(--success)'],
                ['icon' => 'bi-people',         'color' => 'rgba(91,155,213,0.15)',  'val' => \App\Models\Employee::count(),                             'label' => 'Stylist',         'iconColor' => 'var(--info)'],
                ['icon' => 'bi-clock',          'color' => 'rgba(212,160,23,0.15)', 'val' => \App\Models\Booking::where('status','pending')->count(),    'label' => 'Pending',         'iconColor' => '#d4a017'],
                ['icon' => 'bi-check-circle',   'color' => 'rgba(59,130,246,0.15)', 'val' => \App\Models\Booking::where('status','confirmed')->count(),  'label' => 'Confirmed',       'iconColor' => '#3b82f6'],
                ['icon' => 'bi-patch-check',    'color' => 'rgba(34,197,94,0.15)',  'val' => \App\Models\Booking::where('status','done')->count(),       'label' => 'Selesai',         'iconColor' => '#22c55e'],
            ];
        @endphp
        @foreach($statsData as $i => $s)
        <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="{{ $i * 80 }}">
            <div class="stat-card">
                <div class="stat-icon" style="background: {{ $s['color'] }}; color: {{ $s['iconColor'] }};">
                    <i class="{{ $s['icon'] }}"></i>
                </div>
                <div class="stat-value">{{ $s['val'] }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row g-4">
        <!-- QUICK ACTIONS -->
        <div class="col-lg-3" data-aos="fade-right">
            <h5 class="mb-3 text-white fw-600">Aksi Cepat</h5>
            <div class="d-flex flex-column gap-3">
                <a href="{{ route('admin.bookings.index') }}" class="quick-action-card">
                    <div class="quick-action-icon" style="background: rgba(201,169,110,0.1); color: var(--primary);">
                        <i class="bi bi-calendar-week"></i>
                    </div>
                    <div>
                        <div class="text-white fw-600" style="font-size:0.9rem;">Kelola Reservasi</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Lihat & ubah status booking</div>
                    </div>
                </a>
                <a href="{{ route('services.index') }}" class="quick-action-card">
                    <div class="quick-action-icon" style="background: rgba(76,175,125,0.1); color: var(--success);">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div>
                        <div class="text-white fw-600" style="font-size:0.9rem;">Kelola Layanan</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Tambah atau edit layanan</div>
                    </div>
                </a>
                <a href="{{ route('admin.employees.index') }}" class="quick-action-card">
                    <div class="quick-action-icon" style="background: rgba(91,155,213,0.1); color: var(--info);">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <div class="text-white fw-600" style="font-size:0.9rem;">Kelola Stylist</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">Manajemen tim profesional</div>
                    </div>
                </a>
            </div>

            <!-- LEGEND -->
            <div style="background: var(--bg-card); border: 1px solid var(--bg-border); border-radius: 14px; padding: 16px; margin-top: 24px;">
                <p style="font-size: 0.78rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 12px;">
                    Keterangan Warna
                </p>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="legend-dot" style="background:#d4a017;"></div>
                        <span style="font-size:0.82rem; color:var(--text-secondary);">Pending</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="legend-dot" style="background:#3b82f6;"></div>
                        <span style="font-size:0.82rem; color:var(--text-secondary);">Confirmed</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="legend-dot" style="background:#22c55e;"></div>
                        <span style="font-size:0.82rem; color:var(--text-secondary);">Selesai (Done)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FULLCALENDAR -->
        <div class="col-lg-9" data-aos="fade-left">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="text-white fw-600 mb-0">Kalender Reservasi</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-1" style="font-size:0.85rem; padding:8px 16px;">
                    <i class="bi bi-list-ul"></i> Lihat Semua
                </a>
            </div>
            <div class="calendar-wrapper">
                <div id="adminCalendar"></div>
            </div>
        </div>
    </div>

    <!-- RECENT BOOKINGS TABLE -->
    <div class="mt-5" data-aos="fade-up">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="text-white fw-600 mb-0">Reservasi Terbaru</h5>
            <a href="{{ route('admin.bookings.index') }}" class="btn-gold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size:0.82rem; padding:9px 18px;">
                <i class="bi bi-arrow-right-circle"></i> Lihat Semua
            </a>
        </div>
        <div style="background: var(--bg-card); border: 1px solid var(--bg-border); border-radius: 20px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0" style="background: transparent;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--bg-border);">
                            <th class="px-4 py-3" style="color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:0.8px;">Kode</th>
                            <th class="px-4 py-3" style="color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:0.8px;">Pemesan</th>
                            <th class="px-4 py-3" style="color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:0.8px;">Layanan</th>
                            <th class="px-4 py-3" style="color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:0.8px;">Jadwal</th>
                            <th class="px-4 py-3" style="color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:0.8px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $bookings = \App\Models\Booking::with('service')->latest()->take(5)->get(); @endphp
                        @forelse($bookings as $booking)
                        <tr style="border-bottom: 1px solid var(--bg-border);">
                            <td class="px-4 py-3"><code style="color:var(--primary); font-size:0.78rem;">{{ $booking->booking_code }}</code></td>
                            <td class="px-4 py-3">
                                <div class="text-white fw-500">{{ $booking->name }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $booking->phone }}</div>
                            </td>
                            <td class="px-4 py-3 text-muted" style="font-size:0.88rem;">{{ $booking->service->name }}</td>
                            <td class="px-4 py-3" style="font-size:0.85rem; color:var(--text-secondary);">
                                {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }} — {{ $booking->time }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusMap = [
                                        'pending'   => ['pending',   '#d4a017'],
                                        'confirmed' => ['confirmed', '#3b82f6'],
                                        'done'      => ['selesai',   '#22c55e'],
                                        'cancelled' => ['batal',     '#9ca3af'],
                                    ];
                                    [$label, $color] = $statusMap[$booking->status] ?? ['unknown', '#666'];
                                @endphp
                                <span class="status-badge status-badge-{{ $booking->status }}">
                                    <span style="width:6px;height:6px;border-radius:50%;background:{{ $color }};display:inline-block;"></span>
                                    {{ ucfirst($label) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data reservasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- EVENT DETAIL MODAL -->
<div class="modal fade event-modal" id="eventDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title d-flex align-items-center gap-2" style="color:var(--primary);">
                        <i class="bi bi-calendar-event"></i>
                        Detail Reservasi
                    </h5>
                    <div id="modalBookingCode" style="font-size:0.8rem; color:var(--text-muted); margin-top:2px;"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) opacity(0.5);"></button>
            </div>
            <div class="modal-body">
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-person me-1"></i>Pemesan</span>
                    <span class="event-detail-value" id="modalName">—</span>
                </div>
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-telephone me-1"></i>No. HP</span>
                    <span class="event-detail-value" id="modalPhone">—</span>
                </div>
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-scissors me-1"></i>Layanan</span>
                    <span class="event-detail-value" id="modalService">—</span>
                </div>
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-person-badge me-1"></i>Stylist</span>
                    <span class="event-detail-value" id="modalEmployee">—</span>
                </div>
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-calendar3 me-1"></i>Tanggal</span>
                    <span class="event-detail-value" id="modalDate">—</span>
                </div>
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-clock me-1"></i>Waktu</span>
                    <span class="event-detail-value" id="modalTime">—</span>
                </div>
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-currency-dollar me-1"></i>Total</span>
                    <span class="event-detail-value" id="modalPrice" style="color:var(--primary);">—</span>
                </div>
                <div class="event-detail-row">
                    <span class="event-detail-label"><i class="bi bi-info-circle me-1"></i>Status</span>
                    <span id="modalStatus">—</span>
                </div>
            </div>
            <div class="modal-footer d-flex gap-2 justify-content-between">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Tutup</button>
                <a id="modalInvoiceLink" href="#" class="btn-gold text-decoration-none d-inline-flex align-items-center gap-2" style="font-size:0.85rem; padding:10px 20px;">
                    <i class="bi bi-file-earmark-pdf"></i> Download Invoice
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('adminCalendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        height: 'auto',
        // AJAX fetch events dari API
        events: {
            url: '{{ route("api.calendar-events") }}',
            method: 'GET',
            failure: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal memuat kalender',
                    text: 'Tidak dapat mengambil data event. Periksa koneksi.',
                    confirmButtonColor: '#c9a96e'
                });
            }
        },
        eventClick: function (info) {
            const props = info.event.extendedProps;

            // Isi modal dengan data event
            document.getElementById('modalBookingCode').textContent = props.booking_code ?? '';
            document.getElementById('modalName').textContent     = info.event.title.split('—')[0].trim();
            document.getElementById('modalPhone').textContent    = props.phone ?? '—';
            document.getElementById('modalService').textContent  = props.service ?? '—';
            document.getElementById('modalEmployee').textContent = props.employee ?? '—';
            document.getElementById('modalDate').textContent     = props.date ?? '—';
            document.getElementById('modalTime').textContent     = (props.time ?? '—') + ' WIB';
            document.getElementById('modalPrice').textContent    = 'Rp ' + (props.total_price ?? '—');

            // Status badge
            const statusColors = {
                pending:   ['status-badge-pending',   'Pending'],
                confirmed: ['status-badge-confirmed', 'Confirmed'],
                done:      ['status-badge-done',      'Selesai'],
                cancelled: ['status-badge-cancelled', 'Dibatalkan'],
            };
            const [cls, label] = statusColors[props.status] ?? ['', props.status];
            document.getElementById('modalStatus').innerHTML =
                `<span class="status-badge ${cls}"><span style="width:6px;height:6px;border-radius:50%;background:${info.event.backgroundColor};display:inline-block;"></span>${label}</span>`;

            // Link invoice (gunakan ID dari event)
            document.getElementById('modalInvoiceLink').href = `/booking/${info.event.id}/invoice/download`;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
            modal.show();
        },
        eventMouseEnter: function (info) {
            info.el.style.transform = 'scale(1.03)';
            info.el.style.transition = 'transform 0.2s ease';
        },
        eventMouseLeave: function (info) {
            info.el.style.transform = '';
        },
        noEventsText: 'Tidak ada reservasi pada periode ini',
        loading: function (isLoading) {
            if (isLoading) {
                calendarEl.style.opacity = '0.6';
            } else {
                calendarEl.style.opacity = '1';
                calendarEl.style.transition = 'opacity 0.3s ease';
            }
        }
    });

    calendar.render();
});
</script>
@endpush
