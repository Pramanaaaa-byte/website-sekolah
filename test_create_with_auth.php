<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST CREATE ROUTES WITH AUTH ===\n\n";

use App\Models\User;

// Test with different roles
$roles = ['admin', 'guru', 'kepsek'];

foreach ($roles as $role) {
    echo "=== Testing as $role ===\n";
    
    // Get user with this role
    $user = User::where('role', $role)->first();
    if (!$user) {
        echo "✗ No user found with role: $role\n\n";
        continue;
    }
    
    // Login as this user
    auth()->login($user);
    echo "✓ Logged in as: " . auth()->user()->name . " ($role)\n";
    
    // Test specific create routes
    $createRoutes = [
        'siswa.create' => 'role:admin',
        'guru.create' => 'role:admin,guru', 
        'pelanggaran.create' => 'role:admin',
        'jadwal-piket.create' => 'role:admin,guru',
    ];
    
    foreach ($createRoutes as $routeName => $requiredRole) {
        $route = app('router')->getRoutes()->getByName($routeName);
        if ($route) {
            $middleware = $route->middleware();
            $hasAccess = false;
            
            // Check role middleware
            foreach ($middleware as $mid) {
                if (strpos($mid, 'role:') === 0) {
                    $allowedRoles = explode(',', substr($mid, 5));
                    if (in_array($role, $allowedRoles)) {
                        $hasAccess = true;
                    }
                    break;
                }
            }
            
            if ($hasAccess) {
                echo "✓ $routeName - Access allowed\n";
                
                // Test controller method
                try {
                    $action = $route->getActionName();
                    list($controller, $method) = explode('@', $action);
                    $controllerInstance = new $controller();
                    $view = $controllerInstance->$method();
                    echo "  ✓ Controller method works\n";
                } catch (\Exception $e) {
                    echo "  ✗ Controller method failed: " . $e->getMessage() . "\n";
                }
            } else {
                echo "✗ $routeName - Access denied (requires: $requiredRole)\n";
            }
        }
    }
    
    // Logout
    auth()->logout();
    echo "\n";
}

echo "=== TEST COMPLETE ===\n";
