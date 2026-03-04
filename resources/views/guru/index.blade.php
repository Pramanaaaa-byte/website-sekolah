@extends('layouts.app')

@section('content')
<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: var(--primary-color);">Data Guru</h2>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('guru.create') }}" class="btn btn-primary">
                + Tambah Guru
            </a>
        @endif
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guru as $g)
                            <tr>
                                <td>{{ $g->nama }}</td>
                                <td>{{ $g->jabatan }}</td>
                                <td>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('guru.edit', $g) }}" class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route('guru.destroy', $g) }}" method="POST" class="d-inline">
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
                {{ $guru->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
