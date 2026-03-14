<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PELANGGARAN ROUTES CHECK ===\n\n";

$routes = app('router')->getRoutes();
$pelanggaranRoutes = [];

foreach ($routes as $route) {
    if (strpos($route->uri(), 'pelanggaran') !== false) {
        $pelanggaranRoutes[] = [
            'uri' => $route->uri(),
            'methods' => implode(', ', $route->methods()),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    }
}

echo "Pelanggaran Routes Found: " . count($pelanggaranRoutes) . "\n";
foreach ($pelanggaranRoutes as $route) {
    echo "URI: {$route['uri']}\n";
    echo "Methods: {$route['methods']}\n";
    echo "Name: {$route['name']}\n";
    echo "Action: {$route['action']}\n";
    echo "---\n";
}

echo "\n=== ROUTE CHECK COMPLETE ===\n";
