{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Eduspace') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #ec4899;
            --sidebar-bg: #1e293b;
            --sidebar-text: #f1f5f9;
            --sidebar-hover: #334155;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            height: 60px;
            transition: all 0.2s ease;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            border-radius: 0;
            box-shadow: var(--card-shadow);
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            overflow-y: auto;
            z-index: 1030;
            transition: transform 0.3s ease, opacity 0.3s ease;
            will-change: transform;
        }

        .sidebar-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            z-index: 1020;
            transition: transform 0.3s ease;
            will-change: transform;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 0.875rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 0.875rem 1rem;
            margin: 0.25rem 0;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            transform: translateX(4px);
            color: white;
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .sidebar .nav-link i {
            width: 24px;
            text-align: center;
            margin-right: 0.75rem;
            transition: transform 0.2s ease;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }

        .sidebar .text-white-50 {
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
        }

        main {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            margin: 1rem;
            margin-left: 300px;
            min-height: calc(100vh - 60px);
            overflow-y: auto;
            transition: margin-left 0.3s ease;
            will-change: margin-left;
        }

        .user-info {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 1rem;
            margin: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.2s ease;
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .user-name {
            color: white;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }

        .logout-btn {
            width: 100%;
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .logout-btn:hover::before {
            left: 100%;
        }

        .logout-btn:hover {
            background: rgba(220, 53, 69, 0.3);
            transform: translateY(-2px);
        }

        .min-h-screen {
            padding-top: 0;
        }

        /* Responsive Design - All Devices */
        @media (max-width: 768px) {
            .sidebar-container {
                transform: translateX(-100%);
            }

            .sidebar-container.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }

            main {
                margin-left: 0;
                border-radius: 0;
                margin: 0;
            }

            .d-flex {
                flex-direction: column;
            }

            .navbar {
                height: 60px;
                position: fixed;
                z-index: 1040;
            }

            .sidebar {
                width: 100%;
                max-width: 280px;
            }

            .navbar-toggler {
                border: none;
                padding: 0.25rem 0.5rem;
                font-size: 1.25rem;
                color: var(--primary-color);
            }

            .navbar-toggler:hover {
                color: var(--secondary-color);
            }

            .navbar-brand h4 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 992px) {
            .sidebar-container {
                width: 240px;
            }

            main {
                margin-left: 240px;
            }
        }

        @media (min-width: 1200px) {
            .sidebar-container {
                width: 300px;
            }

            main {
                margin-left: 300px;
            }
        }

        /* Tablet Specific */
        @media (min-width: 768px) and (max-width: 1024px) {
            .sidebar-container {
                width: 260px;
            }

            main {
                margin-left: 260px;
            }

            .sidebar .nav-link {
                padding: 0.75rem 0.875rem;
            }
        }

        /* Large Desktop */
        @media (min-width: 1400px) {
            .sidebar-container {
                width: 320px;
            }

            main {
                margin-left: 320px;
                max-width: calc(100vw - 320px);
            }
        }

        /* Ultra-wide screens */
        @media (min-width: 1920px) {
            .sidebar-container {
                width: 350px;
            }

            main {
                margin-left: 350px;
                max-width: calc(100vw - 350px);
            }
        }

        /* Navbar Section Inside Sidebar */
        .navbar-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .brand {
            color: white !important;
        }

        .brand h4 {
            color: white !important;
        }

        .navbar-toggler {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
        }
        * {
            box-sizing: border-box;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
            background: rgba(255, 255, 255, 0.98);
        }

        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(99, 102, 241, 0.3);
        }

        .table {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }

        }
        
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }
        
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .list-group-item {
            border: none;
            border-bottom: 1px solid #dee2e6;
        }
        
        .alert {
            border: none;
            border-radius: 0.5rem;
            backdrop-filter: blur(10px);
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        
        .table th {
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .card-header h5 {
            font-size: 1rem;
            font-weight: 600;
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <!-- CSRF Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        <!-- Integrated Sidebar with Navbar -->
        <aside class="sidebar-container">
            <div class="sidebar">
                <!-- Navbar Section Inside Sidebar -->
                <div class="navbar-section">
                    <div class="d-flex align-items-center justify-content-between px-4 py-3">
                        <!-- Mobile Menu Toggle -->
                        <button class="navbar-toggler d-md-none" type="button" id="mobileMenuToggle">
                            <i class="fas fa-bars text-white"></i>
                        </button>
                        
                        <!-- Brand -->
                        <a href="/" class="brand text-decoration-none d-flex align-items-center">
                            <i class="fas fa-home me-2 text-white" style="font-size: 1.5rem;"></i>
                            <h4 class="mb-0 text-white" style="font-weight: 700;">Selamat Datang</h4>
                        </a>
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="user-info">
                    <div class="user-name">
                        <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name }}
                    </div>
                    <div class="user-role">
                        @if(auth()->user()->role === 'admin')
                            Administrator
                        @elseif(auth()->user()->role === 'kepsek')
                            Kepala Sekolah
                        @else
                            Guru Piket
                        @endif
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="nav flex-column p-3">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                    
                    <div class="mt-3 mb-2 text-white-50 small">DATA MASTER</div>
                    
                    <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Siswa
                    </a>
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('siswa.create') }}" class="nav-link {{ request()->routeIs('siswa.create') ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                    @endif
                    
                    <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i> Guru
                    </a>
                    
                    <div class="mt-3 mb-2 text-white-50 small">TRANSAKSI</div>
                    
                    <a href="{{ route('piket.index') }}" class="nav-link {{ request()->routeIs('piket.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i> Jadwal Piket
                    </a>
                    
                    <a href="{{ route('izin-keluar.index') }}" class="nav-link {{ request()->routeIs('izin-keluar.*') ? 'active' : '' }}">
                        <i class="fas fa-door-open"></i> Izin Keluar
                    </a>
                    
                    <a href="{{ route('keterlambatan.index') }}" class="nav-link {{ request()->routeIs('keterlambatan.*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Keterlambatan
                    </a>
                    
                    <div class="mt-3 mb-2 text-white-50 small">PELAJARAN</div>
                    
                    <a href="{{ route('pelanggaran.index') }}" class="nav-link {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}">
                        <i class="fas fa-exclamation-triangle"></i> Pelanggaran
                    </a>
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('pelanggaran.create') }}" class="nav-link {{ request()->routeIs('pelanggaran.create') ? 'active' : '' }}">
                            <i class="fas fa-plus"></i> Tambah Pelanggaran
                        </a>
                    @endif
                    
                    <a href="{{ route('pelanggaran.rekap') }}" class="nav-link {{ request()->routeIs('pelanggaran.rekap') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> Rekap Pelanggaran
                    </a>
                    
                    <div class="mt-3 mb-2 text-white-50 small">JADWAL</div>
                    
                    <a href="{{ route('jadwal-piket.index') }}" class="nav-link {{ request()->routeIs('jadwal-piket.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Jadwal Piket
                    </a>
                    
                    <a href="{{ route('jadwal-piket.hari-ini') }}" class="nav-link {{ request()->routeIs('jadwal-piket.hari-ini') ? 'active' : '' }}">
                        <i class="fas fa-today"></i> Piket Hari Ini
                    </a>
                    
                    <div class="mt-3 mb-2 text-white-50 small">TOOLS</div>
                    
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
                        <a href="#" onclick="openQRScanner()" class="nav-link">
                            <i class="fas fa-qrcode"></i> QR Scanner
                        </a>
                    @endif
                </nav>
                
                <!-- Logout Button -->
                <div class="p-3">
                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

            <!-- Main Content -->
            <main class="flex-grow-1 fade-in">
                <div class="container-fluid p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @yield('content')
                    {{ $slot ?? '' }}
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- QR Scanner Modal -->
    <div class="modal fade" id="qrScannerModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-qrcode me-2"></i>QR Code Scanner
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-4">
                        <div id="qr-reader" style="width: 100%;"></div>
                        <div id="qr-reader-results"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Performance optimizations
        let qrModal;
        let isProcessing = false;

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Preload modal
            qrModal = new bootstrap.Modal(document.getElementById('qrScannerModal'));
            
            // Optimize scroll performance
            let ticking = false;
            function updateScroll() {
                if (!ticking) {
                    requestAnimationFrame(function() {
                        // Scroll handling code here if needed
                        ticking = false;
                    });
                    ticking = true;
                }
            }
            window.addEventListener('scroll', updateScroll, { passive: true });
            
            // Mobile menu toggle
            setupMobileMenu();
        });

        function setupMobileMenu() {
            const sidebar = document.querySelector('.sidebar-container');
            const toggleBtn = document.getElementById('mobileMenuToggle');
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            overlay.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1025;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            `;
            document.body.appendChild(overlay);
            
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
            }
            
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
            
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('show');
                        overlay.classList.remove('show');
                    }
                }, 250);
            });
        }

        function openQRScanner() {
            if (isProcessing) return;
            
            qrModal.show();
            
            // Initialize QR Scanner immediately
            setTimeout(() => {
                const qrReader = document.getElementById('qr-reader');
                qrReader.innerHTML = `
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        QR Scanner akan segera tersedia. Silakan input manual QR Code data untuk testing.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">QR Code Data (Base64)</label>
                        <textarea class="form-control" id="qrManualInput" rows="3" 
                            placeholder="Masukkan QR Code data..."></textarea>
                    </div>
                    <button class="btn btn-primary" onclick="processQRData()">
                        <i class="fas fa-search me-2"></i>Scan Data
                    </button>
                `;
                
                // Focus on input immediately
                document.getElementById('qrManualInput').focus();
            }, 100);
        }
        
        function processQRData() {
            if (isProcessing) return;
            isProcessing = true;
            
            const qrData = document.getElementById('qrManualInput').value;
            if (!qrData) {
                alert('Silakan masukkan QR Code data');
                isProcessing = false;
                return;
            }
            
            // Show loading state
            const resultsDiv = document.getElementById('qr-reader-results');
            resultsDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Processing...</p></div>';
            
            // Use fetch with timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000);
            
            fetch('/api/qr-scan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ qr_data: qrData }),
                signal: controller.signal
            })
            .then(response => {
                clearTimeout(timeoutId);
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    resultsDiv.innerHTML = `
                        <div class="alert alert-success fade-in">
                            <h6><i class="fas fa-check-circle me-2"></i>Siswa Ditemukan!</h6>
                            <p><strong>Nama:</strong> ${data.data.nama}</p>
                            <p><strong>NIS:</strong> ${data.data.nis}</p>
                            <p><strong>Kelas:</strong> ${data.data.kelas}</p>
                            <p><strong>Total Poin:</strong> ${data.data.total_poin}</p>
                        </div>
                    `;
                    
                    // Auto-close modal after 2 seconds
                    setTimeout(() => {
                        qrModal.hide();
                        document.getElementById('qrManualInput').value = '';
                        document.getElementById('qr-reader-results').innerHTML = '';
                    }, 2000);
                } else {
                    resultsDiv.innerHTML = `
                        <div class="alert alert-danger fade-in">
                            <i class="fas fa-exclamation-triangle me-2"></i>${data.message}
                        </div>
                    `;
                }
            })
            .catch(error => {
                clearTimeout(timeoutId);
                console.error('Error:', error);
                resultsDiv.innerHTML = `
                    <div class="alert alert-danger fade-in">
                        <i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan saat memproses QR Code
                    </div>
                `;
            })
            .finally(() => {
                isProcessing = false;
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K for QR Scanner
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openQRScanner();
            }
            
            // Escape to close modal
            if (e.key === 'Escape' && qrModal._isShown) {
                qrModal.hide();
            }
        });

        // Optimize images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                if (!img.complete) {
                    img.loading = 'lazy';
                }
            });
        });
    </script>
</body>
</html>
