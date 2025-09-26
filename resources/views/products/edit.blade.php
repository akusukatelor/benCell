@extends('layouts.app')

@section('title','Tambah Produk')

@section('content')
<h2>Tambah Produk</h2>
<form action="{{ route('products.store') }}" method="POST">
  @csrf
  <div class="form-group">
    <label>Nama Produk</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Stok</label>
    <input type="number" name="stock" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Harga</label>
    <input type="number" name="price" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Kategori</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <button class="btn btn-success">Simpan</button>
</form>
@endsection
