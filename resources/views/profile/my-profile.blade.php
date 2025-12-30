@extends('layouts.app')

@section('title', 'Profil Saya - ' . Auth::user()->name)

@section('content')
    <div class="container-main">
        <!-- Profile Header -->
        <div class="card shadow-lg mb-5">
            <div class="card-body p-5">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-4 mb-md-0">
                        @if($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                                 class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                 style="width: 150px; height: 150px; background: linear-gradient(135deg, #0077B6, #00B4D8);">
                                <span style="font-size: 4rem; color: white; font-weight: 700;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-9">
                        <h1 class="mb-2">{{ $user->name }}</h1>
                        @if($user->username)
                            <p class="text-muted mb-3">@{{ $user->username }}</p>
                        @endif

                        @if($user->bio)
                            <p class="lead mb-3">{{ $user->bio }}</p>
                        @endif

                        <div class="d-flex flex-wrap gap-3 mb-3">
                            @if($user->location)
                                <span><i class="fas fa-map-marker-alt"></i> {{ $user->location }}</span>
                            @endif
                            @if($user->website)
                                <a href="{{ $user->website }}" target="_blank" rel="noopener">
                                    <i class="fas fa-globe"></i> Website
                                </a>
                            @endif
                            <span><i class="fas fa-calendar-alt"></i> Bergabung {{ $user->created_at->format('M Y') }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Profil
                            </a>
                            <a href="{{ route('profile.show', $user) }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye"></i> Lihat Profil Publik
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="row mb-5">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #0077B6;">
                    <div class="card-body">
                        <h3 class="text-primary mb-0">{{ $stats['total_portfolios'] }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-briefcase"></i> Portfolio</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #00B4D8;">
                    <div class="card-body">
                        <h3 class="text-info mb-0">{{ $stats['total_views'] }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-eye"></i> Views</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="card text-center h-100" style="border-left: 4px solid #06D6A0;">
                    <div class="card-body">
                        <h3 class="text-success mb-0">{{ $stats['total_likes'] }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-heart"></i> Likes</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-center h-100" style="border-left: 4px solid #FFD166;">
                    <div class="card-body">
                        <h3 class="text-warning mb-0">{{ $stats['total_comments'] }}</h3>
                        <p class="text-muted mb-0"><i class="fas fa-comment"></i> Komentar</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Portfolio Section -->
        <div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-th-large"></i> Portfolio Saya
                </h2>
                <a href="{{ route('portfolio.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Portfolio Baru
                </a>
            </div>

            @if($portfolios->count() > 0)
                <div class="row g-4 mb-4">
                    @foreach($portfolios as $portfolio)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card portfolio-card h-100 position-relative">
                                @if($portfolio->image_url)
                                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" 
                                         class="card-img-top">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x" style="color: rgba(255,255,255,0.3);"></i>
                                    </div>
                                @endif

                                <!-- Status Badges -->
                                <div style="position: absolute; top: 0.75rem; left: 0.75rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    @if($portfolio->visibility === 'private')
                                        <span style="background: rgba(255, 107, 107, 0.9); color: white; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.3rem;">
                                            <i class="fas fa-lock"></i> PRIVAT
                                        </span>
                                    @else
                                        <span style="background: rgba(0, 150, 136, 0.9); color: white; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.3rem;">
                                            <i class="fas fa-globe"></i> PUBLIK
                                        </span>
                                    @endif
                                    @if($portfolio->is_highlighted && (!$portfolio->highlighted_until || $portfolio->highlighted_until > now()))
                                        <span style="background: linear-gradient(135deg, #ffc107, #ff9800); color: white; padding: 0.3rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.3rem;">
                                            <i class="fas fa-star"></i> SOROT
                                        </span>
                                    @endif
                                </div>

                                <!-- Edit/Delete Badge -->
                                <div class="position-absolute top-0 end-0 p-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('portfolio.settings', $portfolio) }}" 
                                           class="btn btn-info" title="Pengaturan">
                                            <i class="fas fa-cog"></i>
                                        </a>
                                        <a href="{{ route('portfolio.edit', $portfolio) }}" 
                                           class="btn btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="confirmDelete({{ $portfolio->id }})"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <span class="category-badge">{{ $portfolio->category }}</span>
                                    
                                    <h5 class="title">
                                        <a href="{{ route('portfolio.show', $portfolio) }}">
                                            {{ Str::limit($portfolio->title, 50) }}
                                        </a>
                                    </h5>

                                    <p class="description">{{ Str::limit($portfolio->description, 100) }}</p>

                                    @if($portfolio->technologies)
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-code"></i> 
                                                {{ Str::limit($portfolio->technologies, 60) }}
                                            </small>
                                        </div>
                                    @endif

                                    <!-- Stats -->
                                    <div class="stats">
                                        <div class="stat-item">
                                            <i class="fas fa-eye"></i>
                                            <span>{{ $portfolio->views }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-heart"></i>
                                            <span>{{ $portfolio->likes_count }}</span>
                                        </div>
                                        <div class="stat-item">
                                            <i class="fas fa-comment"></i>
                                            <span>{{ $portfolio->comments_count }}</span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="btn-group-action mt-3">
                                        <a href="{{ route('portfolio.show', $portfolio) }}" class="btn btn-primary btn-sm flex-grow-1">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $portfolios->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mt-3">Anda belum membuat portfolio apapun</p>
                    <a href="{{ route('portfolio.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus"></i> Buat Portfolio Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(portfolioId) {
            if (confirm('Apakah Anda yakin ingin menghapus portfolio ini? Tindakan ini tidak dapat dibatalkan.')) {
                const form = document.getElementById('deleteForm');
                form.action = `/portfolio/${portfolioId}`;
                form.submit();
            }
        }
    </script>
@endsection
