@extends('app')

@section('title', 'Daftar Layanan')

@section('content')
<div class="row mb-4">
    <div class="col-md-6">
        <h2>Daftar Layanan</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('service.create') }}" class="btn btn-success">
            ➕ Tambah Layanan Baru
        </a>
    </div>
</div>

@if($services->isEmpty())
    <div class="alert alert-info">
        <strong>Belum ada layanan.</strong> Klik tombol di atas untuk menambahkan layanan baru.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Durasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $key => $service)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $service->name }}</strong></td>
                        <td>
                            @if($service->description)
                                {{ Str::limit($service->description, 50) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                        <td>{{ $service->duration }} min</td>
                        <td>
                            <a href="{{ route('service.edit', $service->id) }}" class="btn btn-sm btn-warning">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('service.destroy', $service->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
