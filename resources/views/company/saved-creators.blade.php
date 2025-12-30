@extends('layouts.app')

@section('title', 'Kandidat Disimpan - ' . Auth::user()->company_name ?? 'Perusahaan')

@section('content')
    <div class="container-main">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="mb-2">
                <i class="fas fa-heart"></i> Kandidat Disimpan
            </h1>
            <p class="text-muted">Daftar creator yang telah Anda simpan untuk review lebih lanjut</p>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($saved->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
                @foreach($saved as $item)
                    <div style="animation: fadeInUp 0.6s ease-out; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-8px)';" onmouseout="this.style.transform='translateY(0)';">
                        <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.05);">
                            
                            <!-- Creator Header -->
                            <div style="padding: 2rem; background: linear-gradient(135deg, #667eea, #764ba2); color: white; text-align: center;">
                                <img src="{{ $item->creator->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($item->creator->name) }}" 
                                    alt="{{ $item->creator->name }}" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid white; margin-bottom: 1rem;">
                                <h3 style="margin-bottom: 0.25rem;">{{ $item->creator->name }}</h3>
                                <p style="opacity: 0.9; margin-bottom: 0;">@{{ $item->creator->username }}</p>
                            </div>

                            <!-- Creator Info -->
                            <div style="padding: 1.5rem;">
                                @if($item->creator->bio)
                                    <p style="color: #666; margin-bottom: 1rem; font-size: 0.95rem;">
                                        {{ Str::limit($item->creator->bio, 100) }}
                                    </p>
                                @endif

                                <!-- Stats -->
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #f0f2f5;">
                                    <div style="text-align: center;">
                                        <div style="font-size: 1.5rem; font-weight: 700; color: #667eea;">
                                            {{ $item->creator->portfolios()->count() }}
                                        </div>
                                        <div style="color: #999; font-size: 0.85rem;">Portfolio</div>
                                    </div>
                                    <div style="text-align: center;">
                                        <div style="font-size: 1.5rem; font-weight: 700; color: #667eea;">
                                            {{ $item->creator->portfolios()->sum('views') }}
                                        </div>
                                        <div style="color: #999; font-size: 0.85rem;">Total Views</div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <p style="margin-bottom: 1rem;">
                                    <strong style="color: #1a202c;">Email:</strong><br>
                                    <code style="background: #f5f7fa; padding: 0.3rem 0.5rem; border-radius: 4px; font-size: 0.85rem;">
                                        {{ $item->creator->email }}
                                    </code>
                                </p>

                                @if($item->creator->website)
                                    <p style="margin-bottom: 1rem;">
                                        <strong style="color: #1a202c;">Website:</strong><br>
                                        <a href="{{ $item->creator->website }}" target="_blank" style="color: #667eea; text-decoration: none; word-break: break-all;">
                                            {{ Str::limit($item->creator->website, 40) }}
                                        </a>
                                    </p>
                                @endif

                                <!-- Notes -->
                                @if($item->notes)
                                    <div style="background: #f5f7fa; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                                        <strong style="color: #1a202c; display: block; margin-bottom: 0.5rem;">Catatan:</strong>
                                        <p style="margin: 0; color: #666; font-size: 0.9rem;">{{ $item->notes }}</p>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div style="display: flex; gap: 0.75rem;">
                                    <a href="{{ route('profile.show', $item->creator) }}" class="btn btn-primary btn-sm flex-grow-1" style="text-decoration: none;">
                                        <i class="fas fa-eye"></i> Lihat Profil
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm" onclick="removeCreator({{ $item->id }})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $saved->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div style="text-align: center; padding: 4rem 2rem; background: linear-gradient(135deg, #f5f7fa 0%, #f0f2f5 100%); border-radius: 16px;">
                <i class="fas fa-inbox fa-3x" style="color: #ccc; margin-bottom: 1rem;"></i>
                <h3 style="color: #1a202c; margin-bottom: 0.5rem; font-size: 1.3rem;">Belum ada kandidat disimpan</h3>
                <p style="color: #666; margin-bottom: 1.5rem;">Mulai jelajahi portfolio dan simpan creator yang Anda minati</p>
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Jelajahi Creator
                </a>
            </div>
        @endif
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        function removeCreator(savedId) {
            if (confirm('Hapus creator dari daftar disimpan?')) {
                // Implement AJAX delete later
                alert('Feature coming soon');
            }
        }
    </script>
@endsection
