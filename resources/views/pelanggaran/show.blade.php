@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: var(--primary-color);">Detail Pelanggaran</h2>
            <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Siswa</label>
                            <p class="form-control-plaintext">{{ $pelanggaran->siswa->nama ?? 'Tidak ada' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIS</label>
                            <p class="form-control-plaintext">{{ $pelanggaran->siswa->nis ?? 'Tidak ada' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal</label>
                            <p class="form-control-plaintext">{{ $pelanggaran->tanggal->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Pelanggaran</label>
                            <p class="form-control-plaintext">{{ $pelanggaran->jenis_pelanggaran }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Poin</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-danger">{{ $pelanggaran->poin }}</span>
                            </p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Guru</label>
                            <p class="form-control-plaintext">{{ $pelanggaran->guru->nama ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan</label>
                    <p class="form-control-plaintext">{{ $pelanggaran->keterangan ?? 'Tidak ada keterangan' }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Sanksi</label>
                    <p class="form-control-plaintext">{{ $pelanggaran->sanksi ?? 'Tidak ada sanksi' }}</p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('pelanggaran.edit', $pelanggaran) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('pelanggaran.destroy', $pelanggaran) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data pelanggaran ini?')">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
