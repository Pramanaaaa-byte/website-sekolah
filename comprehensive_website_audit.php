<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== COMPREHENSIVE WEBSITE AUDIT ===\n\n";

// 1. Check all routes
echo "1. ROUTES AUDIT\n";
echo "==============\n";

$routes = app('router')->getRoutes();
$problematicRoutes = [];

foreach ($routes as $route) {
    $uri = $route->uri();
    $methods = implode(', ', $route->methods());
    $action = $route->getActionName();
    $middleware = implode(', ', $route->middleware());
    
    // Check if controller method exists
    if (strpos($action, '@') !== false) {
        list($controller, $method) = explode('@', $action);
        if (!class_exists($controller)) {
            $problematicRoutes[] = [
                'uri' => $uri,
                'methods' => $methods,
                'issue' => "Controller class not found: $controller"
            ];
        } elseif (!method_exists($controller, $method)) {
            $problematicRoutes[] = [
                'uri' => $uri,
                'methods' => $methods,
                'issue' => "Method not found: $method in $controller"
            ];
        }
    }
}

if (empty($problematicRoutes)) {
    echo "✓ All routes have valid controllers and methods\n";
} else {
    echo "✗ Found problematic routes:\n";
    foreach ($problematicRoutes as $route) {
        echo "  - {$route['methods']} {$route['uri']}: {$route['issue']}\n";
    }
}

// 2. Check all view files
echo "\n2. VIEWS AUDIT\n";
echo "==============\n";

$viewPaths = [
    __DIR__ . '/resources/views/siswa',
    __DIR__ . '/resources/views/guru',
    __DIR__ . '/resources/views/pelanggaran',
    __DIR__ . '/resources/views/jadwal-piket',
    __DIR__ . '/resources/views/piket',
    __DIR__ . '/resources/views/izin-keluar',
    __DIR__ . '/resources/views/keterlambatan',
    __DIR__ . '/resources/views/auth',
    __DIR__ . '/resources/views/layouts'
];

$expectedViews = [
    'siswa' => ['index', 'create', 'edit', 'show'],
    'guru' => ['index', 'create', 'edit', 'show'],
    'pelanggaran' => ['index', 'create', 'edit', 'show', 'rekap'],
    'jadwal-piket' => ['index', 'create', 'edit', 'show', 'hari-ini'],
    'piket' => ['index', 'create', 'edit', 'show'],
    'izin-keluar' => ['index', 'create', 'edit', 'show'],
    'keterlambatan' => ['index', 'create', 'edit', 'show'],
    'auth' => ['login', 'register', 'forgot-password', 'reset-password'],
    'layouts' => ['app', 'guest']
];

$missingViews = [];

foreach ($expectedViews as $resource => $views) {
    foreach ($views as $view) {
        $viewFile = __DIR__ . "/resources/views/$resource/$view.blade.php";
        if (!file_exists($viewFile)) {
            $missingViews[] = "$resource.$view";
        }
    }
}

if (empty($missingViews)) {
    echo "✓ All expected view files exist\n";
} else {
    echo "✗ Missing view files:\n";
    foreach ($missingViews as $view) {
        echo "  - $view.blade.php\n";
    }
}

// 3. Check database connections and tables
echo "\n3. DATABASE AUDIT\n";
echo "==================\n";

try {
    // Check if database file exists
    $dbPath = __DIR__ . '/database/database.sqlite';
    if (file_exists($dbPath)) {
        echo "✓ Database file exists\n";
        
        // Check tables
        $tables = \DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        $expectedTables = ['users', 'siswa', 'guru', 'pelanggaran', 'jadwal_piket', 'piket', 'izin_keluar', 'keterlambatan'];
        
        $tableNames = array_map(function($table) { return $table->name; }, $tables);
        
        foreach ($expectedTables as $table) {
            if (in_array($table, $tableNames)) {
                echo "✓ Table '$table' exists\n";
            } else {
                echo "✗ Table '$table' missing\n";
            }
        }
    } else {
        echo "✗ Database file not found\n";
    }
} catch (\Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n";
}

// 4. Check controllers
echo "\n4. CONTROLLERS AUDIT\n";
echo "====================\n";

$expectedControllers = [
    'App\Http\Controllers\SiswaController',
    'App\Http\Controllers\GuruController',
    'App\Http\Controllers\PelanggaranController',
    'App\Http\Controllers\JadwalPiketController',
    'App\Http\Controllers\PiketController',
    'App\Http\Controllers\IzinKeluarController',
    'App\Http\Controllers\KeterlambatanController',
    'App\Http\Controllers\DashboardController',
    'App\Http\Controllers\QRScannerController'
];

$missingControllers = [];

foreach ($expectedControllers as $controller) {
    if (!class_exists($controller)) {
        $missingControllers[] = $controller;
    }
}

if (empty($missingControllers)) {
    echo "✓ All expected controllers exist\n";
} else {
    echo "✗ Missing controllers:\n";
    foreach ($missingControllers as $controller) {
        echo "  - $controller\n";
    }
}

// 5. Check models
echo "\n5. MODELS AUDIT\n";
echo "===============\n";

$expectedModels = [
    'App\Models\User',
    'App\Models\Siswa',
    'App\Models\Guru',
    'App\Models\Pelanggaran',
    'App\Models\JadwalPiket',
    'App\Models\Piket',
    'App\Models\IzinKeluar',
    'App\Models\Keterlambatan'
];

$missingModels = [];

foreach ($expectedModels as $model) {
    if (!class_exists($model)) {
        $missingModels[] = $model;
    }
}

if (empty($missingModels)) {
    echo "✓ All expected models exist\n";
} else {
    echo "✗ Missing models:\n";
    foreach ($missingModels as $model) {
        echo "  - $model\n";
    }
}

// 6. Check authentication routes
echo "\n6. AUTHENTICATION AUDIT\n";
echo "========================\n";

$authRoutes = ['login', 'register', 'logout', 'password.request', 'password.reset'];
$missingAuthRoutes = [];

foreach ($authRoutes as $route) {
    if (!Route::has($route)) {
        $missingAuthRoutes[] = $route;
    }
}

if (empty($missingAuthRoutes)) {
    echo "✓ All authentication routes exist\n";
} else {
    echo "✗ Missing authentication routes:\n";
    foreach ($missingAuthRoutes as $route) {
        echo "  - $route\n";
    }
}

echo "\n=== AUDIT COMPLETE ===\n";
echo "Total problematic items found: " . (count($problematicRoutes) + count($missingViews) + count($missingControllers) + count($missingModels) + count($missingAuthRoutes)) . "\n";
