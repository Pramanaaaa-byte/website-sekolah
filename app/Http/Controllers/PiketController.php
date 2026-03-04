<?php
// app/Http/Controllers/PiketController.php

namespace App\Http\Controllers;

use App\Models\Piket;
use App\Models\Guru;
use Illuminate\Http\Request;

class PiketController extends Controller
{
    public function index()
    {
        $piket = Piket::with('guru')->latest()->paginate(10);
        return view('piket.index', compact('piket'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $guru = Guru::all();
        return view('piket.create', compact('guru'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'tanggal' => 'required|date'
        ]);

        Piket::create($request->all());

        return redirect()->route('piket.index')
            ->with('success', 'Jadwal piket berhasil ditambahkan.');
    }

    public function edit(Piket $piket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $guru = Guru::all();
        return view('piket.edit', compact('piket', 'guru'));
    }

    public function update(Request $request, Piket $piket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $request->validate([
            'id_guru' => 'required|exists:guru,id_guru',
            'tanggal' => 'required|date'
        ]);

        $piket->update($request->all());

        return redirect()->route('piket.index')
            ->with('success', 'Jadwal piket berhasil diperbarui.');
    }

    public function destroy(Piket $piket)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access');
        }
        $piket->delete();

        return redirect()->route('piket.index')
            ->with('success', 'Jadwal piket berhasil dihapus.');
    }
}
