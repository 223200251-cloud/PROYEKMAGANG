@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center" style="gap: 0.25rem;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 0.5rem 0.75rem; border-radius: 6px; background: #f0f2f5; color: #ccc; cursor: not-allowed;">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.5rem 0.75rem; border-radius: 6px; background: #f0f2f5; color: #667eea; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='#667eea'; this.style.color='white';" onmouseout="this.style.background='#f0f2f5'; this.style.color='#667eea';">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 0.5rem 0.75rem; color: #999;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 0.5rem 0.75rem; border-radius: 6px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; font-weight: 600; min-width: 40px; text-align: center;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="padding: 0.5rem 0.75rem; border-radius: 6px; background: #f0f2f5; color: #667eea; text-decoration: none; transition: all 0.3s ease; min-width: 40px; text-align: center; display: inline-block;" onmouseover="this.style.background='#e0e2e8';" onmouseout="this.style.background='#f0f2f5';">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.5rem 0.75rem; border-radius: 6px; background: #f0f2f5; color: #667eea; text-decoration: none; transition: all 0.3s ease;" onmouseover="this.style.background='#667eea'; this.style.color='white';" onmouseout="this.style.background='#f0f2f5'; this.style.color='#667eea';">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span style="padding: 0.5rem 0.75rem; border-radius: 6px; background: #f0f2f5; color: #ccc; cursor: not-allowed;">
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif
