<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portfolio Hub') - Bagikan Karya Terbaik Anda</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Modern Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563EB;
            --primary-light: #3B82F6;
            --primary-dark: #1E40AF;
            --secondary-color: #10B981;
            --accent-color: #F59E0B;
            --danger-color: #EF4444;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --info-color: #06B6D4;
            --dark-color: #1F2937;
            --gray-100: #F9FAFB;
            --gray-200: #F3F4F6;
            --gray-300: #E5E7EB;
            --gray-400: #D1D5DB;
            --gray-500: #9CA3AF;
            --gray-600: #6B7280;
            --gray-700: #374151;
            --light-bg: #FAFBFC;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background-color: var(--gray-100);
            color: var(--dark-color);
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        /* Navbar Styling */
        .navbar {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.5px;
        }

        .navbar-brand i {
            font-size: 1.6rem;
        }

        .nav-link {
            color: var(--gray-600) !important;
            margin: 0 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), rgba(59, 130, 246, 0.9));
            border: none;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-secondary {
            background: var(--gray-200);
            border: none;
            color: var(--dark-color);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .btn-secondary:hover {
            background: var(--gray-300);
            color: var(--dark-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .btn-secondary:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border: 1.5px solid var(--primary-color);
            background: transparent;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);
            text-decoration: none;
        }

        .btn-outline-light {
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.65rem 1.5rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .btn-lg {
            padding: 0.9rem 2.5rem;
            font-size: 1.05rem;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        a.btn {
            text-decoration: none;
        }

        a.btn:hover {
            text-decoration: none;
        }

        /* Container & Cards */
        .container-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 1rem;
        }

        .card {
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            border-color: var(--gray-300);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            padding: 1.75rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.75rem;
        }

        /* Portfolio Card */
        .portfolio-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .portfolio-card .card-img-top {
            height: 280px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .portfolio-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .portfolio-card .category-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--secondary-color), #059669);
            color: white;
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: fit-content;
        }

        .portfolio-card .title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.75rem;
            transition: color 0.3s ease;
            line-height: 1.4;
        }

        .portfolio-card:hover .title {
            color: var(--primary-color);
        }

        .portfolio-card .description {
            font-size: 0.9rem;
            color: var(--gray-600);
            margin-bottom: 1.25rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }

        .portfolio-card .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: auto;
            padding-top: 1.25rem;
            border-top: 1px solid var(--gray-200);
        }

        .portfolio-card .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .portfolio-card .user-details {
            flex: 1;
            min-width: 0;
        }

        .portfolio-card .user-name {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
            margin: 0;
        }

        .portfolio-card .user-username {
            color: var(--gray-500);
            font-size: 0.8rem;
            margin: 0;
        }

        .portfolio-card .stats {
            display: flex;
            gap: 1.5rem;
            margin-top: 1.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--gray-200);
            font-size: 0.85rem;
        }

        .portfolio-card .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
        }

        .portfolio-card .stat-item i {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        /* Alert Messages */
        .alert {
            border-radius: 10px;
            border: 1px solid;
            margin-bottom: 2rem;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
            color: var(--success-color);
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: var(--danger-color);
        }

        .alert-info {
            background-color: rgba(6, 182, 212, 0.1);
            border-color: rgba(6, 182, 212, 0.3);
            color: var(--info-color);
        }

        /* Form Styling */
        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1.5px solid var(--gray-300);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
        }

        .invalid-feedback {
            color: var(--danger-color);
            font-size: 0.85rem;
            display: block;
            margin-top: 0.35rem;
            font-weight: 500;
        }

        /* Button Group */
        .btn-group-action {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 4rem 1rem 2rem;
            margin-top: 5rem;
            text-align: center;
            border-top: 1px solid var(--gray-300);
        }

        footer a {
            color: var(--info-color);
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-block;
            margin: 0 0.75rem;
            font-size: 1.1rem;
        }

        footer a:hover {
            color: var(--primary-color);
        }

        footer p {
            margin: 0.5rem 0;
            color: var(--gray-400);
        }

        footer a:hover {
            color: var(--success-color);
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: slideIn 0.5s ease-out;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 4rem 1rem;
            text-align: center;
            margin-bottom: 3rem;
            border-radius: 12px;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 1.8rem;
            }

            .portfolio-card .card-img-top {
                height: 200px;
            }

            .container-main {
                padding: 1rem 0.5rem;
            }
        }

        /* Loading Spinner */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        /* Link Styles */
        a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--secondary-color);
            text-decoration: none;
        }
    </style>

    @yield('css')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-briefcase"></i>
                Portfolio Hub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center gap-2">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-cogs"></i> Admin Panel
                            </a>
                        @else
                            <a href="{{ route('portfolio.create') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-plus"></i> Buat Portfolio
                            </a>
                        @endif

                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        <i class="fas fa-users"></i> Kelola User
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">
                                        <i class="fas fa-sitemap"></i> Kelola Kategori
                                    </a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.moderation.index') }}">
                                        <i class="fas fa-gavel"></i> Moderasi Portfolio
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @elseif(Auth::user()->isCompany())
                                    <li><a class="dropdown-item" href="{{ route('company.saved-creators') }}">
                                        <i class="fas fa-bookmark"></i> Kandidat Disimpan
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('profile.my-profile') }}">
                                    <i class="fas fa-user"></i> Profil Saya
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-edit"></i> Edit Profil
                                </a></li>
                                @if(!Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('portfolio.create') }}">
                                        <i class="fas fa-plus"></i> Portfolio Baru
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container-fluid">
            <p>&copy; 2024 Portfolio Hub. Dibuat dengan <i class="fas fa-heart" style="color: #EF476F;"></i> untuk para creator.</p>
            <p>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Setup CSRF token untuk AJAX
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Auto-hide alerts setelah 5 detik
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Like toggle dengan AJAX
        function toggleLike(portfolioId) {
            fetch(`/portfolio/${portfolioId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => {
                if (response.status === 401) {
                    window.location.href = '{{ route("login") }}';
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data) {
                    const btn = document.querySelector(`[data-like-btn="${portfolioId}"]`);
                    const count = document.querySelector(`[data-like-count="${portfolioId}"]`);
                    
                    if (data.liked) {
                        btn.classList.add('text-danger');
                        btn.innerHTML = '<i class="fas fa-heart"></i>';
                    } else {
                        btn.classList.remove('text-danger');
                        btn.innerHTML = '<i class="far fa-heart"></i>';
                    }
                    count.textContent = data.likes_count;
                }
            })
            .catch(err => console.error(err));
        }
    </script>

    @yield('js')
</body>
</html>
