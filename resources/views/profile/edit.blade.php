@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container">
    <h1>Edit Profile</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-group mb-3">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="photo">Foto Profil</label>
            <input type="file" name="photo" id="photo" class="form-control-file @error('photo') is-invalid @enderror" accept="image/*">
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            
            <!-- Tampilkan gambar saat ini (dengan default otomatis dari model) -->
            <div class="mt-2">
                <img src="{{ $user->profile_photo_url }}" 
                     alt="Foto Profil {{ $user->name }}" 
                     width="100" 
                     height="100" 
                     class="img-thumbnail rounded-circle"
                     onerror="this.src='{{ asset('img/img.jpg') }}';">  {{-- Fallback tambahan --}}
                <small class="text-muted d-block">
                    @if($user->profile_photo_path)
                        Gambar saat ini ({{ $user->profile_photo_path }}). Upload baru untuk ganti.
                    @else
                        Belum ada foto profil (menggunakan default).
                    @endif
                </small>
            </div>

            <!-- **TAMBAH: Checkbox delete photo (hanya jika ada foto saat ini) -->
            @if($user->profile_photo_path)
                <div class="form-check mt-2">
                    <input type="checkbox" name="delete_photo" id="delete_photo" class="form-check-input" value="1">
                    <label for="delete_photo" class="form-check-label">
                        Hapus foto profil saat ini (akan menggunakan foto default)
                    </label>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection