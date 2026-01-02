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
                        <form method="POST" action="{{ route('portfolio.store') }}" id="portfolioForm" enctype="multipart/form-data">
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

                            <!-- Image Upload -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-image"></i> Gambar Proyek
                                </label>
                                
                                <!-- Image Type Selection -->
                                <div class="btn-group w-100 mb-3" role="group">
                                    <input type="radio" class="btn-check" name="image_type" id="image_type_upload" value="uploaded" 
                                        {{ old('image_type') == 'uploaded' || !old('image_type') ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="image_type_upload">
                                        <i class="fas fa-upload"></i> Upload File
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="image_type" id="image_type_url" value="url"
                                        {{ old('image_type') == 'url' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="image_type_url">
                                        <i class="fas fa-link"></i> Dari URL
                                    </label>
                                </div>

                                <!-- File Upload Input -->
                                <div id="upload_file_section" style="display: {{ old('image_type') == 'url' ? 'none' : 'block' }};">
                                    <div class="mb-3">
                                        <input 
                                            type="file" 
                                            name="image_file" 
                                            id="image_file"
                                            class="form-control @error('image_file') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                        <small class="text-muted">Ukuran maksimal: 5MB. Format: JPG, PNG, GIF, WebP</small>
                                        <div id="image_preview" class="mt-3"></div>
                                        @error('image_file')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- URL Input -->
                                <div id="upload_url_section" style="display: {{ old('image_type') == 'url' ? 'block' : 'none' }};">
                                    <input 
                                        type="url" 
                                        name="image_url" 
                                        id="image_url"
                                        class="form-control @error('image_url') is-invalid @enderror"
                                        value="{{ old('image_url') }}"
                                        placeholder="https://example.com/image.jpg">
                                    <small class="text-muted">Masukkan URL lengkap gambar Anda</small>
                                    @error('image_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
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
        // Image type toggle
        const imageTypeUpload = document.getElementById('image_type_upload');
        const imageTypeUrl = document.getElementById('image_type_url');
        const uploadFileSection = document.getElementById('upload_file_section');
        const uploadUrlSection = document.getElementById('upload_url_section');

        function toggleImageInput() {
            if (imageTypeUpload.checked) {
                uploadFileSection.style.display = 'block';
                uploadUrlSection.style.display = 'none';
            } else {
                uploadFileSection.style.display = 'none';
                uploadUrlSection.style.display = 'block';
            }
        }

        imageTypeUpload.addEventListener('change', toggleImageInput);
        imageTypeUrl.addEventListener('change', toggleImageInput);

        // Image preview for file upload
        const imageFileInput = document.getElementById('image_file');
        const imagePreview = document.getElementById('image_preview');

        imageFileInput.addEventListener('change', function() {
            imagePreview.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Validasi ukuran
                if (file.size > 5 * 1024 * 1024) {
                    imagePreview.innerHTML = '<div class="alert alert-danger">Ukuran file terlalu besar (maksimal 5MB)</div>';
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <div style="border: 2px solid var(--gray-300); border-radius: 8px; padding: 1rem; text-align: center;">
                            <img src="${e.target.result}" style="max-width: 100%; max-height: 300px; border-radius: 6px;">
                            <p style="margin-top: 0.75rem; color: var(--gray-600); font-size: 0.9rem;">
                                <i class="fas fa-check-circle" style="color: var(--success-color);"></i>
                                ${file.name} (${(file.size / 1024).toFixed(2)} KB)
                            </p>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Real-time validation feedback
        const form = document.getElementById('portfolioForm');
        const inputs = form.querySelectorAll('input, textarea, select');

        inputs.forEach(input => {
            input.addEventListener('change', function() {
                // Validasi sederhana
                if (this.hasAttribute('required') && !this.value.trim() && this.id !== 'image_file' && this.id !== 'image_url') {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Preview gambar URL
        const imageUrlInput = document.getElementById('image_url');
        imageUrlInput.addEventListener('change', function() {
            if (this.value && !this.value.match(/^https?:\/\/.+\.(jpg|jpeg|png|gif|webp)$/i)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>
@endsection
