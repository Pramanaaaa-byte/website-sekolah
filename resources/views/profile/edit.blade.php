@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #6366f1; font-weight: 700;">
                <i class="fas fa-user-circle me-2"></i>
                Profile Pengguna
            </h2>
            <p class="text-muted mb-0">Kelola informasi profil dan pengaturan akun Anda</p>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <div class="rounded-circle bg-white bg-opacity-20 p-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                </div>
                <div class="flex-grow-1 ms-4">
                    <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                    <p class="mb-0 opacity-75">{{ auth()->user()->email }}</p>
                    <div class="badge bg-white text-dark mt-2">
                        @if(auth()->user()->role === 'admin')
                            Administrator
                        @elseif(auth()->user()->role === 'kepsek')
                            Kepala Sekolah
                        @else
                            Guru Piket
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Update Profile Information -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                        <i class="fas fa-user-edit me-2" style="color: #6366f1;"></i>
                        Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PATCH')
                        
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="name" 
                                   name="name" 
                                   value="{{ auth()->user()->name }}" 
                                   required 
                                   autocomplete="name"
                                   autofocus
                                   style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 0.75rem 1rem;">
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg" 
                                   id="email" 
                                   name="email" 
                                   value="{{ auth()->user()->email }}" 
                                   required 
                                   autocomplete="username"
                                   style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 0.75rem 1rem;">
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 10px; padding: 0.75rem 2rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
                                <i class="fas fa-save me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-lg-6 mb-4">
            <div class="card" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                        <i class="fas fa-lock me-2" style="color: #6366f1;"></i>
                        Ubah Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">
                                <i class="fas fa-key me-2"></i>Password Saat Ini
                            </label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="current_password" 
                                   name="current_password" 
                                   required 
                                   autocomplete="current-password"
                                   style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 0.75rem 1rem;">
                            @error('current_password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2"></i>Password Baru
                            </label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 0.75rem 1rem;">
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2"></i>Konfirmasi Password Baru
                            </label>
                            <input type="password" 
                                   class="form-control form-control-lg" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   style="border-radius: 10px; border: 2px solid #e2e8f0; padding: 0.75rem 1rem;">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning btn-lg" style="border-radius: 10px; padding: 0.75rem 2rem;">
                                <i class="fas fa-shield-alt me-2"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="col-12">
            <div class="card border-danger" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
                <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #dc3545; font-weight: 600;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Zone Berbahaya
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Perhatian!</h6>
                            <p class="mb-0">Menghapus akun akan menghapus semua data Anda secara permanen dan tidak dapat dikembalikan.</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="border-radius: 10px; padding: 0.75rem 2rem;">
                            <i class="fas fa-trash-alt me-2"></i>
                            Hapus Akun Saya
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<style>
.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a67d8, #7c3aed);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
}

.btn-warning:hover {
    background: linear-gradient(135deg, #d97706, #f59e0b);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626, #ef4444);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Password confirmation validation
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');
    
    if (password && passwordConfirmation) {
        function validatePassword() {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Password tidak cocok');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
        }
        
        password.addEventListener('change', validatePassword);
        passwordConfirmation.addEventListener('keyup', validatePassword);
    }
});
</script>
@endsection
