<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== COMPREHENSIVE SYSTEM CHECK ===\n\n";

// 1. Check Laravel Environment
echo "1. LARAVEL ENVIRONMENT:\n";
echo "   Environment: " . app()->environment() . "\n";
echo "   Debug Mode: " . (config('app.debug') ? 'ON' : 'OFF') . "\n";
echo "   App URL: " . config('app.url') . "\n";
echo "   App Name: " . config('app.name') . "\n";
echo "   Timezone: " . config('app.timezone') . "\n";
echo "   Locale: " . config('app.locale') . "\n\n";

// 2. Check Database Connection
echo "2. DATABASE CONNECTION:\n";
try {
    \DB::connection()->getPdo();
    echo "   Connection: ✓ SUCCESS\n";
    echo "   Database: " . \DB::connection()->getDatabaseName() . "\n";
    echo "   Tables: " . count(\DB::select('SELECT name FROM sqlite_master WHERE type=\'table\'')) . "\n";
} catch (\Exception $e) {
    echo "   Connection: ✗ FAILED - " . $e->getMessage() . "\n";
}
echo "\n";

// 3. Check Required Directories
echo "3. DIRECTORY PERMISSIONS:\n";
$requiredDirs = [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache'
];

foreach ($requiredDirs as $dir) {
    $fullPath = __DIR__ . '/' . $dir;
    if (is_dir($fullPath)) {
        if (is_writable($fullPath)) {
            echo "   $dir: ✓ WRITABLE\n";
        } else {
            echo "   $dir: ⚠ READ ONLY\n";
        }
    } else {
        echo "   $dir: ✗ MISSING\n";
    }
}
echo "\n";

// 4. Check Cache Status
echo "4. CACHE STATUS:\n";
$caches = ['config', 'routes', 'views', 'compiled'];
foreach ($caches as $cache) {
    $cacheFile = __DIR__ . "/bootstrap/cache/{$cache}.php";
    if (file_exists($cacheFile)) {
        echo "   $cache: ✓ CACHED\n";
    } else {
        echo "   $cache: ⚠ NOT CACHED\n";
    }
}
echo "\n";

// 5. Check Models and Relationships
echo "5. MODELS AND RELATIONSHIPS:\n";
$models = ['User', 'Siswa', 'Guru', 'Pelanggaran', 'JadwalPiket'];
foreach ($models as $model) {
    $modelClass = "App\\Models\\{$model}";
    if (class_exists($modelClass)) {
        echo "   $model: ✓ EXISTS\n";
        
        // Check if model has correct table
        $modelInstance = new $modelClass;
        $table = $modelInstance->getTable();
        echo "     Table: $table\n";
        
        // Check if table exists
        try {
            \DB::table($table)->limit(1)->get();
            echo "     Table Data: ✓ EXISTS\n";
        } catch (\Exception $e) {
            echo "     Table Data: ✗ MISSING - " . $e->getMessage() . "\n";
        }
    } else {
        echo "   $model: ✗ MISSING\n";
    }
}
echo "\n";

// 6. Check Controllers and Methods
echo "6. CONTROLLERS AND METHODS:\n";
$controllers = [
    'SiswaController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'GuruController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'PelanggaranController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'rekap'],
    'JadwalPiketController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'getJadwalHariIni'],
    'QRScannerController' => ['scan', 'generateQr'],
];

foreach ($controllers as $controller => $methods) {
    $controllerClass = "App\\Http\\Controllers\\{$controller}";
    if (class_exists($controllerClass)) {
        echo "   $controller: ✓ EXISTS\n";
        foreach ($methods as $method) {
            if (method_exists($controllerClass, $method)) {
                echo "     $method: ✓ EXISTS\n";
            } else {
                echo "     $method: ✗ MISSING\n";
            }
        }
    } else {
        echo "   $controller: ✗ MISSING\n";
    }
}
echo "\n";

