<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING SIDEBAR CHANGES ===\n\n";

// Read the updated layout file
$layoutFile = __DIR__ . '/resources/views/layouts/app.blade.php';
$content = file_get_contents($layoutFile);

echo "Checking removed links:\n";
echo "=======================\n";

$linksToCheck = [
    'Tambah Siswa' => 'route(\'siswa.create\')',
    'Tambah Pelanggaran' => 'route(\'pelanggaran.create\')',
    'Piket Hari Ini' => 'route(\'jadwal-piket.hari-ini\')'
];

foreach ($linksToCheck as $linkName => $routeString) {
    if (strpos($content, $routeString) === false) {
        echo "✓ $linkName - Successfully removed\n";
    } else {
        echo "✗ $linkName - Still found in sidebar\n";
    }
}

echo "\nChecking remaining links:\n";
echo "=========================\n";

$remainingLinks = [
    'Siswa' => 'route(\'siswa.index\')',
    'Guru' => 'route(\'guru.index\')',
    'Jadwal Piket' => 'route(\'jadwal-piket.index\')',
    'Pelanggaran' => 'route(\'pelanggaran.index\')',
    'Rekap Pelanggaran' => 'route(\'pelanggaran.rekap\')',
    'Izin Keluar' => 'route(\'izin-keluar.index\')',
    'Keterlambatan' => 'route(\'keterlambatan.index\')'
];

foreach ($remainingLinks as $linkName => $routeString) {
    if (strpos($content, $routeString) !== false) {
        echo "✓ $linkName - Still available\n";
    } else {
        echo "✗ $linkName - Missing\n";
    }
}

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Clear browser cache (Ctrl+F5)\n";
echo "2. Login: http://127.0.0.1:8000/login\n";
echo "3. Use: admin@eduspace.com / password123\n";
echo "4. Check sidebar - the following links should be GONE:\n";
echo "   - ❌ Tambah Siswa\n";
echo "   - ❌ Tambah Pelanggaran\n";
echo "   - ❌ Piket Hari Ini\n";
echo "5. These links should still be available:\n";
echo "   - ✅ Siswa (index only)\n";
echo "   - ✅ Pelanggaran (index & rekap)\n";
echo "   - ✅ Jadwal Piket (index only)\n\n";

echo "=== TEST COMPLETE ===\n";
