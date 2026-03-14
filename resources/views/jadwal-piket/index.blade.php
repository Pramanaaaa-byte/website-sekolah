@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-calendar-alt me-2"></i>Jadwal Piket Guru
        </h2>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('jadwal-piket.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Jadwal
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            @forelse($jadwalPiket as $guruId => $jadwalList)
            <div class="mb-4">
                <h5 class="text-primary mb-3">
                    <i class="fas fa-chalkboard-teacher me-2"></i>{{ $jadwalList->first()->guru->nama }}
                </h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jadwalList as $jadwal)
                            <tr>
                                <td>{{ $jadwal->hari_indo }}</td>
                                <td>{{ $jadwal->jam_mulai->format('H:i') }}</td>
                                <td>{{ $jadwal->jam_selesai->format('H:i') }}</td>
                                <td>{{ $jadwal->semester }}</td>
                                <td>{{ $jadwal->tahun_ajaran }}</td>
                                <td>
                                    @if($jadwal->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Non-aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('jadwal-piket.show', $jadwal) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('jadwal-piket.edit', $jadwal) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('jadwal-piket.destroy', $jadwal) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus jadwal ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada jadwal piket</p>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('jadwal-piket.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Jadwal Pertama
                </a>
                @endif
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
