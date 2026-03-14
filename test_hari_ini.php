<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST JADWAL HARI INI ===\n\n";

use App\Http\Controllers\JadwalPiketController;
use App\Models\JadwalPiket;

// Check if method exists
$controller = new JadwalPiketController();

if (method_exists($controller, 'getJadwalHariIni')) {
    echo "✓ getJadwalHariIni() method exists\n";
    
    // Test the method
    try {
        $view = $controller->getJadwalHariIni();
        echo "✓ getJadwalHariIni() method executed successfully\n";
        echo "View: " . get_class($view) . "\n";
    } catch (\Exception $e) {
        echo "✗ getJadwalHariIni() method failed: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . "\n";
        echo "Line: " . $e->getLine() . "\n";
    }
} else {
    echo "✗ getJadwalHariIni() method does not exist\n";
}

echo "\n=== DATABASE TEST ===\n";
try {
    $hariIni = now()->format('l');
    echo "Hari ini (English): $hariIni\n";
    
    $jadwalHariIni = JadwalPiket::with(['guru'])
        ->where('hari', $hariIni)
        ->where('is_active', true)
        ->get();
    
    echo "✓ Database query executed successfully\n";
    echo "Jadwal hari ini ditemukan: " . $jadwalHariIni->count() . " records\n";
    
    foreach ($jadwalHariIni as $jadwal) {
        echo "  - {$jadwal->guru->nama}: {$jadwal->jam_mulai} - {$jadwal->jam_selesai}\n";
    }
} catch (\Exception $e) {
    echo "✗ Database query failed: " . $e->getMessage() . "\n";
}

echo "\n=== ROUTE TEST ===\n";
if (Route::has('jadwal-piket.hari-ini')) {
    echo "✓ Route jadwal-piket.hari-ini exists\n";
    
    $route = app('router')->getRoutes()->getByName('jadwal-piket.hari-ini');
    if ($route) {
        echo "  URI: " . $route->uri() . "\n";
        echo "  Action: " . $route->getActionName() . "\n";
    }
} else {
    echo "✗ Route jadwal-piket.hari-ini not found\n";
}

echo "\n=== TEST COMPLETE ===\n";
