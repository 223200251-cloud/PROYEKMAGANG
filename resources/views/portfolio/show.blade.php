@extends('layouts.app')

@section('title', $portfolio->title . ' - Portfolio Hub')

@section('content')
    <style>
        /* ============================================
           PORTFOLIO DETAIL STYLES
           ============================================ */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Creator Profile Card */
        .creator-profile-card {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(59, 130, 246, 0.03));
            border: 1px solid rgba(37, 99, 235, 0.1);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .creator-profile-card:hover {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.08));
            border-color: rgba(37, 99, 235, 0.2);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.1);
            transform: translateY(-4px);
        }

        .creator-avatar {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color), rgba(59, 130, 246, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 2rem;
            flex-shrink: 0;
        }

        .creator-info-section {
            flex: 1;
        }

        .creator-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
            font-family: 'Poppins', sans-serif;
        }

        .creator-username {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .creator-bio {
            color: var(--gray-600);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .creator-role-badge {
            display: inline-block;
            background: rgba(37, 99, 235, 0.15);
            color: var(--primary-color);
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
            margin-bottom: 1rem;
        }

        .creator-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        /* Chat Modal */
        .chat-modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .chat-modal.show {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .chat-modal-content {
            background: white;
            border-radius: 16px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .chat-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-modal-header h5 {
            margin: 0;
            font-weight: 700;
            color: var(--dark-color);
            font-family: 'Poppins', sans-serif;
        }

        .chat-close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--gray-500);
            cursor: pointer;
            padding: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .chat-close-btn:hover {
            background: var(--gray-100);
            color: var(--dark-color);
        }

        .chat-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .message {
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .message-bubble {
            background: var(--gray-100);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            max-width: 70%;
            word-wrap: break-word;
            line-height: 1.4;
        }

        .message.sent .message-bubble {
            background: var(--primary-color);
            color: white;
        }

        .message-time {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .chat-modal-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--gray-200);
            background: var(--gray-50);
        }

        .chat-form {
            display: flex;
            gap: 0.75rem;
        }

        .chat-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1.5px solid var(--gray-300);
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
        }

        .chat-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .chat-send-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .chat-send-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Empty chat state */
        .chat-empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray-500);
        }

        .chat-empty-state i {
            font-size: 2.5rem;
            color: var(--gray-300);
            margin-bottom: 1rem;
            display: block;
        }

        /* Portfolio Header */
        .portfolio-header {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
        }

        .portfolio-image-container {
            position: relative;
            height: 400px;
            background: linear-gradient(135deg, rgba(226, 232, 240, 0.8), rgba(241, 245, 249, 0.8));
            overflow: hidden;
        }

        .portfolio-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .portfolio-image-container:hover img {
            transform: scale(1.02);
        }

        .portfolio-info {
            background: white;
            padding: 2rem;
            position: relative;
        }

        .portfolio-badges {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .portfolio-badge {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .badge-category {
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .badge-highlight {
            background: linear-gradient(135deg, rgba(251, 146, 60, 0.15), rgba(239, 68, 68, 0.15));
            color: #D97706;
        }

        .portfolio-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .portfolio-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 1.5rem 0;
            border-top: 1px solid var(--gray-200);
            border-bottom: 1px solid var(--gray-200);
            margin: 2rem 0;
        }

        .stat-box {
            text-align: center;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-color);
            font-family: 'Poppins', sans-serif;
        }

        /* Content Card */
        .content-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .content-card-header {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: 'Poppins', sans-serif;
        }

        .content-card-header i {
            color: var(--primary-color);
            font-size: 1.4rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .portfolio-title {
                font-size: 1.8rem;
            }

            .portfolio-image-container {
                height: 300px;
            }

            .creator-profile-card {
                padding: 1.5rem;
            }

            .portfolio-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .chat-modal-content {
                width: 95%;
                max-height: 90vh;
            }
        }
    </style>

    <div class="container-main">
        <!-- Portfolio Header -->
        <div class="portfolio-header fade-in">
            <div class="portfolio-image-container">
                @if($portfolio->image_url)
                    <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}">
                @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, rgba(37, 99, 235, 0.15), rgba(59, 130, 246, 0.1)); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image" style="font-size: 4rem; color: rgba(37, 99, 235, 0.2);"></i>
                    </div>
                @endif
            </div>

            <div class="portfolio-info">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb" style="margin-bottom: 0;">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--primary-color);">Beranda</a></li>
                        <li class="breadcrumb-item active">{{ Str::limit($portfolio->title, 40) }}</li>
                    </ol>
                </nav>

                <!-- Title & Badges -->
                <h1 class="portfolio-title">{{ $portfolio->title }}</h1>

                <div class="portfolio-badges">
                    <span class="portfolio-badge badge-category">
                        <i class="fas fa-folder"></i> {{ ucfirst(str_replace('_', ' ', $portfolio->category)) }}
                    </span>
                    @if($portfolio->visibility === 'private')
                        <span class="portfolio-badge" style="background: rgba(239, 68, 68, 0.1); color: var(--danger-color);">
                            <i class="fas fa-lock"></i> Privat
                        </span>
                    @else
                        <span class="portfolio-badge badge-success">
                            <i class="fas fa-globe"></i> Publik
                        </span>
                    @endif
                    @if($portfolio->is_highlighted && (!$portfolio->highlighted_until || $portfolio->highlighted_until > now()))
                        <span class="portfolio-badge badge-highlight">
                            <i class="fas fa-star"></i> SOROT
                        </span>
                    @endif
                </div>

                <!-- Stats -->
                <div class="portfolio-stats">
                    <div class="stat-box">
                        <div class="stat-label">Dilihat</div>
                        <div class="stat-value">{{ $portfolio->views }}</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Suka</div>
                        <div class="stat-value" data-like-count="{{ $portfolio->id }}">{{ $portfolio->likes_count }}</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Komentar</div>
                        <div class="stat-value">{{ $portfolio->comments_count }}</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    @if($portfolio->project_url)
                        <a href="{{ $portfolio->project_url }}" target="_blank" class="btn btn-primary btn-lg">
                            <i class="fas fa-external-link-alt"></i> Lihat Project
                        </a>
                    @endif
                    @auth
                        <button class="btn btn-outline-primary btn-lg" 
                                onclick="toggleLike({{ $portfolio->id }})"
                                data-like-btn="{{ $portfolio->id }}">
                            @if($portfolio->liked(Auth::id()))
                                <i class="fas fa-heart"></i> Suka
                            @else
                                <i class="far fa-heart"></i> Suka
                            @endif
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                            <i class="far fa-heart"></i> Suka
                        </a>
                    @endauth
                </div>

                <!-- Edit/Delete for Owner -->
                @auth
                    @if(Auth::id() === $portfolio->user_id)
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--gray-200); display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            <a href="{{ route('portfolio.settings', $portfolio) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-cog"></i> Pengaturan
                            </a>
                            <a href="{{ route('portfolio.edit', $portfolio) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('portfolio.destroy', $portfolio) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Hapus portfolio ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Description -->
                <div class="content-card">
                    <div class="content-card-header">
                        <i class="fas fa-align-left"></i> Deskripsi Proyek
                    </div>
                    <p style="white-space: pre-wrap; margin-bottom: 0; line-height: 1.8; color: var(--gray-700);">{{ $portfolio->description }}</p>
                </div>

                <!-- Technologies -->
                @if($portfolio->technologies)
                    <div class="content-card">
                        <div class="content-card-header">
                            <i class="fas fa-code"></i> Teknologi yang Digunakan
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
                            @foreach(explode(',', $portfolio->technologies) as $tech)
                                <span style="background: rgba(37, 99, 235, 0.08); color: var(--primary-color); padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.9rem; font-weight: 500;">
                                    {{ trim($tech) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Comments Section -->
                <div class="content-card">
                    <div class="content-card-header">
                        <i class="fas fa-comments"></i> Komentar ({{ $portfolio->comments_count }})
                    </div>

                    @auth
                        <!-- Add Comment Form -->
                        <form method="POST" action="{{ route('comment.add', $portfolio) }}" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label" style="font-weight: 600; margin-bottom: 0.75rem;">Tambah Komentar</label>
                                <textarea 
                                    name="comment" 
                                    id="comment"
                                    class="form-control @error('comment') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Berikan feedback atau pujian..."
                                    required
                                    style="border-radius: 10px; border: 1.5px solid var(--gray-300); font-family: 'Inter', sans-serif;"></textarea>
                                @error('comment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-comment-dots"></i> Kirim Komentar
                            </button>
                        </form>
                    @else
                        <div style="background: rgba(6, 182, 212, 0.05); border: 1px solid rgba(6, 182, 212, 0.2); padding: 1rem; border-radius: 10px; margin-bottom: 2rem;">
                            <i class="fas fa-info-circle" style="color: var(--info-color); margin-right: 0.5rem;"></i>
                            <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600;">Login</a> untuk memberikan komentar
                        </div>
                    @endauth

                    <!-- Comments List -->
                    @if($portfolio->comments->count() > 0)
                        <div class="chat-messages">
                            @foreach($portfolio->comments->sortByDesc('created_at') as $comment)
                                <div style="padding: 1.25rem; background: var(--gray-50); border-radius: 12px; border: 1px solid var(--gray-200);">
                                    <div style="display: flex; gap: 1rem;">
                                        <div style="width: 44px; height: 44px; border-radius: 10px; background: linear-gradient(135deg, rgba(37, 99, 235, 0.2), rgba(59, 130, 246, 0.15)); display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-weight: 700; flex-shrink: 0;">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                        <div style="flex: 1;">
                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                                <div>
                                                    <strong style="color: var(--dark-color); display: block;">{{ $comment->user->name }}</strong>
                                                    <small style="color: var(--gray-600);">@{{ $comment->user->username ?? 'user' . $comment->user->id }}</small>
                                                </div>
                                                <small style="color: var(--gray-500); white-space: nowrap;">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <p style="margin-bottom: 0; color: var(--gray-700); line-height: 1.6;">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 2rem; color: var(--gray-500);">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--gray-300); display: block; margin-bottom: 0.75rem;"></i>
                            Belum ada komentar. Jadilah yang pertama!
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Creator Profile Card -->
                <div class="creator-profile-card" onclick="document.getElementById('creatorProfile').scrollIntoView({behavior: 'smooth'})">
                    <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
                        <div class="creator-avatar">
                            {{ strtoupper(substr($portfolio->user->name, 0, 1)) }}
                        </div>
                        <div class="creator-info-section">
                            <div class="creator-name">{{ $portfolio->user->name }}</div>
                            <div class="creator-username">@{{ $portfolio->user->username ?? 'user' . $portfolio->user->id }}</div>
                            @if($portfolio->user->bio)
                                <div class="creator-bio">{{ $portfolio->user->bio }}</div>
                            @endif
                            <div>
                                <span class="creator-role-badge">
                                    <i class="fas fa-user-circle" style="margin-right: 0.3rem;"></i>
                                    {{ ucfirst($portfolio->user->user_type) }}
                                </span>
                            </div>
                            <div class="creator-actions">
                                <a href="{{ route('profile.show', $portfolio->user) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-user"></i> Lihat Profil
                                </a>
                                @auth
                                    @if(Auth::id() !== $portfolio->user_id)
                                        <button class="btn btn-secondary btn-sm" onclick="openChatModal({{ $portfolio->user->id }}, '{{ $portfolio->user->name }}')">
                                            <i class="fas fa-comments"></i> Chat
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-comments"></i> Chat
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="content-card" style="margin-top: 2rem;">
                    <div class="content-card-header">
                        <i class="fas fa-info-circle"></i> Informasi
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div>
                            <small style="color: var(--gray-600); font-weight: 600; text-transform: uppercase; font-size: 0.8rem;">Dipublikasikan</small>
                            <p style="margin-top: 0.5rem; margin-bottom: 0; color: var(--dark-color); font-weight: 500;">{{ $portfolio->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <small style="color: var(--gray-600); font-weight: 600; text-transform: uppercase; font-size: 0.8rem;">Terakhir Diupdate</small>
                            <p style="margin-top: 0.5rem; margin-bottom: 0; color: var(--dark-color); font-weight: 500;">{{ $portfolio->updated_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <small style="color: var(--gray-600); font-weight: 600; text-transform: uppercase; font-size: 0.8rem;">Kategori</small>
                            <p style="margin-top: 0.5rem; margin-bottom: 0; color: var(--dark-color); font-weight: 500;">{{ ucfirst(str_replace('_', ' ', $portfolio->category)) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Related Portfolios -->
                <div class="content-card" style="margin-top: 2rem;">
                    <div class="content-card-header">
                        <i class="fas fa-link"></i> Portfolio Lainnya
                    </div>
                    @php
                        $relatedPortfolios = $portfolio->user->portfolios()
                            ->where('id', '!=', $portfolio->id)
                            ->where('visibility', 'public')
                            ->limit(3)
                            ->get();
                    @endphp

                    @if($relatedPortfolios->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($relatedPortfolios as $related)
                                <a href="{{ route('portfolio.show', $related) }}" style="display: block; padding: 1rem; background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: 10px; text-decoration: none; color: inherit; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(37, 99, 235, 0.05)'; this.style.borderColor='rgba(37, 99, 235, 0.3)';" onmouseout="this.style.background='var(--gray-50)'; this.style.borderColor='var(--gray-200)';">
                                    <h6 style="margin: 0 0 0.5rem 0; font-weight: 700; color: var(--dark-color);">{{ Str::limit($related->title, 40) }}</h6>
                                    <small style="color: var(--gray-600);"><i class="fas fa-eye" style="margin-right: 0.3rem;"></i> {{ $related->views }} dilihat</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p style="text-align: center; padding: 2rem; margin-bottom: 0; color: var(--gray-500);">
                            <i class="fas fa-inbox" style="display: block; font-size: 1.5rem; color: var(--gray-300); margin-bottom: 0.5rem;"></i>
                            Tidak ada portfolio lain
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Modal -->
    <div id="chatModal" class="chat-modal">
        <div class="chat-modal-content">
            <div class="chat-modal-header">
                <h5>Chat dengan <span id="chatRecipientName"></span></h5>
                <button class="chat-close-btn" onclick="closeChatModal()">×</button>
            </div>
            <div class="chat-modal-body">
                <div id="chatMessages" class="chat-messages">
                    <div class="chat-empty-state">
                        <i class="fas fa-comments"></i>
                        <p>Mulai percakapan!</p>
                    </div>
                </div>
            </div>
            <div class="chat-modal-footer">
                <form class="chat-form" onsubmit="sendMessage(event)">
                    <input 
                        type="text" 
                        id="chatInput"
                        class="chat-input"
                        placeholder="Tulis pesan..."
                        autocomplete="off">
                    <button type="submit" class="chat-send-btn">
                        <i class="fas fa-paper-plane"></i> Kirim
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let chatRecipientId = null;

        function openChatModal(recipientId, recipientName) {
            chatRecipientId = recipientId;
            document.getElementById('chatRecipientName').textContent = recipientName;
            document.getElementById('chatModal').classList.add('show');
            loadChatMessages();
            document.getElementById('chatInput').focus();
        }

        function closeChatModal() {
            document.getElementById('chatModal').classList.remove('show');
            chatRecipientId = null;
        }

        function loadChatMessages() {
            if (!chatRecipientId) return;

            fetch(`/chat/messages/${chatRecipientId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                const messagesContainer = document.getElementById('chatMessages');
                messagesContainer.innerHTML = '';

                if (data.messages.length === 0) {
                    messagesContainer.innerHTML = `
                        <div class="chat-empty-state">
                            <i class="fas fa-comments"></i>
                            <p>Mulai percakapan!</p>
                        </div>
                    `;
                } else {
                    data.messages.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `message ${msg.is_sent ? 'sent' : 'received'}`;
                        messageDiv.innerHTML = `
                            <div class="message-bubble">${msg.message}</div>
                            <small class="message-time">${formatTime(msg.created_at)}</small>
                        `;
                        messagesContainer.appendChild(messageDiv);
                    });
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            })
            .catch(error => console.error('Error loading messages:', error));
        }

        function sendMessage(event) {
            event.preventDefault();
            const input = document.getElementById('chatInput');
            const message = input.value.trim();

            if (!message || !chatRecipientId) return;

            fetch(`/chat/send`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    recipient_id: chatRecipientId,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    input.value = '';
                    loadChatMessages();
                }
            })
            .catch(error => console.error('Error sending message:', error));
        }

        function formatTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('chatModal');
            if (event.target === modal) {
                closeChatModal();
            }
        }

        // Toggle Like
        function toggleLike(portfolioId) {
            const btn = document.querySelector(`[data-like-btn="${portfolioId}"]`);
            const isLiked = btn.querySelector('i').classList.contains('fas');

            fetch(`/portfolio/${portfolioId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if (isLiked) {
                    btn.innerHTML = '<i class="far fa-heart"></i> Suka';
                } else {
                    btn.innerHTML = '<i class="fas fa-heart"></i> Suka';
                }
                document.querySelector('[data-like-count="' + portfolioId + '"]').textContent = data.likes_count;
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
