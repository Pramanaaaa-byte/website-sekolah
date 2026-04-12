<?php
// app/Http/Controllers/IzinKeluarController.php

namespace App\Http\Controllers;

use App\Models\IzinKeluar;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\Request;

class IzinKeluarController extends Controller
{
    public function index()
    {
        $izin = IzinKeluar::with(['siswa', 'guru'])->latest()->paginate(10);
        return view('izin-keluar.index', compact('izin'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('izin-keluar.create', compact('siswa', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id_siswa',
            'id_guru' => 'required|exists:guru,id_guru',
            'alasan' => 'required',
            'waktu_keluar' => 'required|date'
        ]);

        IzinKeluar::create($request->all());

        return redirect()->route('izin-keluar.index')
            ->with('success', 'Izin keluar berhasil diajukan.');
    }

    public function edit(IzinKeluar $izinKeluar)
    {
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('izin-keluar.edit', compact('izinKeluar', 'siswa', 'guru'));
    }

    public function update(Request $request, IzinKeluar $izinKeluar)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'waktu_kembali' => 'nullable|date'
        ]);

        $izinKeluar->update($request->all());

        return redirect()->route('izin-keluar.index')
            ->with('success', 'Data izin keluar berhasil diperbarui.');
    }

    public function show(IzinKeluar $izinKeluar)
    {
        $izinKeluar->load(['siswa', 'guru']);
        return view('izin-keluar.show', compact('izinKeluar'));
    }

    public function destroy(IzinKeluar $izinKeluar)
    {
        $izinKeluar->delete();

        return redirect()->route('izin-keluar.index')
            ->with('success', 'Data izin keluar berhasil dihapus.');
    }

    public function laporan()
    {
        if (auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $izin = IzinKeluar::with(['siswa', 'guru'])->latest()->paginate(15);
        $totalIzin = IzinKeluar::count();
        $izinBulanIni = IzinKeluar::whereMonth('waktu_keluar', now()->month)
            ->whereYear('waktu_keluar', now()->year)
            ->count();
        $izinPerStatus = IzinKeluar::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();
        
        return view('laporan.izin', compact('izin', 'totalIzin', 'izinBulanIni', 'izinPerStatus'));
    }
}
