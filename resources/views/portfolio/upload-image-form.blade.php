{{-- Form untuk Upload Portfolio dengan opsi Upload Foto atau Link Gambar --}}

<div class="card">
    <div class="card-header">
        <h5>Upload Karya Portfolio</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Judul Karya *</label>
                <input 
                    type="text" 
                    class="form-control @error('title') is-invalid @enderror" 
                    id="title" 
                    name="title"
                    placeholder="Masukkan judul karya"
                    value="{{ old('title') }}"
                    required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi *</label>
                <textarea 
                    class="form-control @error('description') is-invalid @enderror" 
                    id="description" 
                    name="description"
                    rows="4"
                    placeholder="Jelaskan detail karya Anda"
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label for="category" class="form-label">Kategori *</label>
                <select class="form-select @error('category') is-invalid @enderror" 
                        id="category" 
                        name="category"
                        required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="web_development" {{ old('category') === 'web_development' ? 'selected' : '' }}>Web Development</option>
                    <option value="mobile_development" {{ old('category') === 'mobile_development' ? 'selected' : '' }}>Mobile Development</option>
                    <option value="web_design" {{ old('category') === 'web_design' ? 'selected' : '' }}>Web Design</option>
                    <option value="graphic_design" {{ old('category') === 'graphic_design' ? 'selected' : '' }}>Graphic Design</option>
                    <option value="ui_ux" {{ old('category') === 'ui_ux' ? 'selected' : '' }}>UI/UX Design</option>
                    <option value="other" {{ old('category') === 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Image Type Selection --}}
            <div class="mb-4">
                <label class="form-label">Sumber Gambar *</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="image_type" 
                                id="image_type_uploaded"
                                value="uploaded"
                                {{ old('image_type') === 'uploaded' ? 'checked' : '' }}>
                            <label class="form-check-label" for="image_type_uploaded">
                                <strong>Upload Foto</strong>
                                <small class="d-block text-muted">Upload file dari komputer (JPG, PNG, max 5MB)</small>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="image_type" 
                                id="image_type_url"
                                value="url"
                                {{ old('image_type') === 'url' ? 'checked' : '' }}>
                            <label class="form-check-label" for="image_type_url">
                                <strong>Link Gambar</strong>
                                <small class="d-block text-muted">Gunakan URL gambar dari internet</small>
                            </label>
                        </div>
                    </div>
                </div>
                @error('image_type')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- File Upload Section --}}
            <div id="file-upload-section" class="mb-3" style="display: none;">
                <label for="image_file" class="form-label">
                    Pilih File Foto
                    <span class="badge bg-info">JPG, PNG, GIF, WebP</span>
                    <span class="badge bg-warning">Max 5MB</span>
                </label>
                <input 
                    type="file" 
                    class="form-control @error('image_file') is-invalid @enderror" 
                    id="image_file" 
                    name="image_file"
                    accept="image/jpeg,image/png,image/gif,image/webp">
                <small class="form-text text-muted d-block mt-2">
                    📁 Pastikan file berformat yang didukung dan ukuran tidak melebihi 5MB
                </small>
                @error('image_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- URL Input Section --}}
            <div id="url-input-section" class="mb-3" style="display: none;">
                <label for="image_url" class="form-label">URL Gambar</label>
                <input 
                    type="url" 
                    class="form-control @error('image_url') is-invalid @enderror" 
                    id="image_url" 
                    name="image_url"
                    placeholder="https://example.com/image.jpg"
                    value="{{ old('image_url') }}">
                <small class="form-text text-muted d-block mt-2">
                    🔗 Masukkan URL lengkap gambar Anda (dimulai dengan http:// atau https://)
                </small>
                @error('image_url')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Technologies --}}
            <div class="mb-3">
                <label for="technologies" class="form-label">Teknologi yang Digunakan</label>
                <input 
                    type="text" 
                    class="form-control @error('technologies') is-invalid @enderror" 
                    id="technologies" 
                    name="technologies"
                    placeholder="Misal: React, Laravel, Tailwind CSS"
                    value="{{ old('technologies') }}">
                <small class="form-text text-muted">Pisahkan dengan koma</small>
                @error('technologies')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Project URL --}}
            <div class="mb-3">
                <label for="project_url" class="form-label">URL Proyek</label>
                <input 
                    type="url" 
                    class="form-control @error('project_url') is-invalid @enderror" 
                    id="project_url" 
                    name="project_url"
                    placeholder="https://example.com"
                    value="{{ old('project_url') }}">
                <small class="form-text text-muted">Opsional: Link ke live project atau repository</small>
                @error('project_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload"></i> Upload Portfolio
                </button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadedRadio = document.getElementById('image_type_uploaded');
        const urlRadio = document.getElementById('image_type_url');
        const fileSection = document.getElementById('file-upload-section');
        const urlSection = document.getElementById('url-input-section');

        function toggleSections() {
            if (uploadedRadio.checked) {
                fileSection.style.display = 'block';
                urlSection.style.display = 'none';
                document.getElementById('image_file').required = true;
                document.getElementById('image_url').required = false;
            } else if (urlRadio.checked) {
                fileSection.style.display = 'none';
                urlSection.style.display = 'block';
                document.getElementById('image_file').required = false;
                document.getElementById('image_url').required = true;
            }
        }

        // Set initial state
        toggleSections();

        // Add event listeners
        uploadedRadio.addEventListener('change', toggleSections);
        urlRadio.addEventListener('change', toggleSections);

        // File preview
        document.getElementById('image_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    console.log('File dipilih:', file.name);
                    console.log('Size:', (file.size / 1024).toFixed(2), 'KB');
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
