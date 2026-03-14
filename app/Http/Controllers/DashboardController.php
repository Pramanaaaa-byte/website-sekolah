<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Piket;
use App\Models\IzinKeluar;
use App\Models\Keterlambatan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalPiket = Piket::count();
        $totalKeterlambatan = Keterlambatan::count();
        
        $recentIzin = IzinKeluar::with(['siswa', 'guru'])
            ->latest()
            ->take(5)
            ->get();
            
        $recentKeterlambatan = Keterlambatan::with(['siswa', 'guru'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSiswa', 
            'totalGuru', 
            'totalPiket',
            'totalKeterlambatan',
            'recentIzin',
            'recentKeterlambatan'
        ));
    }
}
