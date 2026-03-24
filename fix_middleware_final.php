<?php

echo "=== FINAL MIDDLEWARE FIX ===\n\n";

// Read current middleware
$currentMiddleware = file_get_contents(__DIR__ . '/app/Http/Middleware/RoleMiddleware.php');

// Create improved middleware
$improvedMiddleware = '<?php

namespace App\\Http\\Middleware;

use Closure;
use Illuminate\\Http\\Request;
use Symfony\\Component\\HttpFoundation\\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \\Closure(\\Illuminate\\Http\\Request): (\\Symfony\\Component\\HttpFoundation\\Response)  $next
     * @param  string $role The role(s) required to access the resource
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // First check if user is authenticated
        if (!auth()->user()) {
            if ($request->expectsJson()) {
                return response()->json([\'error\' => \'Unauthorized\'], 403);
            }
            abort(403, \'Unauthorized access\');
        }

        // Get user role
        $userRole = auth()->user()->role;
        
        // Parse roles - handle both "role:admin,guru" and "admin,guru"
        $allowedRoles = [];
        
        if (strpos($role, \':\') !== false) {
            // Remove "role:" prefix and split by comma
            $roleString = str_replace(\'role:\', \'\', $role);
            $allowedRoles = array_map(\'trim\', explode(\',\', $roleString));
        } else {
            // Direct comma-separated roles
            $allowedRoles = array_map(\'trim\', explode(\',\', $role));
        }
        
        // Check if user role is allowed
        if (!in_array($userRole, $allowedRoles)) {
            if ($request->expectsJson()) {
                return response()->json([\'error\' => \'Unauthorized\'], 403);
            }
            abort(403, \'Unauthorized access\');
        }
        
        return $next($request);
    }
}';

// Backup original middleware
$backupFile = __DIR__ . '/app/Http/Middleware/RoleMiddleware.php.backup';
copy(__DIR__ . '/app/Http/Middleware/RoleMiddleware.php', $backupFile);

// Write improved middleware
file_put_contents(__DIR__ . '/app/Http/Middleware/RoleMiddleware.php', $improvedMiddleware);

echo "✓ Original middleware backed up\n";
echo "✓ Improved middleware written\n";
echo "✓ Role parsing: str_replace + explode + trim\n";
echo "✓ Multiple role support: admin,guru\n";
echo "✓ Better error handling\n";

echo "\n=== CLEARING ALL CACHES ===\n";

// Clear all possible caches
$commands = [
    'cache:clear',
    'config:clear', 
    'route:clear',
    'view:clear',
    'optimize:clear'
];

foreach ($commands as $command) {
    echo "Running: php artisan $command\n";
    $output = [];
    $return_var = 0;
    exec("php artisan $command 2>&1", $output, $return_var);
    
    if ($return_var === 0) {
        echo "✓ Success\n";
    } else {
        echo "✗ Error: " . implode("\n", $output) . "\n";
    }
}

echo "\n=== INSTRUCTIONS ===\n";
echo "1. Restart Laravel server:\n";
echo "   php artisan serve --host=127.0.0.1 --port=8000\n";
echo "2. Test with fresh browser:\n";
echo "   - Close ALL browser windows\n";
echo "   - Open new incognito window\n";
echo "   - Go to: http://127.0.0.1:8000/login\n";
echo "   - Login: guru@eduspace.com / password123\n";
echo "   - Test: http://127.0.0.1:8000/izin-keluar/create\n";
echo "3. If still 403, check:\n";
echo "   - Browser network tab for actual request\n";
echo "   - Temporary routes: http://127.0.0.1:8000/temp-izin-keluar-create\n";
echo "   - Server logs for new errors\n";

echo "\n=== COMPLETE ===\n";
