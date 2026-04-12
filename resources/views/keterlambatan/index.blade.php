@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- User Info Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">
                        <i class="fas fa-user-circle me-2"></i>
                        {{ auth()->user()->name }}
                    </h5>
                    <p class="mb-0 opacity-75">
                        <i class="fas fa-briefcase me-1"></i>
                        @if(auth()->user()->role === 'admin')
                            Administrator
                        @elseif(auth()->user()->role === 'kepsek')
                            Kepala Sekolah
                        @else
                            Guru Piket
                        @endif
                    </p>
                </div>
                <div class="text-end">
                    <small class="opacity-75">Login Sebagai</small>
                    <div class="badge bg-white text-dark">
                        {{ strtoupper(auth()->user()->role) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #6366f1; font-weight: 700;">
                <i class="fas fa-clock me-2"></i>
                Data Keterlambatan
            </h2>
            <p class="text-muted mb-0">Kelola data keterlambatan siswa</p>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
            <a href="{{ route('keterlambatan.create') }}" class="btn btn-primary" style="border-radius: 10px; padding: 0.625rem 1.25rem;">
                <i class="fas fa-plus me-2"></i>
                Catat Keterlambatan
            </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Total Siswa Terlambat</h6>
                            <h3 class="mb-0">{{ $keterlambatan->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f093fb, #f5576c); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Rata-rata Keterlambatan</h6>
                            <h3 class="mb-0">{{ $keterlambatan->avg('durasi') ? number_format($keterlambatan->avg('durasi'), 1) : 0 }} menit</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #4facfe, #00f2fe); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Tertinggi Hari Ini</h6>
                            <h3 class="mb-0">{{ $keterlambatan->max('durasi') ?? 0 }} menit</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #43e97b, #38f9d7); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Bulan Ini</h6>
                            <h3 class="mb-0">{{ $keterlambatan->whereMonth('created_at', now()->month)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card" style="border-radius: 15px; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);">
        <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                        <i class="fas fa-table me-2" style="color: #6366f1;"></i>
                        Data Keterlambatan Siswa
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" style="background: #6366f1; color: white; border: none;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Cari siswa atau kelas..." id="searchInput" style="border-left: none;">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="keterlambatanTable">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">
                                <i class="fas fa-user me-2"></i>Siswa
                            </th>
                            <th class="border-0">
                                <i class="fas fa-graduation-cap me-2"></i>Kelas
                            </th>
                            <th class="border-0">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Guru Piket
                            </th>
                            <th class="border-0">
                                <i class="fas fa-clock me-2"></i>Waktu Datang
                            </th>
                            <th class="border-0">
                                <i class="fas fa-hourglass-half me-2"></i>Durasi
                            </th>
                            <th class="border-0">
                                <i class="fas fa-comment me-2"></i>Keterangan
                            </th>
                            <th class="border-0 text-center">
                                <i class="fas fa-cog me-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keterlambatan as $k)
                            <tr class="hover-row">
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-warning rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <span class="text-white fw-bold">{{ strtoupper(substr($k->siswa->nama, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $k->siswa->nama }}</div>
                                            <small class="text-muted">NIS: {{ $k->siswa->nis }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-info text-white">{{ $k->siswa->kelas }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <span class="text-white fw-bold" style="font-size: 0.75rem;">{{ strtoupper(substr($k->guru->nama, 0, 1)) }}</span>
                                        </div>
                                        <span>{{ $k->guru->nama }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <small class="text-muted">{{ $k->waktu_datang->format('d/m/Y H:i') }}</small>
                                </td>
                                <td class="align-middle">
                                    @if($k->durasi)
                                        <span class="badge bg-warning text-dark">{{ $k->durasi }} menit</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <span title="{{ $k->keterangan ?? 'Tidak ada keterangan' }}">
                                        {{ \Illuminate\Support\Str::limit($k->keterangan ?? 'Tidak ada keterangan', 25) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('keterlambatan.edit', $k) }}" class="btn btn-sm btn-outline-primary btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('keterlambatan.destroy', $k) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Yakin ingin menghapus data keterlambatan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-lock me-1"></i>Tidak ada akses
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5 class="mb-2">Tidak ada data keterlambatan</h5>
                                        <p class="mb-0">Belum ada data keterlambatan yang tercatat</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light border-0 py-3" style="border-radius: 0 0 15px 15px;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="text-muted">
                        Menampilkan {{ $keterlambatan->firstItem() ?? 0 }} - {{ $keterlambatan->lastItem() ?? 0 }} dari {{ $keterlambatan->total() }} data
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {{ $keterlambatan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Custom CSS -->
    <style>
    .table-light {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
    }
    
    .table-light th {
        border: none !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        color: #495057;
    }
    
    .hover-row {
        transition: all 0.3s ease;
    }
    
    .hover-row:hover {
        background-color: #f8f9fc !important;
        transform: translateX(2px);
    }
    
    .btn-action {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 0.875rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .input-group-text {
        border: none;
    }
    
    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    }
    
    .pagination .page-link {
        color: #6366f1;
        border: 1px solid #dee2e6;
        margin: 0 2px;
        border-radius: 8px;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-color: #6366f1;
    }
    
    .pagination .page-link:hover {
        color: #8b5cf6;
        background-color: #f8f9fc;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
    }
    </style>
    
    <!-- JavaScript for Search -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('keterlambatanTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
        
        searchInput.addEventListener('keyup', filterTable);
    });
    </script>
</div>
@endsection
