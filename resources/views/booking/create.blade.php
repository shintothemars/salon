@extends('app')

@section('title', 'Form Reservasi - ' . $service->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Reservasi {{ $service->name }}</h5>
            </div>
            <div class="card-body">
                <!-- Informasi Layanan -->
                <div class="alert alert-info">
                    <strong>Layanan:</strong> {{ $service->name }}<br>
                    <strong>Harga:</strong> Rp {{ number_format($service->price, 0, ',', '.') }}<br>
                    <strong>Durasi:</strong> {{ $service->duration }} menit<br>
                    @if($service->description)
                        <strong>Deskripsi:</strong> {{ $service->description }}
                    @endif
                </div>

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf

                    <!-- Service ID (Hidden) -->
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <!-- Nama Pemesan -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" 
                               placeholder="Masukkan nama lengkap Anda" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" 
                               placeholder="Contoh: 0812345678" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Reservasi -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Tanggal Reservasi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                               id="date" name="date" value="{{ old('date') }}" required>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Waktu Reservasi -->
                    <div class="mb-3">
                        <label for="time" class="form-label">Waktu Reservasi <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('time') is-invalid @enderror" 
                               id="time" name="time" value="{{ old('time') }}" required>
                        @error('time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pilih Karyawan -->
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Pilih Karyawan <span class="text-danger">*</span></label>
                        <select class="form-select @error('employee_id') is-invalid @enderror" 
                                id="employee_id" name="employee_id" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Total Harga -->
                    <div class="mb-4">
                        <div class="alert alert-success">
                            <strong>Total Harga:</strong> 
                            <span class="h5">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Lanjut ke Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Set minimum date to today
    document.getElementById('date').min = new Date().toISOString().split('T')[0];
</script>
@endsection
