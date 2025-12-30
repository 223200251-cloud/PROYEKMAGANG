@extends('layouts.app')

@section('title', 'Edit Kategori - Admin')

@section('content')
    <div class="container-main">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h2 class="mb-0">
                            <i class="fas fa-edit"></i> Edit Kategori
                        </h2>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Terjadi Kesalahan!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama -->
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-heading"></i> Nama Kategori
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $category->name) }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left"></i> Deskripsi
                                </label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="3">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Icon -->
                            <div class="mb-4">
                                <label for="icon" class="form-label">
                                    <i class="fas fa-icons"></i> Icon (Font Awesome)
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('icon') is-invalid @enderror" 
                                    id="icon" 
                                    name="icon" 
                                    value="{{ old('icon', $category->icon) }}">
                                <small class="text-muted">Gunakan kelas Font Awesome</small>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Urutan -->
                            <div class="mb-4">
                                <label for="order" class="form-label">
                                    <i class="fas fa-sort"></i> Urutan
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control @error('order') is-invalid @enderror" 
                                    id="order" 
                                    name="order" 
                                    value="{{ old('order', $category->order) }}"
                                    min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="is_active" 
                                        name="is_active" 
                                        value="1"
                                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kategori Aktif
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary btn-lg">
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
