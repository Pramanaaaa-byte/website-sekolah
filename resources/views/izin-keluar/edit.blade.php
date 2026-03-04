@extends('layouts.app')

@section('content')
<div class="py-4">
    <h2 class="mb-4" style="color: var(--primary-color);">Edit Izin Keluar</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('izin-keluar.update', $izinKeluar) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Siswa</label>
                    <input type="text" class="form-control" value="{{ $izinKeluar->siswa->nama }} ({{ $izinKeluar->siswa->kelas }})" readonly disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Guru Piket</label>
                    <input type="text" class="form-control" value="{{ $izinKeluar->guru->nama }}" readonly disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Alasan</label>
                    <textarea class="form-control" rows="3" readonly disabled>{{ $izinKeluar->alasan }}</textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Waktu Keluar</label>
                    <input type="text" class="form-control" value="{{ $izinKeluar->waktu_keluar->format('d/m/Y H:i') }}" readonly disabled>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="pending" {{ old('status', $izinKeluar->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ old('status', $izinKeluar->status) == 'approved' ? 'selected' : '' }}>Setujui</option>
                        <option value="rejected" {{ old('status', $izinKeluar->status) == 'rejected' ? 'selected' : '' }}>Tolak</option>
                        <option value="completed" {{ old('status', $izinKeluar->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="waktu_kembali" class="form-label">Waktu Kembali</label>
                    <input type="datetime-local" class="form-control @error('waktu_kembali') is-invalid @enderror" 
                           id="waktu_kembali" name="waktu_kembali" 
                           value="{{ old('waktu_kembali', $izinKeluar->waktu_kembali ? $izinKeluar->waktu_kembali->format('Y-m-d\TH:i') : '') }}">
                    @error('waktu_kembali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kosongkan jika belum kembali</small>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('izin-keluar.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
