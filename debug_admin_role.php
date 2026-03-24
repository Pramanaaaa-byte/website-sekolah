<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DEBUGGING ADMIN ROLE ISSUE ===\n\n";

use App\Models\User;

$middleware = new \App\Http\Middleware\RoleMiddleware();
$request = \Illuminate\Http\Request::create('/test', 'GET');

// Test with admin role
$admin = User::where('role', 'admin')->first();
auth()->login($admin);

echo "Testing with ADMIN role:\n";
echo "User role: " . auth()->user()->role . "\n";
echo "User ID: " . auth()->user()->id . "\n";

// Test the middleware logic step by step
$role = 'role:admin,guru';
echo "\nTesting role string: '$role'\n";

$allowedRoles = explode(',', $role);
echo "After explode: " . json_encode($allowedRoles) . "\n";

$allowedRoles = array_map('trim', $allowedRoles);
echo "After trim: " . json_encode($allowedRoles) . "\n";

$userRole = auth()->user()->role;
echo "User role: '$userRole'\n";

$inArray = in_array($userRole, $allowedRoles);
echo "In array result: " . ($inArray ? 'true' : 'false') . "\n";

if (!$inArray) {
    echo "Should block access\n";
} else {
    echo "Should allow access\n";
}

echo "\n=== TESTING MIDDLEWARE WITH ADMIN ===\n";

try {
    $response = $middleware->handle($request, function($req) {
        return 'passed';
    }, $role);
    
    echo "Middleware result: " . $response . "\n";
    
} catch (\Exception $e) {
    echo "Middleware error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}

echo "\n=== CHECKING USER DATA ===\n";
$adminUser = User::where('role', 'admin')->first();
echo "Admin user from DB:\n";
echo "  ID: " . $adminUser->id . "\n";
echo "  Name: " . $adminUser->name . "\n";
echo "  Role: " . $adminUser->role . "\n";

echo "\nCurrent logged in user:\n";
echo "  ID: " . (auth()->user() ? auth()->user()->id : 'null') . "\n";
echo "  Name: " . (auth()->user() ? auth()->user()->name : 'null') . "\n";
echo "  Role: " . (auth()->user() ? auth()->user()->role : 'null') . "\n";

echo "\n=== DEBUG COMPLETE ===\n";
