<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEEP DEBUG 403 ERROR ===\n\n";

use App\Models\User;

// 1. Check if middleware is properly registered
echo "1. CHECKING MIDDLEWARE REGISTRATION:\n";
$kernelPath = __DIR__ . '/bootstrap/app.php';
$kernelContent = file_get_contents($kernelPath);

if (strpos($kernelContent, 'App\\\\Http\\\\Middleware\\\\RoleMiddleware') !== false) {
    echo "✓ RoleMiddleware registered in kernel\n";
} else {
    echo "✗ RoleMiddleware NOT found in kernel\n";
}

// 2. Check route list
echo "\n2. CHECKING ROUTE LIST:\n";
$routes = app('router')->getRoutes();
$problemRoutes = [];

foreach ($routes as $route) {
    $uri = $route->uri();
    $middleware = $route->middleware();
    
    if (strpos($uri, 'izin-keluar') !== false || strpos($uri, 'keterlambatan') !== false) {
        $problemRoutes[] = [
            'uri' => $uri,
            'methods' => $route->methods(),
            'middleware' => $middleware,
            'action' => $route->getActionName()
        ];
    }
}

foreach ($problemRoutes as $route) {
    echo "Route: {$route['uri']}\n";
    echo "  Methods: " . implode(', ', $route['methods']) . "\n";
    echo "  Middleware: " . implode(', ', $route['middleware']) . "\n";
    echo "  Action: {$route['action']}\n";
    echo "---\n";
}

// 3. Test actual HTTP request simulation
echo "\n3. SIMULATING HTTP REQUEST:\n";

// Create a proper request
$request = \Illuminate\Http\Request::create('/izin-keluar/create', 'GET', [
    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Accept-Language' => 'en-US,en;q=0.5',
    'Accept-Encoding' => 'gzip, deflate, br',
    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    'Cookie' => 'laravel_session=' . session()->getId(),
    'Cache-Control' => 'max-age=0',
    'Connection' => 'keep-alive'
]);

// Login as guru
$guru = User::where('role', 'guru')->first();
auth()->login($guru);

echo "Logged in as: " . auth()->user()->name . " (role: " . auth()->user()->role . ")\n";
echo "Session ID: " . session()->getId() . "\n";

try {
    // Dispatch the request through the router
    $response = app('router')->dispatch($request);
    
    echo "HTTP Status Code: " . $response->getStatusCode() . "\n";
    echo "Response Headers:\n";
    foreach ($response->headers as $name => $value) {
        echo "  $name: $value\n";
    }
    
    if ($response->getStatusCode() === 403) {
        echo "✗ GOT 403 - Response content:\n";
        echo $response->getContent() . "\n";
    } else {
        echo "✓ No 403 - Success!\n";
    }
    
} catch (\Exception $e) {
    echo "✗ Exception: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}

// 4. Check session data
echo "\n4. CHECKING SESSION DATA:\n";
echo "Session data: " . json_encode(session()->all()) . "\n";
echo "Auth check: " . (auth()->check() ? 'true' : 'false') . "\n";
echo "Auth user: " . (auth()->user() ? json_encode([
    'id' => auth()->user()->id,
    'name' => auth()->user()->name,
    'role' => auth()->user()->role
]) : 'null') . "\n";

// 5. Check if there are any other middleware interfering
echo "\n5. CHECKING FOR OTHER MIDDLEWARE:\n";
$middlewareGroups = $kernel->getMiddlewareGroups();

echo "Middleware groups:\n";
foreach ($middlewareGroups as $name => $group) {
    echo "  - $name: " . implode(', ', $group) . "\n";
}

echo "\nRoute middleware aliases:\n";
$middlewareAliases = $kernel->getRouteMiddleware();
foreach ($middlewareAliases as $name => $middleware) {
    echo "  - $name: " . (is_string($middleware) ? $middleware : get_class($middleware)) . "\n";
}

echo "\n6. POSSIBLE SOLUTIONS:\n";
echo "If still getting 403:\n";
echo "1. Check .env session configuration\n";
echo "2. Check config/session.php settings\n";
echo "3. Check browser cookies for laravel_session\n";
echo "4. Try different browser (Chrome, Firefox, Edge)\n";
echo "5. Try clearing browser data completely\n";
echo "6. Check if there are multiple Laravel instances running\n";
echo "7. Restart computer and try again\n";
echo "8. Check if Apache/Nginx is interfering (if using)\n";

echo "\n=== DEBUG COMPLETE ===\n";
