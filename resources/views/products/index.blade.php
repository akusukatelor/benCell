@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
        <form method="GET" action="{{ route('products.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama produk..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">Cari</button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $p)
        @if($products->isEmpty())
    <tr>
        <td colspan="6" class="text-center">Tidak ada produk ditemukan.</td>
    </tr>
@endif
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->category->name ?? '-' }}</td>
                <td>{{ $p->stock }}</td>
                <td>{{ number_format($p->cost_price) }}</td>
                <td>{{ number_format($p->sell_price) }}</td>
                <td>
                    <a href="{{ route('products.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('products.destroy', $p->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
</div>
@endsection