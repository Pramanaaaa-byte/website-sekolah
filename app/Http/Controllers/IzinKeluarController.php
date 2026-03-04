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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('izin-keluar.create', compact('siswa', 'guru'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('izin-keluar.edit', compact('izinKeluar', 'siswa', 'guru'));
    }

    public function update(Request $request, IzinKeluar $izinKeluar)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'waktu_kembali' => 'nullable|date'
        ]);

        $izinKeluar->update($request->all());

        return redirect()->route('izin-keluar.index')
            ->with('success', 'Data izin keluar berhasil diperbarui.');
    }

    public function destroy(IzinKeluar $izinKeluar)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $izinKeluar->delete();

        return redirect()->route('izin-keluar.index')
            ->with('success', 'Data izin keluar berhasil dihapus.');
    }
}
