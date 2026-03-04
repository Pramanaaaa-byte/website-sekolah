<?php
// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\IzinKeluarController;
use App\Http\Controllers\KeterlambatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Master Data - Only admin can create, edit, delete
    Route::resource('siswa', SiswaController::class);
    Route::get('siswa/create', [SiswaController::class, 'create'])->middleware('role:admin')->name('siswa.create');
    Route::post('siswa', [SiswaController::class, 'store'])->middleware('role:admin');
    Route::get('siswa/{siswa}/edit', [SiswaController::class, 'edit'])->middleware('role:admin')->name('siswa.edit');
    Route::put('siswa/{siswa}', [SiswaController::class, 'update'])->middleware('role:admin');
    Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy'])->middleware('role:admin');
    
    Route::resource('guru', GuruController::class);
    Route::get('guru/create', [GuruController::class, 'create'])->middleware('role:admin')->name('guru.create');
    Route::post('guru', [GuruController::class, 'store'])->middleware('role:admin');
    Route::get('guru/{guru}/edit', [GuruController::class, 'edit'])->middleware('role:admin')->name('guru.edit');
    Route::put('guru/{guru}', [GuruController::class, 'update'])->middleware('role:admin');
    Route::delete('guru/{guru}', [GuruController::class, 'destroy'])->middleware('role:admin');
    
    // Transaksi - Only admin can create, edit, delete
    Route::resource('piket', PiketController::class);
    Route::get('piket/create', [PiketController::class, 'create'])->middleware('role:admin')->name('piket.create');
    Route::post('piket', [PiketController::class, 'store'])->middleware('role:admin');
    Route::get('piket/{piket}/edit', [PiketController::class, 'edit'])->middleware('role:admin')->name('piket.edit');
    Route::put('piket/{piket}', [PiketController::class, 'update'])->middleware('role:admin');
    Route::delete('piket/{piket}', [PiketController::class, 'destroy'])->middleware('role:admin');
    
    Route::resource('izin-keluar', IzinKeluarController::class);
    Route::get('izin-keluar/create', [IzinKeluarController::class, 'create'])->middleware('role:admin')->name('izin-keluar.create');
    Route::post('izin-keluar', [IzinKeluarController::class, 'store'])->middleware('role:admin');
    Route::get('izin-keluar/{izinKeluar}/edit', [IzinKeluarController::class, 'edit'])->middleware('role:admin')->name('izin-keluar.edit');
    Route::put('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'update'])->middleware('role:admin');
    Route::delete('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'destroy'])->middleware('role:admin');
    
    Route::resource('keterlambatan', KeterlambatanController::class);
    Route::get('keterlambatan/create', [KeterlambatanController::class, 'create'])->middleware('role:admin')->name('keterlambatan.create');
    Route::post('keterlambatan', [KeterlambatanController::class, 'store'])->middleware('role:admin');
    Route::get('keterlambatan/{keterlambatan}/edit', [KeterlambatanController::class, 'edit'])->middleware('role:admin')->name('keterlambatan.edit');
    Route::put('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'update'])->middleware('role:admin');
    Route::delete('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'destroy'])->middleware('role:admin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
