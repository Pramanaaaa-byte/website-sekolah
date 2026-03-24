<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FINAL URL TEST FOR ALL PAGES ===\n\n";

use App\Models\User;

// Login as admin
$admin = User::where('role', 'admin')->first();
if ($admin) {
    auth()->login($admin);
    echo "✓ Logged in as: " . auth()->user()->name . " (admin)\n\n";
}

$urls = [
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

echo "Testing all URLs:\n";
echo "==================\n";

foreach ($urls as $name => $url) {
    echo "Testing: $name\n";
    echo "URL: $url\n";
    
    // Parse the URL to get the path
    $parsedUrl = parse_url($url);
    $path = $parsedUrl['path'] ?? '/';
    
    // Create a request to test the route
    try {
        $request = \Illuminate\Http\Request::create($url, 'GET');
        
        // Try to resolve the route
        try {
            $route = app('router')->getRoutes()->match($request);
            if ($route) {
                echo "✓ Route found: " . $route->uri() . "\n";
                echo "  Methods: " . implode(', ', $route->methods()) . "\n";
                echo "  Action: " . $route->getActionName() . "\n";
                
                // Check if controller method exists
                $action = $route->getActionName();
                if (strpos($action, '@') !== false) {
                    list($controller, $method) = explode('@', $action);
                    if (class_exists($controller) && method_exists($controller, $method)) {
                        echo "  ✓ Controller and method exist\n";
                        
                        // Check view file
                        $viewName = str_replace(['.', '-'], ['/', '-'], $name);
                        $viewFile = __DIR__ . "/resources/views/$viewName.blade.php";
                        if (file_exists($viewFile)) {
                            echo "  ✓ View file exists\n";
                        } else {
                            echo "  ✗ View file missing: $viewName.blade.php\n";
                        }
                    } else {
                        echo "  ✗ Controller or method missing\n";
                    }
                }
            } else {
                echo "✗ Route not found\n";
            }
        } catch (\Exception $e) {
            echo "✗ Route matching failed: " . $e->getMessage() . "\n";
        }
    } catch (\Exception $e) {
        echo "✗ Request creation failed: " . $e->getMessage() . "\n";
    }
    
    echo "---\n";
}

echo "\n=== MANUAL VERIFICATION ===\n";
echo "Please manually test these URLs in your browser:\n";
echo "===============================================\n";

foreach ($urls as $name => $url) {
    echo "$name: $url\n";
}

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Open browser and go to: http://127.0.0.1:8000/login\n";
echo "2. Login with: admin@eduspace.com / password123\n";
echo "3. Test each URL above\n";
echo "4. If any page shows 'Not Found', note which one\n";
echo "5. Check Laravel logs: storage/logs/laravel.log\n\n";

echo "=== COMMON ISSUES & SOLUTIONS ===\n";
echo "If pages still show 'Not Found':\n";
echo "1. Check if you're logged in (all pages require auth)\n";
echo "2. Clear browser cache\n";
echo "3. Try URL without trailing slash\n";
echo "4. Check Laravel logs for specific errors\n";
echo "5. Ensure server is running on correct port\n\n";

echo "=== TEST COMPLETE ===\n";
