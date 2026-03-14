<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Read the last 20 lines of the log file
$logFile = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -20);
    echo "=== Recent Laravel Log (Last 20 lines) ===\n";
    foreach ($lastLines as $line) {
        echo $line;
    }
} else {
    echo "Log file not found: $logFile\n";
}
