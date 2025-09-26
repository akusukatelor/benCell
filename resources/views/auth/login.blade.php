@extends('layouts.app')

@section('title','Login')

@section('content')
<div class="login-box mx-auto" style="max-width:400px;">
  <div class="card card-outline card-primary">
    <div class="card-header text-center"><b>Login</b></div>
    <div class="card-body">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
        </div>
        <div class="form-group mt-2">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button class="btn btn-primary btn-block mt-3">Login</button>
      </form>
      <p class="mt-2 text-center">
        <a href="{{ route('register') }}">Register</a>
      </p>
    </div>
  </div>
</div>
@endsection
