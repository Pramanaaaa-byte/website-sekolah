<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING 403 UNAUTHORIZED ACCESS ===\n\n";

use App\Models\User;

// Login as guru
$guru = User::where('role', 'guru')->first();
if ($guru) {
    auth()->login($guru);
    echo "✓ Logged in as: " . auth()->user()->name . " (role: " . auth()->user()->role . ")\n\n";
} else {
    echo "✗ No guru user found\n";
    exit;
}

echo "=== CHECKING MIDDLEWARE REGISTRATION ===\n";

// Check if RoleMiddleware exists
if (class_exists('App\Http\Middleware\RoleMiddleware')) {
    echo "✓ RoleMiddleware class exists\n";
} else {
    echo "✗ RoleMiddleware class NOT found\n";
}

// Check kernel.php for middleware registration
$kernelPath = __DIR__ . '/bootstrap/app.php';
$kernelContent = file_get_contents($kernelPath);

if (strpos($kernelContent, 'role') !== false) {
    echo "✓ Role middleware registered in kernel\n";
} else {
    echo "✗ Role middleware NOT registered in kernel\n";
}

echo "\n=== TESTING MIDDLEWARE DIRECTLY ===\n";

// Test middleware directly
try {
    $request = \Illuminate\Http\Request::create('/izin-keluar/create', 'GET');
    $middleware = new \App\Http\Middleware\RoleMiddleware();
    
    echo "Testing RoleMiddleware directly...\n";
    
    // Simulate admin role
    auth()->login(User::where('role', 'admin')->first());
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, 'role:admin');
    echo "Admin role result: " . $response . "\n";
    
    // Simulate guru role
    auth()->login($guru);
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, 'role:admin,guru');
    echo "Guru role result: " . $response . "\n";
    
    // Test with invalid role
    auth()->login(User::where('role', 'kepsek')->first());
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, 'role:admin,guru');
    echo "Kepsek role result: " . $response . "\n";
    
} catch (\Exception $e) {
    echo "Middleware test error: " . $e->getMessage() . "\n";
}

echo "\n=== CHECKING ROUTE MIDDLEWARE ===\n";

// Check actual route middleware
$routes = app('router')->getRoutes();
$izinRoutes = [];

foreach ($routes as $route) {
    $uri = $route->uri();
    if (strpos($uri, 'izin-keluar') !== false) {
        $izinRoutes[$uri] = [
            'methods' => $route->methods(),
            'middleware' => $route->middleware()
        ];
    }
}

foreach ($izinRoutes as $uri => $info) {
    echo "Route: $uri\n";
    echo "Methods: " . implode(', ', $info['methods']) . "\n";
    echo "Middleware: " . implode(', ', $info['middleware']) . "\n";
    echo "---\n";
}

echo "\n=== CHECKING SESSION DATA ===\n";
echo "Session ID: " . session()->getId() . "\n";
echo "Authenticated: " . (auth()->check() ? 'true' : 'false') . "\n";
echo "User ID: " . (auth()->user() ? auth()->user()->id : 'null') . "\n";
echo "User Role: " . (auth()->user() ? auth()->user()->role : 'null') . "\n";
echo "Session Data: " . json_encode(session()->all()) . "\n";

echo "\n=== TESTING ACTUAL ROUTE ACCESS ===\n";

// Test actual route resolution
try {
    $request = \Illuminate\Http\Request::create('/izin-keluar/create', 'GET');
    
    // Start Laravel request lifecycle
    $response = app('router')->dispatch($request);
    
    echo "Route dispatch result: " . $response->getStatusCode() . "\n";
    echo "Response content: " . $response->getContent() . "\n";
    
} catch (\Exception $e) {
    echo "Route dispatch error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\n=== RECOMMENDATIONS ===\n";
echo "If still getting 403:\n";
echo "1. Check App\\Http\\Middleware\\RoleMiddleware.php\n";
echo "2. Check bootstrap/app.php middleware registration\n";
echo "3. Check .env file for session settings\n";
echo "4. Try: php artisan config:cache && php artisan route:cache\n";
echo "5. Check browser cookies and session\n";
echo "6. Try different browser\n\n";

echo "=== DEBUG COMPLETE ===\n";
