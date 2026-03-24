<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FORCE CLEAR SESSION & RETEST ===\n\n";

use App\Models\User;

// Clear all session data
session()->flush();
echo "✓ Session flushed\n";

// Clear all auth data
auth()->logout();
echo "✓ Auth cleared\n";

// Clear cookies
if (isset($_COOKIE)) {
    foreach ($_COOKIE as $name => $value) {
        if (strpos($name, 'laravel_session') !== false) {
            setcookie($name, '', time() - 3600, '/');
            echo "✓ Cleared cookie: $name\n";
        }
    }
}

// Re-login as guru
$guru = User::where('role', 'guru')->first();
if ($guru) {
    auth()->login($guru);
    echo "✓ Logged in as: " . auth()->user()->name . " (role: " . auth()->user()->role . ")\n";
    echo "✓ Session ID: " . session()->getId() . "\n";
} else {
    echo "✗ No guru user found\n";
    exit;
}

// Test middleware directly one more time
echo "\n=== TESTING MIDDLEWARE WITH FRESH SESSION ===\n";

$middleware = new \App\Http\Middleware\RoleMiddleware();
$request = \Illuminate\Http\Request::create('/izin-keluar/create', 'GET');

try {
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, 'role:admin,guru');
    
    if ($response === 'passed') {
        echo "✓ Middleware allows GURU for 'admin,guru'\n";
    } else {
        echo "✗ Middleware blocks GURU for 'admin,guru'\n";
    }
    
} catch (\Exception $e) {
    echo "✗ Middleware error: " . $e->getMessage() . "\n";
}

echo "\n=== TESTING CONTROLLER WITH FRESH SESSION ===\n";

try {
    $izinController = new \App\Http\Controllers\IzinKeluarController();
    $result = $izinController->create();
    echo "✓ IzinKeluarController create() works\n";
    
    $keterlambatanController = new \App\Http\Controllers\KeterlambatanController();
    $result = $keterlambatanController->create();
    echo "✓ KeterlambatanController create() works\n";
    
} catch (\Exception $e) {
    echo "✗ Controller error: " . $e->getMessage() . "\n";
}

echo "\n=== FINAL STATUS ===\n";
echo "Session ID: " . session()->getId() . "\n";
echo "Auth check: " . (auth()->check() ? 'true' : 'false') . "\n";
echo "User role: " . (auth()->user() ? auth()->user()->role : 'null') . "\n";

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Close ALL browser windows\n";
echo "2. Open NEW browser window (incognito)\n";
echo "3. Go to: http://127.0.0.1:8000/login\n";
echo "4. Login with: guru@eduspace.com / password123\n";
echo "5. Go to: http://127.0.0.1:8000/izin-keluar/create\n";
echo "6. If still 403, check browser network tab for actual HTTP requests\n";
echo "7. Try accessing via curl: curl -i http://127.0.0.1:8000/izin-keluar/create\n\n";

echo "=== COMPLETE ===\n";
