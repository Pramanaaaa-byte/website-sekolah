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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('keterlambatan.create', compact('siswa', 'guru'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $siswa = Siswa::all();
        $guru = Guru::all();
        return view('keterlambatan.edit', compact('keterlambatan', 'siswa', 'guru'));
    }

    public function update(Request $request, Keterlambatan $keterlambatan)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'keterangan' => 'nullable'
        ]);

        $keterlambatan->update($request->all());

        return redirect()->route('keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil diperbarui.');
    }

    public function destroy(Keterlambatan $keterlambatan)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $keterlambatan->delete();

        return redirect()->route('keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil dihapus.');
    }
}
