@extends('layouts.app')

@section('title', 'Pengaturan - ' . $portfolio->title)

@section('content')
    <div class="container-main">
        <!-- Header -->
        <div class="mb-4">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <a href="{{ route('portfolio.show', $portfolio) }}" style="color: #667eea; text-decoration: none; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Portfolio
                    </a>
                    <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0;">Pengaturan Portfolio</h1>
                    <p style="color: #666; margin-top: 0.5rem;">{{ $portfolio->title }}</p>
                </div>
            </div>
        </div>

        <!-- Settings Form -->
        <div style="max-width: 900px;">
            <form method="POST" action="{{ route('portfolio.updateSettings', $portfolio) }}" style="display: grid; gap: 2rem;">
                @csrf
                @method('PUT')

                <!-- Section 1: Visibility Settings -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.05);">
                    <h2 style="font-size: 1.4rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-eye" style="color: #667eea;"></i> Visibilitas Portfolio
                    </h2>

                    <div style="display: grid; gap: 1rem;">
                        <!-- Public Option -->
                        <div id="public-option"
                             onclick="setVisibility('public')" 
                             style="border: 2px solid {{ $portfolio->visibility === 'public' ? '#667eea' : '#e0e0e0' }}; border-radius: 10px; padding: 1.5rem; cursor: pointer; transition: all 0.3s ease; background: {{ $portfolio->visibility === 'public' ? '#f0f4ff' : 'white' }};">
                            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                <input type="radio" name="visibility" value="public" id="visibility-public" 
                                       {{ $portfolio->visibility === 'public' ? 'checked' : '' }}
                                       style="margin-top: 0.3rem; cursor: pointer; width: 20px; height: 20px;">
                                <div style="flex: 1;">
                                    <label for="visibility-public" style="font-weight: 700; font-size: 1.1rem; cursor: pointer; display: block; margin-bottom: 0.3rem;">
                                        <i class="fas fa-globe"></i> Publik
                                    </label>
                                    <p style="color: #666; margin: 0; font-size: 0.95rem;">Portfolio terlihat oleh semua orang dan muncul di halaman beranda</p>
                                </div>
                            </div>
                        </div>

                        <!-- Private Option -->
                        <div id="private-option"
                             onclick="setVisibility('private')"
                             style="border: 2px solid {{ $portfolio->visibility === 'private' ? '#667eea' : '#e0e0e0' }}; border-radius: 10px; padding: 1.5rem; cursor: pointer; transition: all 0.3s ease; background: {{ $portfolio->visibility === 'private' ? '#f0f4ff' : 'white' }};">
                            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                <input type="radio" name="visibility" value="private" id="visibility-private"
                                       {{ $portfolio->visibility === 'private' ? 'checked' : '' }}
                                       style="margin-top: 0.3rem; cursor: pointer; width: 20px; height: 20px;">
                                <div style="flex: 1;">
                                    <label for="visibility-private" style="font-weight: 700; font-size: 1.1rem; cursor: pointer; display: block; margin-bottom: 0.3rem;">
                                        <i class="fas fa-lock"></i> Privat
                                    </label>
                                    <p style="color: #666; margin: 0; font-size: 0.95rem;">Portfolio hanya terlihat oleh Anda. Tidak muncul di halaman publik</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Display Order -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.05);">
                    <h2 style="font-size: 1.4rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-list" style="color: #667eea;"></i> Urutan Portfolio
                    </h2>

                    <div style="background: #f8f9fa; border-radius: 10px; padding: 1.5rem; margin-bottom: 1.5rem;">
                        <p style="color: #666; margin-bottom: 1rem;">Atur urutan tampilan portfolio Anda. Semakin kecil angka, semakin depan tampil.</p>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Urutan Tampilan</label>
                        <input type="number" name="display_order" value="{{ $portfolio->display_order }}" min="0" 
                               style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                    </div>

                    <!-- Portfolio List for Reference -->
                    <div style="background: #fafbfc; border-radius: 10px; padding: 1.5rem; border: 1px dashed #ddd;">
                        <p style="font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-info-circle" style="color: #667eea;"></i> Urutan Portfolio Anda Saat Ini
                        </p>
                        <div style="display: grid; gap: 0.75rem;">
                            @foreach($userPortfolios as $p)
                                <div style="background: white; padding: 0.75rem 1rem; border-radius: 6px; display: flex; align-items: center; gap: 1rem; border-left: 4px solid {{ $p->id === $portfolio->id ? '#667eea' : '#e0e0e0' }};">
                                    <span style="background: #f0f2f5; padding: 0.3rem 0.6rem; border-radius: 4px; font-weight: 600; color: #667eea; min-width: 30px; text-align: center;">{{ $p->display_order }}</span>
                                    <span style="flex: 1;">{{ $p->title }}</span>
                                    @if($p->id === $portfolio->id)
                                        <span style="background: #667eea; color: white; padding: 0.3rem 0.75rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">Saat Ini</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Section 3: Highlight -->
                <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid rgba(0,0,0,0.05);">
                    <h2 style="font-size: 1.4rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-star" style="color: #ffc107;"></i> Sorot Portfolio (Highlight)
                    </h2>

                    <div style="background: linear-gradient(135deg, #fff8e1 0%, #ffe4b5 100%); border-radius: 10px; padding: 1.5rem; margin-bottom: 1.5rem; border-left: 4px solid #ffc107;">
                        <p style="color: #856404; margin-bottom: 0.5rem;">
                            <i class="fas fa-lightbulb"></i> <strong>Sorot portfolio terbaik Anda!</strong>
                        </p>
                        <p style="color: #856404; margin: 0; font-size: 0.95rem;">Portfolio yang di-highlight akan mendapat perhatian lebih di halaman profil Anda dan mungkin mendapat prioritas pada pencarian</p>
                    </div>

                    <div style="background: #f8f9fa; border-radius: 10px; padding: 1.5rem;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; margin-bottom: 1.5rem;">
                            <input type="checkbox" name="is_highlighted" value="1" 
                                   {{ $portfolio->is_highlighted ? 'checked' : '' }}
                                   onchange="toggleHighlightOptions()"
                                   style="width: 20px; height: 20px; cursor: pointer;">
                            <span style="font-weight: 600;">Sorot Portfolio Ini</span>
                        </label>

                        <div id="highlightOptions" style="display: {{ $portfolio->is_highlighted ? 'block' : 'none' }}; background: white; border-radius: 8px; padding: 1.5rem; border: 1px solid #ffc107;">
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                Sampai Kapan Highlight Ditampilkan?
                            </label>
                            <p style="color: #666; font-size: 0.9rem; margin-bottom: 1rem;">Pilih tanggal berakhirnya highlight (kosongkan untuk tanpa batas)</p>
                            <input type="datetime-local" name="highlighted_until" 
                                   value="{{ $portfolio->highlighted_until ? $portfolio->highlighted_until->format('Y-m-d\TH:i') : '' }}"
                                   style="width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                            <small style="color: #999; display: block; margin-top: 0.5rem;">
                                <i class="fas fa-clock"></i> Jika dikosongkan, highlight akan bertahan selamanya
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div style="display: flex; gap: 1rem; justify-content: space-between; flex-wrap: wrap;">
                    <a href="{{ route('portfolio.show', $portfolio) }}" style="background: #f0f2f5; color: #667eea; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; border: none; cursor: pointer;" onmouseover="this.style.background='#e8eaf6';" onmouseout="this.style.background='#f0f2f5';">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; border: none; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function setVisibility(value) {
            document.getElementById('visibility-' + value).checked = true;
            
            // Update UI
            const publicOption = document.getElementById('public-option');
            const privateOption = document.getElementById('private-option');
            
            if (value === 'public') {
                publicOption.style.borderColor = '#667eea';
                publicOption.style.background = '#f0f4ff';
                privateOption.style.borderColor = '#e0e0e0';
                privateOption.style.background = 'white';
            } else {
                privateOption.style.borderColor = '#667eea';
                privateOption.style.background = '#f0f4ff';
                publicOption.style.borderColor = '#e0e0e0';
                publicOption.style.background = 'white';
            }
        }

        function toggleHighlightOptions() {
            const checkbox = document.querySelector('input[name="is_highlighted"]');
            const options = document.getElementById('highlightOptions');
            options.style.display = checkbox.checked ? 'block' : 'none';
        }

        // Initialize visibility styling on page load
        document.addEventListener('DOMContentLoaded', function() {
            const visibility = document.querySelector('input[name="visibility"]:checked').value;
            setVisibility(visibility);
        });
    </script>
@endsection
