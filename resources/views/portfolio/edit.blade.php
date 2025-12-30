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
                        <form method="POST" action="{{ route('portfolio.update', $portfolio) }}" id="portfolioForm">
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
                                <input 
                                    type="url" 
                                    name="image_url" 
                                    id="image_url"
                                    class="form-control @error('image_url') is-invalid @enderror"
                                    value="{{ old('image_url', $portfolio->image_url) }}">
                                <small class="text-muted">Gambar thumbnail proyek Anda (opsional)</small>
                                @if($portfolio->image_url)
                                    <div class="mt-2">
                                        <small class="text-success">
                                            <i class="fas fa-check-circle"></i> Gambar saat ini:
                                        </small>
                                        <br>
                                        <img src="{{ $portfolio->image_url }}" alt="Preview" style="max-width: 200px; max-height: 150px; border-radius: 8px; margin-top: 0.5rem;">
                                    </div>
                                @endif
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
