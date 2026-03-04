@extends('layouts.app')

@section('content')
<div class="py-4">
    <h2 class="mb-4" style="color: var(--primary-color);">Edit Jadwal Piket</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('piket.update', $piket) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="id_guru" class="form-label">Pilih Guru</label>
                    <select class="form-control @error('id_guru') is-invalid @enderror" 
                            id="id_guru" name="id_guru" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->id_guru }}" 
                                {{ old('id_guru', $piket->id_guru) == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama }} - {{ $g->jabatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_guru')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Piket</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                           id="tanggal" name="tanggal" value="{{ old('tanggal', $piket->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('piket.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
