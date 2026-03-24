@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: var(--primary-color);">Detail Keterlambatan</h2>
            <a href="{{ route('keterlambatan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Siswa</label>
                            <p class="form-control-plaintext">{{ $keterlambatan->siswa->nama }} ({{ $keterlambatan->siswa->nis }})</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Guru</label>
                            <p class="form-control-plaintext">{{ $keterlambatan->guru->nama }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Waktu Datang</label>
                            <p class="form-control-plaintext">{{ $keterlambatan->waktu_datang }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan</label>
                            <p class="form-control-plaintext">{{ $keterlambatan->keterangan ?: '-' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dibuat</label>
                            <p class="form-control-plaintext">{{ $keterlambatan->created_at->format('d M Y H:i') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="form-control-plaintext">
                                <span class="badge bg-warning">Terlambat</span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('keterlambatan.edit', $keterlambatan) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
