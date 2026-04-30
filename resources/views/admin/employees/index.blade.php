@extends('layouts.app')

@section('title', 'Kelola Stylist')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-0">Manajemen <span style="font-style:italic;">Stylist</span></h1>
            <p class="text-muted">Daftar tim profesional salon Anda</p>
        </div>
        <a href="{{ route('admin.employees.create') }}" class="btn-gold text-decoration-none">
            <i class="bi bi-plus-lg me-2"></i>Tambah Stylist
        </a>
    </div>

    <div class="card-custom">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0" style="background: transparent;">
                <thead style="border-bottom: 1px solid var(--bg-border);">
                    <tr>
                        <th class="px-4 py-3">Nama Stylist</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">No. HP</th>
                        <th class="px-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr style="border-bottom: 1px solid var(--bg-border);">
                        <td class="px-4 py-3 align-middle">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 40px; height: 40px; background: var(--gradient-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #0d0d0d;">
                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                </div>
                                <span class="fw-600 text-white">{{ $employee->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 align-middle text-muted">{{ $employee->email ?? '-' }}</td>
                        <td class="px-4 py-3 align-middle text-muted">{{ $employee->phone ?? '-' }}</td>
                        <td class="px-4 py-3 align-middle text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn-edit-soft text-decoration-none">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Hapus stylist ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger-soft">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-3"></i>
                            Belum ada stylist. Klik tombol "Tambah Stylist" untuk mulai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
