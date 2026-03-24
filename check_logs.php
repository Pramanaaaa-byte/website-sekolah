<?php

echo "=== CHECKING LARAVEL LOGS ===\n\n";

$logFile = __DIR__ . '/storage/logs/laravel.log';

if (file_exists($logFile)) {
    echo "✓ Log file exists\n";
    
    // Read last 50 lines
    $lines = file($logFile);
    $lineCount = count($lines);
    
    echo "Total lines: $lineCount\n";
    echo "Last 20 lines:\n";
    echo "==================\n";
    
    // Get last 20 lines
    $start = max(0, $lineCount - 20);
    for ($i = $start; $i < $lineCount; $i++) {
        echo $lines[$i];
    }
    
    echo "==================\n";
    
} else {
    echo "✗ Log file not found\n";
}

echo "\n=== CHECKING ERROR DETAILS ===\n";

// Check for common errors
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    
    $errors = [
        '500' => substr_count($content, '500 Internal Server Error'),
        '403' => substr_count($content, '403'),
        '404' => substr_count($content, '404'),
        'RoleMiddleware' => substr_count($content, 'RoleMiddleware'),
        'IzinKeluarController' => substr_count($content, 'IzinKeluarController'),
        'KeterlambatanController' => substr_count($content, 'KeterlambatanController'),
    ];
    
    echo "Error count in last log:\n";
    foreach ($errors as $error => $count) {
        echo "  $error: $count\n";
    }
}

echo "\n=== COMPLETE ===\n";
