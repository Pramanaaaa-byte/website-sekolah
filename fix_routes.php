<?php

// Read the current routes file
$routesFile = file_get_contents(__DIR__ . '/routes/web.php');

// Fix the syntax errors by removing extra brackets
$fixedRoutes = str_replace(
    [
        "Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'rekap']));",
        "Route::resource('jadwal-piket', JadwalPiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'getJadwalHariIni']));"
    ],
    [
        "Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'rekap']));",
        "Route::resource('jadwal-piket', JadwalPiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'getJadwalHariIni']));"
    ],
    $routesFile
);

// Write back the fixed routes
file_put_contents(__DIR__ . '/routes/web.php', $fixedRoutes);

echo "Fixed syntax errors in routes/web.php\n";
echo "1. Removed extra bracket from pelanggaran resource route\n";
echo "2. Removed extra bracket from jadwal-piket resource route\n";
