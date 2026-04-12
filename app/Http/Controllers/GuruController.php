<?php
// app/Http/Controllers/GuruController.php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::latest()->paginate(10);
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:50'
        ]);

        Guru::create($request->all());

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        // Allow admin to edit any teacher, or teacher to edit their own data
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized access');
        }
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        // Allow admin to update any teacher, or teacher to update their own data
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'guru') {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'nama' => 'required|max:100',
            'jabatan' => 'required|max:50'
        ]);

        $guru->update($request->all());

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    public function laporan()
    {
        if (auth()->user()->role !== 'kepsek') {
            abort(403, 'Unauthorized access');
        }
        
        $guru = Guru::latest()->paginate(15);
        $totalGuru = Guru::count();
        $totalPerJabatan = Guru::selectRaw('jabatan, COUNT(*) as total')
            ->groupBy('jabatan')
            ->get();
        
        return view('laporan.guru', compact('guru', 'totalGuru', 'totalPerJabatan'));
    }
}
