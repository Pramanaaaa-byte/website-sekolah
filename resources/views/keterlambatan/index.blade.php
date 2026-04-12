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
            <div class="stats-card fade-in" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; animation-delay: 0.1s;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon">
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
            <div class="stats-card fade-in" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; animation-delay: 0.2s;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon">
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
            <div class="stats-card fade-in" style="background: linear-gradient(135deg, #fa709a, #fee140); color: white; animation-delay: 0.3s;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon">
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
            <div class="stats-card fade-in" style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; animation-delay: 0.4s;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-white-50">Bulan Ini</h6>
                            <h3 class="mb-0">{{ $keterlambatanBulanIni ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">
                <i class="fas fa-filter me-2" style="color: var(--primary-color);"></i>
                Filter Data
            </h5>
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Cari siswa, kelas, atau guru..." style="border-left: none;">
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="filterDate" placeholder="Filter tanggal">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                        <i class="fas fa-redo me-2"></i>Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card fade-in">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0">
                <i class="fas fa-list me-2" style="color: var(--primary-color);"></i>
                Daftar Keterlambatan Siswa
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="keterlambatanTable">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-user me-2"></i>Siswa
                            </th>
                            <th>
                                <i class="fas fa-graduation-cap me-2"></i>Kelas
                            </th>
                            <th>
                                <i class="fas fa-chalkboard-teacher me-2"></i>Guru
                            </th>
                            <th>
                                <i class="fas fa-clock me-2"></i>Waktu Datang
                            </th>
                            <th>
                                <i class="fas fa-hourglass-half me-2"></i>Durasi
                            </th>
                            <th>
                                <i class="fas fa-comment me-2"></i>Keterangan
                            </th>
                            <th>
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
        </div>
    </div>

    <!-- Pagination -->
    <div class="card fade-in mt-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="text-muted">
                        <i class="fas fa-info-circle me-2"></i>
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
</div>

<style>
/* CSS Variables for Consistent Design */
:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --info-color: #3b82f6;
    --light-color: #f8fafc;
    --dark-color: #1e293b;
    --border-color: #e2e8f0;
    --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.12);
    --radius-sm: 8px;
    --radius-md: 10px;
    --radius-lg: 15px;
    --radius-xl: 20px;
}

/* Base Styles */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    min-height: 100vh;
}

/* Card Styles */
.card {
    border: none;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: white;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Stats Cards */
.stats-card {
    border-radius: var(--radius-lg);
    border: none;
    box-shadow: var(--shadow-sm);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: rgba(255, 255, 255, 0.3);
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stats-card .card-body {
    padding: 1.5rem;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.stats-card:hover .stats-icon {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.3);
}

/* Table Styles */
.table {
    margin-bottom: 0;
}

.table th {
    background: linear-gradient(135deg, var(--light-color), #f1f5f9);
    border: none;
    color: var(--dark-color);
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem;
    position: sticky;
    top: 0;
    z-index: 10;
    border-bottom: 2px solid var(--border-color);
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #f1f5f9;
}

.hover-row {
    transition: all 0.3s ease;
    position: relative;
}

.hover-row:hover {
    background-color: rgba(99, 102, 241, 0.03) !important;
    transform: scale(1.005);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
    z-index: 5;
}

.hover-row::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.hover-row:hover::before {
    opacity: 1;
}

/* Avatar Styles */
.avatar-sm {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
    color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.avatar-sm:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Badge Styles */
.badge {
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: var(--radius-xl);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Button Styles */
.btn {
    border-radius: var(--radius-md);
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    padding: 0.75rem 1.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    background: transparent;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-outline-danger {
    border: 2px solid var(--danger-color);
    color: var(--danger-color);
    background: transparent;
}

.btn-outline-danger:hover {
    background: linear-gradient(135deg, var(--danger-color), #dc2626);
    border-color: var(--danger-color);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-outline-secondary {
    border: 2px solid var(--border-color);
    color: #64748b;
    background: transparent;
}

.btn-outline-secondary:hover {
    background: #64748b;
    border-color: #64748b;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

/* Form Styles */
.form-control {
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    outline: none;
}

.form-select {
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
    outline: none;
}

.input-group-text {
    border: none;
    border-radius: var(--radius-md) 0 0 var(--radius-md);
    background: var(--primary-color);
    color: white;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

/* Pagination Styles */
.pagination .page-link {
    color: var(--primary-color);
    border: 1px solid var(--border-color);
    margin: 0 2px;
    border-radius: var(--radius-sm);
    transition: all 0.3s ease;
    padding: 0.5rem 1rem;
    font-weight: 500;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-color: var(--primary-color);
    color: white;
}

.pagination .page-link:hover {
    color: var(--secondary-color);
    background-color: rgba(99, 102, 241, 0.1);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.2);
}

/* Animation Classes */
@keyframes fadeIn {
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
    animation: fadeIn 0.6s ease-out forwards;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .table th,
    .table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.875rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .stats-card .card-body {
        padding: 1rem;
    }
    
    .stats-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
}

@media (max-width: 576px) {
    .table-responsive {
        border-radius: var(--radius-lg);
        overflow: hidden;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        margin-bottom: 0.25rem;
        border-radius: var(--radius-md) !important;
    }
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
