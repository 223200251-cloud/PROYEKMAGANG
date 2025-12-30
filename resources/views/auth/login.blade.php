@extends('layouts.app')

@section('title', 'Login - Portfolio Hub')

@section('content')
    <div class="container-main">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card fade-in">
                    <div class="card-header text-center py-4">
                        <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
                        <p class="text-white-50 mb-0 mt-2">Masuk ke akun Anda</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input 
                                    type="checkbox" 
                                    name="remember" 
                                    id="remember"
                                    class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="fas fa-arrow-right"></i> Login
                            </button>

                            <!-- Register Link -->
                            <p class="text-center text-muted mb-0">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-decoration-none">
                                    <strong>Daftar di sini</strong>
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
