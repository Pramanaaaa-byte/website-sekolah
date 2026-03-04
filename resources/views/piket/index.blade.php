@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--primary-color);">Jadwal Piket Guru</h2>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('piket.create') }}" class="btn btn-primary">
                + Tambah Jadwal
            </a>
        @endif
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Guru</th>
                            <th>Jabatan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($piket as $p)
                            <tr>
                                <td>{{ $p->guru->nama }}</td>
                                <td>{{ $p->guru->jabatan }}</td>
                                <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('piket.edit', $p) }}" class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('piket.destroy', $p) }}" method="POST" class="d-inline">
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
                {{ $piket->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
