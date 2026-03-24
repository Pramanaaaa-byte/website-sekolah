<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING JADWAL PIKET FOREIGN KEY ===\n\n";

use App\Models\Guru;
use App\Models\JadwalPiket;

// Check if guru data exists
echo "Checking Guru data:\n";
echo "====================\n";
$guruList = Guru::all();
foreach ($guruList as $guru) {
    echo "✓ ID: {$guru->id_guru}, Nama: {$guru->nama}, Jabatan: {$guru->jabatan}\n";
}

echo "\nTesting JadwalPiket creation:\n";
echo "=============================\n";

try {
    // Test creating a jadwal piket record
    $jadwal = JadwalPiket::create([
        'id_guru' => 1,
        'hari' => 'Monday',
        'jam_mulai' => '06:30:00',
        'jam_selesai' => '15:00:00',
        'semester' => 'Ganjil',
        'tahun_ajaran' => 2026,
        'is_active' => true,
    ]);
    
    echo "✓ JadwalPiket created successfully!\n";
    echo "  ID: {$jadwal->id}\n";
    echo "  Guru: {$jadwal->guru->nama}\n";
    echo "  Hari: {$jadwal->hari}\n";
    
    // Clean up
    $jadwal->delete();
    echo "✓ Test record deleted\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== CHECKING FOREIGN KEY CONSTRAINT ===\n";

// Test with invalid guru ID
try {
    $invalidJadwal = JadwalPiket::create([
        'id_guru' => 999, // Non-existent guru ID
        'hari' => 'Tuesday',
        'jam_mulai' => '07:00:00',
        'jam_selesai' => '14:00:00',
        'semester' => 'Ganjil',
        'tahun_ajaran' => 2026,
        'is_active' => true,
    ]);
    
    echo "✗ Foreign key constraint not working - invalid ID was accepted!\n";
    $invalidJadwal->delete();
    
} catch (\Exception $e) {
    echo "✓ Foreign key constraint working - invalid ID rejected\n";
}

echo "\n=== TEST COMPLETE ===\n";
