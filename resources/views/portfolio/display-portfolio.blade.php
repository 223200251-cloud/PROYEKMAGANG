{{-- Contoh menampilkan gambar portfolio dengan helper --}}

@php
    use App\Helpers\PortfolioImageHelper;
@endphp

<div class="portfolio-card">
    <div class="portfolio-image">
        @if(PortfolioImageHelper::getImageUrl($portfolio))
            <img 
                src="{{ PortfolioImageHelper::getImageUrl($portfolio) }}"
                alt="{{ PortfolioImageHelper::getImageAlt($portfolio) }}"
                class="img-fluid"
                loading="lazy">
            
            {{-- Badge untuk menunjukkan tipe image --}}
            @if(PortfolioImageHelper::isUploadedImage($portfolio))
                <span class="badge bg-success position-absolute top-2 end-2">
                    <i class="bi bi-cloud-upload"></i> Upload
                </span>
            @elseif(PortfolioImageHelper::isExternalImage($portfolio))
                <span class="badge bg-info position-absolute top-2 end-2">
                    <i class="bi bi-link-45deg"></i> Link
                </span>
            @endif
        @else
            <div class="placeholder-image bg-light d-flex align-items-center justify-content-center">
                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
            </div>
        @endif
    </div>

    <div class="portfolio-content">
        <h3>{{ $portfolio->title }}</h3>
        <p class="text-muted">{{ $portfolio->user->name }}</p>
        <p>{{ Str::limit($portfolio->description, 100) }}</p>

        {{-- Display category and technologies --}}
        <div class="portfolio-meta mb-3">
            <span class="badge bg-secondary">{{ $portfolio->category }}</span>
            @if($portfolio->technologies)
                @foreach(explode(',', $portfolio->technologies) as $tech)
                    <span class="badge bg-light text-dark">{{ trim($tech) }}</span>
                @endforeach
            @endif
        </div>

        {{-- Action buttons --}}
        <div class="d-flex gap-2">
            <a href="{{ route('portfolio.show', $portfolio) }}" class="btn btn-sm btn-primary">
                Lihat Detail
            </a>
            @if(Auth::check() && Auth::user()->id === $portfolio->user_id)
                <a href="{{ route('portfolio.edit', $portfolio) }}" class="btn btn-sm btn-warning">
                    Edit
                </a>
                <form action="{{ route('portfolio.destroy', $portfolio) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" 
                            onclick="return confirm('Yakin ingin menghapus?')">
                        Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
.portfolio-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.2s;
}

.portfolio-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.portfolio-image {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
    background-color: #f5f5f5;
}

.portfolio-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.placeholder-image {
    width: 100%;
    height: 100%;
}

.portfolio-content {
    padding: 15px;
}

.portfolio-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}
</style>
