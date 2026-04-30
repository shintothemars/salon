@extends('layouts.app')

@section('title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')

@push('styles')
<style>
    .form-page-header {
        background: var(--bg-card);
        border-bottom: 1px solid var(--bg-border);
        padding: 40px 0;
    }

    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
    }

    .form-card-header {
        padding: 24px 32px;
        border-bottom: 1px solid var(--bg-border);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .form-card-icon {
        width: 44px;
        height: 44px;
        background: var(--gradient-gold);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d0d0d;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .form-card-body {
        padding: 32px;
    }

    .form-section-title {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--bg-border);
    }

    .price-input-wrapper {
        position: relative;
    }

    .price-prefix {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
        font-weight: 600;
        font-size: 0.9rem;
        z-index: 2;
    }

    .price-input {
        padding-left: 48px !important;
    }

    .preview-card {
        background: var(--bg-surface);
        border: 1px solid var(--bg-border);
        border-radius: 16px;
        padding: 24px;
        position: sticky;
        top: 80px;
    }

    .preview-title {
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-service-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 12px;
        overflow: hidden;
        transition: var(--transition);
    }

    .preview-img {
        width: 100%;
        height: 120px;
        background: linear-gradient(135deg, #1a1208, #2a1e0c);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    .preview-body { padding: 16px; }

    .preview-name {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .preview-desc {
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .preview-price {
        font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .char-counter {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-align: right;
        margin-top: 4px;
        transition: var(--transition);
    }

    .char-counter.warning { color: #ffc107; }
    .char-counter.danger { color: var(--danger); }

    .tip-box {
        background: rgba(201, 169, 110, 0.08);
        border: 1px solid rgba(201, 169, 110, 0.2);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        gap: 10px;
        align-items: flex-start;
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .tip-box i { color: var(--primary); margin-top: 2px; flex-shrink: 0; }
</style>
@endpush

@section('content')

<!-- PAGE HEADER -->
<div class="form-page-header">
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-bottom: 8px;">
            <ol class="breadcrumb" style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">
                <li class="breadcrumb-item"><a href="/" style="color: var(--text-muted); text-decoration:none;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/services" style="color: var(--text-muted); text-decoration:none;">Layanan</a></li>
                <li class="breadcrumb-item active" style="color: var(--primary);">
                    {{ isset($service) ? 'Edit Layanan' : 'Tambah Layanan' }}
                </li>
            </ol>
        </nav>
        <h1 class="page-title mb-1">
            {{ isset($service) ? 'Edit' : 'Tambah' }} <span style="font-style:italic;">Layanan</span>
        </h1>
        <p class="page-subtitle">
            {{ isset($service) ? 'Perbarui informasi layanan yang sudah ada' : 'Isi formulir untuk menambahkan layanan baru' }}
        </p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">

        <!-- FORM COLUMN -->
        <div class="col-lg-8">
            <form method="POST" action="{{ isset($service) ? '/services/'.$service->id : '/services' }}" id="serviceForm">
                @csrf
                @if(isset($service)) @method('PUT') @endif

                <!-- Validation Errors -->
                @if($errors->any())
                <div class="alert-custom alert-danger-custom d-flex gap-2 mb-4">
                    <i class="bi bi-exclamation-circle-fill mt-1" style="flex-shrink:0;"></i>
                    <div>
                        <strong>Terdapat {{ $errors->count() }} kesalahan:</strong>
                        <ul style="margin: 6px 0 0; padding-left: 18px;">
                            @foreach($errors->all() as $error)
                            <li style="font-size: 0.88rem; margin-top: 2px;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="form-card">
                    <div class="form-card-header">
                        <div class="form-card-icon">
                            <i class="bi bi-{{ isset($service) ? 'pencil-square' : 'plus-lg' }}"></i>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: var(--text-primary);">
                                {{ isset($service) ? 'Edit Data Layanan' : 'Data Layanan Baru' }}
                            </div>
                            <div style="font-size: 0.82rem; color: var(--text-muted);">
                                Semua field bertanda * wajib diisi
                            </div>
                        </div>
                    </div>

                    <div class="form-card-body">

                        <!-- Section: Info Dasar -->
                        <div class="form-section-title">
                            <i class="bi bi-info-circle"></i> Informasi Dasar
                        </div>

                        <!-- Nama Layanan -->
                        <div class="mb-4">
                            <label class="form-label-custom" for="name">Nama Layanan *</label>
                            <input
                                type="text"
                                class="form-control-custom form-control"
                                id="name"
                                name="name"
                                placeholder="Contoh: Creambath Premium, Facial Deep Cleansing"
                                value="{{ old('name', $service->name ?? '') }}"
                                maxlength="100"
                                required
                            >
                            <div class="char-counter" id="nameCounter">0/100</div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label class="form-label-custom" for="description">Deskripsi Layanan</label>
                            <textarea
                                class="form-control-custom form-control"
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Deskripsikan layanan ini: apa yang didapatkan pelanggan, manfaat, dll..."
                                maxlength="500"
                                style="resize: vertical;"
                            >{{ old('description', $service->description ?? '') }}</textarea>
                            <div class="char-counter" id="descCounter">0/500</div>
                        </div>

                        <div class="divider-gold" style="margin: 24px 0;"></div>

                        <!-- Section: Harga & Durasi -->
                        <div class="form-section-title">
                            <i class="bi bi-tag"></i> Harga & Durasi
                        </div>

                        <div class="row g-3 mb-4">
                            <!-- Harga -->
                            <div class="col-md-7">
                                <label class="form-label-custom" for="price">Harga (IDR) *</label>
                                <div class="price-input-wrapper">
                                    <span class="price-prefix">Rp</span>
                                    <input
                                        type="number"
                                        class="form-control-custom form-control price-input"
                                        id="price"
                                        name="price"
                                        placeholder="0"
                                        value="{{ old('price', $service->price ?? '') }}"
                                        min="0"
                                        step="1000"
                                        required
                                    >
                                </div>
                                <div style="font-size:0.78rem; color: var(--text-muted); margin-top: 6px;" id="priceDisplay"></div>
                            </div>

                            <!-- Durasi -->
                            <div class="col-md-5">
                                <label class="form-label-custom" for="duration">Durasi (Menit) *</label>
                                <div style="position:relative;">
                                    <input
                                        type="number"
                                        class="form-control-custom form-control"
                                        id="duration"
                                        name="duration"
                                        placeholder="60"
                                        value="{{ old('duration', $service->duration ?? '') }}"
                                        min="5"
                                        max="480"
                                        step="5"
                                        required
                                    >
                                </div>
                                <div style="font-size:0.78rem; color: var(--text-muted); margin-top: 6px;" id="durationDisplay"></div>
                            </div>
                        </div>

                        <!-- Tip Box -->
                        <div class="tip-box mb-4">
                            <i class="bi bi-lightbulb-fill"></i>
                            <div>
                                <strong style="color: var(--primary);">Tips Harga:</strong> Tetapkan harga yang kompetitif. Anda bisa gunakan format kelipatan Rp 5.000 untuk kemudahan perhitungan.
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 flex-wrap">
                            <button type="submit" class="btn-gold d-inline-flex align-items-center gap-2" id="submitBtn">
                                <i class="bi bi-{{ isset($service) ? 'check-lg' : 'plus-lg' }}"></i>
                                {{ isset($service) ? 'Simpan Perubahan' : 'Tambah Layanan' }}
                            </button>
                            <a href="/services" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- PREVIEW COLUMN -->
        <div class="col-lg-4">
            <div class="preview-card">
                <div class="preview-title">
                    <i class="bi bi-eye-fill" style="color: var(--primary);"></i>
                    Preview Layanan
                </div>

                <div class="preview-service-card">
                    <div class="preview-img" id="previewEmoji">✨</div>
                    <div class="preview-body">
                        <div class="preview-name" id="previewName">Nama Layanan</div>
                        <div class="preview-desc" id="previewDesc">Deskripsi layanan akan muncul di sini...</div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="preview-price" id="previewPrice">Rp 0</div>
                            <span class="badge-gold" id="previewDuration">60 Menit</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 16px; padding: 12px; background: var(--bg-card); border-radius: 8px; border: 1px solid var(--bg-border);">
                    <div style="font-size: 0.78rem; color: var(--text-muted); font-weight: 600; margin-bottom: 10px; letter-spacing: 0.8px; text-transform: uppercase;">Panduan Emoji</div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                        <div style="font-size: 0.78rem; color: var(--text-muted);">💇‍♀️ Rambut</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">💆‍♀️ Facial/Wajah</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">💅 Nail/Kuku</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">🧖‍♀️ Massage</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">💄 Makeup</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">✨ Lainnya</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    const priceInput = document.getElementById('price');
    const durationInput = document.getElementById('duration');

    // Char counters
    function updateCounter(input, counterId, max) {
        const counter = document.getElementById(counterId);
        const len = input.value.length;
        counter.textContent = `${len}/${max}`;
        counter.className = 'char-counter';
        if (len > max * 0.9) counter.classList.add('danger');
        else if (len > max * 0.7) counter.classList.add('warning');
    }

    nameInput?.addEventListener('input', function() {
        updateCounter(this, 'nameCounter', 100);
        updatePreview();
    });

    descInput?.addEventListener('input', function() {
        updateCounter(this, 'descCounter', 500);
        updatePreview();
    });

    priceInput?.addEventListener('input', function() {
        const val = parseInt(this.value) || 0;
        document.getElementById('priceDisplay').textContent =
            val > 0 ? 'Rp ' + val.toLocaleString('id-ID') : '';
        updatePreview();
    });

    durationInput?.addEventListener('input', function() {
        const val = parseInt(this.value) || 0;
        const h = Math.floor(val / 60);
        const m = val % 60;
        document.getElementById('durationDisplay').textContent =
            val > 0 ? (h > 0 ? `${h} jam ` : '') + (m > 0 ? `${m} menit` : '') : '';
        updatePreview();
    });

    // Live preview update
    function getEmoji(name) {
        name = name.toLowerCase();
        if (name.includes('rambut') || name.includes('creambath')) return '💇‍♀️';
        if (name.includes('facial') || name.includes('wajah')) return '💆‍♀️';
        if (name.includes('nail') || name.includes('kuku')) return '💅';
        if (name.includes('massage') || name.includes('pijat')) return '🧖‍♀️';
        if (name.includes('make') || name.includes('lipstik')) return '💄';
        return '✨';
    }

    function updatePreview() {
        const name = nameInput.value || 'Nama Layanan';
        const desc = descInput.value || 'Deskripsi layanan akan muncul di sini...';
        const price = parseInt(priceInput.value) || 0;
        const dur = parseInt(durationInput.value) || 60;

        document.getElementById('previewName').textContent = name;
        document.getElementById('previewDesc').textContent =
            desc.length > 80 ? desc.substring(0, 80) + '...' : desc;
        document.getElementById('previewPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('previewDuration').textContent = dur + ' Menit';
        document.getElementById('previewEmoji').textContent = getEmoji(name);
    }

    // Init counters
    updateCounter(nameInput, 'nameCounter', 100);
    updateCounter(descInput, 'descCounter', 500);
    updatePreview();
</script>
@endpush
