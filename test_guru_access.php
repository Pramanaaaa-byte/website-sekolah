<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== GURU ACCESS TEST ===\n\n";

// Test routes that guru should access
$testRoutes = [
    'pelanggaran.create' => 'Create Pelanggaran',
    'pelanggaran.store' => 'Store Pelanggaran',
    'pelanggaran.edit' => 'Edit Pelanggaran',
    'pelanggaran.update' => 'Update Pelanggaran',
    'pelanggaran.destroy' => 'Delete Pelanggaran',
    'jadwal-piket.create' => 'Create Jadwal Piket',
    'jadwal-piket.store' => 'Store Jadwal Piket',
    'jadwal-piket.edit' => 'Edit Jadwal Piket',
    'jadwal-piket.update' => 'Update Jadwal Piket',
    'jadwal-piket.destroy' => 'Delete Jadwal Piket',
];

echo "Routes that should be accessible for GURU:\n";
foreach ($testRoutes as $routeName => $description) {
    if (Route::has($routeName)) {
        echo "✓ $routeName - $description\n";
        
        // Check middleware
        $route = app('router')->getRoutes()->getByName($routeName);
        if ($route) {
            $middleware = $route->middleware();
            if (in_array('role:admin,guru', $middleware) || in_array('role:admin', $middleware)) {
                echo "  ✓ GURU can access\n";
            } else {
                echo "  ✗ GURU cannot access\n";
            }
        }
    } else {
        echo "✗ $routeName - Route not found\n";
    }
}

echo "\n=== ACCESS TEST COMPLETE ===\n";
