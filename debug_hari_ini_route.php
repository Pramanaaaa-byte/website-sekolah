<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG JADWAL HARI INI ROUTE ===\n\n";

// Test route existence
if (Route::has('jadwal-piket.hari-ini')) {
    echo "✓ Route jadwal-piket.hari-ini exists\n";
    
    // Get route details
    $route = app('router')->getRoutes()->getByName('jadwal-piket.hari-ini');
    if ($route) {
        echo "  URI: " . $route->uri() . "\n";
        echo "  Methods: " . implode(', ', $route->methods()) . "\n";
        echo "  Action: " . $route->getActionName() . "\n";
        echo "  Middleware: " . implode(', ', $route->middleware()) . "\n";
    }
} else {
    echo "✗ Route jadwal-piket.hari-ini not found\n";
}

echo "\n=== CONTROLLER METHOD TEST ===\n";
use App\Http\Controllers\JadwalPiketController;

$controller = new JadwalPiketController();

if (method_exists($controller, 'getJadwalHariIni')) {
    echo "✓ Method getJadwalHariIni exists\n";
} else {
    echo "✗ Method getJadwalHariIni not found\n";
}

echo "\n=== VIEW FILE TEST ===\n";
$viewPath = __DIR__ . '/resources/views/jadwal-piket/hari-ini.blade.php';
if (file_exists($viewPath)) {
    echo "✓ View file exists: " . basename($viewPath) . "\n";
    echo "  Size: " . filesize($viewPath) . " bytes\n";
} else {
    echo "✗ View file not found: " . basename($viewPath) . "\n";
}

echo "\n=== DATABASE TEST ===\n";
use App\Models\JadwalPiket;

try {
    $count = JadwalPiket::count();
    echo "✓ Database connection OK\n";
    echo "  Total jadwal records: $count\n";
    
    $hariIni = now()->format('l');
    $todayCount = JadwalPiket::where('hari', $hariIni)->where('is_active', true)->count();
    echo "  Today's schedule: $todayCount records\n";
} catch (\Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}

echo "\n=== AUTH TEST ===\n";
if (auth()->check()) {
    echo "✓ User authenticated: " . auth()->user()->name . " (" . auth()->user()->role . ")\n";
} else {
    echo "✗ User not authenticated\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
