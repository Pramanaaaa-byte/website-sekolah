<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== COMPREHENSIVE PAGE CHECK ===\n\n";

// Important routes to check
$routes = [
    'dashboard' => 'Dashboard',
    'siswa.index' => 'Siswa Index',
    'siswa.create' => 'Siswa Create',
    'guru.index' => 'Guru Index', 
    'guru.create' => 'Guru Create',
    'pelanggaran.index' => 'Pelanggaran Index',
    'pelanggaran.create' => 'Pelanggaran Create',
    'pelanggaran.rekap' => 'Pelanggaran Rekap',
    'jadwal-piket.index' => 'Jadwal Piket Index',
    'jadwal-piket.create' => 'Jadwal Piket Create',
    'jadwal-piket.hari-ini' => 'Jadwal Piket Hari Ini',
    'login' => 'Login',
    'logout' => 'Logout',
];

echo "Checking Routes:\n";
foreach ($routes as $routeName => $description) {
    if (Route::has($routeName)) {
        echo "✓ $routeName - $description\n";
        
        // Check if view exists for the route
        $route = app('router')->getRoutes()->getByName($routeName);
        if ($route) {
            $action = $route->getActionName();
            if (strpos($action, '@') !== false) {
                list($controller, $method) = explode('@', $action);
                try {
                    $controllerInstance = new $controller();
                    if (method_exists($controllerInstance, $method)) {
                        echo "  ✓ Controller method exists\n";
                    } else {
                        echo "  ✗ Controller method missing\n";
                    }
                } catch (\Exception $e) {
                    echo "  ⚠ Controller error: " . $e->getMessage() . "\n";
                }
            }
        }
    } else {
        echo "✗ $routeName - $description\n";
    }
}

echo "\nChecking Views:\n";
$viewDirs = ['siswa', 'guru', 'pelanggaran', 'jadwal-piket'];
foreach ($viewDirs as $viewDir) {
    $viewPath = __DIR__ . "/resources/views/$viewDir";
    if (is_dir($viewPath)) {
        $files = glob("$viewPath/*.blade.php");
        echo "✓ $viewDir: " . count($files) . " files\n";
        foreach ($files as $file) {
            $fileName = basename($file, '.blade.php');
            echo "  ✓ $fileName.blade.php\n";
        }
    } else {
        echo "✗ $viewDir: Directory missing\n";
    }
}

echo "\nChecking Controllers:\n";
$controllers = [
    'SiswaController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'GuruController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'PelanggaranController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'rekap'],
    'JadwalPiketController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'getJadwalHariIni'],
];

foreach ($controllers as $controller => $methods) {
    $controllerClass = "App\\Http\\Controllers\\{$controller}";
    if (class_exists($controllerClass)) {
        echo "✓ $controller: EXISTS\n";
        foreach ($methods as $method) {
            if (method_exists($controllerClass, $method)) {
                echo "  ✓ $method\n";
            } else {
                echo "  ✗ $method\n";
            }
        }
    } else {
        echo "✗ $controller: MISSING\n";
    }
}

echo "\n=== PAGE CHECK COMPLETE ===\n";
