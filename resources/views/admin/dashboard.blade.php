@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-main">
        <!-- Admin Header -->
        <div class="mb-5">
            <h1 class="mb-2">
                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
            </h1>
            <p class="text-muted">Kelola website Portfolio Hub</p>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #0077B6;">
                    <div class="card-body">
                        <h3 class="text-primary mb-0">{{ $stats['total_users'] }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-users"></i> User</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #00B4D8;">
                    <div class="card-body">
                        <h3 class="text-info mb-0">{{ $stats['total_portfolios'] }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-briefcase"></i> Portfolio</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #06D6A0;">
                    <div class="card-body">
                        <h3 class="text-success mb-0">{{ $stats['total_categories'] }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-tag"></i> Kategori</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-center h-100" style="border-left: 4px solid #FFD166;">
                    <div class="card-body">
                        <h3 class="text-warning mb-0">{{ $stats['pending_moderation'] ?? 0 }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-hourglass"></i> Pending</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Menu -->
        <div class="row mb-5">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-sitemap fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Kelola Kategori</h5>
                        <p class="text-muted small">Tambah, edit, atau hapus kategori portfolio</p>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm w-100 mt-3">
                            <i class="fas fa-arrow-right"></i> Kelola Kategori
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Kelola User</h5>
                        <p class="text-muted small">Lihat dan kelola daftar user</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-info btn-sm w-100 mt-3">
                            <i class="fas fa-arrow-right"></i> Kelola User
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-gavel fa-3x text-danger mb-3"></i>
                        <h5 class="card-title">Moderasi Portfolio</h5>
                        <p class="text-muted small">Tinjau dan moderasi portfolio yang dilaporkan</p>
                        <a href="{{ route('admin.moderation.index') }}" class="btn btn-danger btn-sm w-100 mt-3">
                            <i class="fas fa-arrow-right"></i> Moderasi Portfolio
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Portfolios -->
        <div>
            <h3 class="mb-4">
                <i class="fas fa-history"></i> Portfolio Terbaru
            </h3>

            @if($recent_portfolios->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>User</th>
                                <th>Kategori</th>
                                <th>Views</th>
                                <th>Likes</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_portfolios as $portfolio)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($portfolio->title, 30) }}</strong>
                                    </td>
                                    <td>
                                        <a href="{{ route('profile.show', $portfolio->user) }}">
                                            {{ $portfolio->user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $portfolio->category }}</span>
                                    </td>
                                    <td>{{ $portfolio->views }}</td>
                                    <td>{{ $portfolio->likes_count }}</td>
                                    <td>{{ $portfolio->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('portfolio.show', $portfolio) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mt-3">Belum ada portfolio</p>
                </div>
            @endif
        </div>
    </div>
@endsection
