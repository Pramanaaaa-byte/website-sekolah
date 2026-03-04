@extends('layouts.app')

@section('content')
<div class="py-4">
    <h2 class="mb-4" style="color: var(--primary-color);">Ajukan Izin Keluar</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('izin-keluar.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="id_siswa" class="form-label">Pilih Siswa</label>
                    <select class="form-control @error('id_siswa') is-invalid @enderror" 
                            id="id_siswa" name="id_siswa" required>
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id_siswa }}" {{ old('id_siswa') == $s->id_siswa ? 'selected' : '' }}>
                                {{ $s->nis }} - {{ $s->nama }} ({{ $s->kelas }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_siswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="id_guru" class="form-label">Guru Piket</label>
                    <select class="form-control @error('id_guru') is-invalid @enderror" 
                            id="id_guru" name="id_guru" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama }} - {{ $g->jabatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_guru')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="alasan" class="form-label">Alasan</label>
                    <textarea class="form-control @error('alasan') is-invalid @enderror" 
                              id="alasan" name="alasan" rows="3" required>{{ old('alasan') }}</textarea>
                    @error('alasan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                    <input type="datetime-local" class="form-control @error('waktu_keluar') is-invalid @enderror" 
                           id="waktu_keluar" name="waktu_keluar" value="{{ old('waktu_keluar', now()->format('Y-m-d\TH:i')) }}" required>
                    @error('waktu_keluar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                    <a href="{{ route('izin-keluar.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
