@extends('layouts.app')

@section('title', 'Edit Portfolio - ' . $portfolio->title)

@section('content')
    <div class="container-main">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card fade-in">
                    <div class="card-header text-center py-4">
                        <h2><i class="fas fa-edit"></i> Edit Portfolio</h2>
                        <p class="text-white-50 mb-0 mt-2">Update informasi proyek Anda</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('portfolio.update', $portfolio) }}" id="portfolioForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

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
                                    value="{{ old('title', $portfolio->title) }}"
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
                                    <option value="Web Development" {{ old('category', $portfolio->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                                    <option value="Mobile Development" {{ old('category', $portfolio->category) == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                                    <option value="UI/UX Design" {{ old('category', $portfolio->category) == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                                    <option value="Graphic Design" {{ old('category', $portfolio->category) == 'Graphic Design' ? 'selected' : '' }}>Graphic Design</option>
                                    <option value="Game Development" {{ old('category', $portfolio->category) == 'Game Development' ? 'selected' : '' }}>Game Development</option>
                                    <option value="Data Science" {{ old('category', $portfolio->category) == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                                    <option value="Machine Learning" {{ old('category', $portfolio->category) == 'Machine Learning' ? 'selected' : '' }}>Machine Learning</option>
                                    <option value="Video Production" {{ old('category', $portfolio->category) == 'Video Production' ? 'selected' : '' }}>Video Production</option>
                                    <option value="3D Modeling" {{ old('category', $portfolio->category) == '3D Modeling' ? 'selected' : '' }}>3D Modeling</option>
                                    <option value="Lainnya" {{ old('category', $portfolio->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                    required>{{ old('description', $portfolio->description) }}</textarea>
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
                                    value="{{ old('technologies', $portfolio->technologies) }}">
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
                                
                                <!-- Image Type Selection -->
                                <div class="btn-group w-100 mb-3" role="group">
                                    <input type="radio" class="btn-check" name="image_type" id="image_type_upload" value="uploaded" 
                                        {{ old('image_type', $portfolio->image_type) == 'uploaded' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="image_type_upload">
                                        <i class="fas fa-upload"></i> Upload File
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="image_type" id="image_type_url" value="url"
                                        {{ old('image_type', $portfolio->image_type) == 'url' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="image_type_url">
                                        <i class="fas fa-link"></i> Dari URL
                                    </label>
                                </div>

                                <!-- File Upload Input -->
                                <div id="upload_file_section" style="display: {{ old('image_type', $portfolio->image_type) == 'uploaded' ? 'block' : 'none' }};">
                                    <div class="mb-3">
                                        <input 
                                            type="file" 
                                            name="image_file" 
                                            id="image_file"
                                            class="form-control @error('image_file') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                                        <small class="text-muted">Ukuran maksimal: 5MB. Format: JPG, PNG, GIF, WebP</small>
                                        <div id="image_preview" class="mt-3">
                                            @if($portfolio->image_type === 'uploaded' && $portfolio->image_path)
                                                <div style="border: 2px solid var(--gray-300); border-radius: 8px; padding: 1rem; text-align: center;">
                                                    <img src="{{ $portfolio->image_url }}" style="max-width: 100%; max-height: 300px; border-radius: 6px;">
                                                    <p style="margin-top: 0.75rem; color: var(--gray-600); font-size: 0.9rem;">
                                                        <i class="fas fa-check-circle" style="color: var(--success-color);"></i>
                                                        Gambar saat ini
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                        @error('image_file')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- URL Input -->
                                <div id="upload_url_section" style="display: {{ old('image_type', $portfolio->image_type) == 'url' ? 'block' : 'none' }};">
                                    <input 
                                        type="url" 
                                        name="image_url" 
                                        id="image_url"
                                        class="form-control @error('image_url') is-invalid @enderror"
                                        value="{{ old('image_url', $portfolio->image_url) }}"
                                        placeholder="https://example.com/image.jpg">
                                    <small class="text-muted">Masukkan URL lengkap gambar Anda</small>
                                    @error('image_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                    value="{{ old('project_url', $portfolio->project_url) }}">
                                <small class="text-muted">Link ke proyek live atau repository (opsional)</small>
                                @error('project_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-5">
                                <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('portfolio.show', $portfolio) }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </form>
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

        // Preview gambar URL
        const imageUrlInput = document.getElementById('image_url');
        if (imageUrlInput) {
            imageUrlInput.addEventListener('change', function() {
                if (this.value && !this.value.match(/^https?:\/\/.+\.(jpg|jpeg|png|gif|webp)$/i)) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });
        }
    </script>
@endsection