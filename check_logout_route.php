<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get all routes
$routes = app('router')->getRoutes();
$logoutRoutes = [];

foreach ($routes as $route) {
    if (strpos($route->uri(), 'logout') !== false) {
        $logoutRoutes[] = [
            'uri' => $route->uri(),
            'methods' => implode(', ', $route->methods()),
            'name' => $route->getName(),
        ];
    }
}

echo "=== Logout Routes Found ===\n";
if (empty($logoutRoutes)) {
    echo "No logout routes found\n";
} else {
    foreach ($logoutRoutes as $route) {
        echo "URI: " . $route['uri'] . "\n";
        echo "Methods: " . $route['methods'] . "\n";
        echo "Name: " . $route['name'] . "\n";
        echo "---\n";
    }
}

echo "\n=== All Routes (last 10) ===\n";
$allRoutes = $routes->getRoutes();
$allRoutes = array_slice($allRoutes, -10);
foreach ($allRoutes as $route) {
    echo $route->methods()[0] . " " . $route->uri() . "\n";
}
