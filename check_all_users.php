<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

echo "=== USER ANALYSIS ===\n\n";

// Check all users
$users = User::all();
echo "Total Users: " . $users->count() . "\n";
foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
}

echo "\n=== GURU ANALYSIS ===\n";
$gurus = Guru::all();
echo "Total Guru: " . $gurus->count() . "\n";
foreach ($gurus as $guru) {
    echo "ID: {$guru->id_guru}, Name: {$guru->nama}, Jabatan: {$guru->jabatan}\n";
}

echo "\n=== SISWA ANALYSIS ===\n";
$siswas = Siswa::all();
echo "Total Siswa: " . $siswas->count() . "\n";
foreach ($siswas as $siswa) {
    echo "ID: {$siswa->id_siswa}, NIS: {$siswa->nis}, Name: {$siswa->nama}, Kelas: {$siswa->kelas}\n";
}

echo "\n=== ROUTE ANALYSIS ===\n";
$routes = app('router')->getRoutes();
$siswaRoutes = [];
foreach ($routes as $route) {
    if (strpos($route->uri(), 'siswa') !== false) {
        $siswaRoutes[] = [
            'uri' => $route->uri(),
            'methods' => implode(', ', $route->methods()),
            'name' => $route->getName(),
        ];
    }
}

echo "Siswa Routes Found: " . count($siswaRoutes) . "\n";
foreach ($siswaRoutes as $route) {
    echo "URI: {$route['uri']}, Methods: {$route['methods']}, Name: {$route['name']}\n";
}
