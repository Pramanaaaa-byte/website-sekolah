<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING TEMPORARY ROUTES ===\n\n";

use App\Models\User;

// Login as guru
$guru = User::where('role', 'guru')->first();
if ($guru) {
    auth()->login($guru);
    echo "✓ Logged in as: " . auth()->user()->name . " (role: " . auth()->user()->role . ")\n";
} else {
    echo "✗ No guru user found\n";
    exit;
}

// Test if routes are registered
echo "\n=== CHECKING ROUTE REGISTRATION ===\n";

$routes = app('router')->getRoutes();
$tempRoutes = [];

foreach ($routes as $route) {
    $uri = $route->uri();
    
    if (strpos($uri, 'temp-izin-keluar') !== false || strpos($uri, 'temp-keterlambatan') !== false) {
        $tempRoutes[] = [
            'uri' => $uri,
            'methods' => $route->methods(),
            'middleware' => $route->middleware(),
            'action' => $route->getActionName()
        ];
    }
}

if (empty($tempRoutes)) {
    echo "✗ No temporary routes found\n";
} else {
    echo "✓ Temporary routes found:\n";
    foreach ($tempRoutes as $route) {
        echo "  - {$route['uri']} ({$route['action']})\n";
        echo "    Methods: " . implode(', ', $route['methods']) . "\n";
        echo "    Middleware: " . implode(', ', $route['middleware']) . "\n";
    }
}

echo "\n=== TESTING ROUTE ACCESS ===\n";

// Simulate HTTP requests to temp routes
$testUrls = [
    'http://127.0.0.1:8000/temp-izin-keluar-create',
    'http://127.0.0.1:8000/temp-keterlambatan-create'
];

foreach ($testUrls as $url) {
    echo "\nTesting: $url\n";
    
    try {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Cookie: laravel_session=' . session()->getId(),
                    'User-Agent: Mozilla/5.0 (Test)'
                ]
            ]
        ]);
        
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            echo "✗ Failed to get response\n";
        } else {
            echo "✓ Got response (length: " . strlen($response) . ")\n";
            
            if (strpos($response, '403') !== false) {
                echo "✗ Still getting 403\n";
            } elseif (strpos($response, '500') !== false) {
                echo "✗ Server error (500)\n";
            } else {
                echo "✓ Success (no 403 or 500)\n";
            }
        }
        
    } catch (\Exception $e) {
        echo "✗ Exception: " . $e->getMessage() . "\n";
    }
}

echo "\n=== INSTRUCTIONS ===\n";
echo "1. If temp routes work: Controllers are OK, issue is middleware\n";
echo "2. If temp routes still give 403: Issue is deeper (server config, etc.)\n";
echo "3. Test URLs manually in browser:\n";
echo "   - http://127.0.0.1:8000/temp-izin-keluar-create\n";
echo "   - http://127.0.0.1:8000/temp-keterlambatan-create\n\n";

echo "=== TEST COMPLETE ===\n";
