@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-today me-2"></i>Jadwal Piket Hari Ini
        </h2>
        <a href="{{ route('jadwal-piket.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Hari Ini:</strong> 
                @php
                    $hariIndo = [
                        'Monday' => 'Senin',
                        'Tuesday' => 'Selasa', 
                        'Wednesday' => 'Rabu',
                        'Thursday' => 'Kamis',
                        'Friday' => 'Jumat',
                        'Saturday' => 'Sabtu',
                        'Sunday' => 'Minggu'
                    ];
                    $hariInggris = now()->format('l');
                    $hariIni = $hariIndo[$hariInggris] ?? $hariInggris;
                @endphp
                {{ $hariIni }}, {{ now()->format('d F Y') }}
            </div>

            @forelse($jadwalHariIni as $jadwal)
            <div class="row">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-chalkboard-teacher me-2"></i>{{ $jadwal->guru->nama }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td><strong>Jabatan:</strong></td>
                                    <td>{{ $jadwal->guru->jabatan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jam:</strong></td>
                                    <td>{{ $jadwal->jam_mulai->format('H:i') }} - {{ $jadwal->jam_selesai->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Semester:</strong></td>
                                    <td>{{ $jadwal->semester }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-success">Aktif</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Informasi Kontak</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama Lengkap:</strong><br>{{ $jadwal->guru->nama }}</p>
                                    <p><strong>Jabatan:</strong><br>{{ $jadwal->guru->jabatan }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Jadwal:</strong><br>{{ $jadwal->hari_indo }}, {{ $jadwal->jam_mulai->format('H:i') }} - {{ $jadwal->jam_selesai->format('H:i') }}</p>
                                    <p><strong>Periode:</strong><br>{{ $jadwal->semester }} {{ $jadwal->tahun_ajaran }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Guru piket hari ini sedang bertugas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak Ada Jadwal Piket Hari Ini</h5>
                <p class="text-muted">Belum ada jadwal piket yang ditetapkan untuk hari ini</p>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('jadwal-piket.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Jadwal
                </a>
                @endif
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
