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
    Route::resource('siswa', SiswaController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('siswa/create', [SiswaController::class, 'create'])->middleware('role:admin')->name('siswa.create');
    Route::post('siswa', [SiswaController::class, 'store'])->middleware('role:admin')->name('siswa.store');
    Route::get('siswa/{siswa}/edit', [SiswaController::class, 'edit'])->middleware('role:admin')->name('siswa.edit');
    Route::put('siswa/{siswa}', [SiswaController::class, 'update'])->middleware('role:admin')->name('siswa.update');
    Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy'])->middleware('role:admin')->name('siswa.destroy');
    
    Route::resource('guru', GuruController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('guru/create', [GuruController::class, 'create'])->middleware('role:admin')->name('guru.create');
    Route::post('guru', [GuruController::class, 'store'])->middleware('role:admin')->name('guru.store');
    Route::get('guru/{guru}/edit', [GuruController::class, 'edit'])->middleware('role:admin')->name('guru.edit');
    Route::put('guru/{guru}', [GuruController::class, 'update'])->middleware('role:admin')->name('guru.update');
    Route::delete('guru/{guru}', [GuruController::class, 'destroy'])->middleware('role:admin')->name('guru.destroy');
    
    // Transaksi - Only admin can create, edit, delete
    Route::resource('piket', PiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('piket/create', [PiketController::class, 'create'])->middleware('role:admin')->name('piket.create');
    Route::post('piket', [PiketController::class, 'store'])->middleware('role:admin')->name('piket.store');
    Route::get('piket/{piket}/edit', [PiketController::class, 'edit'])->middleware('role:admin')->name('piket.edit');
    Route::put('piket/{piket}', [PiketController::class, 'update'])->middleware('role:admin')->name('piket.update');
    Route::delete('piket/{piket}', [PiketController::class, 'destroy'])->middleware('role:admin')->name('piket.destroy');
    
    Route::resource('izin-keluar', IzinKeluarController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('izin-keluar/create', [IzinKeluarController::class, 'create'])->middleware('role:admin')->name('izin-keluar.create');
    Route::post('izin-keluar', [IzinKeluarController::class, 'store'])->middleware('role:admin')->name('izin-keluar.store');
    Route::get('izin-keluar/{izinKeluar}/edit', [IzinKeluarController::class, 'edit'])->middleware('role:admin')->name('izin-keluar.edit');
    Route::put('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'update'])->middleware('role:admin')->name('izin-keluar.update');
    Route::delete('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'destroy'])->middleware('role:admin')->name('izin-keluar.destroy');
    
    Route::resource('keterlambatan', KeterlambatanController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('keterlambatan/create', [KeterlambatanController::class, 'create'])->middleware('role:admin')->name('keterlambatan.create');
    Route::post('keterlambatan', [KeterlambatanController::class, 'store'])->middleware('role:admin')->name('keterlambatan.store');
    Route::get('keterlambatan/{keterlambatan}/edit', [KeterlambatanController::class, 'edit'])->middleware('role:admin')->name('keterlambatan.edit');
    Route::put('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'update'])->middleware('role:admin')->name('keterlambatan.update');
    Route::delete('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'destroy'])->middleware('role:admin')->name('keterlambatan.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
