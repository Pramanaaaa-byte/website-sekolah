<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING GURU LOGIN & ACCESS ===\n\n";

use App\Models\User;

// Test login as guru
$guru = User::where('role', 'guru')->first();
if ($guru) {
    auth()->login($guru);
    echo "✓ Logged in as: " . auth()->user()->name . "\n";
    echo "✓ Role: " . auth()->user()->role . "\n";
    echo "✓ Email: " . auth()->user()->email . "\n";
    echo "✓ Auth check: " . (auth()->check() ? 'true' : 'false') . "\n\n";
} else {
    echo "✗ No guru user found\n";
    exit;
}

// Test if middleware is working
echo "Testing middleware access:\n";
echo "==========================\n";

$routesToTest = [
    'izin-keluar.create' => 'GET /izin-keluar/create',
    'izin-keluar.store' => 'POST /izin-keluar',
    'keterlambatan.create' => 'GET /keterlambatan/create',
    'keterlambatan.store' => 'POST /keterlambatan',
];

foreach ($routesToTest as $routeName => $method) {
    echo "Testing: $routeName ($method)\n";
    
    if (Route::has($routeName)) {
        echo "  ✓ Route exists\n";
        
        try {
            $route = Route::getRoutes()->getByName($routeName);
            $middleware = $route->middleware();
            
            echo "  Middleware: " . implode(', ', $middleware) . "\n";
            
            // Check if middleware allows guru
            $allowsGuru = false;
            foreach ($middleware as $m) {
                if (strpos($m, 'role:') !== false) {
                    $roles = explode(',', str_replace('role:', '', $m));
                    foreach ($roles as $role) {
                        if (trim($role) === 'guru') {
                            $allowsGuru = true;
                            break 2;
                        }
                    }
                }
            }
            
            if ($allowsGuru || empty($middleware)) {
                echo "  ✓ GURU allowed\n";
            } else {
                echo "  ✗ GURU not allowed\n";
            }
            
        } catch (\Exception $e) {
            echo "  ✗ Error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "  ✗ Route not found\n";
    }
    echo "---\n";
}

echo "\n=== TESTING CONTROLLER METHODS ===\n";

// Test controller methods directly
try {
    echo "Testing IzinKeluarController create()\n";
    $izinController = new \App\Http\Controllers\IzinKeluarController();
    $result = $izinController->create();
    echo "✓ create() method works\n";
} catch (\Exception $e) {
    echo "✗ create() method error: " . $e->getMessage() . "\n";
}

try {
    echo "Testing KeterlambatanController create()\n";
    $keterlambatanController = new \App\Http\Controllers\KeterlambatanController();
    $result = $keterlambatanController->create();
    echo "✓ create() method works\n";
} catch (\Exception $e) {
    echo "✗ create() method error: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUGGING INFO ===\n";
echo "Current user role: " . auth()->user()->role . "\n";
echo "Is authenticated: " . (auth()->check() ? 'true' : 'false') . "\n";
echo "Session ID: " . session()->getId() . "\n";

echo "\n=== INSTRUCTIONS ===\n";
echo "1. If still getting 403:\n";
echo "   - Clear browser cache (Ctrl+F5)\n";
echo "   - Try incognito window\n";
echo "   - Check Laravel logs: php artisan log:clear && php artisan tinker --execute=\"Log::info('Test')\"\n";
echo "   - Restart Laravel server\n";
echo "2. Test URLs manually:\n";
echo "   - http://127.0.0.1:8000/izin-keluar/create\n";
echo "   - http://127.0.0.1:8000/keterlambatan/create\n\n";

echo "=== TEST COMPLETE ===\n";
