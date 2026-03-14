<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST REKAP METHOD ===\n\n";

use App\Http\Controllers\PelanggaranController;
use App\Models\Pelanggaran;

// Check if method exists
$controller = new PelanggaranController();

if (method_exists($controller, 'rekap')) {
    echo "✓ rekap() method exists\n";
    
    // Test the method
    try {
        $view = $controller->rekap();
        echo "✓ rekap() method executed successfully\n";
        echo "View: " . get_class($view) . "\n";
    } catch (\Exception $e) {
        echo "✗ rekap() method failed: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . "\n";
        echo "Line: " . $e->getLine() . "\n";
    }
} else {
    echo "✗ rekap() method does not exist\n";
}

echo "\n=== DATABASE TEST ===\n";
try {
    $pelanggaran = Pelanggaran::with(['siswa'])
        ->selectRaw('
            id_siswa,
            siswa.nama,
            siswa.kelas,
            COUNT(*) as jumlah_pelanggaran,
            SUM(poin) as total_poin
        ')
        ->groupBy('id_siswa', 'siswa.nama', 'siswa.kelas')
        ->orderBy('total_poin', 'desc')
        ->get();
    
    echo "✓ Database query executed successfully\n";
    echo "Records found: " . $pelanggaran->count() . "\n";
    
    foreach ($pelanggaran as $row) {
        echo "  {$row->nama} ({$row->kelas}): {$row->jumlah_pelanggaran} pelanggaran, {$row->total_poin} poin\n";
    }
} catch (\Exception $e) {
    echo "✗ Database query failed: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
