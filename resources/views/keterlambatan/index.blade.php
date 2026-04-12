@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: #6366f1; font-weight: 700;">
                <i class="fas fa-clock me-2"></i>
                Data Keterlambatan
            </h2>
            <p class="text-muted mb-0">Kelola dan monitor keterlambatan siswa</p>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru')
            <a href="{{ route('keterlambatan.create') }}" class="btn btn-primary" style="border-radius: 10px; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); border: none;">
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
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Total Keterlambatan</h6>
                            <h3 class="mb-0">{{ $totalKeterlambatan ?? 0 }}</h3>
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
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Hari Ini</h6>
                            <h3 class="mb-0">{{ $keterlambatanHariIni ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #fa709a, #fee140); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-white bg-opacity-20 p-3">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Minggu Ini</h6>
                            <h3 class="mb-0">{{ $keterlambatanMingguIni ?? 0 }}</h3>
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
                            <h3 class="mb-0">{{ $keterlambatanBulanIni ?? 0 }}</h3>
                        </div>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius: 10px 0 0 10px; background: #6366f1; color: white; border: none;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari siswa, kelas, atau guru..." style="border-radius: 0 10px 10px 0; border-left: none; border-color: #e2e8f0;">
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filterDate" style="border-radius: 10px; border-color: #e2e8f0;">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="clearFilters()" style="border-radius: 10px; border-color: #e2e8f0;">
                        <i class="fas fa-redo me-2"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card" style="border-radius: 15px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);">
        <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
            <h5 class="mb-0" style="color: #1e293b; font-weight: 600;">
                <i class="fas fa-list me-2" style="color: #6366f1;"></i>
                Daftar Keterlambatan Siswa
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="keterlambatanTable">
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
                                <i class="fas fa-clock me-2"></i>Waktu Datang
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-hourglass-half me-2"></i>Durasi
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-comment me-2"></i>Keterangan
                            </th>
                            <th style="border-bottom: 2px solid #e2e8f0; color: #64748b; font-weight: 600;">
                                <i class="fas fa-cogs me-2"></i>Aksi
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
    
    <!-- Pagination -->
            <div class="mt-3">
                {{ $keterlambatan->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.hover-row:hover {
    background-color: rgba(99, 102, 241, 0.05) !important;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.1);
    transition: all 0.3s ease;
}

.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 0.875rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.form-control:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-color: #6366f1;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-outline-danger:hover {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border-color: #ef4444;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
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
    color: #6366f1;
    border: 1px solid #dee2e6;
    margin: 0 2px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-color: #6366f1;
}

.pagination .page-link:hover {
    color: #8b5cf6;
    background-color: rgba(99, 102, 241, 0.1);
    transform: translateY(-1px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterDate = document.getElementById('filterDate');
    const table = document.getElementById('keterlambatanTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterDateValue = filterDate.value;
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            
            if (cells.length === 0) continue;
            
            let showRow = true;
            
            // Search filter
            if (searchTerm) {
                const siswaCell = cells[0].textContent.toLowerCase();
                const kelasCell = cells[1].textContent.toLowerCase();
                const guruCell = cells[2].textContent.toLowerCase();
                const keteranganCell = cells[5].textContent.toLowerCase();
                
                if (!siswaCell.includes(searchTerm) && 
                    !kelasCell.includes(searchTerm) && 
                    !guruCell.includes(searchTerm) && 
                    !keteranganCell.includes(searchTerm)) {
                    showRow = false;
                }
            }
            
            // Date filter
            if (filterDateValue && showRow) {
                const waktuCell = cells[3].textContent.trim();
                // Extract date from text (format: "d/m/Y H:i")
                const dateMatch = waktuCell.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
                if (dateMatch) {
                    const [, day, month, year] = dateMatch;
                    const formattedDate = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                    if (formattedDate !== filterDateValue) {
                        showRow = false;
                    }
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        }
    }

    searchInput.addEventListener('input', filterTable);
    filterDate.addEventListener('change', filterTable);

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
    document.getElementById('filterDate').value = '';
    
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
