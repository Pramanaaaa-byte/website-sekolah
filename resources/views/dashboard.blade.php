@extends('layouts.app')

@section('content')
    <div class="py-4">
        <!-- Welcome Section -->
        <div class="welcome-section mb-4">
            <div class="welcome-content">
                <h2 class="welcome-title">
                    <i class="fas fa-home me-2"></i>Dashboard
                </h2>
                <p class="welcome-subtitle">Selamat datang kembali, <span class="user-highlight">{{ Auth::user()->name }}</span>! 👋</p>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stat-card modern-stat">
                    <div class="card-body">
                        <div class="stat-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="stat-content">
                            <h6 class="stat-label">Total Siswa</h6>
                            <h3 class="stat-value">{{ $totalSiswa }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stat-card modern-stat">
                    <div class="card-body">
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-content">
                            <h6 class="stat-label">Total Guru</h6>
                            <h3 class="stat-value">{{ $totalGuru }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stat-card modern-stat">
                    <div class="card-body">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-content">
                            <h6 class="stat-label">Jadwal Piket</h6>
                            <h3 class="stat-value">{{ $totalPiket }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stat-card modern-stat">
                    <div class="card-body">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h6 class="stat-label">Keterlambatan</h6>
                            <h3 class="stat-value">{{ $totalKeterlambatan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- WhatsApp Contact Card -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card whatsapp-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="whatsapp-icon me-3">
                                    <i class="fab fa-whatsapp fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">Hubungi Admin</h5>
                                    <p class="card-text text-muted mb-0">Butuh bantuan? Hubungi kami via WhatsApp</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="mb-2"><strong>No. WhatsApp:</strong></p>
                                <a href="https://wa.me/628123456789" target="_blank" class="btn btn-success btn-lg">
                                    <i class="fab fa-whatsapp me-2"></i>+62 812-3456-789
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="row">
            <div class="col-md-6">
                <div class="card activity-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-door-open me-2"></i>Izin Keluar Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($recentIzin->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Siswa</th>
                                            <th>Alasan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentIzin as $izin)
                                            <tr>
                                                <td>{{ $izin->siswa->nama }}</td>
                                                <td>{{ Str::limit($izin->alasan, 30) }}</td>
                                                <td>
                                                    @if($izin->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($izin->status == 'approved')
                                                        <span class="badge bg-success">Disetujui</span>
                                                    @elseif($izin->status == 'rejected')
                                                        <span class="badge bg-danger">Ditolak</span>
                                                    @else
                                                        <span class="badge bg-primary">Selesai</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data izin keluar</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card activity-card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>Keterlambatan Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($recentKeterlambatan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Siswa</th>
                                            <th>Waktu</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentKeterlambatan as $keterlambatan)
                                            <tr>
                                                <td>{{ $keterlambatan->siswa->nama }}</td>
                                                <td>{{ $keterlambatan->waktu_datang->format('d/m H:i') }}</td>
                                                <td>{{ $keterlambatan->keterangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data keterlambatan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
