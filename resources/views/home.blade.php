@extends('layouts.app')

@section('title', 'Beranda - Portfolio Hub')

@section('content')
    <style>
        /* ============================================
           HERO SECTION
           ============================================ */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            padding: 8rem 1rem 9rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            min-height: 650px;
            display: flex;
            align-items: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -40%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-content {
            max-width: 950px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            padding: 0 1rem;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -1px;
            animation: slideInDown 0.6s ease-out;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            opacity: 0.95;
            line-height: 1.7;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 400;
            font-family: 'Inter', sans-serif;
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .hero-actions {
            display: flex;
            gap: 1.25rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 4rem;
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 2.5rem;
            max-width: 550px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }

        .stat-item {
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-number {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.3px;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            text-transform: capitalize;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ============================================
           SECTION HEADER
           ============================================ */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .section-header-content h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.4px;
        }

        .section-subtitle {
            color: var(--gray-600);
            margin: 0;
            font-weight: 500;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
        }

        /* ============================================
           SEARCH SECTION
           ============================================ */
        .search-section {
            margin-bottom: 3rem;
            padding: 0;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            max-width: 100%;
        }

        .search-input-wrapper {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 1.5px solid var(--gray-300);
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            background: white;
        }

        .search-input::placeholder {
            color: var(--gray-500);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background: white;
        }

        /* ============================================
           PORTFOLIO GRID
           ============================================ */
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        /* ============================================
           PORTFOLIO CARD
           ============================================ */
        .portfolio-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            background: white;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.08);
            height: 100%;
            position: relative;
        }

        .portfolio-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 10;
        }

        .portfolio-card:hover::before {
            opacity: 1;
        }

        .portfolio-card:hover {
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
            transform: translateY(-12px);
        }

        /* Card Image Section */
        .portfolio-image {
            position: relative;
            height: 280px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(240, 147, 251, 0.1));
            overflow: hidden;
        }

        .portfolio-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(240, 147, 251, 0.15));
            color: rgba(102, 126, 234, 0.3);
        }

        .placeholder i {
            font-size: 3rem;
        }

        /* Badges */
        .badge-container {
            position: absolute;
            top: 1rem;
            left: 1rem;
            right: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            pointer-events: none;
        }

        .badge-highlight {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 8px 20px rgba(245, 87, 108, 0.3);
            font-family: 'Inter', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-category {
            background: rgba(255, 255, 255, 0.98);
            color: #667eea;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
            font-family: 'Inter', sans-serif;
            pointer-events: auto;
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
            gap: 0.4rem;
            backdrop-filter: blur(10px);
            font-family: 'Inter', sans-serif;
            pointer-events: auto;
        }

        /* Card Content Section */
        .portfolio-content {
            padding: 1.75rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .portfolio-title {
            font-size: 1.3rem;
            font-weight: 700;
            line-height: 1.35;
            color: var(--dark-color);
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.2px;
            margin: 0;
            transition: color 0.3s ease;
        }

        .portfolio-title a {
            color: inherit;
            text-decoration: none;
        }

        .portfolio-title a:hover {
            color: var(--primary-color);
        }

        .portfolio-description {
            color: var(--gray-600);
            font-size: 0.95rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
            line-height: 1.6;
            font-weight: 400;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        /* Technologies Section */
        .portfolio-tech {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .tech-tag {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.12), rgba(240, 147, 251, 0.08));
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            white-space: nowrap;
            border: 1px solid rgba(102, 126, 234, 0.15);
        }

        .tech-tag:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2), rgba(240, 147, 251, 0.15));
            border-color: rgba(102, 126, 234, 0.3);
            transform: translateY(-3px);
        }

        /* User Info Section */
        .portfolio-user {
            padding-top: 1.25rem;
            border-top: 1px solid rgba(226, 232, 240, 0.6);
            margin-top: auto;
        }

        .user-link {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            transition: all 0.3s ease;
            color: inherit;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
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
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .user-username {
            color: var(--gray-500);
            font-size: 0.8rem;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .user-link:hover .user-name {
            color: var(--primary-color);
        }

        /* Portfolio Footer - Stats & Actions */
        .portfolio-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(226, 232, 240, 0.6);
        }

        .portfolio-stats {
            display: flex;
            gap: 1.5rem;
            font-size: 0.9rem;
            color: var(--gray-600);
            font-family: 'Inter', sans-serif;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 500;
        }

        .stat i {
            color: var(--primary-color);
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
            flex-shrink: 0;
        }

        .btn-action:hover {
            background: rgba(37, 99, 235, 0.08);
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* View Button */
        .btn-view {
            display: block;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-view:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        /* ============================================
           PAGINATION
           ============================================ */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-200);
        }

        /* ============================================
           EMPTY STATE
           ============================================ */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--gray-50);
            border-radius: 16px;
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
            font-size: 1.4rem;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        .empty-state p {
            color: var(--gray-600);
            margin-bottom: 2rem;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
        }

        /* ============================================
           RESPONSIVE DESIGN
           ============================================ */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: 2.8rem;
            }

            .section-header-content h2 {
                font-size: 2.2rem;
            }

            .portfolio-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 1rem 5rem;
                min-height: auto;
            }

            .hero-title {
                font-size: 2.2rem;
                margin-bottom: 1rem;
            }

            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }

            .hero-actions {
                gap: 0.75rem;
                margin-bottom: 3rem;
            }

            .hero-stats {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .section-header {
                flex-direction: column;
                gap: 1.5rem;
            }

            .section-header-content h2 {
                font-size: 1.8rem;
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

            .portfolio-image {
                height: 240px;
            }

            .portfolio-content {
                padding: 1.5rem;
            }

            .portfolio-card:hover {
                transform: translateY(-6px);
            }

            .portfolio-actions {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.8rem;
                margin-bottom: 0.75rem;
            }

            .hero-subtitle {
                font-size: 0.95rem;
                margin-bottom: 1.5rem;
            }

            .hero-actions {
                flex-direction: column;
                width: 100%;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .section-header-content h2 {
                font-size: 1.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .stat-label {
                font-size: 0.85rem;
            }

            .portfolio-title {
                font-size: 1.1rem;
            }

            .portfolio-description {
                -webkit-line-clamp: 1;
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

            <!-- Hero Actions -->
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

            <!-- Stats Grid -->
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
        <div id="portfolio-list">
            <!-- Section Header -->
            <div class="section-header">
                <div class="section-header-content">
                    <h2>{{ $search ? '🔍 Hasil Pencarian' : '✨ Portfolio Terbaru' }}</h2>
                    <p class="section-subtitle">
                        {{ $search ? 'Hasil untuk: ' . $search : 'Karya terbaik dari komunitas kami' }}
                    </p>
                </div>
                @auth
                    @if(!Auth::user()->isAdmin())
                        <a href="{{ route('portfolio.create') }}" class="btn btn-primary btn-lg">
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
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    @if($search)
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Bersihkan
                        </a>
                    @endif
                </form>
            </div>

            @if($portfolios->count() > 0)
                <!-- Portfolio Grid -->
                <div class="portfolio-grid">
                    @foreach($portfolios as $portfolio)
                        <article class="portfolio-card">
                            <!-- Image Section -->
                            <div class="portfolio-image">
                                @if($portfolio->image_url)
                                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" loading="lazy">
                                @else
                                    <div class="placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif

                                <!-- Badge Container -->
                                <div class="badge-container">
                                    <div>
                                        @if($portfolio->is_highlighted && (!$portfolio->highlighted_until || $portfolio->highlighted_until > now()))
                                            <div class="badge-highlight">
                                                <i class="fas fa-star"></i> SOROT
                                            </div>
                                        @endif
                                    </div>
                                    <div class="badge-category">
                                        {{ Str::limit($portfolio->category, 15) }}
                                    </div>
                                </div>

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
                                        {{ Str::limit($portfolio->title, 50) }}
                                    </a>
                                </h3>

                                <!-- Description -->
                                <p class="portfolio-description">
                                    {{ Str::limit($portfolio->description, 110) }}
                                </p>

                                <!-- Technologies -->
                                @if($portfolio->technologies)
                                    <div class="portfolio-tech">
                                        @foreach(explode(', ', Str::limit($portfolio->technologies, 50)) as $tech)
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
                                            <p class="user-name">{{ $portfolio->user->name }}</p>
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
                                            <button class="btn-action like-btn" onclick="toggleLike({{ $portfolio->id }})" data-like-btn="{{ $portfolio->id }}" title="Like">
                                                @if($portfolio->liked(Auth::id()))
                                                    <i class="fas fa-heart"></i>
                                                @else
                                                    <i class="far fa-heart"></i>
                                                @endif
                                            </button>
                                        @elseif(Auth::user()->isCompany())
                                            <button class="btn-action save-btn" onclick="saveCreator({{ $portfolio->user->id }})" data-save-btn="{{ $portfolio->user->id }}" title="Simpan">
                                                <i class="fas fa-bookmark"></i>
                                            </button>
                                        @endif
                                    @endauth
                                </div>

                                <!-- View Button -->
                                <a href="{{ route('portfolio.show', $portfolio) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </article>
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
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus"></i> Daftar Sekarang
                        </a>
                    @else
                        <a href="{{ route('portfolio.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus"></i> Buat Portfolio Pertama
                        </a>
                    @endguest
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
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
                border-radius: 10px;
                z-index: 1000;
                animation: slideInUp 0.3s ease-out;
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
@endsection
