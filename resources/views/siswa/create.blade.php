{{-- resources/views/siswa/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="py-4">
        <h2 class="mb-4" style="color: var(--primary-color);">Tambah Siswa</h2>
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('siswa.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                               id="nis" name="nis" value="{{ old('nis') }}" required>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select name="kelas" id="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                            <option value="">Pilih Kelas</option>
                            <option value="X PPLG 1" {{ old('kelas') == 'X PPLG 1' ? 'selected' : '' }}>X PPLG 1</option>
                            <option value="X PPLG 2" {{ old('kelas') == 'X PPLG 2' ? 'selected' : '' }}>X PPLG 2</option>
                            <option value="X PPLG 3" {{ old('kelas') == 'X PPLG 3' ? 'selected' : '' }}>X PPLG 3</option>
                            <option value="XI PPLG 1" {{ old('kelas') == 'XI PPLG 1' ? 'selected' : '' }}>XI PPLG 1</option>
                            <option value="XI PPLG 2" {{ old('kelas') == 'XI PPLG 2' ? 'selected' : '' }}>XI PPLG 2</option>
                            <option value="XI PPLG 3" {{ old('kelas') == 'XI PPLG 3' ? 'selected' : '' }}>XI PPLG 3</option>
                            <option value="XII PPLG 1" {{ old('kelas') == 'XII PPLG 1' ? 'selected' : '' }}>XII PPLG 1</option>
                            <option value="XII PPLG 2" {{ old('kelas') == 'XII PPLG 2' ? 'selected' : '' }}>XII PPLG 2</option>
                            <option value="XII PPLG 3" {{ old('kelas') == 'XII PPLG 3' ? 'selected' : '' }}>XII PPLG 3</option>
                            <option value="X BCF 1" {{ old('kelas') == 'X BCF 1' ? 'selected' : '' }}>X BCF 1</option>
                            <option value="X BCF 2" {{ old('kelas') == 'X BCF 2' ? 'selected' : '' }}>X BCF 2</option>
                            <option value="XI BCF 1" {{ old('kelas') == 'XI BCF 1' ? 'selected' : '' }}>XI BCF 1</option>
                            <option value="XI BCF 2" {{ old('kelas') == 'XI BCF 2' ? 'selected' : '' }}>XI BCF 2</option>
                            <option value="XII BCF 1" {{ old('kelas') == 'XII BCF 1' ? 'selected' : '' }}>XII BCF 1</option>
                            <option value="XII BCF 2" {{ old('kelas') == 'XII BCF 2' ? 'selected' : '' }}>XII BCF 2</option>
                            <option value="X TPFL" {{ old('kelas') == 'X TPFL' ? 'selected' : '' }}>X TPFL</option>
                            <option value="XI TPFL 1" {{ old('kelas') == 'XI TPFL 1' ? 'selected' : '' }}>XI TPFL 1</option>
                            <option value="XI TPFL 2" {{ old('kelas') == 'XI TPFL 2' ? 'selected' : '' }}>XI TPFL 2</option>
                            <option value="XII TPFL" {{ old('kelas') == 'XII TPFL' ? 'selected' : '' }}>XII TPFL</option>
                            <option value="XI TPFL 1" {{ old('kelas') == 'XI TPFL 1' ? 'selected' : '' }}>XI TPFL 1</option>
                            <option value="XI TPFL 2" {{ old('kelas') == 'XI TPFL 2' ? 'selected' : '' }}>XI TPFL 2</option>
                            <option value="XII TPFL" {{ old('kelas') == 'XII TPFL' ? 'selected' : '' }}>XII TPFL</option>
                            <option value="X TO 1" {{ old('kelas') == 'X TO 1' ? 'selected' : '' }}>X TO 1</option>
                            <option value="X TO 2" {{ old('kelas') == 'X TO 2' ? 'selected' : '' }}>X TO 2</option>
                            <option value="XI TO 1" {{ old('kelas') == 'XI TO 1' ? 'selected' : '' }}>XI TO 1</option>
                            <option value="XI TO 2" {{ old('kelas') == 'XI TO 2' ? 'selected' : '' }}>XI TO 2</option>
                            <option value="XII TO" {{ old('kelas') == 'XII TO' ? 'selected' : '' }}>XII TO</option>
                        </select>
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                               id="jurusan" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: Teknik Informatika">
                        @error('jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
