@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fas fa-plus me-2"></i>Tambah Pelanggaran
        </h2>
        <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pelanggaran.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="siswa" class="form-label">Siswa <span class="text-danger">*</span></label>
                            <select name="id_siswa" id="siswa" class="form-select" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                <option value="{{ $s->id_siswa }}">{{ $s->nama }} - {{ $s->kelas }}</option>
                                @endforeach
                            </select>
                            @error('id_siswa')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                   value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <select name="jenis_pelanggaran" id="jenis_pelanggaran" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Terlambat">Terlambat</option>
                                <option value="Tidak Masuk Tanpa Keterangan">Tidak Masuk Tanpa Keterangan</option>
                                <option value="Memakai Make Up">Memakai Make Up</option>
                                <option value="Tidak Memakai Seragam">Tidak Memakai Seragam</option>
                                <option value="Menggunakan HP di Kelas">Menggunakan HP di Kelas</option>
                                <option value="Bertengkar">Bertengkar</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('jenis_pelanggaran')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="poin" class="form-label">Poin Pelanggaran <span class="text-danger">*</span></label>
                            <input type="number" name="poin" id="poin" class="form-control" 
                                   min="0" max="100" value="{{ old('poin', 5) }}" required>
                            @error('poin')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="sanksi" class="form-label">Sanksi</label>
                    <textarea name="sanksi" id="sanksi" class="form-control" rows="3">{{ old('sanksi') }}</textarea>
                    @error('sanksi')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
