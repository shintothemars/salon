@extends('layouts.app')

@section('title', isset($employee) ? 'Edit Stylist' : 'Tambah Stylist')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="mb-4">
                <a href="{{ route('admin.employees.index') }}" class="text-decoration-none text-muted mb-3 d-inline-block">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                </a>
                <h1 class="page-title">{{ isset($employee) ? 'Edit' : 'Tambah' }} <span style="font-style:italic;">Stylist</span></h1>
            </div>

            <div class="card-custom p-4">
                <form action="{{ isset($employee) ? route('admin.employees.update', $employee->id) : route('admin.employees.store') }}" method="POST">
                    @csrf
                    @if(isset($employee))
                        @method('PUT')
                    @endif

                    <div class="mb-4">
                        <label class="form-label-custom">Nama Lengkap *</label>
                        <input type="text" name="name" class="form-control-custom form-control @error('name') is-invalid @enderror" value="{{ old('name', $employee->name ?? '') }}" required placeholder="Masukkan nama stylist">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">Email (Opsional)</label>
                        <input type="email" name="email" class="form-control-custom form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email ?? '') }}" placeholder="email@example.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label-custom">No. WhatsApp / HP (Opsional)</label>
                        <input type="text" name="phone" class="form-control-custom form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $employee->phone ?? '') }}" placeholder="0812xxxx">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn-gold py-3">
                            <i class="bi bi-check2-circle me-2"></i>{{ isset($employee) ? 'Simpan Perubahan' : 'Tambah Stylist' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
