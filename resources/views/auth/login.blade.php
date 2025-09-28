@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-box mx-auto">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <b>Login</b>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required autofocus value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mt-2">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
            </form>
            <p class="mt-2 text-center">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </p>
        </div>
    </div>
</div>
@endsection