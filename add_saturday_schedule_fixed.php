<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ADDING SATURDAY SCHEDULE (FIXED) ===\n\n";

// Disable foreign key checks temporarily
\DB::statement('PRAGMA foreign_keys = OFF');

use App\Models\JadwalPiket;
use App\Models\Guru;

echo "Adding Saturday jadwal piket data...\n";
$guru = Guru::first();

if ($guru) {
    // Check if Saturday schedule already exists
    $existing = JadwalPiket::where('hari', 'Saturday')->where('is_active', true)->first();
    
    if (!$existing) {
        $saturdaySchedule = [
            'id_guru' => $guru->id_guru,
            'hari' => 'Saturday',
            'jam_mulai' => '07:00:00',
            'jam_selesai' => '12:00:00',
            'semester' => 'Ganjil',
            'tahun_ajaran' => 2026,
            'is_active' => true,
        ];

        JadwalPiket::create($saturdaySchedule);
        echo "  Added: Saturday - {$saturdaySchedule['jam_mulai']} s/d {$saturdaySchedule['jam_selesai']}\n";
    } else {
        echo "  Saturday schedule already exists\n";
    }
}

// Re-enable foreign key checks
\DB::statement('PRAGMA foreign_keys = ON');

echo "\n=== SAMPLE DATA ADDED ===\n";
echo "Saturday Schedule: " . JadwalPiket::where('hari', 'Saturday')->where('is_active', true)->count() . " records\n";
