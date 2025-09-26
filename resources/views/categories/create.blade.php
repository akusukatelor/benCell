@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container">
    <h1 class="mb-3">Tambah Kategori</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label>Nama Kategori</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
