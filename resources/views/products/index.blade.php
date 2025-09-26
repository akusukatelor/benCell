@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

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
</div>
@endsection
