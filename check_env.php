<?php

echo "=== CHECKING .env FILE ===\n";

$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    echo "✓ .env file exists\n";
    $envContent = file_get_contents($envFile);
    echo "Session driver: " . (preg_match('/SESSION_DRIVER=(.+)/', $envContent, $matches) ? $matches[1] : 'not found') . "\n";
    echo "Session lifetime: " . (preg_match('/SESSION_LIFETIME=(.+)/', $envContent, $matches) ? $matches[1] : 'not found') . "\n";
    echo "App env: " . (preg_match('/APP_ENV=(.+)/', $envContent, $matches) ? $matches[1] : 'not found') . "\n";
    echo "App debug: " . (preg_match('/APP_DEBUG=(.+)/', $envContent, $matches) ? $matches[1] : 'not found') . "\n";
} else {
    echo "✗ .env file not found\n";
}

echo "\n=== CREATING SIMPLE TEST ROUTE ===\n";

// Create a simple test route without middleware
$testRouteContent = '<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test-guru-access', function() {
    if (auth()->check()) {
        return "Logged in as: " . auth()->user()->name . " (role: " . auth()->user()->role . ")";
    } else {
        return "Not logged in";
    }
});

Route::get('/test-middleware', function(Request $request) {
    $middleware = new \App\Http\Middleware\RoleMiddleware();
    
    try {
        $response = $middleware->handle($request, function($req) {
            return "Middleware passed";
        }, "role:admin,guru");
        
        return $response;
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
';

file_put_contents(__DIR__ . '/routes/test_routes.php', $testRouteContent);

echo "✓ Test routes created\n";
echo "Add this to routes/web.php:\n";
echo "require __DIR__.'/test_routes.php';\n";

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Add test routes to routes/web.php\n";
echo "2. Clear caches: php artisan cache:clear\n";
echo "3. Test: http://127.0.0.1:8000/test-guru-access\n";
echo "4. Test: http://127.0.0.1:8000/test-middleware\n";
echo "5. Check results\n";
