@extends('layouts.app')

@section('title', 'Reservasi - ' . $service->name)
@section('nav_booking', 'active')

@push('styles')
<style>
    .booking-header {
        background: var(--bg-card);
        border-bottom: 1px solid var(--bg-border);
        padding: 40px 0;
    }

    /* Timeline steps */
    .booking-steps {
        display: flex;
        align-items: center;
        gap: 0;
        margin: 32px 0 0;
    }

    .step-item {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .step-dot {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        border: 2px solid var(--bg-border);
        color: var(--text-muted);
        background: var(--bg-surface);
        position: relative;
        z-index: 1;
        flex-shrink: 0;
        transition: var(--transition);
    }

    .step-dot.active {
        background: var(--gradient-gold);
        border-color: transparent;
        color: #0d0d0d;
        box-shadow: 0 0 0 4px rgba(201,169,110,0.2);
    }

    .step-dot.done {
        background: rgba(76, 175, 125, 0.2);
        border-color: var(--success);
        color: var(--success);
    }

    .step-label {
        font-size: 0.78rem;
        margin-left: 8px;
        font-weight: 500;
        color: var(--text-muted);
        white-space: nowrap;
    }

    .step-label.active { color: var(--primary); font-weight: 600; }
    .step-label.done { color: var(--success); }

    .step-connector {
        flex: 1;
        height: 2px;
        background: var(--bg-border);
        margin: 0 8px;
    }

    .step-connector.done { background: var(--success); }

    /* Booking layout */
    .booking-form-card {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
    }

    .booking-form-header {
        padding: 20px 28px;
        border-bottom: 1px solid var(--bg-border);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .booking-form-section {
        padding: 28px;
        border-bottom: 1px solid var(--bg-border);
    }

    .booking-form-section:last-child { border-bottom: none; }

    .section-heading {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    /* Time slots */
    .time-slots {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 8px;
        margin-top: 4px;
    }

    .time-slot {
        background: var(--bg-surface);
        border: 1.5px solid var(--bg-border);
        border-radius: 8px;
        padding: 10px 8px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--text-secondary);
        user-select: none;
    }

    .time-slot:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(201,169,110,0.07);
    }

    .time-slot.selected {
        background: var(--gradient-gold);
        border-color: transparent;
        color: #0d0d0d;
        font-weight: 700;
        transform: scale(1.03);
        box-shadow: var(--shadow-gold);
    }

    .time-slot.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Employee card select */
    .employee-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .employee-card {
        background: var(--bg-surface);
        border: 1.5px solid var(--bg-border);
        border-radius: 12px;
        padding: 14px 16px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 160px;
        user-select: none;
    }

    .employee-card:hover {
        border-color: var(--primary);
        background: rgba(201,169,110,0.05);
    }

    .employee-card.selected {
        border-color: var(--primary);
        background: rgba(201,169,110,0.1);
    }

    .employee-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gradient-gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #0d0d0d;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .employee-name {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-primary);
    }

    .employee-check {
        margin-left: auto;
        width: 18px;
        height: 18px;
        background: var(--gradient-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0d0d0d;
        font-size: 0.65rem;
        opacity: 0;
        transition: var(--transition);
        flex-shrink: 0;
    }

    .employee-card.selected .employee-check { opacity: 1; }

    /* Order summary */
    .order-summary {
        background: var(--bg-card);
        border: 1px solid var(--bg-border);
        border-radius: 20px;
        overflow: hidden;
        position: sticky;
        top: 80px;
    }

    .order-summary-header {
        background: linear-gradient(135deg, #1a1208, #2a1e0c);
        padding: 20px 24px;
    }

    .order-summary-body { padding: 20px 24px; }

    .order-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 12px 0;
        border-bottom: 1px solid var(--bg-border);
    }

    .order-row:last-child { border-bottom: none; }

    .order-label {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .order-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-primary);
        text-align: right;
    }

    .total-row {
        background: rgba(201,169,110,0.07);
        border: 1px solid rgba(201,169,110,0.2);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
    }

    .total-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .total-price {
        font-size: 1.3rem;
        font-weight: 700;
        background: var(--gradient-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Date input fix dark */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1) opacity(0.5);
        cursor: pointer;
    }

    .note-field {
        background: var(--bg-surface) !important;
        border: 1.5px solid var(--bg-border) !important;
        color: var(--text-primary) !important;
        resize: vertical;
    }
