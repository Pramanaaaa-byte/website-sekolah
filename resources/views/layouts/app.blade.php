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
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #aaabc5ff;
            --secondary-color: #727274ff;
            --accent-color: #717987ff;
            --success-color: #36dba4ff;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #f8fafc;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f1f5f9;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.75rem 1rem;
            margin: 0.2rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .sidebar .nav-link.active {
            background-color: var(--accent-color);
            color: white;
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        
        .stat-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        .btn-primary {
            background-color: var(--accent-color);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
        }
        
        .btn-primary:hover {
            background-color: #2563eb;
        }
        
        .table {
            background-color: white;
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .badge-pending {
            background-color: var(--warning-color);
            color: white;
        }
        
        .badge-approved {
            background-color: var(--success-color);
            color: white;
        }
        
        .badge-rejected {
            background-color: var(--danger-color);
            color: white;
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
            border-radius: 0.5rem;
            border: none;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
            <div class="container-fluid">
                <a href="/" class="navbar-brand text-decoration-none">
                    <h4 class="mb-0" style="color: var(--primary-color);">{{ config('app.name') }}</h4>
                </a>
                
                <div class="navbar-nav ms-auto">
                    <form method="POST" action="{{ route('logout') }}" class="d-flex">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Sidebar and Content -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 px-0">
                    <div class="sidebar p-3">
                        <nav class="nav flex-column">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEzIDJMMTMgOUgyMjEzTDIxLjUgMTAuNUwxMyAyMkgxMyAyWk0xMyAyTDkgNkw5IDE0SDEzTDIxLjUgMTAuNUwxMyAyWiIgZmlsbD0iI0ZGNjY2NiIvPgo8cGF0aCBkPSJNOSA2TDkgNkgxM0wxMyAyTDkgNlpNOSA2TDkgMTRIMTMxM0wxMyAyTDkgNloiIGZpbGw9IiM0Q0FGNTAiLz4KPHBhdGggZD0iTTEzIDlMMTMgMTZIMjIxM0wyMS41IDEwLjVMMTMgOVoiIGZpbGw9IiMzM0M0ODUiLz4KPC9zdmc+" alt="Dashboard" width="20" height="20" style="margin-right: 8px;"></i> Dashboard
                            </a>
                            
                            <div class="mt-3 mb-2 text-white-50 small">MASTER DATA</div>
                            
                            <a href="{{ route('siswa.index') }}" class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                                <i>👥</i> Siswa
                            </a>
                            
                            <a href="{{ route('guru.index') }}" class="nav-link {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                                <i>👨‍🏫</i> Guru
                            </a>
                            
                            <div class="mt-3 mb-2 text-white-50 small">TRANSAKSI</div>
                            
                            <a href="{{ route('piket.index') }}" class="nav-link {{ request()->routeIs('piket.*') ? 'active' : '' }}">
                                <i>📅</i> Jadwal Piket
                            </a>
                            
                            <a href="{{ route('izin-keluar.index') }}" class="nav-link {{ request()->routeIs('izin-keluar.*') ? 'active' : '' }}">
                                <i>🚪</i> Izin Keluar
                            </a>
                            
                            <a href="{{ route('keterlambatan.index') }}" class="nav-link {{ request()->routeIs('keterlambatan.*') ? 'active' : '' }}">
                                <i>⏰</i> Keterlambatan
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <main class="col-md-9 col-lg-10 px-4 py-4">
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
                </main>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
