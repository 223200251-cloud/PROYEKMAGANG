@extends('layouts.app')

@section('title', 'Review Portfolio - Admin')

@section('content')
    <div class="container-main">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.moderation.index') }}">Moderasi</a></li>
                <li class="breadcrumb-item active">{{ $portfolio->title }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <!-- Portfolio Details -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ $portfolio->title }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            @if($portfolio->image_url)
                                <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" class="img-fluid rounded mb-3" style="max-height: 400px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded p-5 text-center mb-3">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Pembuat:</strong></p>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $portfolio->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($portfolio->user->name) }}" 
                                        alt="{{ $portfolio->user->name }}" class="rounded-circle" style="width: 40px; height: 40px;">
                                    <a href="{{ route('admin.users.show', $portfolio->user) }}">{{ $portfolio->user->name }}</a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Kategori:</strong></p>
                                <p><span class="badge bg-primary">{{ $portfolio->category ?? '-' }}</span></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Deskripsi:</strong>
                            <p class="mt-2">{{ $portfolio->description }}</p>
                        </div>

                        @if($portfolio->technologies)
                            <div class="mb-3">
                                <strong>Teknologi:</strong>
                                <div class="mt-2">
                                    @foreach(explode(', ', $portfolio->technologies) as $tech)
                                        <span class="badge bg-secondary">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="row text-center pt-3 border-top">
                            <div class="col-6 col-md-3">
                                <p class="text-muted small mb-0">Views</p>
                                <h6>{{ $portfolio->views }}</h6>
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="text-muted small mb-0">Likes</p>
                                <h6>{{ $portfolio->likes_count ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="text-muted small mb-0">Comments</p>
                                <h6>{{ $portfolio->comments_count ?? 0 }}</h6>
                            </div>
                            <div class="col-6 col-md-3">
                                <p class="text-muted small mb-0">Tanggal Dibuat</p>
                                <h6 class="text-muted">{{ $portfolio->created_at->format('d M Y') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                @if($portfolio->comments_count > 0)
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-comments"></i> Komentar ({{ $portfolio->comments_count }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <!-- Sample comments display -->
                                <p class="text-muted text-center py-3">Komentar ditampilkan di sini</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Moderation Panel -->
            <div class="col-lg-4">
                <!-- Status Card -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Status Moderasi</h5>
                    </div>
                    <div class="card-body">
                        @if($portfolio->is_flagged)
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-flag"></i> Portfolio ini telah di-flag
                            </div>
                        @endif

                        @if($portfolio->status === 'rejected')
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-times-circle"></i> <strong>Ditolak</strong>
                                @if($portfolio->rejection_reason)
                                    <p class="mt-2 mb-0">{{ $portfolio->rejection_reason }}</p>
                                @endif
                            </div>
                        @elseif($portfolio->status === 'approved')
                            <div class="alert alert-success mb-3">
                                <i class="fas fa-check-circle"></i> <strong>Disetujui</strong>
                            </div>
                        @else
                            <div class="alert alert-warning mb-3">
                                <i class="fas fa-hourglass-half"></i> <strong>Menunggu Review</strong>
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            @if($portfolio->status !== 'approved')
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                                    <i class="fas fa-check"></i> Setujui Portfolio
                                </button>
                            @endif

                            @if($portfolio->status !== 'rejected')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="fas fa-times"></i> Tolak Portfolio
                                </button>
                            @endif

                            @if(!$portfolio->is_flagged)
                                <form action="{{ route('admin.moderation.flag', $portfolio) }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" onclick="return confirm('Flag portfolio ini?')">
                                        <i class="fas fa-flag"></i> Flag Portfolio
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.moderation.unflag', $portfolio) }}" method="POST" class="d-grid">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning">
                                        <i class="fas fa-flag"></i> Hapus Flag
                                    </button>
                                </form>
                            @endif

                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> Hapus Portfolio
                            </button>
                        </div>
                    </div>
                </div>

                <!-- User Info Card -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informasi Pembuat</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ $portfolio->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($portfolio->user->name) }}" 
                            alt="{{ $portfolio->user->name }}" class="rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <h6>{{ $portfolio->user->name }}</h6>
                        <p class="text-muted small mb-3">{{ $portfolio->user->email }}</p>
                        
                        @if($portfolio->user->is_banned)
                            <div class="alert alert-danger mb-3">
                                <i class="fas fa-ban"></i> User Ter-ban
                            </div>
                        @endif

                        <a href="{{ route('admin.users.show', $portfolio->user) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-user"></i> Lihat Profil User
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Setujui Portfolio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.moderation.approve', $portfolio) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin untuk menyetujui portfolio ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Ya, Setujui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reject Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tolak Portfolio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.moderation.reject', $portfolio) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Masukkan alasan penolakan:</p>
                            <textarea name="rejection_reason" class="form-control" rows="4" placeholder="Alasan penolakan..." required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times"></i> Tolak Portfolio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Portfolio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.moderation.destroy', $portfolio) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p class="text-danger">
                                <i class="fas fa-exclamation-triangle"></i> 
                                Menghapus portfolio tidak dapat dibatalkan. Lanjutkan?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Ya, Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
