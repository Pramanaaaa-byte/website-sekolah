<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== FOREIGN KEY CHECK ===\n\n";

// Check foreign key constraints
echo "Foreign Key Constraints:\n";
$foreignKeys = \DB::select("PRAGMA foreign_key_list(pelanggaran)");
foreach ($foreignKeys as $fk) {
    echo "  Table: {$fk->table}, Column: {$fk->from}, References: {$fk->table}({$fk->to})\n";
}

echo "\nChecking data integrity:\n";
$siswaIds = \DB::table('siswa')->pluck('id_siswa')->toArray();
$guruIds = \DB::table('guru')->pluck('id_guru')->toArray();

echo "Available Siswa IDs: " . implode(', ', $siswaIds) . "\n";
echo "Available Guru IDs: " . implode(', ', $guruIds) . "\n";

// Test if we can create a simple record without foreign keys
echo "\nTesting simple pelanggaran record...\n";
try {
    \DB::table('pelanggaran')->insert([
        'id_siswa' => 1,
        'id_guru' => 1,
        'tanggal' => '2026-03-13',
        'jenis_pelanggaran' => 'Test',
        'keterangan' => 'Test',
        'sanksi' => 'Test',
        'poin' => 1,
    ]);
    echo "  Simple pelanggaran record: ✓ SUCCESS\n";
} catch (\Exception $e) {
    echo "  Simple pelanggaran record: ✗ FAILED - " . $e->getMessage() . "\n";
}

echo "\n=== FOREIGN KEY CHECK COMPLETE ===\n";
