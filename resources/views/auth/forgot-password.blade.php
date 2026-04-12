<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Eduspace</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --info-color: #06b6d4;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-secondary: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }
        
        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: 
                radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(79, 172, 254, 0.05) 0%, transparent 50%);
            animation: backgroundShift 20s ease-in-out infinite;
        }

        @keyframes backgroundShift {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.05) rotate(1deg); }
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-section h1 {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .logo-section p {
            color: #64748b;
            font-size: 0.95rem;
        }
        
        .form-floating-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .form-floating-custom input {
            background: rgba(248, 250, 252, 0.8);
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-floating-custom input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
            background: white;
        }
        
        .form-floating-custom label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: #64748b;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        .form-floating-custom input:focus + label,
        .form-floating-custom input:not(:placeholder-shown) + label {
            top: -10px;
            left: 0.75rem;
            font-size: 0.75rem;
            color: var(--primary-color);
            background: white;
            padding: 0 0.5rem;
        }
        
        .btn-primary-custom {
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
        }
        
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .back-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-success-custom {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        
        .alert-danger-custom {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05));
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .icon-wrapper {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
            z-index: 1;
        }
        
        @media (max-width: 576px) {
            .login-container {
                margin: 1rem;
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="bg-animation"></div>
    
    <div class="login-container">
        <div class="logo-section">
            <h1><i class="fas fa-graduation-cap me-2"></i>Eduspace</h1>
            <p>Sistem Manajemen Sekolah Modern</p>
        </div>
        
        <!-- Session Status -->
        @if(session('status'))
            <div class="alert alert-success-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('errors'))
            <div class="alert alert-danger-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Terjadi kesalahan. Silakan periksa kembali data Anda.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="mb-4 text-center">
                <h5 class="fw-bold mb-3">Lupa Password?</h5>
                <p class="text-muted">Tidak masalah. Masukkan email Anda dan kami akan mengirimkan link reset password.</p>
            </div>
            
            <!-- Email Address -->
            <div class="form-floating-custom">
                <i class="fas fa-envelope icon-wrapper"></i>
                <input type="email" 
                       class="form-control" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder=" " 
                       required 
                       autofocus>
                <label for="email">Email Address</label>
                @error('email')
                    <div class="text-danger mt-2" style="font-size: 0.875rem;">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary-custom">
                <i class="fas fa-paper-plane me-2"></i>
                Kirim Link Reset Password
            </button>
        </form>
        
        <div class="back-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Login
            </a>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
