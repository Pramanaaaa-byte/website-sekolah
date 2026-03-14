@extends('layouts.app')

@section('content')
    <div class="py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: var(--primary-color);">Edit Jadwal Piket</h2>
            <a href="{{ route('jadwal-piket.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('jadwal-piket.update', $jadwalPiket) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_guru" class="form-label">Guru</label>
                                <select class="form-select @error('id_guru') is-invalid @enderror" 
                                        id="id_guru" name="id_guru" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach(\App\Models\Guru::all() as $guru)
                                        <option value="{{ $guru->id_guru }}" 
                                                {{ old('id_guru', $jadwalPiket->id_guru) == $guru->id_guru ? 'selected' : '' }}>
                                            {{ $guru->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_guru')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="hari" class="form-label">Hari</label>
                                <select class="form-select @error('hari') is-invalid @enderror" 
                                        id="hari" name="hari" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Monday" {{ old('hari', $jadwalPiket->hari) == 'Monday' ? 'selected' : '' }}>Senin</option>
                                    <option value="Tuesday" {{ old('hari', $jadwalPiket->hari) == 'Tuesday' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Wednesday" {{ old('hari', $jadwalPiket->hari) == 'Wednesday' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Thursday" {{ old('hari', $jadwalPiket->hari) == 'Thursday' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Friday" {{ old('hari', $jadwalPiket->hari) == 'Friday' ? 'selected' : '' }}>Jumat</option>
                                    <option value="Saturday" {{ old('hari', $jadwalPiket->hari) == 'Saturday' ? 'selected' : '' }}>Sabtu</option>
                                    <option value="Sunday" {{ old('hari', $jadwalPiket->hari) == 'Sunday' ? 'selected' : '' }}>Minggu</option>
                                </select>
                                @error('hari')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                       id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $jadwalPiket->jam_mulai) }}" required>
                                @error('jam_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                       id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $jadwalPiket->jam_selesai) }}" required>
                                @error('jam_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-select @error('semester') is-invalid @enderror" 
                                        id="semester" name="semester" required>
                                    <option value="Ganjil" {{ old('semester', $jadwalPiket->semester) == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="Genap" {{ old('semester', $jadwalPiket->semester) == 'Genap' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                <input type="number" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                                       id="tahun_ajaran" name="tahun_ajaran" value="{{ old('tahun_ajaran', $jadwalPiket->tahun_ajaran) }}" min="2020" max="2030" required>
                                @error('tahun_ajaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input @error('is_active') is-invalid @enderror" 
                                   type="checkbox" id="is_active" name="is_active" {{ old('is_active', $jadwalPiket->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ route('jadwal-piket.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
