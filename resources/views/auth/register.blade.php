@extends('layouts.app')

@section('title', 'Daftar Akun - Portfolio Hub')

@section('content')
    <div class="container-main">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card fade-in">
                    <div class="card-header text-center py-4">
                        <h2><i class="fas fa-user-plus"></i> Daftar Akun Baru</h2>
                        <p class="text-white-50 mb-0 mt-2">Bergabunglah dengan komunitas creator kami</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}" id="registerForm">
                            @csrf

                            <!-- User Type Selection -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-user-tag"></i> Tipe Akun
                                </label>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <input type="radio" name="user_type" id="individual" value="individual" 
                                            class="form-check-input" checked onchange="toggleCompanyFields()">
                                        <label for="individual" class="form-check-label d-block border rounded p-3 text-center cursor-pointer" style="cursor: pointer; background: #f8f9ff; border: 2px solid #667eea;">
                                            <i class="fas fa-briefcase fa-lg"></i>
                                            <div class="fw-bold mt-2">Creator/Individual</div>
                                            <small class="text-muted">Bagikan portofolio Anda</small>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" name="user_type" id="company" value="company" 
                                            class="form-check-input" onchange="toggleCompanyFields()">
                                        <label for="company" class="form-check-label d-block border rounded p-3 text-center cursor-pointer" style="cursor: pointer;">
                                            <i class="fas fa-building fa-lg"></i>
                                            <div class="fw-bold mt-2">Perusahaan/Recruiter</div>
                                            <small class="text-muted">Temukan talenta terbaik</small>
                                        </label>
                                    </div>
                                </div>
                                @error('user_type')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Nama Lengkap
                                </label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-at"></i> Username
                                </label>
                                <input 
                                    type="text" 
                                    name="username" 
                                    id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}"
                                    placeholder="username (tanpa spasi)"
                                    required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company Fields (Hidden by default) -->
                            <div id="companyFields" style="display: none;">
                                <!-- Company Name -->
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">
                                        <i class="fas fa-building"></i> Nama Perusahaan
                                    </label>
                                    <input 
                                        type="text" 
                                        name="company_name" 
                                        id="company_name"
                                        data-company-required
                                        class="form-control @error('company_name') is-invalid @enderror"
                                        value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Company Website -->
                                <div class="mb-3">
                                    <label for="company_website" class="form-label">
                                        <i class="fas fa-globe"></i> Website Perusahaan
                                    </label>
                                    <input 
                                        type="url" 
                                        name="company_website" 
                                        id="company_website"
                                        data-company-required
                                        class="form-control @error('company_website') is-invalid @enderror"
                                        value="{{ old('company_website') }}"
                                        placeholder="https://example.com">
                                    @error('company_website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Company Phone -->
                                <div class="mb-3">
                                    <label for="company_phone" class="form-label">
                                        <i class="fas fa-phone"></i> Nomor Telepon
                                    </label>
                                    <input 
                                        type="tel" 
                                        name="company_phone" 
                                        id="company_phone"
                                        data-company-required
                                        class="form-control @error('company_phone') is-invalid @enderror"
                                        value="{{ old('company_phone') }}"
                                        placeholder="+62 XXX XXX XXXX">
                                    @error('company_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Company Description -->
                                <div class="mb-3">
                                    <label for="company_description" class="form-label">
                                        <i class="fas fa-pencil"></i> Deskripsi Perusahaan
                                    </label>
                                    <textarea 
                                        name="company_description" 
                                        id="company_description"
                                        class="form-control @error('company_description') is-invalid @enderror"
                                        rows="3"
                                        placeholder="Deskripsi singkat tentang perusahaan Anda...">{{ old('company_description') }}</textarea>
                                    @error('company_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required>
                                <small class="text-muted">Minimal 8 karakter</small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock"></i> Konfirmasi Password
                                </label>
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    required>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="fas fa-arrow-right"></i> Daftar Sekarang
                            </button>

                            <!-- Login Link -->
                            <p class="text-center text-muted mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    <strong>Login di sini</strong>
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function toggleCompanyFields() {
            const userType = document.querySelector('input[name="user_type"]:checked').value;
            const companyFields = document.getElementById('companyFields');
            const companyInputs = companyFields.querySelectorAll('[data-company-required]');
            
            if (userType === 'company') {
                companyFields.style.display = 'block';
                // Set company fields as required
                companyInputs.forEach(input => {
                    input.required = true;
                    input.closest('.mb-3').querySelector('label .text-danger')?.remove();
                    input.closest('.mb-3').querySelector('label')?.insertAdjacentHTML('beforeend', '<span class="text-danger">*</span>');
                });
            } else {
                companyFields.style.display = 'none';
                // Remove required from company fields
                companyInputs.forEach(input => {
                    input.required = false;
                    input.closest('.mb-3').querySelector('label .text-danger')?.remove();
                });
            }
        }

        // Check if company was selected and show fields on page load
        window.addEventListener('load', () => {
            toggleCompanyFields();
        });

        // Add event listeners for radio buttons
        document.querySelectorAll('input[name="user_type"]').forEach(radio => {
            radio.addEventListener('change', toggleCompanyFields);
        });
    </script>
@endsection
