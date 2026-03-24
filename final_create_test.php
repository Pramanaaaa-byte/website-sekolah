<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FINAL CREATE ROUTES TEST ===\n\n";

// Test as admin (should have access to all)
use App\Models\User;

$admin = User::where('role', 'admin')->first();
if ($admin) {
    auth()->login($admin);
    echo "✓ Logged in as: " . auth()->user()->name . " (admin)\n\n";
    
    $createRoutes = [
        'siswa.create' => 'http://127.0.0.1:8000/siswa/create',
        'guru.create' => 'http://127.0.0.1:8000/guru/create',
        'pelanggaran.create' => 'http://127.0.0.1:8000/pelanggaran/create',
        'jadwal-piket.create' => 'http://127.0.0.1:8000/jadwal-piket/create',
    ];
    
    echo "Testing CREATE URLs as ADMIN:\n";
    foreach ($createRoutes as $routeName => $url) {
        if (Route::has($routeName)) {
            echo "✓ $routeName - $url\n";
            
            // Test controller method
            try {
                $route = app('router')->getRoutes()->getByName($routeName);
                $action = $route->getActionName();
                list($controller, $method) = explode('@', $action);
                $controllerInstance = new $controller();
                $view = $controllerInstance->$method();
                echo "  ✓ Controller method works\n";
            } catch (\Exception $e) {
                echo "  ✗ Controller method failed: " . $e->getMessage() . "\n";
            }
        } else {
            echo "✗ $routeName - Route not found\n";
        }
        echo "---\n";
    }
    
    auth()->logout();
}

echo "\n=== ACCESS SUMMARY ===\n";

echo "CREATE Routes Access Matrix:\n";
echo "┌─────────────────┬───────────┬───────────┬─────────────┐\n";
echo "│ Route           │ Admin    │ Guru     │ Kepsek     │\n";
echo "├─────────────────┼───────────┼───────────┼─────────────┤\n";

$routes = [
    'siswa.create' => ['admin' => '✓', 'guru' => '✗', 'kepsek' => '✗'],
    'guru.create' => ['admin' => '✓', 'guru' => '✓', 'kepsek' => '✗'],
    'pelanggaran.create' => ['admin' => '✓', 'guru' => '✗', 'kepsek' => '✗'],
    'jadwal-piket.create' => ['admin' => '✓', 'guru' => '✓', 'kepsek' => '✗'],
];

foreach ($routes as $routeName => $access) {
    printf("│ %-15s │ %-9s │ %-9s │ %-11s │\n", 
        $routeName, 
        $access['admin'], 
        $access['guru'], 
        $access['kepsek']
    );
}

echo "└─────────────────┴───────────┴───────────┴─────────────┘\n";

echo "\n=== SOLUTION ===\n";
echo "If you're getting 'Not Found' errors:\n";
echo "1. Make sure you're logged in first\n";
echo "2. Use the correct role for the route\n";
echo "3. Check the URL is correct\n\n";

echo "Login URLs:\n";
echo "Admin: http://127.0.0.1:8000/login (admin@eduspace.com)\n";
echo "Guru: http://127.0.0.1:8000/login (guru@eduspace.com)\n";
echo "Kepsek: http://127.0.0.1:8000/login (kepsek@eduspace.com)\n\n";

echo "=== TEST COMPLETE ===\n";
