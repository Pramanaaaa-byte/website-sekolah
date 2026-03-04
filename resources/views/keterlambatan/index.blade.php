@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--primary-color);">Data Keterlambatan</h2>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('keterlambatan.create') }}" class="btn btn-primary">
                + Catat Keterlambatan
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
                            <th>Guru Piket</th>
                            <th>Waktu Datang</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keterlambatan as $k)
                            <tr>
                                <td>{{ $k->siswa->nama }}</td>
                                <td>{{ $k->siswa->kelas }}</td>
                                <td>{{ $k->guru->nama }}</td>
                                <td>{{ $k->waktu_datang->format('d/m/Y H:i') }}</td>
                                <td>{{ $k->keterangan ?? '-' }}</td>
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('keterlambatan.edit', $k) }}" class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('keterlambatan.destroy', $k) }}" method="POST" class="d-inline">
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
                {{ $keterlambatan->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
