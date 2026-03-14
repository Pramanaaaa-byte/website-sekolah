@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: var(--primary-color);">Edit Pelanggaran</h2>
            <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pelanggaran.update', $pelanggaran) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_siswa" class="form-label">Siswa</label>
                                <select class="form-select @error('id_siswa') is-invalid @enderror" 
                                        id="id_siswa" name="id_siswa" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach(\App\Models\Siswa::all() as $siswa)
                                        <option value="{{ $siswa->id_siswa }}" 
                                                {{ old('id_siswa', $pelanggaran->id_siswa) == $siswa->id_siswa ? 'selected' : '' }}>
                                            {{ $siswa->nama }} ({{ $siswa->nis }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_siswa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                       id="tanggal" name="tanggal" value="{{ old('tanggal', $pelanggaran->tanggal->format('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_guru" class="form-label">Guru</label>
                                <select class="form-select @error('id_guru') is-invalid @enderror" 
                                        id="id_guru" name="id_guru" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach(\App\Models\Guru::all() as $guru)
                                        <option value="{{ $guru->id_guru }}" 
                                                {{ old('id_guru', $pelanggaran->id_guru) == $guru->id_guru ? 'selected' : '' }}>
                                            {{ $guru->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_guru')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="poin" class="form-label">Poin</label>
                                <input type="number" class="form-control @error('poin') is-invalid @enderror" 
                                       id="poin" name="poin" value="{{ old('poin', $pelanggaran->poin) }}" min="1" max="100" required>
                                @error('poin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                        <input type="text" class="form-control @error('jenis_pelanggaran') is-invalid @enderror" 
                               id="jenis_pelanggaran" name="jenis_pelanggaran" value="{{ old('jenis_pelanggaran', $pelanggaran->jenis_pelanggaran) }}" required>
                        @error('jenis_pelanggaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $pelanggaran->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="sanksi" class="form-label">Sanksi</label>
                        <textarea class="form-control @error('sanksi') is-invalid @enderror" 
                                  id="sanksi" name="sanksi" rows="3">{{ old('sanksi', $pelanggaran->sanksi) }}</textarea>
                        @error('sanksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
