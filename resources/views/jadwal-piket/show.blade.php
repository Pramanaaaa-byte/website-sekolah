@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-eye me-2"></i>Detail Jadwal Piket
        </h2>
        <a href="{{ route('jadwal-piket.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Guru:</strong></td>
                            <td>{{ $jadwalPiket->guru->nama }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jabatan:</strong></td>
                            <td>{{ $jadwalPiket->guru->jabatan }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hari:</strong></td>
                            <td>{{ $jadwalPiket->hari_indo }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Jam Mulai:</strong></td>
                            <td>{{ $jadwalPiket->jam_mulai->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jam Selesai:</strong></td>
                            <td>{{ $jadwalPiket->jam_selesai->format('H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($jadwalPiket->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Non-aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <hr>
            
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Semester:</strong></td>
                            <td>{{ $jadwalPiket->semester }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tahun Ajaran:</strong></td>
                            <td>{{ $jadwalPiket->tahun_ajaran }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Dibuat:</strong></td>
                            <td>{{ $jadwalPiket->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $jadwalPiket->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if(auth()->user()->role === 'admin')
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('jadwal-piket.edit', $jadwalPiket) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <form action="{{ route('jadwal-piket.destroy', $jadwalPiket) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus jadwal ini?')">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
