@extends('layouts.app')

@section('title', 'Moderasi Portfolio - Admin')

@section('content')
    <div class="container-main">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="mb-2">
                <i class="fas fa-gavel"></i> Moderasi Portfolio
            </h1>
            <p class="text-muted">Review dan moderasi portfolio yang dilaporkan</p>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #0077B6;">
                    <div class="card-body">
                        <h3 class="text-primary mb-0">{{ $stats['total_portfolios'] }}</h3>
                        <p class="text-muted mb-0">Total Portfolio</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #FFD166;">
                    <div class="card-body">
                        <h3 class="text-warning mb-0">{{ $stats['total_flagged'] }}</h3>
                        <p class="text-muted mb-0">Di-flag</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-center h-100" style="border-left: 4px solid #EF476F;">
                    <div class="card-body">
                        <h3 class="text-danger mb-0">{{ $stats['total_rejected'] }}</h3>
                        <p class="text-muted mb-0">Ditolak</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Portfolios List -->
        @if($portfolios->count() > 0)
            <div class="row g-4">
                @foreach($portfolios as $portfolio)
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-md-8">
                                        <h5 class="card-title">{{ $portfolio->title }}</h5>
                                        <p class="text-muted mb-2">
                                            <i class="fas fa-user"></i> {{ $portfolio->user->name }}
                                            | <i class="fas fa-tag"></i> {{ $portfolio->category }}
                                        </p>
                                        <p class="text-muted small">{{ Str::limit($portfolio->description, 150) }}</p>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <span class="badge bg-info"><i class="fas fa-eye"></i> {{ $portfolio->views }}</span>
                                            <span class="badge bg-danger"><i class="fas fa-heart"></i> {{ $portfolio->likes_count }}</span>
                                            <span class="badge bg-warning"><i class="fas fa-comment"></i> {{ $portfolio->comments_count }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        @if($portfolio->is_flagged)
                                            <span class="badge bg-danger mb-2 d-inline-block">
                                                <i class="fas fa-flag"></i> Di-flag
                                            </span>
                                        @endif

                                        @if($portfolio->status === 'rejected')
                                            <span class="badge bg-danger mb-2 d-inline-block">
                                                <i class="fas fa-times"></i> Ditolak
                                            </span>
                                            @if($portfolio->rejection_reason)
                                                <p class="small text-muted mt-2">
                                                    <strong>Alasan:</strong> {{ $portfolio->rejection_reason }}
                                                </p>
                                            @endif
                                        @elseif($portfolio->status === 'approved')
                                            <span class="badge bg-success mb-2 d-inline-block">
                                                <i class="fas fa-check"></i> Disetujui
                                            </span>
                                        @endif

                                        <div class="mt-3">
                                            <a href="{{ route('admin.moderation.show', $portfolio) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Review
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $portfolios->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info text-center py-5">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p class="mt-3">Belum ada portfolio untuk dimoderasi</p>
            </div>
        @endif
    </div>
@endsection
