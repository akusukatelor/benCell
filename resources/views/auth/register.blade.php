@extends('layouts.app')

@section('title','Register')

@section('content')
<div class="register-box mx-auto" style="max-width:400px;">
  <div class="card card-outline card-primary">
    <div class="card-header text-center"><b>Register</b></div>
    <div class="card-body">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
          <input type="text" name="name" class="form-control" placeholder="Nama" required>
        </div>
        <div class="form-group mt-2">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group mt-2">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="form-group mt-2">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
        </div>
        <button class="btn btn-success btn-block mt-3">Register</button>
      </form>
    </div>
  </div>
</div>
@endsection
