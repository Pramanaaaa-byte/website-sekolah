{{-- resources/views/siswa/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="color: var(--primary-color);">Data Siswa</h2>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                    + Tambah Siswa
                </a>
            @endif
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $s)
                                <tr>
                                    <td>{{ $s->nis }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>{{ $s->kelas }}</td>
                                    <td>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('siswa.edit', $s) }}" class="btn btn-sm btn-outline-primary">
                                                Edit
                                            </a>
                                            <form action="{{ route('siswa.destroy', $s) }}" method="POST" class="d-inline">
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
                    {{ $siswa->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
