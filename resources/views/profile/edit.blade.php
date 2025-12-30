@extends('layouts.app')

@section('title', 'Edit Profil - ' . Auth::user()->name)

@section('content')
    <div class="container-main">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-user-edit"></i> Edit Profil Saya
                        </h2>
                        <p class="text-white-50 mt-2 mb-0">Perbarui informasi profil Anda</p>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Terjadi Kesalahan!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Lengkap -->
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', Auth::user()->name) }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', Auth::user()->email) }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="mb-4">
                                <label for="username" class="form-label">
                                    <i class="fas fa-at"></i> Username
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('username') is-invalid @enderror" 
                                    id="username" 
                                    name="username" 
                                    value="{{ old('username', Auth::user()->username) }}"
                                    placeholder="nama_unik_anda">
                                <small class="text-muted">Digunakan untuk profil publik Anda</small>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div class="mb-4">
                                <label for="bio" class="form-label">
                                    <i class="fas fa-align-left"></i> Bio
                                </label>
                                <textarea 
                                    class="form-control @error('bio') is-invalid @enderror" 
                                    id="bio" 
                                    name="bio" 
                                    rows="3"
                                    placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', Auth::user()->bio) }}</textarea>
                                <small class="text-muted">Maksimal 500 karakter</small>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Avatar URL -->
                            <div class="mb-4">
                                <label for="avatar_url" class="form-label">
                                    <i class="fas fa-image"></i> URL Avatar
                                </label>
                                <input 
                                    type="url" 
                                    class="form-control @error('avatar_url') is-invalid @enderror" 
                                    id="avatar_url" 
                                    name="avatar_url" 
                                    value="{{ old('avatar_url', Auth::user()->avatar_url) }}"
                                    placeholder="https://example.com/avatar.jpg">
                                <small class="text-muted">Link ke foto profil Anda</small>
                                @if(Auth::user()->avatar_url)
                                    <div class="mt-2">
                                        <small class="text-success">
                                            <i class="fas fa-check-circle"></i> Avatar saat ini:
                                        </small>
                                        <br>
                                        <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" 
                                             class="rounded-circle mt-2" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                @endif
                                @error('avatar_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-4">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone-alt"></i> Nomor Telepon
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone', Auth::user()->phone) }}"
                                    placeholder="+62 812-xxxx-xxxx">
                                <small class="text-muted">Format: +62 xxx-xxxx-xxxx (opsional)</small>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div class="mb-4">
                                <label for="location" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('location') is-invalid @enderror" 
                                    id="location" 
                                    name="location" 
                                    value="{{ old('location', Auth::user()->location) }}"
                                    placeholder="Kota, Negara">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="mb-4">
                                <label for="website" class="form-label">
                                    <i class="fas fa-globe"></i> Website
                                </label>
                                <input 
                                    type="url" 
                                    class="form-control @error('website') is-invalid @enderror" 
                                    id="website" 
                                    name="website" 
                                    value="{{ old('website', Auth::user()->website) }}"
                                    placeholder="https://example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Submit -->
                            <div class="d-flex gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('profile.my-profile') }}" class="btn btn-outline-primary btn-lg">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
