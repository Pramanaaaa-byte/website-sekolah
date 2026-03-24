<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== BYPASS MIDDLEWARE TEST ===\n\n";

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

// Test direct controller access (bypass middleware)
echo "\n=== TESTING DIRECT CONTROLLER ACCESS ===\n";

try {
    echo "1. Testing IzinKeluarController create()\n";
    $izinController = new \App\Http\Controllers\IzinKeluarController();
    $result = $izinController->create();
    echo "   ✓ Controller method works\n";
    
    echo "2. Testing KeterlambatanController create()\n";
    $keterlambatanController = new \App\Http\Controllers\KeterlambatanController();
    $result = $keterlambatanController->create();
    echo "   ✓ Controller method works\n";
    
} catch (\Exception $e) {
    echo "   ✗ Controller error: " . $e->getMessage() . "\n";
}

echo "\n=== CREATING TEMPORARY ROUTES (NO MIDDLEWARE) ===\n";

// Create temporary routes without middleware for testing
$tempRoutesContent = '<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IzinKeluarController;
use App\Http\Controllers\KeterlambatanController;

// Temporary routes without middleware for testing
Route::get("/temp-izin-keluar-create", [IzinKeluarController::class, "create"]);
Route::get("/temp-keterlambatan-create", [KeterlambatanController::class, "create"]);

Route::post("/temp-izin-keluar-store", [IzinKeluarController::class, "store"]);
Route::post("/temp-keterlambatan-store", [KeterlambatanController::class, "store"]);
';

file_put_contents(__DIR__ . '/routes/temp_routes.php', $tempRoutesContent);
echo "✓ Temporary routes created\n";

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Add to routes/web.php (at the end):\n";
echo "   require __DIR__.'/temp_routes.php';\n";
echo "2. Clear route cache: php artisan route:clear\n";
echo "3. Test these URLs:\n";
echo "   - http://127.0.0.1:8000/temp-izin-keluar-create\n";
echo "   - http://127.0.0.1:8000/temp-keterlambatan-create\n";
echo "4. If these work, the issue is with middleware\n";
echo "5. If these still give 403, the issue is deeper\n\n";

echo "=== COMPLETE ===\n";
