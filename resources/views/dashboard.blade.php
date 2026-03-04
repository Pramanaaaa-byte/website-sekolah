@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1" style="color: var(--primary-color);">Dashboard</h2>
                <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}! 👋</p>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total Siswa</h6>
                                <h3 class="text-white mb-0">{{ $totalSiswa }}</h3>
                            </div>
                            <div class="display-4 text-white-50">👥</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Total Guru</h6>
                                <h3 class="text-white mb-0">{{ $totalGuru }}</h3>
                            </div>
                            <div class="display-4 text-white-50">👨‍🏫</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Izin Pending</h6>
                                <h3 class="text-white mb-0">{{ $izinPending }}</h3>
                            </div>
                            <div class="display-4 text-white-50">⏳</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">Telat Hari Ini</h6>
                                <h3 class="text-white mb-0">{{ $keterlambatanHariIni }}</h3>
                            </div>
                            <div class="display-4 text-white-50">⏰</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Piket Hari Ini -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0" style="color: var(--primary-color);">📅 Jadwal Piket Hari Ini</h5>
                    </div>
                    <div class="card-body">
                        @if($piketHariIni->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Guru</th>
                                            <th>Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($piketHariIni as $piket)
                                            <tr>
                                                <td>{{ $piket->guru->nama }}</td>
                                                <td>{{ $piket->guru->jabatan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Tidak ada jadwal piket hari ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0" style="color: var(--primary-color);">🚪 Izin Keluar Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if($recentIzin->count() > 0)
                            <div class="list-group">
                                @foreach($recentIzin as $izin)
                                    <div class="list-group-item border-0 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $izin->siswa->nama }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $izin->alasan }}</small>
                                            </div>
                                            <span class="badge @if($izin->status == 'pending') bg-warning @elseif($izin->status == 'approved') bg-success @elseif($izin->status == 'rejected') bg-danger @elseif($izin->status == 'completed') bg-primary @endif text-white">
                                                {{ $izin->status }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada izin keluar.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0" style="color: var(--primary-color);">⏰ Keterlambatan Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if($recentTelat->count() > 0)
                            <div class="list-group">
                                @foreach($recentTelat as $telat)
                                    <div class="list-group-item border-0 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $telat->siswa->nama }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    {{ $telat->waktu_datang->format('H:i') }} WIB
                                                </small>
                                            </div>
                                            <small class="text-muted">
                                                {{ $telat->waktu_datang->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada keterlambatan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
