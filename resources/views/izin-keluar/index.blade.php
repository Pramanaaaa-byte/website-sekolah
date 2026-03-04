@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--primary-color);">Izin Keluar Siswa</h2>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('izin-keluar.create') }}" class="btn btn-primary">
                + Ajukan Izin
            </a>
        @endif
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th>Alasan</th>
                            <th>Waktu Keluar</th>
                            <th>Waktu Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($izin as $i)
                            <tr>
                                <td>{{ $i->siswa->nama }}</td>
                                <td>{{ $i->siswa->kelas }}</td>
                                <td>{{ $i->guru->nama }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($i->alasan, 30) }}</td>
                                <td>{{ $i->waktu_keluar->format('d/m/Y H:i') }}</td>
                                <td>{{ $i->waktu_kembali ? $i->waktu_kembali->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    @if($i->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($i->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($i->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-primary">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('izin-keluar.edit', $i) }}" class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('izin-keluar.destroy', $i) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $izin->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
