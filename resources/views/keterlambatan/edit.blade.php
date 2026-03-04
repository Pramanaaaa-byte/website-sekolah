@extends('layouts.app')

@section('content')
<div class="py-4">
    <h2 class="mb-4" style="color: var(--primary-color);">Edit Keterlambatan</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('keterlambatan.update', $keterlambatan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Siswa</label>
                    <input type="text" class="form-control" value="{{ $keterlambatan->siswa->nama }} ({{ $keterlambatan->siswa->kelas }})" readonly disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Guru Piket</label>
                    <input type="text" class="form-control" value="{{ $keterlambatan->guru->nama }}" readonly disabled>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Waktu Datang</label>
                    <input type="text" class="form-control" value="{{ $keterlambatan->waktu_datang->format('d/m/Y H:i') }}" readonly disabled>
                </div>
                
                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                              id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $keterlambatan->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('keterlambatan.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
