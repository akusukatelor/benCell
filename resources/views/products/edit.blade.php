@extends('layouts.app')

@section('title','Tambah Produk')

@section('content')
<h2>Edit Produk</h2>
<form action="{{ route('products.update', $product->id) }}" method="POST">
  @csrf @method('PUT')
  <div class="form-group">
    <label>Nama Produk</label>
    <input type="text" name="name" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Stok</label>
    <input type="number" name="stock" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Harga Beli</label>
    <input type="number" name="cost_price" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Harga Jual</label>
    <input type="number" name="sell_price" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Kategori</label>
    <select name="category_id" class="form-control" required>
      @foreach($categories as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <button class="btn btn-success">Simpan</button>
</form>
@endsection
