<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TABLE STRUCTURE CHECK ===\n\n";

// Check siswa table structure
echo "SISWA TABLE:\n";
$siswaColumns = \DB::select('PRAGMA table_info(siswa)');
foreach ($siswaColumns as $col) {
    echo "  {$col->name} ({$col->type})\n";
}

echo "\nGURU TABLE:\n";
$guruColumns = \DB::select('PRAGMA table_info(guru)');
foreach ($guruColumns as $col) {
    echo "  {$col->name} ({$col->type})\n";
}

echo "\nPELANGGARAN TABLE:\n";
$pelanggaranColumns = \DB::select('PRAGMA table_info(pelanggaran)');
foreach ($pelanggaranColumns as $col) {
    echo "  {$col->name} ({$col->type})\n";
}

echo "\nJADWAL PIKET TABLE:\n";
$jadwalPiketColumns = \DB::select('PRAGMA table_info(jadwal_piket)');
foreach ($jadwalPiketColumns as $col) {
    echo "  {$col->name} ({$col->type})\n)";
}

echo "\n=== SAMPLE DATA ===\n";
echo "Siswa: " . \App\Models\Siswa::count() . " records\n";
echo "Guru: " . \App\Models\Guru::count() . " records\n";
echo "Pelanggaran: " . \App\Models\Pelanggaran::count() . " records\n";
echo "Jadwal Piket: " . \App\Models\JadwalPiket::count() . " records\n";

echo "\n=== FIRST RECORDS ===\n";
$firstSiswa = \App\Models\Siswa::first();
$firstGuru = \App\Models\Guru::first();

if ($firstSiswa) {
    echo "First Siswa:\n";
    echo "  id_siswa: {$firstSiswa->id_siswa}\n";
    echo "  nis: {$firstSiswa->nis}\n";
    echo "  nama: {$firstSiswa->nama}\n";
}

if ($firstGuru) {
    echo "\nFirst Guru:\n";
    echo "  id_guru: {$firstGuru->id_guru}\n";
    echo "  nama: {$firstGuru->nama}\n";
    echo "  jabatan: {$firstGuru->jabatan}\n";
}
