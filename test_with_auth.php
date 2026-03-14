<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST WITH AUTHENTICATION ===\n\n";

use App\Models\User;
use App\Http\Controllers\JadwalPiketController;

// Simulate login as guru
$guru = User::where('role', 'guru')->first();
if ($guru) {
    auth()->login($guru);
    echo "✓ Logged in as: " . auth()->user()->name . " (" . auth()->user()->role . ")\n";
} else {
    echo "✗ No guru user found\n";
    exit;
}

echo "\n=== ROUTE ACCESS TEST ===\n";
if (Route::has('jadwal-piket.hari-ini')) {
    echo "✓ Route exists\n";
    
    // Test controller method with auth
    $controller = new JadwalPiketController();
    
    try {
        $view = $controller->getJadwalHariIni();
        echo "✓ Controller method executed successfully\n";
        echo "  View: " . get_class($view) . "\n";
    } catch (\Exception $e) {
        echo "✗ Controller method failed: " . $e->getMessage() . "\n";
    }
}

echo "\n=== URL GENERATION TEST ===\n";
try {
    $url = route('jadwal-piket.hari-ini');
    echo "✓ URL generated: $url\n";
} catch (\Exception $e) {
    echo "✗ URL generation failed: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