// 7. Check Routes
echo "7. ROUTES STATUS:\n";
$routes = app('router')->getRoutes();
$routeCount = count($routes->getRoutes());
echo "   Total Routes: $routeCount\n";

// Check for specific routes
$importantRoutes = [
    'siswa.index', 'siswa.create', 'siswa.show',
    'guru.index', 'guru.create', 'guru.show',
    'pelanggaran.index', 'pelanggaran.create', 'pelanggaran.show', 'pelanggaran.rekap',
    'jadwal-piket.index', 'jadwal-piket.create', 'jadwal-piket.show', 'jadwal-piket.hari-ini',
    'dashboard', 'login', 'logout'
];

foreach ($importantRoutes as $routeName) {
    if (Route::has($routeName)) {
        echo "   $routeName: ✓ EXISTS\n";
    } else {
        echo "   $routeName: ✗ MISSING\n";
    }
}
echo "\n";

// 8. Check Views
echo "8. VIEWS STATUS:\n";
$viewDirs = ['siswa', 'guru', 'pelanggaran', 'jadwal-piket'];
foreach ($viewDirs as $viewDir) {
    $viewPath = __DIR__ . "/resources/views/$viewDir";
    if (is_dir($viewPath)) {
        $files = glob("$viewPath/*.blade.php");
        echo "   $viewDir: " . count($files) . " files\n";
        foreach ($files as $file) {
            $fileName = basename($file, '.blade.php');
            echo "     $fileName: ✓ EXISTS\n";
        }
    } else {
        echo "   $viewDir: ✗ MISSING\n";
    }
}
echo "\n";

// 9. Check Session Configuration
echo "9. SESSION CONFIGURATION:\n";
echo "   Session Driver: " . config('session.driver') . "\n";
echo "   Session Lifetime: " . config('session.lifetime') . " minutes\n";
echo "   Session Encryption: " . (config('session.encrypt') ? 'ENABLED' : 'DISABLED') . "\n";
echo "   CSRF Protection: " . (config('app.csrf_protection') ? 'ENABLED' : 'DISABLED') . "\n\n";

// 10. Check User Data
echo "10. USER DATA:\n";
$users = \App\Models\User::all();
echo "   Total Users: " . $users->count() . "\n";
foreach ($users as $user) {
    echo "   {$user->name} ({$user->email}) - Role: {$user->role}\n";
}
echo "\n";

// 11. Check Sample Data
echo "11. SAMPLE DATA:\n";
$siswaCount = \App\Models\Siswa::count();
$guruCount = \App\Models\Guru::count();
$pelanggaranCount = \App\Models\Pelanggaran::count();
$jadwalPiketCount = \App\Models\JadwalPiket::count();

echo "   Siswa: $siswaCount records\n";
echo "   Guru: $guruCount records\n";
echo "   Pelanggaran: $pelanggaranCount records\n";
echo "   Jadwal Piket: $jadwalPiketCount records\n\n";

// 12. Performance Check
echo "12. PERFORMANCE CHECK:\n";
$startTime = microtime(true);

// Test database query
$testQuery = \DB::table('users')->count();
$dbTime = microtime(true) - $startTime;

// Test cache
$cacheTest = cache()->remember('test_key', 60, function() {
    return 'test_value';
});
$cacheTime = microtime(true) - $dbTime;

echo "   Database Query Time: " . number_format($dbTime * 1000, 2) . " ms\n";
echo "   Cache Operation Time: " . number_format($cacheTime * 1000, 2) . " ms\n";
echo "   Memory Usage: " . number_format(memory_get_usage(true) / 1024 / 1024, 2) . " MB\n\n";

echo "=== RECOMMENDATIONS ===\n";
echo "1. Clear and rebuild cache if needed\n";
echo "2. Ensure all directories are writable\n";
echo "3. Check file permissions for storage directory\n";
echo "4. Verify database migrations are up to date\n";
echo "5. Monitor memory usage for optimization\n";

echo "\n=== SYSTEM CHECK COMPLETE ===\n";
