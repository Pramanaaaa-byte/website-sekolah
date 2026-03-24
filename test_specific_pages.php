<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING SPECIFIC PAGES ===\n\n";

use App\Models\User;

// Login as admin for full access
$admin = User::where('role', 'admin')->first();
if ($admin) {
    auth()->login($admin);
    echo "✓ Logged in as: " . auth()->user()->name . " (admin)\n\n";
} else {
    echo "✗ No admin user found\n";
    exit;
}

$testPages = [
    'siswa.create' => 'http://127.0.0.1:8000/siswa/create',
    'guru.create' => 'http://127.0.0.1:8000/guru/create', 
    'piket.create' => 'http://127.0.0.1:8000/piket/create',
    'izin-keluar.create' => 'http://127.0.0.1:8000/izin-keluar/create',
    'keterlambatan.create' => 'http://127.0.0.1:8000/keterlambatan/create',
    'pelanggaran.create' => 'http://127.0.0.1:8000/pelanggaran/create',
    'pelanggaran.rekap' => 'http://127.0.0.1:8000/pelanggaran/rekap',
    'jadwal-piket.create' => 'http://127.0.0.1:8000/jadwal-piket/create',
    'jadwal-piket.hari-ini' => 'http://127.0.0.1:8000/jadwal-piket/hari-ini'
];

echo "Testing each page:\n";
echo "==================\n";

foreach ($testPages as $routeName => $url) {
    echo "Testing: $routeName\n";
    echo "URL: $url\n";
    
    // Check if route exists
    if (Route::has($routeName)) {
        echo "✓ Route exists\n";
        
        try {
            $route = app('router')->getRoutes()->getByName($routeName);
            if ($route) {
                $action = $route->getActionName();
                echo "  Action: $action\n";
                
                if (strpos($action, '@') !== false) {
                    list($controller, $method) = explode('@', $action);
                    if (class_exists($controller)) {
                        echo "  ✓ Controller exists: $controller\n";
                        
                        if (method_exists($controller, $method)) {
                            echo "  ✓ Method exists: $method\n";
                            
                            // Test controller method
                            try {
                                $controllerInstance = new $controller();
                                
                                // For create methods, we need to handle dependencies
                                if ($method === 'create') {
                                    $view = $controllerInstance->create();
                                    echo "  ✓ Controller method works\n";
                                } elseif ($method === 'getJadwalHariIni') {
                                    $view = $controllerInstance->getJadwalHariIni();
                                    echo "  ✓ Controller method works\n";
                                } elseif ($method === 'rekap') {
                                    $view = $controllerInstance->rekap();
                                    echo "  ✓ Controller method works\n";
                                }
                                
                                // Check if view file exists
                                $viewName = str_replace('.', '/', $routeName);
                                $viewFile = __DIR__ . "/resources/views/$viewName.blade.php";
                                
                                if (file_exists($viewFile)) {
                                    echo "  ✓ View file exists: $viewName.blade.php\n";
                                } else {
                                    echo "  ✗ View file missing: $viewName.blade.php\n";
                                }
                                
                            } catch (\Exception $e) {
                                echo "  ✗ Controller method failed: " . $e->getMessage() . "\n";
                            }
                        } else {
                            echo "  ✗ Method missing: $method\n";
                        }
                    } else {
                        echo "  ✗ Controller missing: $controller\n";
                    }
                }
            }
        } catch (\Exception $e) {
            echo "  ✗ Route error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "✗ Route NOT found\n";
    }
    echo "---\n";
}

echo "\n=== CHECKING VIEW FILES DIRECTLY ===\n";

$viewFiles = [
    'siswa/create' => 'resources/views/siswa/create.blade.php',
    'guru/create' => 'resources/views/guru/create.blade.php',
    'piket/create' => 'resources/views/piket/create.blade.php',
    'izin-keluar/create' => 'resources/views/izin-keluar/create.blade.php',
    'keterlambatan/create' => 'resources/views/keterlambatan/create.blade.php',
    'pelanggaran/create' => 'resources/views/pelanggaran/create.blade.php',
    'pelanggaran/rekap' => 'resources/views/pelanggaran/rekap.blade.php',
    'jadwal-piket/create' => 'resources/views/jadwal-piket/create.blade.php',
    'jadwal-piket/hari-ini' => 'resources/views/jadwal-piket/hari-ini.blade.php'
];

foreach ($viewFiles as $viewName => $filePath) {
    if (file_exists(__DIR__ . '/' . $filePath)) {
        echo "✓ $viewName - View file exists\n";
    } else {
        echo "✗ $viewName - View file MISSING: $filePath\n";
    }
}

echo "\n=== TEST COMPLETE ===\n";
