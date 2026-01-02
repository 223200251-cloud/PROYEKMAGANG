@extends('layouts.app')

@section('title', $user->name . ' - Portfolio Hub')

@section('content')
    <style>
        /* ============================================
           PROFILE PAGE STYLES
           ============================================ */
        .profile-banner {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.95) 0%, rgba(59, 130, 246, 0.85) 50%, rgba(79, 140, 245, 0.9) 100%);
            height: 280px;
            position: relative;
            overflow: hidden;
        }

        .profile-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .profile-header-card {
            margin-top: -120px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-avatar-section {
            text-align: center;
            padding: 2rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .profile-avatar {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 6px solid white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            object-fit: cover;
        }

        .profile-avatar-placeholder {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 6px solid white;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            background: linear-gradient(135deg, var(--primary-color), rgba(59, 130, 246, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4.5rem;
            color: white;
            font-weight: 800;
            font-family: 'Poppins', sans-serif;
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
            letter-spacing: -0.5px;
        }

        .profile-username {
            font-size: 1.1rem;
            color: var(--gray-500);
            margin-bottom: 1rem;
            font-family: 'Inter', sans-serif;
        }

        .profile-bio {
            font-size: 1.05rem;
            color: var(--gray-600);
            line-height: 1.7;
            max-width: 700px;
            margin: 1rem auto 1.5rem;
            font-family: 'Inter', sans-serif;
        }

        .profile-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }

        .profile-content {
            padding: 2rem;
        }

        .profile-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }

        .info-card-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
            font-family: 'Inter', sans-serif;
        }

        .info-card-content {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-card-content i {
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .info-card-content a {
            color: var(--dark-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .info-card-content a:hover {
            color: var(--primary-color);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(59, 130, 246, 0.03));
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        .stat-card {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-family: 'Poppins', sans-serif;
        }

        .stat-label {
            font-size: 0.9rem;
            color: var(--gray-600);
            font-weight: 500;
            font-family: 'Inter', sans-serif;
        }

        .contact-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
        }

        .contact-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .contact-title i {
            color: var(--primary-color);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 10px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(37, 99, 235, 0.05);
            transform: translateX(5px);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), rgba(59, 130, 246, 0.9));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .contact-info {
            flex: 1;
        }

        .contact-label {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-bottom: 0.25rem;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
        }

        .contact-value {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--dark-color);
            font-family: 'Inter', sans-serif;
        }

        .contact-value a {
            color: inherit;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-value a:hover {
            color: var(--primary-color);
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 2rem;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .portfolio-section {
            margin-top: 3rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .profile-banner {
                height: 200px;
            }

            .profile-header-card {
                margin-top: -80px;
            }

            .profile-avatar,
            .profile-avatar-placeholder {
                width: 120px;
                height: 120px;
                border: 4px solid white;
            }

            .profile-avatar-placeholder {
                font-size: 3rem;
            }

            .profile-name {
                font-size: 1.5rem;
            }

            .profile-username {
                font-size: 1rem;
            }

            .profile-bio {
                font-size: 0.95rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                padding: 1.5rem;
            }

            .stat-number {
                font-size: 1.8rem;
            }

            .contact-title {
                font-size: 1.3rem;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <!-- Profile Banner -->
    <div class="profile-banner"></div>

    <div class="container-main">
        <!-- Profile Header Card -->
        <div class="profile-header-card">
            <!-- Avatar & Basic Info Section -->
            <div class="profile-avatar-section">
                <div class="profile-avatar-wrapper">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h1 class="profile-name">{{ $user->name }}</h1>
                
                <p class="profile-username" style="font-weight: 500; font-size: 1.1rem;">
                    @if($user->user_type === 'individual')
                        <i class="fas fa-user-circle" style="color: #0077B6;"></i> Kreator Portfolio
                    @else
                        <i class="fas fa-building" style="color: #06D6A0;"></i> Perusahaan / Rekruter
                    @endif
                </p>

                @if($user->bio)
                    <p class="profile-bio">{{ $user->bio }}</p>
                @endif

                @if($user->isCompany() && $user->company_description)
                    <p class="profile-bio">{{ $user->company_description }}</p>
                @endif

                <!-- Action Buttons -->
                <div class="profile-actions">
                    @auth
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-edit"></i> Edit Profil
                            </a>
                        @elseif(Auth::user()->isCompany())
                            <button onclick="saveCreator({{ $user->id }})" 
                                class="btn btn-primary btn-lg"
                                data-save-profile="{{ $user->id }}"
                                style="@if($user->isSavedBy(Auth::id())) background: linear-gradient(135deg, #667eea, #764ba2); @endif">
                                <i class="fas fa-bookmark"></i> 
                                <span id="save-text-{{ $user->id }}">
                                    @if($user->isSavedBy(Auth::id()))
                                        Hapus dari Kandidat
                                    @else
                                        Simpan Kandidat
                                    @endif
                                </span>
                            </button>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $stats['total_portfolios'] }}</div>
                        <div class="stat-label">Portfolio</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($stats['total_views']) }}</div>
                        <div class="stat-label">Total Views</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($stats['total_likes']) }}</div>
                        <div class="stat-label">Total Likes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ number_format($stats['total_comments']) }}</div>
                        <div class="stat-label">Komentar</div>
                    </div>
                </div>

                <!-- Additional Info Grid -->
                <div class="profile-info-grid">
                    @if($user->location)
                        <div class="info-card">
                            <div class="info-card-title">Lokasi</div>
                            <div class="info-card-content">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $user->location }}</span>
                            </div>
                        </div>
                    @endif

                    @if($user->website || $user->company_website)
                        <div class="info-card">
                            <div class="info-card-title">Website</div>
                            <div class="info-card-content">
                                <i class="fas fa-globe"></i>
                                <a href="{{ $user->website ?? $user->company_website }}" target="_blank" rel="noopener">
                                    {{ parse_url($user->website ?? $user->company_website, PHP_URL_HOST) }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="info-card">
                        <div class="info-card-title">Bergabung</div>
                        <div class="info-card-content">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $user->created_at->format('F Y') }}</span>
                        </div>
                    </div>

                    @if($user->isCompany() && $user->company_name)
                        <div class="info-card">
                            <div class="info-card-title">Perusahaan</div>
                            <div class="info-card-content">
                                <i class="fas fa-building"></i>
                                <span>{{ $user->company_name }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="contact-section">
            <h2 class="contact-title">
                <i class="fas fa-address-card"></i>
                Informasi Kontak
            </h2>

            <div class="row g-3">
                <!-- Email -->
                <div class="col-md-6">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info">
                            <div class="contact-label">Email Address</div>
                            <div class="contact-value">
                                <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phone Number -->
                @if($user->phone || ($user->isCompany() && $user->company_phone))
                    <div class="col-md-6">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Nomor Telepon</div>
                                <div class="contact-value">
                                    <a href="tel:{{ $user->phone ?? $user->company_phone }}">
                                        {{ $user->phone ?? $user->company_phone }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Website -->
                @if($user->website || $user->company_website)
                    <div class="col-md-6">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Website</div>
                                <div class="contact-value">
                                    <a href="{{ $user->website ?? $user->company_website }}" target="_blank" rel="noopener">
                                        {{ $user->website ?? $user->company_website }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Location -->
                @if($user->location)
                    <div class="col-md-6">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Lokasi</div>
                                <div class="contact-value">{{ $user->location }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Company Name -->
                @if($user->isCompany() && $user->company_name)
                    <div class="col-md-6">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-label">Nama Perusahaan</div>
                                <div class="contact-value">{{ $user->company_name }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Portfolio Section -->
        <div class="portfolio-section">
            <h2 class="section-title">
                <i class="fas fa-briefcase"></i>
                Portfolio Karya
            </h2>

            @if($portfolios->count() > 0)
                <div class="portfolio-grid">
                    @foreach($portfolios as $portfolio)
                        <article class="portfolio-card">
                            <!-- Image Section -->
                            <div class="portfolio-image">
                                @if($portfolio->image)
                                    <img src="{{ $portfolio->image }}" alt="{{ $portfolio->title }}" loading="lazy">
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
                                        @if(Auth::id() === $user->id)
                                            <a href="{{ route('portfolio.edit', $portfolio) }}" class="btn-action" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
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
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum ada portfolio</h3>
                    <p>{{ $user->name }} belum menambahkan portfolio</p>
                    @auth
                        @if(Auth::id() === $user->id && Auth::user()->isCreator())
                            <a href="{{ route('portfolio.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus"></i> Buat Portfolio
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function saveCreator(creatorId) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const btn = document.querySelector(`[data-save-profile="${creatorId}"]`);
            const textEl = document.getElementById(`save-text-${creatorId}`);
            
            fetch(`/company/save-creator/${creatorId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                if (btn) {
                    // Animate button
                    btn.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        btn.style.transform = 'scale(1)';
                    }, 200);
                    
                    // Update button text
                    if (data.saved) {
                        textEl.textContent = 'Hapus dari Kandidat';
                        btn.style.background = 'linear-gradient(135deg, #667eea, #764ba2)';
                        btn.style.color = 'white';
                    } else {
                        textEl.textContent = 'Simpan Kandidat';
                        btn.style.background = 'var(--primary-color)';
                        btn.style.color = 'white';
                    }
                    
                    // Show toast
                    showToast(data.message || (data.saved ? 'Creator disimpan!' : 'Creator dihapus dari daftar'));
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Terjadi kesalahan');
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                background: var(--primary-color);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
                z-index: 9999;
                font-family: 'Inter', sans-serif;
                font-weight: 600;
                animation: slideInUp 0.3s ease-out;
            `;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideInUp 0.3s ease-out reverse';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </script>
@endpush
