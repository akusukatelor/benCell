@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container">
    <h1 class="mb-3">Edit Kategori</h1>
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group mb-2">
            <label>Nama Kategori</label>
            <input type="text" name="name" value="{{ $category->name }}" class="form-control" required>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
