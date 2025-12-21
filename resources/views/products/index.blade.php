@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">📦 Daftar Produk</h1>
        <a href="{{ route('products.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('products.index') }}" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2 shadow-sm"
            placeholder="Cari nama produk..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary shadow-sm">
            <i class="bi bi-search"></i> Cari
        </button>
    </form>

    <!-- Table Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Sku</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th >Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            <tr>
                                <td class="fw-medium">{{ $p->sku }}</td>
                                <td class="fw-medium">{{ $p->name }}</td>
                                <td>{{ $p->category->name ?? '-' }}</td>
                                <td>{{ $p->stock }}</td>
                                <td>Rp {{ number_format($p->cost_price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($p->sell_price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('products.edit', $p->id) }}" 
                                       class="btn btn-sm btn-warning me-1 shadow-sm">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $p->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                            onclick="return confirm('Yakin hapus?')">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-box-seam"></i> Tidak ada produk ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>

{{-- Optional Custom Style --}}
@push('styles')
<style>
    table.table tr:hover {
        background-color: #f8f9fa !important;
        transition: 0.2s ease;
    }
    .card {
        border-radius: 12px;
    }
</style>
@endpush
@endsection
