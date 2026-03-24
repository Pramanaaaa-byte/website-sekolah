<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING FIXED MIDDLEWARE ===\n\n";

use App\Models\User;

// Test middleware directly
$middleware = new \App\Http\Middleware\RoleMiddleware();
$request = \Illuminate\Http\Request::create('/test', 'GET');

echo "Testing RoleMiddleware with multiple roles:\n";
echo "==========================================\n";

// Test with guru role
$guru = User::where('role', 'guru')->first();
auth()->login($guru);

echo "1. Testing with GURU role:\n";
echo "   User role: " . auth()->user()->role . "\n";

try {
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, 'role:admin,guru');
    
    if ($response === 'passed') {
        echo "   ✓ GURU allowed for 'admin,guru'\n";
    } else {
        echo "   ✗ GURU blocked for 'admin,guru'\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test with admin role
$admin = User::where('role', 'admin')->first();
auth()->login($admin);

echo "\n2. Testing with ADMIN role:\n";
echo "   User role: " . auth()->user()->role . "\n";

try {
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, 'role:admin,guru');
    
    if ($response === 'passed') {
        echo "   ✓ ADMIN allowed for 'admin,guru'\n";
    } else {
        echo "   ✗ ADMIN blocked for 'admin,guru'\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test with kepsek role (should be blocked)
$kepsek = User::where('role', 'kepsek')->first();
auth()->login($kepsek);

echo "\n3. Testing with KEPSEK role:\n";
echo "   User role: " . auth()->user()->role . "\n";

try {
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, 'role:admin,guru');
    
    if ($response === 'passed') {
        echo "   ✗ KEPSEK allowed for 'admin,guru' (should be blocked)\n";
    } else {
        echo "   ✓ KEPSEK blocked for 'admin,guru'\n";
    }
} catch (\Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== TESTING ROUTE ACCESS AFTER FIX ===\n";

// Login as guru again
auth()->login($guru);

echo "4. Testing actual route access:\n";
echo "   Logged in as: " . auth()->user()->name . " (" . auth()->user()->role . ")\n";

try {
    // Test controller method
    $izinController = new \App\Http\Controllers\IzinKeluarController();
    $result = $izinController->create();
    echo "   ✓ IzinKeluarController create() works\n";
    
    $keterlambatanController = new \App\Http\Controllers\KeterlambatanController();
    $result = $keterlambatanController->create();
    echo "   ✓ KeterlambatanController create() works\n";
    
} catch (\Exception $e) {
    echo "   ✗ Controller error: " . $e->getMessage() . "\n";
}

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Clear all caches:\n";
echo "   php artisan cache:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan route:clear\n";
echo "   php artisan view:clear\n";
echo "2. Rebuild caches:\n";
echo "   php artisan config:cache\n";
echo "   php artisan route:cache\n";
echo "   php artisan view:cache\n";
echo "3. Restart server\n";
echo "4. Test URLs:\n";
echo "   - http://127.0.0.1:8000/izin-keluar/create\n";
echo "   - http://127.0.0.1:8000/keterlambatan/create\n\n";

echo "=== TEST COMPLETE ===\n";
