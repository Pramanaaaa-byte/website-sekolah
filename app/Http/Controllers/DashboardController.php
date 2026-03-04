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
        $piketHariIni = Piket::whereDate('tanggal', today())->with('guru')->get();
        $izinPending = IzinKeluar::where('status', 'pending')->count();
        $keterlambatanHariIni = Keterlambatan::whereDate('waktu_datang', today())->count();
        
        $recentIzin = IzinKeluar::with(['siswa', 'guru'])
            ->latest()
            ->take(5)
            ->get();
            
        $recentTelat = Keterlambatan::with(['siswa', 'guru'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalSiswa', 
            'totalGuru', 
            'piketHariIni', 
            'izinPending',
            'keterlambatanHariIni',
            'recentIzin',
            'recentTelat'
        ));
    }
}
