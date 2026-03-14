@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-chart-bar me-2"></i>Rekapitulasi Pelanggaran
        </h2>
        <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Siswa</h6>
                            <h3 class="mb-0">{{ $rekap->count() }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Pelanggaran</h6>
                            <h3 class="mb-0">{{ $rekap->sum('jumlah_pelanggaran') }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Poin</h6>
                            <h3 class="mb-0">{{ $rekap->sum('total_poin') }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Rata-rata Poin</h6>
                            <h3 class="mb-0">{{ $rekap->count() > 0 ? number_format($rekap->sum('total_poin') / $rekap->count(), 1) : 0 }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jumlah Pelanggaran</th>
                            <th>Total Poin</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->siswa->nama ?? 'Tidak ada' }}</td>
                                <td>{{ $item->siswa->kelas ?? 'Tidak ada' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->jumlah_pelanggaran }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">{{ $item->total_poin }}</span>
                                </td>
                                <td>
                                    @if($item->total_poin >= 20)
                                        <span class="badge bg-danger">Sangat Buruk</span>
                                    @elseif($item->total_poin >= 10)
                                        <span class="badge bg-warning">Perlu Perhatian</span>
                                    @elseif($item->total_poin >= 5)
                                        <span class="badge bg-info">Cukup Baik</span>
                                    @else
                                        <span class="badge bg-success">Baik</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
                            <h3>{{ $rekap->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Pelanggaran</h6>
                            <h3>{{ $rekap->sum('jumlah_pelanggaran') }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Poin</h6>
                            <h3>{{ $rekap->sum('total_poin') }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-star fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Rata-rata Poin</h6>
                            <h3>{{ round($rekap->avg('total_poin'), 1) }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jumlah Pelanggaran</th>
                            <th>Total Poin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekap as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>
                                <span class="badge bg-warning">{{ $item->jumlah_pelanggaran }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger">{{ $item->total_poin }} poin</span>
                            </td>
                            <td>
                                @if($item->total_poin >= 50)
                                    <span class="badge bg-danger">Sangat Buruk</span>
                                @elseif($item->total_poin >= 30)
                                    <span class="badge bg-warning">Buruk</span>
                                @elseif($item->total_poin >= 15)
                                    <span class="badge bg-info">Cukup</span>
                                @else
                                    <span class="badge bg-success">Baik</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pelanggaran.index') }}?siswa={{ $item->id_siswa }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data pelanggaran</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
