@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: #64748b;">Detail Siswa</h2>
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary" style="background: linear-gradient(135deg, #64748b, #94a3b8); border: 1px solid rgba(255, 255, 255, 0.2);"
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIS</label>
                            <p class="form-control-plaintext">{{ $siswa->nis }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama</label>
                            <p class="form-control-plaintext">{{ $siswa->nama }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kelas</label>
                            <p class="form-control-plaintext">{{ $siswa->kelas }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jurusan</label>
                            <p class="form-control-plaintext">{{ $siswa->jurusan ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <p class="form-control-plaintext">{{ $siswa->jenis_kelamin ?? '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">QR Code</label>
                            <p class="form-control-plaintext">
                                @if($siswa->qr_code)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-warning">Belum Ada</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <form method="POST" action="{{ route('siswa.destroy', $siswa) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
