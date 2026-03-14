<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== KEPSEK ACCESS DEBUG ===\n\n";

// Check current user
if (auth()->check()) {
    $user = auth()->user();
    echo "Current User:\n";
    echo "  ID: {$user->id}\n";
    echo "  Name: {$user->name}\n";
    echo "  Email: {$user->email}\n";
    echo "  Role: {$user->role}\n\n";
    
    // Check what routes should be accessible for kepsek
    $kepsekRoutes = [
        'dashboard' => 'Dashboard',
        'siswa.index' => 'Siswa Index',
        'guru.index' => 'Guru Index', 
        'pelanggaran.index' => 'Pelanggaran Index',
        'pelanggaran.rekap' => 'Pelanggaran Rekap',
        'jadwal-piket.index' => 'Jadwal Piket Index',
        'jadwal-piket.hari-ini' => 'Jadwal Piket Hari Ini',
    ];
    
    echo "Routes that should be accessible for kepsek:\n";
    foreach ($kepsekRoutes as $route => $description) {
        $hasAccess = true;
        
        // Check specific route restrictions
        if ($route === 'siswa.create' || $route === 'siswa.store' || $route === 'siswa.edit' || $route === 'siswa.update' || $route === 'siswa.destroy') {
            $hasAccess = false; // These are admin only
        }
        
        if ($route === 'guru.create' || $route === 'guru.store' || $route === 'guru.edit' || $route === 'guru.update' || $route === 'guru.destroy') {
            $hasAccess = false; // These are admin only
        }
        
        echo "  {$route}: " . ($hasAccess ? "✓ ALLOWED" : "✗ DENIED") . " - {$description}\n";
    }
    
    echo "\n=== RECOMMENDED ROUTE ACCESS ===\n";
    echo "For kepsek role, these routes should be accessible:\n";
    echo "  dashboard (✓)\n";
    echo "  siswa.index (✓) - Read only\n";
    echo "  guru.index (✓) - Read only\n";
    echo "  pelanggaran.index (✓) - Read only\n";
    echo "  pelanggaran.rekap (✓) - Read only\n";
    echo "  jadwal-piket.index (✓) - Read only\n";
    echo "  jadwal-piket.hari-ini (✓) - Read only\n";
    echo "  profile (✓)\n";
    
    echo "\n=== ADMIN ONLY ROUTES ===\n";
    echo "These routes should remain admin only:\n";
    echo "  siswa.create, siswa.store, siswa.edit, siswa.update, siswa.destroy\n";
    echo "  guru.create, guru.store, guru.edit, guru.update, guru.destroy\n";
    echo "  pelanggaran.create, pelanggaran.store, pelanggaran.edit, pelanggaran.update, pelanggaran.destroy\n";
    echo "  jadwal-piket.create, jadwal-piket.store, jadwal-piket.edit, jadwal-piket.update, jadwal-piket.destroy\n";
    
} else {
    echo "No user is currently authenticated\n";
}
