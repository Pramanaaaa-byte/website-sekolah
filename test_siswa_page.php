<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING SISWA PAGE ===\n\n";

use App\Models\User;

// Login as admin
$admin = User::where('role', 'admin')->first();
if ($admin) {
    auth()->login($admin);
    echo "✓ Logged in as: " . auth()->user()->name . " (admin)\n\n";
} else {
    echo "✗ No admin user found\n";
    exit;
}

// Test siswa index route
echo "Testing siswa.index route:\n";
echo "==========================\n";

if (Route::has('siswa.index')) {
    echo "✓ Route exists\n";
    
    try {
        $controller = new \App\Http\Controllers\SiswaController();
        $result = $controller->index();
        echo "✓ Controller method works\n";
        
        if (method_exists($result, 'getData')) {
            $data = $result->getData();
            if (isset($data['siswa'])) {
                echo "✓ Data passed to view\n";
                echo "  Total siswa: " . $data['siswa']->count() . "\n";
            }
        }
    } catch (\Exception $e) {
        echo "✗ Controller error: " . $e->getMessage() . "\n";
    }
} else {
    echo "✗ Route not found\n";
}

echo "\n=== CHECKING VIEW FILE ===\n";

$viewFile = __DIR__ . '/resources/views/siswa/index.blade.php';
if (file_exists($viewFile)) {
    echo "✓ View file exists: siswa/index.blade.php\n";
} else {
    echo "✗ View file missing: siswa/index.blade.php\n";
}

echo "\n=== CHECKING CSRF TOKEN ===\n";

// Check if CSRF token is properly configured
$token = csrf_token();
echo "✓ CSRF Token: $token\n";

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Clear browser cache and cookies\n";
echo "2. Open new browser window\n";
echo "3. Go to: http://127.0.0.1:8000/login\n";
echo "4. Login with: admin@eduspace.com / password123\n";
echo "5. Then go to: http://127.0.0.1:8000/siswa\n";
echo "6. If still 419, try: http://127.0.0.1:8000/siswa?refresh=1\n\n";

echo "=== TEST COMPLETE ===\n";
