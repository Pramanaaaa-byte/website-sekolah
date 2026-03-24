<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\PiketController;
use App\Http\Controllers\IzinKeluarController;
use App\Http\Controllers\KeterlambatanController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\JadwalPiketController;
use App\Http\Controllers\QRScannerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Simple test routes
Route::get('/simple-test', function() {
    return 'Simple test works!';
});

Route::get('/session-check', function() {
    return session()->has('user')
        ? 'Session exists: ' . session('user')['name']
        : 'No session found';
});

Route::get('/auth-check', function() {
    return auth()->check()
        ? 'Authenticated as: ' . auth()->user()->name . ' (Role: ' . auth()->user()->role . ')'
        : 'Not authenticated';
});

Route::get('/siswa-test', function() {
    return view('siswa.create');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/test-route', fn() => 'Route test successful')->name('test.route');
    Route::get('/middleware-test', fn() => 'Middleware test successful')->middleware('role:admin');
    Route::get('/middleware-siswa', [SiswaController::class, 'create'])->middleware('role:admin');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ================= SISWA =================
    Route::get('siswa/create', [SiswaController::class, 'create'])->middleware('role:admin')->name('siswa.create');
    Route::post('siswa', [SiswaController::class, 'store'])->middleware('role:admin')->name('siswa.store');
    Route::resource('siswa', SiswaController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('siswa/{siswa}/edit', [SiswaController::class, 'edit'])->middleware('role:admin')->name('siswa.edit');
    Route::put('siswa/{siswa}', [SiswaController::class, 'update'])->middleware('role:admin')->name('siswa.update');
    Route::delete('siswa/{siswa}', [SiswaController::class, 'destroy'])->middleware('role:admin')->name('siswa.destroy');

    // ================= GURU =================
    Route::get('guru/create', [GuruController::class, 'create'])->middleware('role:admin,guru')->name('guru.create');
    Route::post('guru', [GuruController::class, 'store'])->middleware('role:admin,guru')->name('guru.store');
    Route::resource('guru', GuruController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('guru/{guru}/edit', [GuruController::class, 'edit'])->middleware('role:admin,guru')->name('guru.edit');
    Route::put('guru/{guru}', [GuruController::class, 'update'])->middleware('role:admin,guru')->name('guru.update');
    Route::delete('guru/{guru}', [GuruController::class, 'destroy'])->middleware('role:admin,guru')->name('guru.destroy');

    // ================= PIKET =================
    Route::get('piket/create', [PiketController::class, 'create'])->middleware('role:admin')->name('piket.create');
    Route::post('piket', [PiketController::class, 'store'])->middleware('role:admin')->name('piket.store');
    Route::resource('piket', PiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('piket/{piket}/edit', [PiketController::class, 'edit'])->middleware('role:admin')->name('piket.edit');
    Route::put('piket/{piket}', [PiketController::class, 'update'])->middleware('role:admin')->name('piket.update');
    Route::delete('piket/{piket}', [PiketController::class, 'destroy'])->middleware('role:admin')->name('piket.destroy');

    // ================= IZIN KELUAR =================
    Route::get('izin-keluar/create', [IzinKeluarController::class, 'create'])->middleware('role:admin,guru')->name('izin-keluar.create');
    Route::post('izin-keluar', [IzinKeluarController::class, 'store'])->middleware('role:admin,guru')->name('izin-keluar.store');
    Route::resource('izin-keluar', IzinKeluarController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('izin-keluar/{izinKeluar}/edit', [IzinKeluarController::class, 'edit'])->middleware('role:admin,guru')->name('izin-keluar.edit');
    Route::put('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'update'])->middleware('role:admin,guru')->name('izin-keluar.update');
    Route::delete('izin-keluar/{izinKeluar}', [IzinKeluarController::class, 'destroy'])->middleware('role:admin,guru')->name('izin-keluar.destroy');

    // ================= KETERLAMBATAN =================
    Route::get('keterlambatan/create', [KeterlambatanController::class, 'create'])->middleware('role:admin,guru')->name('keterlambatan.create');
    Route::post('keterlambatan', [KeterlambatanController::class, 'store'])->middleware('role:admin,guru')->name('keterlambatan.store');
    Route::resource('keterlambatan', KeterlambatanController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('keterlambatan/{keterlambatan}/edit', [KeterlambatanController::class, 'edit'])->middleware('role:admin,guru')->name('keterlambatan.edit');
    Route::put('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'update'])->middleware('role:admin,guru')->name('keterlambatan.update');
    Route::delete('keterlambatan/{keterlambatan}', [KeterlambatanController::class, 'destroy'])->middleware('role:admin,guru')->name('keterlambatan.destroy');

    // ================= PELANGGARAN =================
    Route::get('pelanggaran/create', [PelanggaranController::class, 'create'])->middleware('role:admin')->name('pelanggaran.create');
    Route::post('pelanggaran', [PelanggaranController::class, 'store'])->middleware('role:admin')->name('pelanggaran.store');
    Route::get('pelanggaran/rekap', [PelanggaranController::class, 'rekap'])->name('pelanggaran.rekap');
    Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('pelanggaran/{pelanggaran}/edit', [PelanggaranController::class, 'edit'])->middleware('role:admin')->name('pelanggaran.edit');
    Route::put('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'update'])->middleware('role:admin')->name('pelanggaran.update');
    Route::delete('pelanggaran/{pelanggaran}', [PelanggaranController::class, 'destroy'])->middleware('role:admin')->name('pelanggaran.destroy');

    // ================= JADWAL PIKET =================
    Route::get('jadwal-piket/create', [JadwalPiketController::class, 'create'])->middleware('role:admin,guru')->name('jadwal-piket.create');
    Route::post('jadwal-piket', [JadwalPiketController::class, 'store'])->middleware('role:admin,guru')->name('jadwal-piket.store');
    Route::get('jadwal-piket/hari-ini', [JadwalPiketController::class, 'getJadwalHariIni'])->name('jadwal-piket.hari-ini');
    Route::resource('jadwal-piket', JadwalPiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('jadwal-piket/{jadwalPiket}/edit', [JadwalPiketController::class, 'edit'])->middleware('role:admin,guru')->name('jadwal-piket.edit');
    Route::put('jadwal-piket/{jadwalPiket}', [JadwalPiketController::class, 'update'])->middleware('role:admin,guru')->name('jadwal-piket.update');
    Route::delete('jadwal-piket/{jadwalPiket}', [JadwalPiketController::class, 'destroy'])->middleware('role:admin,guru')->name('jadwal-piket.destroy');

    // ================= QR =================
    Route::post('/api/qr-scan', [QRScannerController::class, 'scan'])->middleware('role:admin,guru')->name('qr.scan');
    Route::get('/api/qr-generate/{siswa}', [QRScannerController::class, 'generateQr'])->middleware('role:admin,guru')->name('qr.generate');

    // ================= AUTH =================
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// logout fallback
Route::get('logout', function() {
    return redirect()->route('login')->with('message', 'Please use the logout button.');
})->name('logout.get');

// profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Temporary routes for testing (bypass middleware)
require __DIR__.'/temp_routes.php';

require __DIR__.'/auth.php';