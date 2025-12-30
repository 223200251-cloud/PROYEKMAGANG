@extends('layouts.app')

@section('title', 'Buat Portfolio - Portfolio Hub')

@section('content')
    <div class="container-main">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card fade-in">
                    <div class="card-header text-center py-4">
                        <h2><i class="fas fa-plus-circle"></i> Buat Portfolio Baru</h2>
                        <p class="text-white-50 mb-0 mt-2">Bagikan karya dan proyek terbaik Anda</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('portfolio.store') }}" id="portfolioForm">
                            @csrf

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label">
                                    <i class="fas fa-heading"></i> Judul Proyek
                                </label>
                                <input 
                                    type="text" 
                                    name="title" 
                                    id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}"
                                    placeholder="Contoh: Website E-commerce Modern"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label for="category" class="form-label">
                                    <i class="fas fa-tag"></i> Kategori
                                </label>
                                <select 
                                    name="category" 
                                    id="category"
                                    class="form-select @error('category') is-invalid @enderror"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Web Development" {{ old('category') == 'Web Development' ? 'selected' : '' }}>
                                        Web Development
                                    </option>
                                    <option value="Mobile Development" {{ old('category') == 'Mobile Development' ? 'selected' : '' }}>
                                        Mobile Development
                                    </option>
                                    <option value="UI/UX Design" {{ old('category') == 'UI/UX Design' ? 'selected' : '' }}>
                                        UI/UX Design
                                    </option>
                                    <option value="Graphic Design" {{ old('category') == 'Graphic Design' ? 'selected' : '' }}>
                                        Graphic Design
                                    </option>
                                    <option value="Game Development" {{ old('category') == 'Game Development' ? 'selected' : '' }}>
                                        Game Development
                                    </option>
                                    <option value="Data Science" {{ old('category') == 'Data Science' ? 'selected' : '' }}>
                                        Data Science
                                    </option>
                                    <option value="Machine Learning" {{ old('category') == 'Machine Learning' ? 'selected' : '' }}>
                                        Machine Learning
                                    </option>
                                    <option value="Video Production" {{ old('category') == 'Video Production' ? 'selected' : '' }}>
                                        Video Production
                                    </option>
                                    <option value="3D Modeling" {{ old('category') == '3D Modeling' ? 'selected' : '' }}>
                                        3D Modeling
                                    </option>
                                    <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left"></i> Deskripsi Lengkap
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description"
                                    class="form-control @error('description') is-invalid @enderror"
                                    rows="6"
                                    placeholder="Jelaskan detail proyek Anda, tantangan yang dihadapi, solusi yang diberikan, dan hasil yang dicapai..."
                                    required>{{ old('description') }}</textarea>
                                <small class="text-muted">Ceritakan kisah di balik proyek Anda</small>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Technologies -->
                            <div class="mb-4">
                                <label for="technologies" class="form-label">
                                    <i class="fas fa-code"></i> Teknologi yang Digunakan
                                </label>
                                <input 
                                    type="text" 
                                    name="technologies" 
                                    id="technologies"
                                    class="form-control @error('technologies') is-invalid @enderror"
                                    value="{{ old('technologies') }}"
                                    placeholder="Contoh: React, Node.js, MongoDB, Tailwind CSS">
                                <small class="text-muted">Pisahkan dengan koma (opsional)</small>
                                @error('technologies')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image URL -->
                            <div class="mb-4">
                                <label for="image_url" class="form-label">
                                    <i class="fas fa-image"></i> URL Gambar/Screenshot
                                </label>
                                <input 
                                    type="url" 
                                    name="image_url" 
                                    id="image_url"
                                    class="form-control @error('image_url') is-invalid @enderror"
                                    value="{{ old('image_url') }}"
                                    placeholder="https://example.com/image.jpg">
                                <small class="text-muted">Gambar thumbnail proyek Anda (opsional)</small>
                                @error('image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Project URL -->
                            <div class="mb-4">
                                <label for="project_url" class="form-label">
                                    <i class="fas fa-external-link-alt"></i> URL Proyek/Live Demo
                                </label>
                                <input 
                                    type="url" 
                                    name="project_url" 
                                    id="project_url"
                                    class="form-control @error('project_url') is-invalid @enderror"
                                    value="{{ old('project_url') }}"
                                    placeholder="https://example.com atau https://github.com/username/project">
                                <small class="text-muted">Link ke proyek live atau repository (opsional)</small>
                                @error('project_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                    <i class="fas fa-check-circle"></i> Publikasikan Portfolio
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card mt-4 bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-lightbulb"></i> Tips Membuat Portfolio yang Menarik
                        </h5>
                        <ul class="mb-0">
                            <li>Buat judul yang jelas dan deskriptif</li>
                            <li>Jelaskan proses dan tantangan yang dihadapi</li>
                            <li>Sebutkan semua teknologi yang digunakan</li>
                            <li>Gunakan gambar/screenshot berkualitas tinggi</li>
                            <li>Tambahkan link ke proyek atau repository</li>
                            <li>Ceritakan hasil dan impact dari proyek Anda</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Real-time validation feedback
        const form = document.getElementById('portfolioForm');
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.addEventListener('change', function() {
                // Validasi sederhana
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Preview gambar
        const imageInput = document.getElementById('image_url');
        imageInput.addEventListener('change', function() {
            if (this.value && !this.value.match(/^https?:\/\/.+\.(jpg|jpeg|png|gif|webp)$/i)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>
@endsection
