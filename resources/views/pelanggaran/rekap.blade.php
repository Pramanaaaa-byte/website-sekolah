@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Rekap Pelanggaran</h1>

    <div class="card">
        <div class="card-body">
            <table border="1" cellpadding="10" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Jumlah Pelanggaran</th>
                        <th>Total Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekap as $item)
                        <tr>
                            <td>{{ $item->siswa->nama ?? '-' }}</td>
                            <td>{{ $item->jumlah_pelanggaran }}</td>
                            <td>{{ $item->total_poin }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection        