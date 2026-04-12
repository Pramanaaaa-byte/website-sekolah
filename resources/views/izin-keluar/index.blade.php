@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #4e73df; font-weight: 700;">
                <i class="fas fa-door-open me-2"></i>
                Data Izin Keluar
            </h2>
            <p class="text-muted mb-0">Kelola dan monitor izin keluar siswa</p>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
            <a href="{{ route('izin-keluar.create') }}" class="btn btn-primary" style="border-radius: 10px; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #4e73df, #224abe); border: none;">
                <i class="fas fa-plus me-2"></i>
                Tambah Izin
            </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #4e73df, #224abe); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Total Izin</h6>
                            <h3 class="mb-0">{{ $izin->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #1cc88a, #17a673); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Disetujui</h6>
                            <h3 class="mb-0">{{ $izin->where('status', 'approved')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f6c23e, #dda20a); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Pending</h6>
                            <h3 class="mb-0">{{ $izin->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #e74a3b, #c0392b); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Ditolak</h6>
                            <h3 class="mb-0">{{ $izin->where('status', 'rejected')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="card mb-4" style="border-radius: 15px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; background: #4e73df; color: white; border: none;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari siswa atau alasan..." style="border-radius: 0 10px 10px 0; border-left: none; border-color: #e2e8f0;">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter" style="border-radius: 10px; border-color: #e2e8f0;">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="clearFilters()" style="border-radius: 10px; border-color: #e2e8f0;">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card" style="border-radius: 15px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
        <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                <i class="fas fa-list me-2" style="color: #4e73df;"></i>
                Daftar Izin Keluar
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="izinTable">
                    <thead>
                        <tr>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-user me-2"></i>Siswa
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-graduation-cap me-2"></i>Kelas
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Guru
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-comment me-2"></i>Alasan
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-sign-out-alt me-2"></i>Waktu Keluar
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-sign-in-alt me-2"></i>Waktu Kembali
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-info-circle me-2"></i>Status
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-cogs me-2"></i>Aksi
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
    
    <!-- Pagination -->
            <div class="mt-3">
                {{ $izin->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.hover-row:hover {
    background-color: rgba(78, 115, 223, 0.05) !important;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(78, 115, 223, 0.1);
    transition: all 0.3s ease;
}

.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 0.875rem;
    font-weight: 600;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #4e73df, #224abe);
    border-color: #4e73df;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
}

.btn-outline-danger:hover {
    background: linear-gradient(135deg, #e74a3b, #c0392b);
    border-color: #e74a3b;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(231, 74, 59, 0.3);
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.badge {
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 20px;
}

.table th {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    position: sticky;
    top: 0;
    z-index: 10;
}

.pagination .page-link {
    color: #4e73df;
    border: 1px solid #dee2e6;
    margin: 0 2px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4e73df, #224abe);
    border-color: #4e73df;
}

.pagination .page-link:hover {
    color: #224abe;
    background-color: rgba(78, 115, 223, 0.1);
    transform: translateY(-1px);
}
</style>

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
            const cells = row.getElementsByTagName('td');
            
            if (cells.length === 0) continue;
            
            let showRow = true;
            
            // Search filter
            if (searchTerm) {
                const siswaCell = cells[0].textContent.toLowerCase();
                const alasanCell = cells[3].textContent.toLowerCase();
                const guruCell = cells[2].textContent.toLowerCase();
                
                if (!siswaCell.includes(searchTerm) && 
                    !alasanCell.includes(searchTerm) && 
                    !guruCell.includes(searchTerm)) {
                    showRow = false;
                }
            }
            
            // Status filter
            if (statusValue && showRow) {
                const statusCell = cells[6].textContent.toLowerCase();
                if (!statusCell.includes(statusValue.toLowerCase())) {
                    showRow = false;
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        }
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);

    // Add animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
        card.classList.add('fade-in');
    });
});

// Clear filters function
function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';
    
    const event = new Event('input');
    document.getElementById('searchInput').dispatchEvent(event);
}

// Add CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in {
        animation: fade-in 0.6s ease-out forwards;
    }
`;
document.head.appendChild(style);
</script>
@endsection
