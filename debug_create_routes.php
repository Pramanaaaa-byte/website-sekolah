<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUG CREATE ROUTES ===\n\n";

// Test all create routes
$createRoutes = [
    'siswa.create' => 'Siswa Create',
    'guru.create' => 'Guru Create', 
    'pelanggaran.create' => 'Pelanggaran Create',
    'jadwal-piket.create' => 'Jadwal Piket Create',
    'piket.create' => 'Piket Create',
    'izin-keluar.create' => 'Izin Keluar Create',
    'keterlambatan.create' => 'Keterlambatan Create',
];

echo "Checking CREATE routes:\n";
foreach ($createRoutes as $routeName => $description) {
    if (Route::has($routeName)) {
        echo "✓ $routeName - $description\n";
        
        $route = app('router')->getRoutes()->getByName($routeName);
        if ($route) {
            echo "  URI: {$route->uri()}\n";
            echo "  Methods: " . implode(', ', $route->methods()) . "\n";
            echo "  Action: {$route->getActionName()}\n";
            echo "  Middleware: " . implode(', ', $route->middleware()) . "\n";
            
            // Check if controller method exists
            $action = $route->getActionName();
            if (strpos($action, '@') !== false) {
                list($controller, $method) = explode('@', $action);
                if (class_exists($controller) && method_exists($controller, $method)) {
                    echo "  ✓ Controller method exists\n";
                } else {
                    echo "  ✗ Controller method missing\n";
                }
            }
        }
    } else {
        echo "✗ $routeName - Route not found\n";
    }
    echo "---\n";
}

echo "\n=== AUTHENTICATION CHECK ===\n";
if (auth()->check()) {
    echo "✓ User authenticated: " . auth()->user()->name . " (" . auth()->user()->role . ")\n";
    
    // Test access based on current user role
    $userRole = auth()->user()->role;
    echo "\nTesting access for role: $userRole\n";
    
    foreach ($createRoutes as $routeName => $description) {
        $route = app('router')->getRoutes()->getByName($routeName);
        if ($route) {
            $middleware = $route->middleware();
            $hasRoleMiddleware = false;
            $allowedRoles = [];
            
            foreach ($middleware as $mid) {
                if (strpos($mid, 'role:') === 0) {
                    $hasRoleMiddleware = true;
                    $allowedRoles = explode(',', substr($mid, 5));
                    break;
                }
            }
            
            if ($hasRoleMiddleware) {
                if (in_array($userRole, $allowedRoles)) {
                    echo "✓ $routeName - Access allowed\n";
                } else {
                    echo "✗ $routeName - Access denied (requires: " . implode(', ', $allowedRoles) . ")\n";
                }
            } else {
                echo "? $routeName - No role restriction\n";
            }
        }
    }
} else {
    echo "✗ User not authenticated\n";
    echo "  Most create routes require authentication\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
