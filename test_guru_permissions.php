<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING GURU ACCESS FOR IZIN KELUAR & KETERLAMBATAN ===\n\n";

use App\Models\User;

// Login as guru
$guru = User::where('role', 'guru')->first();
if ($guru) {
    auth()->login($guru);
    echo "✓ Logged in as: " . auth()->user()->name . " (guru)\n";
    echo "✓ Email: " . auth()->user()->email . "\n\n";
} else {
    echo "✗ No guru user found\n";
    exit;
}

$routesToTest = [
    'izin-keluar.index' => 'Daftar Izin Keluar',
    'izin-keluar.create' => 'Tambah Izin Keluar',
    'izin-keluar.store' => 'Simpan Izin Keluar',
    'izin-keluar.edit' => 'Edit Izin Keluar',
    'izin-keluar.update' => 'Update Izin Keluar',
    'izin-keluar.destroy' => 'Hapus Izin Keluar',
    'keterlambatan.index' => 'Daftar Keterlambatan',
    'keterlambatan.create' => 'Tambah Keterlambatan',
    'keterlambatan.store' => 'Simpan Keterlambatan',
    'keterlambatan.edit' => 'Edit Keterlambatan',
    'keterlambatan.update' => 'Update Keterlambatan',
    'keterlambatan.destroy' => 'Hapus Keterlambatan',
];

echo "Testing route access for GURU role:\n";
echo "=====================================\n";

foreach ($routesToTest as $routeName => $description) {
    echo "Testing: $description ($routeName)\n";
    
    if (Route::has($routeName)) {
        echo "  ✓ Route exists\n";
        
        try {
            $route = Route::getRoutes()->getByName($routeName);
            $middleware = $route->middleware();
            
            if (in_array('role:admin,guru', $middleware) || in_array('role:guru,admin', $middleware)) {
                echo "  ✓ GURU has access\n";
            } elseif (in_array('role:admin', $middleware)) {
                echo "  ✗ GURU NO access (admin only)\n";
            } else {
                echo "  ✓ No role restriction\n";
            }
            
        } catch (\Exception $e) {
            echo "  ✗ Error checking route: " . $e->getMessage() . "\n";
        }
    } else {
        echo "  ✗ Route not found\n";
    }
    echo "---\n";
}

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Login as GURU:\n";
echo "   - Email: guru@eduspace.com\n";
echo "   - Password: password123\n";
echo "2. Test these URLs:\n";
echo "   - http://127.0.0.1:8000/izin-keluar/create\n";
echo "   - http://127.0.0.1:8000/keterlambatan/create\n";
echo "   - http://127.0.0.1:8000/izin-keluar\n";
echo "   - http://127.0.0.1:8000/keterlambatan\n";
echo "3. GURU should be able to:\n";
echo "   ✓ Create new izin keluar\n";
echo "   ✓ Create new keterlambatan\n";
echo "   ✓ Edit existing records\n";
echo "   ✓ Delete records\n\n";

echo "=== TEST COMPLETE ===\n";
