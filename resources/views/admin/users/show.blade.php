@extends('layouts.app')

@section('title', 'Detail User - Admin')

@section('content')
    <div class="container-main">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- User Profile -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body text-center py-5">
                        <img src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                            alt="{{ $user->name }}" class="rounded-circle mb-3" style="width: 120px; height: 120px;">
                        <h3 class="mb-1">{{ $user->name }}</h3>
                        <p class="text-muted">@{{ $user->username ?? 'user' . $user->id }}</p>
                        <p class="text-muted">{{ $user->email }}</p>
                        
                        @if($user->is_banned)
                            <span class="badge bg-danger mb-3 d-inline-block">
                                <i class="fas fa-ban"></i> User Ter-ban
                            </span>
                        @else
                            <span class="badge bg-success mb-3 d-inline-block">
                                <i class="fas fa-check-circle"></i> Aktif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- User Stats -->
                <div class="row mb-4 g-3">
                    <div class="col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-primary mb-0">{{ $user->portfolios_count }}</h4>
                                <p class="text-muted mb-0">Portfolio</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card text-center">
                            <div class="card-body">
                                <h4 class="text-info mb-0">{{ $totalViews }}</h4>
                                <p class="text-muted mb-0">Total Views</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Info -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informasi Akun</h5>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Nama:</dt>
                            <dd class="col-sm-8">{{ $user->name }}</dd>

                            <dt class="col-sm-4">Username:</dt>
                            <dd class="col-sm-8">@{{ $user->username ?? 'user' . $user->id }}</dd>

                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8"><code>{{ $user->email }}</code></dd>

                            <dt class="col-sm-4">Role:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-info">
                                    {{ ucfirst($user->role ?? 'user') }}
                                </span>
                            </dd>

                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8">
                                @if($user->is_banned)
                                    <span class="badge bg-danger">Ter-ban</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Bergabung:</dt>
                            <dd class="col-sm-8">{{ $user->created_at->format('d M Y H:i') }}</dd>

                            <dt class="col-sm-4">Update Terakhir:</dt>
                            <dd class="col-sm-8">{{ $user->updated_at->format('d M Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>

                <!-- User Portfolios -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-image"></i> Portfolio ({{ $user->portfolios_count }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($portfolios->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($portfolios as $portfolio)
                                    <div class="list-group-item">
                                        <div class="row align-items-center g-3">
                                            <div class="col-auto">
                                                @if($portfolio->image_url)
                                                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" 
                                                        class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded p-2">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col flex-grow-1">
                                                <h6 class="mb-1">{{ $portfolio->title }}</h6>
                                                <p class="text-muted small mb-1">{{ $portfolio->category }}</p>
                                                <div class="d-flex gap-2">
                                                    <span class="badge bg-info"><i class="fas fa-eye"></i> {{ $portfolio->views }}</span>
                                                    <span class="badge bg-danger"><i class="fas fa-heart"></i> {{ $portfolio->likes_count ?? 0 }}</span>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                @if($portfolio->status === 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($portfolio->status === 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @endif
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('portfolio.show', $portfolio) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($portfolios->hasMorePages())
                                <div class="mt-3 text-center">
                                    <a href="{{ route('admin.users.show', $user) }}?page=2" class="btn btn-outline-secondary btn-sm">
                                        Lihat Lebih Banyak
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-info text-center py-4 mb-0">
                                <i class="fas fa-inbox fa-2x mb-2"></i>
                                <p class="mt-2">Belum ada portfolio dari user ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions Panel -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Aksi Admin</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit User
                            </a>

                            @if(!$user->is_banned)
                                <form action="{{ route('admin.users.toggleBan', $user) }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" onclick="return confirm('Ban user ini?')">
                                        <i class="fas fa-ban"></i> Ban User
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.toggleBan', $user) }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning">
                                        <i class="fas fa-ban"></i> Unban User
                                    </button>
                                </form>
                            @endif

                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Hapus User
                            </button>
                        </div>

                        <hr>

                        <p class="small text-muted mb-2"><strong>User ID:</strong></p>
                        <p class="small"><code>{{ $user->id }}</code></p>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Timeline</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline-item">
                            <div class="timeline-point bg-success"></div>
                            <p class="text-muted small">
                                <strong>Bergabung</strong><br>
                                {{ $user->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        @if($user->updated_at->ne($user->created_at))
                            <div class="timeline-item">
                                <div class="timeline-point bg-info"></div>
                                <p class="text-muted small">
                                    <strong>Update Terakhir</strong><br>
                                    {{ $user->updated_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Menghapus user tidak dapat dibatalkan dan akan menghapus semua data terkait!
                            </p>
                            <p class="mt-3">Apakah Anda yakin ingin menghapus <strong>{{ $user->name }}</strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Ya, Hapus User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline-item {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            border-left: 2px solid #e0e0e0;
            padding-left: 1rem;
            margin-left: 0.5rem;
        }

        .timeline-item:last-child {
            border-left: none;
        }

        .timeline-point {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-top: 0.3rem;
            flex-shrink: 0;
        }
    </style>
@endsection
