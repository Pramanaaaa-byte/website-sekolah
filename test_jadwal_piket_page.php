<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING JADWAL PIKET PAGES ===\n\n";

use App\Models\User;

// Login as admin
$admin = User::where('role', 'admin')->first();
if ($admin) {
    auth()->login($admin);
    echo "✓ Logged in as: " . auth()->user()->name . " (admin)\n\n";
} else {
    echo "✗ No admin user found\n";
    exit;
}

$pages = [
    'jadwal-piket.index' => route('jadwal-piket.index'),
    'jadwal-piket.create' => route('jadwal-piket.create'),
    'jadwal-piket.hari-ini' => route('jadwal-piket.hari-ini'),
];

echo "Testing all Jadwal Piket pages:\n";
echo "===============================\n";

foreach ($pages as $pageName => $url) {
    echo "Testing: $pageName\n";
    echo "URL: $url\n";
    
    try {
        $route = app('router')->getRoutes()->getByName($pageName);
        if ($route) {
            echo "✓ Route exists\n";
            
            $action = $route->getActionName();
            echo "  Action: $action\n";
            
            if (strpos($action, '@') !== false) {
                list($controller, $method) = explode('@', $action);
                
                if (class_exists($controller) && method_exists($controller, $method)) {
                    echo "  ✓ Controller method exists\n";
                    
                    // Test controller method
                    try {
                        $controllerInstance = new $controller();
                        
                        if ($method === 'index') {
                            $result = $controllerInstance->index();
                            echo "  ✓ Index method works\n";
                        } elseif ($method === 'create') {
                            $result = $controllerInstance->create();
                            echo "  ✓ Create method works\n";
                        } elseif ($method === 'getJadwalHariIni') {
                            $result = $controllerInstance->getJadwalHariIni();
                            echo "  ✓ getJadwalHariIni method works\n";
                        }
                        
                    } catch (\Exception $e) {
                        echo "  ✗ Controller method error: " . $e->getMessage() . "\n";
                    }
                } else {
                    echo "  ✗ Controller or method missing\n";
                }
            }
        }
    } catch (\Exception $e) {
        echo "✗ Error: " . $e->getMessage() . "\n";
    }
    echo "---\n";
}

echo "\n=== CHECKING GURU DATA FOR DROPDOWN ===\n";

use App\Models\Guru;
$guruCount = Guru::count();
echo "✓ Total Guru: $guruCount\n";

if ($guruCount > 0) {
    echo "✓ Guru data available for dropdown\n";
    $guruList = Guru::take(3)->get();
    foreach ($guruList as $guru) {
        echo "  - {$guru->id_guru}: {$guru->nama}\n";
    }
} else {
    echo "✗ No guru data available\n";
}

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Login: http://127.0.0.1:8000/login\n";
echo "2. Use: admin@eduspace.com / password123\n";
echo "3. Test pages:\n";
foreach ($pages as $pageName => $url) {
    echo "   - $pageName: $url\n";
}
echo "4. Try creating new jadwal piket\n";
echo "5. Foreign key error should be fixed now\n\n";

echo "=== TEST COMPLETE ===\n";
