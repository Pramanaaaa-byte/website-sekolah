<?php
// app/Http/Controllers/KeterlambatanController.php

namespace App\Http\Controllers;

use App\Models\Keterlambatan;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\Request;

class KeterlambatanController extends Controller
{
    public function index()
    {
        $keterlambatan = Keterlambatan::with(['siswa', 'guru'])->latest()->paginate(10);
        return view('keterlambatan.index', compact('keterlambatan'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('keterlambatan.create', compact('siswa', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_guru' => 'required|exists:guru,id_guru',
            'waktu_datang' => 'required|date',
            'keterangan' => 'nullable'
        ]);

        Keterlambatan::create($request->all());

        return redirect()->route('keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil ditambahkan.');
    }

    public function edit(Keterlambatan $keterlambatan)
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('keterlambatan.edit', compact('keterlambatan', 'siswa', 'guru'));
    }

    public function update(Request $request, Keterlambatan $keterlambatan)
    {
        $request->validate([
            'keterangan' => 'nullable'
        ]);

        $keterlambatan->update($request->all());

        return redirect()->route('keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil diperbarui.');
    }

    public function show(Keterlambatan $keterlambatan)
    {
        $keterlambatan->load(['siswa', 'guru']);
        return view('keterlambatan.show', compact('keterlambatan'));
    }

    public function destroy(Keterlambatan $keterlambatan)
    {
        $keterlambatan->delete();

        return redirect()->route('keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil dihapus.');
    }

    public function laporan()
    {
        if (auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $keterlambatan = Keterlambatan::with(['siswa', 'guru'])->latest()->paginate(15);
        $totalKeterlambatan = Keterlambatan::count();
        $keterlambatanBulanIni = Keterlambatan::whereMonth('waktu_datang', now()->month)
            ->whereYear('waktu_datang', now()->year)
            ->count();
        $rerataDurasi = Keterlambatan::avg('durasi');
        
        return view('laporan.keterlambatan', compact('keterlambatan', 'totalKeterlambatan', 'keterlambatanBulanIni', 'rerataDurasi'));
    }
}
