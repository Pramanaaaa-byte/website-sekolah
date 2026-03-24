<?php

// Read the routes file
$content = file_get_contents(__DIR__ . '/routes/web.php');

// Fix the syntax errors by removing extra brackets
$content = str_replace(
    "Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'rekap']));",
    "Route::resource('pelanggaran', PelanggaranController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'rekap']));",
    $content
);

$content = str_replace(
    "Route::resource('jadwal-piket', JadwalPiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'getJadwalHariIni']));",
    "Route::resource('jadwal-piket', JadwalPiketController::class)->except(['create', 'store', 'edit', 'update', 'destroy', 'getJadwalHariIni']));",
    $content
);

// Write back the fixed content
file_put_contents(__DIR__ . '/routes/web.php', $content);

echo "Fixed syntax errors in routes/web.php\n";
echo "Removed extra brackets from resource routes\n";
