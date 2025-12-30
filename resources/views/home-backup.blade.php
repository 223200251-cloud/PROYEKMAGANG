@extends('layouts.app')

@section('title', 'Beranda - Portfolio Hub')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --font-body: 'Inter', sans-serif;
            --font-heading: 'Poppins', sans-serif;
        }

        body {
            font-family: var(--font-body);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.95) 0%, rgba(59, 130, 246, 0.85) 50%, rgba(79, 140, 245, 0.9) 100%);
            color: white;
            padding: 5rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.2;
            font-family: var(--font-heading);
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 400;
            font-family: var(--font-body);
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .btn-lg {
            padding: 0.875rem 2rem;
            font-size: 1rem;
        }

        .btn-outline-light {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 2rem;
            max-width: 500px;
            margin: 0 auto;
            margin-top: 3rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            font-family: var(--font-heading);
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
            font-weight: 500;
            font-family: var(--font-body);
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            color: var(--dark-color);
            font-family: var(--font-heading);
            letter-spacing: -0.3px;
        }

        .section-subtitle {
            color: var(--gray-600);
            margin: 0;
            font-weight: 500;
            font-size: 0.95rem;
            font-family: var(--font-body);
        }

        /* Search Section */
        .search-section {
            margin-bottom: 2.5rem;
        }

        .search-form {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .search-input-wrapper {
            flex: 1;
            min-width: 250px;
            max-width: 500px;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 1.5px solid var(--gray-300);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: var(--font-body);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Portfolio Grid */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* Portfolio Card */
        .portfolio-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            background: white;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .portfolio-card:hover {
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.12);
            transform: translateY(-8px);
        }

        .portfolio-image {
            position: relative;
            height: 280px;
            background: linear-gradient(135deg, rgba(226, 232, 240, 0.8), rgba(241, 245, 249, 0.8));
            overflow: hidden;
        }

        .portfolio-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .portfolio-card:hover .portfolio-image img {
            transform: scale(1.05);
        }

        .portfolio-image .placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(79, 140, 245, 0.15), rgba(59, 130, 246, 0.1));
            color: rgba(100, 130, 200, 0.3);
        }

        .placeholder i {
            font-size: 3rem;
        }

        /* Badges */
        .badge-category {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.98);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-family: var(--font-body);
        }

        .badge-highlight {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: linear-gradient(135deg, rgba(251, 146, 60, 0.9), rgba(239, 68, 68, 0.9));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
            font-family: var(--font-body);
        }

        .badge-views {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            background: rgba(0, 0, 0, 0.45);
            color: white;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            backdrop-filter: blur(10px);
            font-family: var(--font-body);
        }

        /* Portfolio Content */
        .portfolio-content {
            padding: 1.75rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .portfolio-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.35;
            color: var(--dark-color);
            font-family: var(--font-heading);
            letter-spacing: -0.2px;
        }

        .portfolio-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .portfolio-title a:hover {
            color: var(--primary-color);
        }

        .portfolio-description {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
            line-height: 1.6;
            font-weight: 400;
        }

        /* Technologies */
        .portfolio-tech {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .tech-tag {
            background: rgba(37, 99, 235, 0.08);
            color: var(--primary-color);
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            font-family: var(--font-body);
            transition: all 0.3s ease;
        }

        .tech-tag:hover {
            background: rgba(37, 99, 235, 0.15);
        }

        /* User Info */
        .portfolio-user {
            padding-top: 1.25rem;
            border-top: 1px solid rgba(226, 232, 240, 0.6);
            margin-bottom: 1.25rem;
        }

        .user-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            color: inherit;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.2), rgba(59, 130, 246, 0.15));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
            font-family: var(--font-body);
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
            transition: color 0.3s ease;
            font-family: var(--font-body);
        }

        .user-username {
            color: var(--gray-500);
            font-size: 0.8rem;
            font-family: var(--font-body);
        }

        .user-link:hover .user-name {
            color: var(--primary-color);
        }

        /* Portfolio Footer */
        .portfolio-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .portfolio-stats {
            display: flex;
            gap: 1.25rem;
            font-size: 0.9rem;
            color: var(--gray-600);
            font-family: var(--font-body);
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 500;
        }

        .btn-action {
            background: transparent;
            border: 1.5px solid rgba(226, 232, 240, 0.8);
            color: var(--primary-color);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .btn-action:hover {
            background: rgba(37, 99, 235, 0.08);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* View Button */
        .btn-view {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color), rgba(59, 130, 246, 0.9));
            color: white;
            padding: 0.85rem 1.25rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            font-family: var(--font-body);
            cursor: pointer;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-200);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--gray-50);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            margin: 2rem 0;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
            display: block;
        }

        .empty-state h3 {
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .section-header {
                flex-direction: column;
                align-items: stretch;
            }

            .section-header > div:last-child {
                width: 100%;
            }

            .section-header .btn-primary {
                width: 100%;
                justify-content: center;
            }

            .search-form {
                flex-direction: column;
            }

            .search-input-wrapper {
                max-width: none;
            }

            .search-form button {
                width: 100%;
            }

            .portfolio-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats {
                grid-template-columns: 1fr;
            }

            .portfolio-card:hover {
                transform: translateY(-6px);
            }
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Showcase Your Best Work</h1>
            <p class="hero-subtitle">
                Temukan inspirasi dari portfolio terbaik creator, designer, dan developer. Bagikan karya Anda dan bangun reputasi profesional.
            </p>
            <div class="hero-actions">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> Daftar Gratis
                    </a>
                @endguest
                <a href="#portfolio-list" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-arrow-down"></i> Jelajahi
                </a>
            </div>

            <!-- Stats -->
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">1,200+</div>
                    <div class="stat-label">Portfolio</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">450+</div>
                    <div class="stat-label">Creator</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Pengunjung</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <div class="container-main">
        <div id="portfolio-list" style="margin-top: 2rem;">
            <!-- Section Header -->
            <div class="section-header">
                <div>
                    <h2 class="section-title">
                        {{ $search ? '🔍 Hasil Pencarian' : '✨ Portfolio Terbaru' }}
                    </h2>
                    <p class="section-subtitle">
                        {{ $search ? 'Hasil untuk: ' . $search : 'Karya terbaik dari komunitas kami' }}
                    </p>
                </div>
                @auth
                    @if(!Auth::user()->isAdmin())
                        <a href="{{ route('portfolio.create') }}" class="btn btn-primary" style="height: fit-content;">
                            <i class="fas fa-plus"></i> Buat Portfolio
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Search Bar -->
            <div class="search-section">
                <form method="GET" action="{{ route('home') }}" class="search-form">
                    <div class="search-input-wrapper">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $search ?? '' }}"
                            placeholder="🔍 Cari portfolio, creator, atau skills..."
                            class="search-input">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Bersihkan
                        </a>
                    @endif
                </form>
            </div>

            @if($portfolios->count() > 0)
                <!-- Portfolio Grid -->
                <div class="portfolio-grid">
                    @foreach($portfolios as $portfolio)
                        <div class="portfolio-card">
                            
                            <!-- Image Section -->
                            <div class="portfolio-image">
                                @if($portfolio->image_url)
                                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}">
                                @else
                                    <div class="placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif

                                <!-- Category Badge -->
                                <div class="badge-category">
                                    {{ Str::limit($portfolio->category, 15) }}
                                </div>

                                <!-- Highlight Badge -->
                                @if($portfolio->is_highlighted && (!$portfolio->highlighted_until || $portfolio->highlighted_until > now()))
                                    <div class="badge-highlight">
                                        <i class="fas fa-star"></i> SOROT
                                    </div>
                                @endif

                                <!-- View Count Badge -->
                                <div class="badge-views">
                                    <i class="fas fa-eye"></i> {{ $portfolio->views }}
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="portfolio-content">
                                <!-- Title -->
                                <h3 class="portfolio-title">
                                    <a href="{{ route('portfolio.show', $portfolio) }}">
                                        {{ Str::limit($portfolio->title, 45) }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                <p class="portfolio-description">
                                    {{ Str::limit($portfolio->description, 100) }}
                                </p>

                                <!-- Technologies -->
                                @if($portfolio->technologies)
                                    <div class="portfolio-tech">
                                        @foreach(explode(', ', Str::limit($portfolio->technologies, 40)) as $tech)
                                            <span class="tech-tag">{{ trim($tech) }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- User Info -->
                                <div class="portfolio-user">
                                    <a href="{{ route('profile.show', $portfolio->user) }}" class="user-link">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($portfolio->user->name, 0, 1)) }}
                                        </div>
                                        <div class="user-info">
                                            <div class="user-name">{{ $portfolio->user->name }}</div>
                                            <div class="user-username">@{{ $portfolio->user->username ?? 'creator' }}</div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Stats & Actions -->
                                <div class="portfolio-footer">
                                    <div class="portfolio-stats">
                                        <div class="stat">
                                            <i class="fas fa-heart"></i>
                                            <span>{{ $portfolio->likes_count ?? 0 }}</span>
                                        </div>
                                        <div class="stat">
                                            <i class="fas fa-comment"></i>
                                            <span>{{ $portfolio->comments_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                    @auth
                                        @if(Auth::user()->isCreator())
                                            <button class="btn-action like-btn" onclick="toggleLike({{ $portfolio->id }})" data-like-btn="{{ $portfolio->id }}">
                                                @if($portfolio->liked(Auth::id()))
                                                    <i class="fas fa-heart"></i>
                                                @else
                                                    <i class="far fa-heart"></i>
                                                @endif
                                            </button>
                                        @elseif(Auth::user()->isCompany())
                                            <button class="btn-action save-btn" onclick="saveCreator({{ $portfolio->user->id }})" data-save-btn="{{ $portfolio->user->id }}">
                                                <i class="fas fa-bookmark"></i>
                                            </button>
                                        @endif
                                    @endauth
                                </div>

                                <!-- Action Button -->
                                <a href="{{ route('portfolio.show', $portfolio) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    {{ $portfolios->links(view: 'pagination.custom') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum ada portfolio</h3>
                    <p>Jadilah yang pertama membagikan karya menakjubkan Anda</p>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </a>
                    @else
                        <a href="{{ route('portfolio.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Buat Portfolio Pertama
                        </a>
                    @endguest
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleLike(portfolioId) {
            const btn = document.querySelector(`[data-like-btn="${portfolioId}"]`);
            const isLiked = btn.querySelector('i').classList.contains('fas');

            fetch(`/portfolio/${portfolioId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                if (isLiked) {
                    btn.innerHTML = '<i class="far fa-heart"></i>';
                } else {
                    btn.innerHTML = '<i class="fas fa-heart"></i>';
                }
            }).catch(error => console.error('Error:', error));
        }

        function saveCreator(userId) {
            const btn = event.target.closest('button');
            
            fetch(`/profile/${userId}/save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                btn.style.color = 'var(--success-color)';
                showToast('Creator tersimpan!', 'success');
            }).catch(error => console.error('Error:', error));
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type}`;
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                z-index: 1000;
                animation: slideInUp 0.3s ease-out;
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
@endsection
