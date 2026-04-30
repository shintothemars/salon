@extends('layouts.app')

@section('title', 'Kelola Layanan')
@section('nav_services', 'active')

@push('styles')
<style>
    .services-header {
        background: var(--bg-card);
        border-bottom: 1px solid var(--bg-border);
        padding: 40px 0;
    }

    .services-table-wrapper {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
    }

    .services-table-header {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--bg-border);
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom thead th {
        background: var(--bg-surface);
        color: var(--text-muted);
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 14px 20px;
        border-bottom: 1px solid var(--bg-border);
        white-space: nowrap;
    }

    .table-custom tbody tr {
        border-bottom: 1px solid var(--bg-border);
        transition: var(--transition);
    }

    .table-custom tbody tr:last-child { border-bottom: none; }

    .table-custom tbody tr:hover {
        background: rgba(201, 169, 110, 0.04);
    }

    .table-custom td {
        padding: 16px 20px;
        font-size: 0.93rem;
        color: var(--text-primary);
        vertical-align: middle;
    }

    .service-icon-cell {
        width: 44px;
        height: 44px;
        background: rgba(201, 169, 110, 0.1);
        border: 1px solid rgba(201, 169, 110, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .table-price {
        font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .action-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .search-input {
        background: var(--bg-surface) !important;
        border: 1.5px solid var(--bg-border) !important;
        color: var(--text-primary) !important;
        padding: 10px 14px 10px 36px !important;
        border-radius: var(--radius-sm) !important;
        font-family: 'Outfit', sans-serif !important;
        font-size: 0.88rem !important;
        width: 240px;
        transition: var(--transition) !important;
    }

    .search-input:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.15) !important;
        outline: none !important;
    }

    .search-input::placeholder { color: var(--text-muted) !important; }

    .empty-state-table {
        text-align: center;
        padding: 60px 24px;
        color: var(--text-muted);
    }

    /* Modal Confirm Delete */
    .modal-custom .modal-content {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        color: var(--text-primary);
    }

    .modal-custom .modal-header {
        border-bottom: 1px solid var(--bg-border);
        padding: 20px 24px;
    }

    .modal-custom .modal-footer {
        border-top: 1px solid var(--bg-border);
        padding: 16px 24px;
    }

    .modal-custom .btn-close {
        filter: invert(1) opacity(0.5);
    }

    .stats-row {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .stat-mini {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 12px;
        padding: 16px 20px;
        flex: 1;
        min-width: 140px;
        transition: var(--transition);
    }

    .stat-mini:hover { border-color: rgba(201,169,110,0.3); }

    .stat-mini-value {
        font-size: 1.6rem;
        font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-mini-label {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
    }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="services-header">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <nav aria-label="breadcrumb" style="margin-bottom: 8px;">
                    <ol class="breadcrumb" style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">
                        <li class="breadcrumb-item"><a href="/" style="color: var(--text-muted); text-decoration:none;">Beranda</a></li>
                        <li class="breadcrumb-item active" style="color: var(--primary);">Layanan</li>
                    </ol>
                </nav>
                <h1 class="page-title mb-1">Manajemen <span style="font-style:italic;">Layanan</span></h1>
                <p class="page-subtitle">Kelola daftar layanan yang tersedia untuk reservasi</p>
            </div>
            <a href="/services/create" class="btn-gold text-decoration-none d-inline-flex align-items-center gap-2" id="btn-add-service">
                <i class="bi bi-plus-lg"></i> Tambah Layanan
            </a>
        </div>
    </div>
</div>

<div class="container py-4">

    <!-- Stats Mini -->
    <div class="stats-row">
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $services->count() }}</div>
            <div class="stat-mini-label">Total Layanan</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value">Rp {{ $services->count() > 0 ? number_format($services->avg('price'), 0, ',', '.') : '0' }}</div>
            <div class="stat-mini-label">Rata-rata Harga</div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-value">{{ $services->count() > 0 ? $services->avg('duration') : '0' }} mnt</div>
            <div class="stat-mini-label">Rata-rata Durasi</div>
        </div>
    </div>

    <!-- Services Table -->
    <div class="services-table-wrapper">
        <div class="services-table-header">
            <h3 style="font-size: 1rem; font-weight: 600; margin: 0; color: var(--text-primary);">
                Daftar Layanan
                <span class="badge-gold ms-2">{{ $services->count() }}</span>
            </h3>
            <div class="search-input-wrapper">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input" id="searchService" placeholder="Cari layanan...">
            </div>
        </div>

        @if($services->count() > 0)
        <div class="table-responsive">
            <table class="table-custom" id="servicesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Layanan</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $index => $service)
                    <tr id="row-service-{{ $service->id }}">
                        <td style="color: var(--text-muted);">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="service-icon-cell">
                                    @if(stripos($service->name, 'creambath') !== false || stripos($service->name, 'rambut') !== false) 💇‍♀️
                                    @elseif(stripos($service->name, 'facial') !== false || stripos($service->name, 'wajah') !== false) 💆‍♀️
                                    @elseif(stripos($service->name, 'nail') !== false || stripos($service->name, 'kuku') !== false) 💅
                                    @elseif(stripos($service->name, 'massage') !== false || stripos($service->name, 'pijat') !== false) 🧖‍♀️
                                    @elseif(stripos($service->name, 'make') !== false) 💄
                                    @else ✨ @endif
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $service->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color: var(--text-muted); max-width: 220px;">
                            {{ Str::limit($service->description ?? '-', 55) }}
                        </td>
                        <td>
                            <span class="table-price">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span style="display: flex; align-items: center; gap: 4px; color: var(--text-secondary); font-size: 0.88rem;">
                                <i class="bi bi-clock" style="color: var(--primary);"></i>
                                {{ $service->duration }} menit
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="/services/{{ $service->id }}/edit" class="btn-edit-soft text-decoration-none d-inline-flex align-items-center gap-1" id="edit-service-{{ $service->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <button class="btn-danger-soft d-inline-flex align-items-center gap-1"
                                    onclick="confirmDelete({{ $service->id }}, '{{ $service->name }}')"
                                    id="delete-service-{{ $service->id }}">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state-table">
            <div style="font-size: 3rem; margin-bottom: 16px; color: var(--bg-border);">📋</div>
            <h5 style="color: var(--text-secondary); margin-bottom: 8px;">Belum Ada Layanan</h5>
            <p style="margin-bottom: 24px; font-size: 0.9rem;">Klik tombol "Tambah Layanan" untuk mulai menambahkan.</p>
            <a href="/services/create" class="btn-gold text-decoration-none">
                <i class="bi bi-plus-lg me-2"></i>Tambah Layanan Pertama
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade modal-custom" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p style="color: var(--text-secondary); margin-bottom: 8px;">Anda akan menghapus layanan:</p>
                <p style="font-weight: 600; font-size: 1.05rem; color: var(--text-primary);" id="deleteServiceName"></p>
                <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 8px;">
                    <i class="bi bi-info-circle me-1"></i>
                    Tindakan ini tidak dapat dibatalkan. Data reservasi terkait juga akan terpengaruh.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-gold" id="confirmDeleteBtn">
                        <i class="bi bi-trash3 me-2"></i>Hapus Layanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchService')?.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('#servicesTable tbody tr').forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    // Delete confirmation
    function confirmDelete(id, name) {
        document.getElementById('deleteServiceName').textContent = name;
        document.getElementById('deleteForm').action = `/services/${id}`;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endpush
