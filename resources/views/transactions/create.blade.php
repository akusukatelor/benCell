@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="container">
    <h1 class="mb-3">Tambah Transaksi</h1>
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label>Produk</label>
            <select name="product_id" class="form-control" required>
                @foreach($products as $product)
                  <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2">
            <label>Jumlah</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