</style>
@endpush

@section('content')

<!-- BOOKING HEADER -->
<div class="booking-header">
    <div class="container">
        <nav aria-label="breadcrumb" style="margin-bottom: 8px;">
            <ol class="breadcrumb" style="font-size: 0.82rem; color: var(--text-muted); margin: 0;">
                <li class="breadcrumb-item"><a href="/" style="color: var(--text-muted); text-decoration:none;">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/" style="color: var(--text-muted); text-decoration:none;">Layanan</a></li>
                <li class="breadcrumb-item active" style="color: var(--primary);">Reservasi</li>
            </ol>
        </nav>
        <h1 class="page-title mb-1">Form <span style="font-style:italic;">Reservasi</span></h1>
        <p class="page-subtitle">Lengkapi data di bawah untuk menyelesaikan pemesanan Anda</p>

        <!-- Booking Steps -->
        <div class="booking-steps d-none d-md-flex">
            <div class="step-item">
                <div class="step-dot done"><i class="bi bi-check-lg"></i></div>
                <span class="step-label done">Pilih Layanan</span>
            </div>
            <div class="step-connector done"></div>
            <div class="step-item">
                <div class="step-dot active">2</div>
                <span class="step-label active">Isi Data</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item">
                <div class="step-dot">3</div>
                <span class="step-label">Konfirmasi</span>
            </div>
            <div class="step-connector"></div>
            <div class="step-item">
                <div class="step-dot">4</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <form method="POST" action="/booking" id="bookingForm">
        @csrf
        <input type="hidden" name="service_id" value="{{ $service->id }}">
        <input type="hidden" name="time" id="selectedTime" value="{{ old('time') }}">

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

        <div class="row g-4">

            <!-- FORM -->
            <div class="col-lg-8">

                <!-- ===== SECTION: JADWAL ===== -->
                <div class="booking-form-card mb-4">
                    <div class="booking-form-header">
                        <div style="width:38px;height:38px;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary);">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div>
                            <div style="font-weight:600;color:var(--text-primary);">Jadwal Reservasi</div>
                            <div style="font-size:0.82rem;color:var(--text-muted);">Pilih tanggal dan waktu kunjungan</div>
                        </div>
                    </div>

                    <div class="booking-form-section">
                        <div class="section-heading"><i class="bi bi-calendar-date"></i> Tanggal</div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom" for="date">Pilih Tanggal *</label>
                                <input type="text"
                                    class="form-control-custom form-control"
                                    id="date_picker"
                                    name="date"
                                    value="{{ old('date', date('Y-m-d')) }}"
                                    placeholder="Pilih Tanggal"
                                    required
                                    onchange="updateSummary()">
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div style="background:var(--bg-surface);border:1px solid var(--bg-border);border-radius:8px;padding:12px 14px;width:100%;">
                                    <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:2px;">Hari ini</div>
                                    <div style="font-weight:600;color:var(--text-primary);font-size:0.9rem;">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="booking-form-section">
                        <div class="section-heading"><i class="bi bi-clock"></i> Waktu</div>
                        <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:14px;">Pilih slot waktu yang tersedia:</p>

                        <div class="time-slots" id="timeSlots">
                            @php
                                $times = ['09:00','09:30','10:00','10:30','11:00','11:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30'];
                            @endphp
                            @foreach($times as $t)
                            <div class="time-slot {{ old('time') == $t ? 'selected' : '' }}" onclick="selectTime('{{ $t }}')" id="slot-{{ str_replace(':', '', $t) }}">
                                {{ $t }}
                            </div>
                            @endforeach
                        </div>

                        <div id="timeWarning" style="display:none;margin-top:10px;" class="d-flex align-items-center gap-2" style="color: var(--danger);">
                            <i class="bi bi-exclamation-circle" style="color:var(--danger);"></i>
                            <span style="font-size:0.85rem; color:var(--danger);">Silakan pilih waktu reservasi</span>
                        </div>
                    </div>
                </div>

                <!-- ===== SECTION: STYLIST ===== -->
                <div class="booking-form-card mb-4">
                    <div class="booking-form-header">
                        <div style="width:38px;height:38px;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary);">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div>
                            <div style="font-weight:600;color:var(--text-primary);">Pilih Stylist</div>
                            <div style="font-size:0.82rem;color:var(--text-muted);">Pilih terapis atau stylist favorit Anda</div>
                        </div>
                    </div>

                    <div class="booking-form-section">
                        <input type="hidden" name="employee_id" id="selectedEmployee" value="{{ old('employee_id') }}" required>

                        <div class="employee-cards" id="employeeCards">
                            @foreach($employees as $emp)
                            <div class="employee-card {{ old('employee_id') == $emp->id ? 'selected' : '' }}"
                                onclick="selectEmployee({{ $emp->id }}, this)"
                                id="emp-{{ $emp->id }}">
                                <div class="employee-avatar">{{ strtoupper(substr($emp->name, 0, 1)) }}</div>
                                <div>
                                    <div class="employee-name">{{ $emp->name }}</div>
                                    <div style="font-size:0.75rem;color:var(--text-muted);">Stylist</div>
                                </div>
                                <div class="employee-check"><i class="bi bi-check-lg"></i></div>
                            </div>
                            @endforeach

                            @if($employees->isEmpty())
                            <div style="color:var(--text-muted);font-size:0.9rem;padding:12px;">
                                <i class="bi bi-info-circle me-2"></i>Belum ada stylist tersedia
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ===== SECTION: BIODATA ===== -->
                <div class="booking-form-card mb-4">
                    <div class="booking-form-header">
                        <div style="width:38px;height:38px;background:rgba(201,169,110,0.15);border:1px solid rgba(201,169,110,0.25);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--primary);">
                            <i class="bi bi-person-vcard"></i>
                        </div>
                        <div>
                            <div style="font-weight:600;color:var(--text-primary);">Data Pemesan</div>
                            <div style="font-size:0.82rem;color:var(--text-muted);">Isi biodata untuk keperluan konfirmasi</div>
                        </div>
                    </div>

                    <div class="booking-form-section">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom" for="name">Nama Lengkap *</label>
                                <input type="text"
                                    class="form-control-custom form-control"
                                    id="pname"
                                    name="name"
                                    placeholder="Masukkan nama lengkap"
                                    value="{{ old('name') }}"
                                    required
                                    oninput="updateSummary()">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom" for="phone">No. WhatsApp / HP *</label>
                                <div style="position:relative;">
                                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:0.88rem;">+62</span>
                                    <input type="tel"
                                        class="form-control-custom form-control"
                                        id="phone"
                                        name="phone"
                                        placeholder="812-3456-7890"
                                        value="{{ old('phone') }}"
                                        style="padding-left: 48px !important;"
                                        required
                                        oninput="updateSummary()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom" for="email">Email (Opsional)</label>
                                <input type="email"
                                    class="form-control-custom form-control"
                                    id="email"
                                    name="email"
                                    placeholder="email@example.com"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom" for="gender">Jenis Kelamin</label>
                                <select class="form-select-custom form-select" id="gender" name="gender">
                                    <option value="">-- Pilih --</option>
                                    <option value="Wanita" {{ old('gender') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                    <option value="Pria" {{ old('gender') == 'Pria' ? 'selected' : '' }}>Pria</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom" for="notes">Catatan Tambahan</label>
                                <textarea class="form-control-custom form-control note-field"
                                    id="notes"
                                    name="notes"
                                    rows="3"
                                    placeholder="Ada permintaan khusus? Tuliskan di sini...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn-gold d-inline-flex align-items-center gap-2 flex-fill justify-content-center" id="submitBookingBtn">
                        <i class="bi bi-calendar-check"></i>
                        Konfirmasi Reservasi
                    </button>
                    <a href="/" class="btn-ghost text-decoration-none d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Batal
                    </a>
                </div>

            </div>

            <!-- ORDER SUMMARY -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <div class="order-summary-header">
                        <div style="font-size:0.75rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--primary);margin-bottom:12px;">Ringkasan Pesanan</div>

                        <div class="d-flex align-items-center gap-3">
                            <div style="width:48px;height:48px;background:rgba(201,169,110,0.15);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">
                                @if(stripos($service->name, 'creambath') !== false || stripos($service->name, 'rambut') !== false) 💇‍♀️
                                @elseif(stripos($service->name, 'facial') !== false || stripos($service->name, 'wajah') !== false) 💆‍♀️
                                @elseif(stripos($service->name, 'nail') !== false || stripos($service->name, 'kuku') !== false) 💅
                                @elseif(stripos($service->name, 'massage') !== false || stripos($service->name, 'pijat') !== false) 🧖‍♀️
                                @elseif(stripos($service->name, 'make') !== false) 💄
                                @else ✨ @endif
                            </div>
                            <div>
                                <div style="font-weight:700;color:var(--text-primary);font-size:1rem;">{{ $service->name }}</div>
                                <div style="display:flex;gap:8px;margin-top:4px;flex-wrap:wrap;">
                                    <span class="badge-gold">{{ $service->duration }} Menit</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary-body">
                        <div class="order-row">
                            <div class="order-label">Layanan</div>
                            <div class="order-value">{{ $service->name }}</div>
                        </div>
                        <div class="order-row">
                            <div class="order-label">Pemesan</div>
                            <div class="order-value" id="summaryName">—</div>
                        </div>
                        <div class="order-row">
                            <div class="order-label">No. HP</div>
                            <div class="order-value" id="summaryPhone">—</div>
                        </div>
                        <div class="order-row">
                            <div class="order-label">Tanggal</div>
                            <div class="order-value" id="summaryDate">—</div>
                        </div>
                        <div class="order-row">
                            <div class="order-label">Waktu</div>
                            <div class="order-value" id="summaryTime">—</div>
                        </div>
                        <div class="order-row">
                            <div class="order-label">Stylist</div>
                            <div class="order-value" id="summaryEmployee">—</div>
                        </div>
                        <div class="order-row">
                            <div class="order-label">Harga Layanan</div>
                            <div class="order-value">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                        </div>

                        <div class="total-row">
                            <div class="total-label">Total Pembayaran</div>
                            <div class="total-price">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                        </div>

                        <div style="margin-top:16px;padding:12px;background:rgba(76,175,125,0.08);border:1px solid rgba(76,175,125,0.2);border-radius:8px;">
                            <div class="d-flex align-items-center gap-2" style="font-size:0.82rem;color:var(--success);">
                                <i class="bi bi-shield-check-fill"></i>
                                <span>Pemesanan 100% aman & terjamin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    let selectedTimeValue = '{{ old('time') }}';
    let selectedEmployeeName = '';

    // Initialize Flatpickr
    flatpickr("#date_picker", {
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
        minDate: "today",
        locale: "id",
        theme: "dark",
        onChange: function(selectedDates, dateStr, instance) {
            updateSummary();
        }
    });

    function selectTime(time) {
        // Remove selected from all
        document.querySelectorAll('.time-slot').forEach(s => s.classList.remove('selected'));
        // Add to clicked
        const slotId = 'slot-' + time.replace(':', '');
        document.getElementById(slotId).classList.add('selected');
        selectedTimeValue = time;
        document.getElementById('selectedTime').value = time;
        document.getElementById('summaryTime').textContent = time + ' WIB';
        document.getElementById('timeWarning').style.display = 'none';
    }

    function selectEmployee(id, el) {
        document.querySelectorAll('.employee-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('selectedEmployee').value = id;
        selectedEmployeeName = el.querySelector('.employee-name').textContent;
        document.getElementById('summaryEmployee').textContent = selectedEmployeeName;
    }

    function updateSummary() {
        const name = document.getElementById('pname')?.value || '—';
        const phone = document.getElementById('phone')?.value || '—';
        const dateVal = document.getElementById('date_picker')?.value;

        document.getElementById('summaryName').textContent = name || '—';
        document.getElementById('summaryPhone').textContent = phone ? '+62' + phone : '—';

        if (dateVal) {
            const d = new Date(dateVal);
            const opts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('summaryDate').textContent = d.toLocaleDateString('id-ID', opts);
        }
    }

    // Form submit validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if (!selectedTimeValue) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Waktu Belum Dipilih',
                text: 'Silakan pilih slot waktu yang tersedia terlebih dahulu.',
                confirmButtonColor: '#c9a96e'
            });
            document.getElementById('timeSlots').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        if (!document.getElementById('selectedEmployee').value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Stylist Belum Dipilih',
                text: 'Silakan pilih stylist favorit Anda untuk melanjutkan.',
                confirmButtonColor: '#c9a96e'
            });
            document.getElementById('employeeCards').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
    });

    // Init
    updateSummary();
    if (selectedTimeValue) {
        document.getElementById('summaryTime').textContent = selectedTimeValue + ' WIB';
    }
</script>
@endpush