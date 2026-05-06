@extends('layouts.app')

@section('title', 'Kelola Reservasi')

@push('styles')
<style>
    .bookings-header {
        background: var(--bg-card);
        border-bottom: 1px solid var(--bg-border);
        padding: 40px 0;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }
    .stat-pill {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 14px;
        padding: 16px 18px;
        transition: var(--transition);
    }
    .stat-pill:hover { border-color: rgba(201,169,110,0.3); }
    .stat-pill-value {
        font-size: 1.8rem; font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }
    .stat-pill-label { font-size: 0.78rem; color: var(--text-muted); margin-top: 4px; }
    .table-wrapper {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
    }
    .table-wrapper-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--bg-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .table-dark-custom {
        width: 100%;
        background: transparent !important;
        border-collapse: collapse;
    }
    .table-dark-custom thead th {
        background: var(--bg-surface) !important;
        color: var(--text-muted) !important;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 14px 16px;
        border-bottom: 1px solid var(--bg-border) !important;
        white-space: nowrap;
        border-top: none !important;
    }
    .table-dark-custom tbody tr {
        border-bottom: 1px solid var(--bg-border);
        transition: background 0.2s;
    }
    .table-dark-custom tbody tr:hover { background: rgba(201,169,110,0.03); }
    .table-dark-custom td {
        padding: 14px 16px;
        color: var(--text-primary);
        vertical-align: middle;
        font-size: 0.9rem;
        border-color: var(--bg-border) !important;
    }
    .status-select {
        background: var(--bg-surface);
        border: 1px solid var(--bg-border);
        color: var(--text-primary);
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 0.82rem;
        cursor: pointer;
        transition: var(--transition);
    }
    .status-select:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(201,169,110,0.15);
    }
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 50px;
        font-size: 0.76rem; font-weight: 600; text-transform: capitalize;
    }
    .status-badge-pending   { background: rgba(212,160,23,0.18); color: #d4a017; border: 1px solid rgba(212,160,23,0.3); }
    .status-badge-confirmed { background: rgba(59,130,246,0.18); color: #3b82f6; border: 1px solid rgba(59,130,246,0.3); }
    .status-badge-done      { background: rgba(34,197,94,0.18);  color: #22c55e; border: 1px solid rgba(34,197,94,0.3);  }
    .status-badge-cancelled { background: rgba(107,114,128,0.18);color: #9ca3af; border: 1px solid rgba(107,114,128,0.3);}
    /* Override DataTables for dark theme */
    table.dataTable tbody tr { background: transparent !important; }
    table.dataTable thead th { border-bottom: none !important; }
    .dataTables_wrapper { padding: 0 24px 20px; }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter { padding-top: 16px; }
</style>
@endpush

@section('content')

<!-- HEADER -->
<div class="bookings-header" data-aos="fade-down">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <nav aria-label="breadcrumb" style="margin-bottom:8px;">
                    <ol class="breadcrumb" style="font-size:0.82rem; color:var(--text-muted); margin:0;">
                        <li class="breadcrumb-item"><a href="/admin-dashboard" style="color:var(--text-muted);text-decoration:none;">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color:var(--primary);">Reservasi</li>
                    </ol>
                </nav>
                <h1 class="page-title mb-1">Kelola <span style="font-style:italic;">Reservasi</span></h1>
                <p class="page-subtitle">Manajemen semua reservasi pelanggan GlowSalon</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="container py-5">

    <!-- STATS -->
    <div class="stats-grid" data-aos="fade-up">
        @php
            $pillStats = [
                ['val' => $stats['total'],     'label' => 'Total',     'color' => 'var(--primary)'],
                ['val' => $stats['pending'],   'label' => 'Pending',   'color' => '#d4a017'],
                ['val' => $stats['confirmed'], 'label' => 'Confirmed', 'color' => '#3b82f6'],
                ['val' => $stats['done'],      'label' => 'Selesai',   'color' => '#22c55e'],
                ['val' => $stats['cancelled'], 'label' => 'Batal',     'color' => '#9ca3af'],
            ];
        @endphp
        @foreach($pillStats as $ps)
        <div class="stat-pill">
            <div class="stat-pill-value" style="-webkit-text-fill-color: {{ $ps['color'] }}; color: {{ $ps['color'] }};">{{ $ps['val'] }}</div>
            <div class="stat-pill-label">{{ $ps['label'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- TABLE -->
    <div class="table-wrapper" data-aos="fade-up" data-aos-delay="100">
        <div class="table-wrapper-header">
            <h3 style="font-size:1rem; font-weight:600; margin:0; color:var(--text-primary);">
                Semua Reservasi
                <span class="badge-gold ms-2">{{ $stats['total'] }}</span>
            </h3>
        </div>

        <div class="table-responsive">
            <table class="table-dark-custom" id="bookingsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Pemesan</th>
                        <th>Layanan</th>
                        <th>Stylist</th>
                        <th>Jadwal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $i => $booking)
                    <tr id="booking-row-{{ $booking->id }}">
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td>
                            <code style="color:var(--primary); font-size:0.75rem;">{{ $booking->booking_code }}</code>
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $booking->name }}</div>
                            <div style="font-size:0.78rem; color:var(--text-muted);">{{ $booking->phone }}</div>
                        </td>
                        <td style="font-size:0.88rem; color:var(--text-secondary);">{{ $booking->service->name ?? '—' }}</td>
                        <td style="font-size:0.88rem; color:var(--text-secondary);">{{ $booking->employee->name ?? '—' }}</td>
                        <td>
                            <div style="font-size:0.85rem;">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</div>
                            <div style="font-size:0.78rem; color:var(--text-muted);">{{ $booking->time }} WIB</div>
                        </td>
                        <td>
                            <span style="font-weight:700; color:var(--primary); font-size:0.88rem;">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-badge-{{ $booking->status }}" id="badge-{{ $booking->id }}">
                                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                <!-- Dropdown ubah status -->
                                <select class="status-select" id="status-{{ $booking->id }}"
                                    onchange="updateStatus({{ $booking->id }}, this.value)">
                                    <option value="pending"   {{ $booking->status === 'pending'   ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="done"      {{ $booking->status === 'done'      ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                                </select>
                                <!-- Download Invoice -->
                                <a href="{{ route('booking.invoice.download', $booking->id) }}"
                                   class="btn-edit-soft text-decoration-none d-inline-flex align-items-center gap-1"
                                   title="Download Invoice"
                                   style="font-size:0.8rem; padding:6px 12px;">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Inisialisasi DataTables
    $('#bookingsTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        language: {
            search:           '<i class="bi bi-search"></i> Cari:',
            lengthMenu:       'Tampilkan _MENU_ data',
            info:             'Menampilkan _START_–_END_ dari _TOTAL_ reservasi',
            infoEmpty:        'Tidak ada data',
            infoFiltered:     '(difilter dari _MAX_ total)',
            paginate: {
                next:     '<i class="bi bi-chevron-right"></i>',
                previous: '<i class="bi bi-chevron-left"></i>'
            },
            zeroRecords:      'Tidak ada reservasi yang cocok',
            emptyTable:       'Belum ada data reservasi'
        },
        columnDefs: [
            { orderable: false, targets: [8] } // kolom aksi tidak bisa diurutkan
        ]
    });
});

// Update status booking via Axios (AJAX)
function updateStatus(id, status) {
    Swal.fire({
        title: 'Ubah Status?',
        text: `Status akan diubah menjadi "${status}"`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#c9a96e',
        cancelButtonColor: '#555',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.patch(`/admin/bookings/${id}/status`, { status })
                .then(res => {
                    if (res.data.success) {
                        // Update badge tanpa reload
                        const badge = document.getElementById(`badge-${id}`);
                        const statusClass = {
                            pending:   'status-badge-pending',
                            confirmed: 'status-badge-confirmed',
                            done:      'status-badge-done',
                            cancelled: 'status-badge-cancelled',
                        };
                        badge.className = `status-badge ${statusClass[status]}`;
                        badge.innerHTML = `<span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>${status.charAt(0).toUpperCase() + status.slice(1)}`;

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.data.message,
                            confirmButtonColor: '#c9a96e',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                })
                .catch(err => {
                    // Reset select ke nilai sebelumnya
                    location.reload();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat memperbarui status.',
                        confirmButtonColor: '#c9a96e'
                    });
                });
        } else {
            // Reset select ke nilai awal (batalkan perubahan)
            document.getElementById(`status-${id}`).value =
                document.getElementById(`badge-${id}`).textContent.trim().toLowerCase();
        }
    });
}
</script>
@endpush
