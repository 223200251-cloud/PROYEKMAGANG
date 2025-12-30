@extends('layouts.app')

@section('title', 'Kelola Kategori - Admin')

@section('content')
    <div class="container-main">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-2">
                    <i class="fas fa-sitemap"></i> Kelola Kategori
                </h1>
                <p class="text-muted">Tambah, edit, atau hapus kategori portfolio</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Categories Table -->
        @if($categories->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Slug</th>
                                <th>Deskripsi</th>
                                <th>Urutan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>
                                        @if($category->icon)
                                            <i class="{{ $category->icon }}"></i>
                                        @endif
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        {{ Str::limit($category->description, 50) ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $category->order }}</span>
                                    </td>
                                    <td>
                                        @if($category->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus kategori ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p class="mt-3">Belum ada kategori</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus"></i> Buat Kategori Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
