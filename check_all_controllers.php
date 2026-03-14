<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controllers = [
    'SiswaController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'GuruController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'],
    'PelanggaranController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'rekap'],
    'JadwalPiketController' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'getJadwalHariIni'],
    'QRScannerController' => ['index', 'scan', 'generate'],
];

echo "=== CONTROLLER ANALYSIS ===\n\n";

foreach ($controllers as $controller => $methods) {
    $controllerClass = "App\\Http\\Controllers\\{$controller}";
    
    echo "Controller: $controller\n";
    
    if (class_exists($controllerClass)) {
        echo "  Status: ✓ EXISTS\n";
        
        foreach ($methods as $method) {
            if (method_exists($controllerClass, $method)) {
                echo "  Method $method: ✓ EXISTS\n";
            } else {
                echo "  Method $method: ✗ MISSING\n";
            }
        }
    } else {
        echo "  Status: ✗ MISSING\n";
    }
    
    echo "\n";
}

echo "=== VIEW ANALYSIS ===\n";
$views = [
    'siswa.index', 'siswa.create', 'siswa.show', 'siswa.edit',
    'guru.index', 'guru.create', 'guru.show', 'guru.edit',
    'pelanggaran.index', 'pelanggaran.create', 'pelanggaran.show', 'pelanggaran.edit', 'pelanggaran.rekap',
    'jadwal-piket.index', 'jadwal-piket.create', 'jadwal-piket.show', 'jadwal-piket.edit', 'jadwal-piket.hari-ini',
    'qr-scanner.index', 'qr-scanner.scan', 'qr-scanner.generate'
];

foreach ($views as $view) {
    if (view()->exists($view)) {
        echo "View $view: ✓ EXISTS\n";
    } else {
        echo "View $view: ✗ MISSING\n";
    }
}
