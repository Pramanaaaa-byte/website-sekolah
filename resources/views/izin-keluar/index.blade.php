@extends('layouts.app')

@section('content')
<div class="py-4">
    <!-- User Info Card -->
    <div class="card mb-4" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color: white;">
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
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--primary-color);">Izin Keluar Siswa</h2>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
            <a href="{{ route('izin-keluar.create') }}" class="btn btn-primary">
                + Ajukan Izin
            </a>
        @endif
    </div>
    
    <div class="card">
        <div class="card-body p-0">
            <!-- Search and Filter Section -->
            <div class="p-3 border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Cari izin berdasarkan nama siswa atau alasan..." id="searchInput">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="text-end">
                            <small class="text-muted">Total: {{ $izin->count() }} izin</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modern Table -->
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="izinTable">
                    <thead class="table-primary">
                        <tr>
                            <th class="border-0 text-white">
                                <i class="fas fa-user me-2"></i>Siswa
                            </th>
                            <th class="border-0 text-white">
                                <i class="fas fa-graduation-cap me-2"></i>Kelas
                            </th>
                            <th class="border-0 text-white">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Guru
                            </th>
                            <th class="border-0 text-white">
                                <i class="fas fa-comment me-2"></i>Alasan
                            </th>
                            <th class="border-0 text-white">
                                <i class="fas fa-clock me-2"></i>Waktu Keluar
                            </th>
                            <th class="border-0 text-white">
                                <i class="fas fa-clock me-2"></i>Waktu Kembali
                            </th>
                            <th class="border-0 text-center text-white">
                                <i class="fas fa-info-circle me-2"></i>Status
                            </th>
                            <th class="border-0 text-center text-white">
                                <i class="fas fa-cog me-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($izin as $i)
                            <tr class="hover-row">
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <span class="text-white fw-bold">{{ strtoupper(substr($i->siswa->nama, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $i->siswa->nama }}</div>
                                            <small class="text-muted">NIS: {{ $i->siswa->nis }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span class="badge bg-secondary text-white">{{ $i->siswa->kelas }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-success rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <span class="text-white fw-bold" style="font-size: 0.75rem;">{{ strtoupper(substr($i->guru->nama, 0, 1)) }}</span>
                                        </div>
                                        <span>{{ $i->guru->nama }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span title="{{ $i->alasan }}">
                                        {{ \Illuminate\Support\Str::limit($i->alasan, 30) }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <small class="text-muted">{{ $i->waktu_keluar->format('d/m/Y H:i') }}</small>
                                </td>
                                <td class="align-middle">
                                    @if($i->waktu_kembali)
                                        <small class="text-muted">{{ $i->waktu_kembali->format('d/m/Y H:i') }}</small>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Kembali</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if($i->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($i->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($i->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $i->status }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('izin-keluar.edit', $i) }}" class="btn btn-sm btn-outline-primary btn-action">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('izin-keluar.destroy', $i) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Yakin ingin menghapus izin ini?')">
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
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Modern Pagination -->
            <div class="p-3 border-top bg-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="text-muted">
                            Menampilkan {{ $izin->firstItem() }} - {{ $izin->lastItem() }} dari {{ $izin->total() }} data
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            {{ $izin->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Custom CSS -->
    <style>
    .table-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .table-primary th {
        border: none !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
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
        border-radius: 0.375rem;
        transition: all 0.2s ease;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .avatar-sm {
        width: 40px;
        height: 40px;
        font-size: 0.875rem;
    }
    
    .input-group-text {
        border: none;
    }
    
    .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    .pagination .page-link {
        color: #4e73df;
        border: 1px solid #dee2e6;
        margin: 0 2px;
        border-radius: 0.375rem;
    }
    
    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-color: #4e73df;
    }
    
    .pagination .page-link:hover {
        color: #224abe;
        background-color: #f8f9fc;
    }
    </style>
    
    <!-- JavaScript for Search and Filter -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('izinTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const siswa = row.cells[0].textContent.toLowerCase();
                const alasan = row.cells[3].textContent.toLowerCase();
                const status = row.cells[6].textContent.toLowerCase();
                
                const matchesSearch = siswa.includes(searchTerm) || alasan.includes(searchTerm);
                const matchesStatus = statusValue === '' || status.includes(statusValue.toLowerCase());
                
                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
        
        searchInput.addEventListener('keyup', filterTable);
        statusFilter.addEventListener('change', filterTable);
    });
    </script>
</div>
@endsection
