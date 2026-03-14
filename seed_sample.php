<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create sample guru data
use App\Models\Guru;
Guru::create(['nama' => 'Budi Santoso', 'jabatan' => 'Guru Produktif TKJ']);
Guru::create(['nama' => 'Siti Nurhaliza', 'jabatan' => 'Guru Matematika']);
Guru::create(['nama' => 'Ahmad Fauzi', 'jabatan' => 'Guru Bahasa Indonesia']);

// Create sample siswa data
use App\Models\Siswa;
Siswa::create(['nis' => '2023001', 'nama' => 'John Doe', 'kelas' => 'XI PPLG 2']);
Siswa::create(['nis' => '2023002', 'nama' => 'Jane Smith', 'kelas' => 'XI PPLG 2']);
Siswa::create(['nis' => '2023003', 'nama' => 'Bob Johnson', 'kelas' => 'XI PPLG 1']);

// Create sample jadwal piket
use App\Models\JadwalPiket;
$guru = Guru::first();
JadwalPiket::create([
    'id_guru' => $guru->id_guru,
    'hari' => 'Monday',
    'jam_mulai' => '07:00:00',
    'jam_selesai' => '15:00:00',
    'semester' => 'Ganjil',
    'tahun_ajaran' => 2026,
    'is_active' => true
]);

echo "Sample data created successfully!\n";
