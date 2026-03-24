<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING ACTUAL ERRORS ===\n\n";

// Check Laravel log for recent errors
$logFile = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    echo "Checking Laravel log for recent errors:\n";
    echo "=====================================\n";
    
    // Read last 50 lines of log
    $lines = file($logFile);
    $lastLines = array_slice($lines, -50);
    
    foreach ($lastLines as $line) {
        if (strpos($line, 'ERROR') !== false || strpos($line, 'Exception') !== false) {
            echo trim($line) . "\n";
        }
    }
} else {
    echo "✗ Laravel log file not found\n";
}

echo "\n=== CHECKING ROUTE REGISTRATION ===\n";

// Check if routes are properly registered
$allRoutes = app('router')->getRoutes();
$problematicRoutes = [];

foreach ($allRoutes as $route) {
    $uri = $route->uri();
    $action = $route->getActionName();
    
    // Check specific routes from user
    if (strpos($uri, 'siswa/create') !== false) {
        echo "✓ siswa/create route registered\n";
    }
    if (strpos($uri, 'guru/create') !== false) {
        echo "✓ guru/create route registered\n";
    }
    if (strpos($uri, 'piket/create') !== false) {
        echo "✓ piket/create route registered\n";
    }
    if (strpos($uri, 'izin-keluar/create') !== false) {
        echo "✓ izin-keluar/create route registered\n";
    }
    if (strpos($uri, 'keterlambatan/create') !== false) {
        echo "✓ keterlambatan/create route registered\n";
    }
    if (strpos($uri, 'pelanggaran/create') !== false) {
        echo "✓ pelanggaran/create route registered\n";
    }
    if (strpos($uri, 'pelanggaran/rekap') !== false) {
        echo "✓ pelanggaran/rekap route registered\n";
    }
    if (strpos($uri, 'jadwal-piket/create') !== false) {
        echo "✓ jadwal-piket/create route registered\n";
    }
    if (strpos($uri, 'jadwal-piket/hari-ini') !== false) {
        echo "✓ jadwal-piket/hari-ini route registered\n";
    }
}

echo "\n=== CHECKING MIDDLEWARE ===\n";

// Check if middleware is properly configured
$middleware = app('router')->getMiddleware();
echo "Available middleware:\n";
foreach ($middleware as $name => $class) {
    if (strpos($name, 'auth') !== false || strpos($name, 'role') !== false) {
        echo "✓ $name => $class\n";
    }
}

echo "\n=== CHECKING CACHE ===\n";

// Check if route cache is interfering
$cacheFile = __DIR__ . '/bootstrap/cache/routes-v7.php';
if (file_exists($cacheFile)) {
    echo "✓ Route cache exists\n";
    echo "Cache file size: " . filesize($cacheFile) . " bytes\n";
    echo "Cache modified: " . date('Y-m-d H:i:s', filemtime($cacheFile)) . "\n";
} else {
    echo "✗ No route cache found\n";
}

echo "\n=== RECOMMENDATIONS ===\n";
echo "1. Clear all caches:\n";
echo "   php artisan route:clear\n";
echo "   php artisan view:clear\n";
echo "   php artisan config:clear\n";
echo "   php artisan cache:clear\n\n";

echo "2. Rebuild caches:\n";
echo "   php artisan route:cache\n";
echo "   php artisan view:cache\n";
echo "   php artisan config:cache\n\n";

echo "3. Restart Laravel server\n\n";

echo "=== CHECK COMPLETE ===\n";
