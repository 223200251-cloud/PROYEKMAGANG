@extends('layouts.app')

@section('title', 'Edit User - Admin')

@section('content')
    <div class="container-main">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>

        <div class="row g-4 justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Edit User: {{ $user->name }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Nama <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-at"></i> Username
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('username') is-invalid @enderror" 
                                    id="username"
                                    name="username"
                                    value="{{ old('username', $user->username) }}"
                                    placeholder="Opsional">
                                @error('username')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Username unik untuk profile user</small>
                            </div>

                            <!-- Avatar URL -->
                            <div class="mb-3">
                                <label for="avatar_url" class="form-label">
                                    <i class="fas fa-image"></i> URL Avatar
                                </label>
                                <input 
                                    type="url" 
                                    class="form-control @error('avatar_url') is-invalid @enderror" 
                                    id="avatar_url"
                                    name="avatar_url"
                                    value="{{ old('avatar_url', $user->avatar_url) }}"
                                    placeholder="https://example.com/avatar.jpg">
                                @error('avatar_url')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Biarkan kosong untuk menggunakan avatar default</small>
                            </div>

                            <!-- Current Avatar Preview -->
                            @if($user->avatar_url)
                                <div class="mb-3">
                                    <label class="form-label">Avatar Saat Ini</label>
                                    <div>
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                            class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                </div>
                            @endif

                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role" class="form-label">
                                    <i class="fas fa-shield-alt"></i> Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">User: Pengguna reguler | Admin: Pengguna administrator</small>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="is_banned" class="form-label">
                                    <i class="fas fa-ban"></i> Status
                                </label>
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_banned"
                                        name="is_banned"
                                        value="1"
                                        @checked(old('is_banned', $user->is_banned))>
                                    <label class="form-check-label" for="is_banned">
                                        Ban user ini (user tidak dapat login)
                                    </label>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2 justify-content-between">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Informasi Akun</h6>
                    </div>
                    <div class="card-body small">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">User ID:</dt>
                            <dd class="col-sm-8"><code>{{ $user->id }}</code></dd>

                            <dt class="col-sm-4">Email Terverifikasi:</dt>
                            <dd class="col-sm-8">
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">{{ $user->email_verified_at->format('d M Y') }}</span>
                                @else
                                    <span class="badge bg-warning">Belum Terverifikasi</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Bergabung:</dt>
                            <dd class="col-sm-8">{{ $user->created_at->format('d M Y H:i') }}</dd>

                            <dt class="col-sm-4">Update Terakhir:</dt>
                            <dd class="col-sm-8">{{ $user->updated_at->format('d M Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Bootstrap form validation
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection
