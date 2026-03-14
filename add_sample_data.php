<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ADDING SAMPLE DATA ===\n\n";

// Add sample pelanggaran data
use App\Models\Pelanggaran;
use App\Models\JadwalPiket;
use App\Models\Siswa;
use App\Models\Guru;

echo "Adding sample pelanggaran data...\n";
$siswa = Siswa::first();
$guru = Guru::first();

if ($siswa && $guru) {
    $pelanggaranData = [
        [
            'id_siswa' => $siswa->id_siswa,
            'id_guru' => $guru->id_guru,
            'tanggal' => now()->format('Y-m-d'),
            'jenis_pelanggaran' => 'Terlambat Masuk Kelas',
            'keterangan' => 'Siswa datang terlambat 15 menit',
            'sanksi' => 'Menulis surat pernyataan',
            'poin' => 5,
        ],
        [
            'id_siswa' => $siswa->id_siswa,
            'id_guru' => $guru->id_guru,
            'tanggal' => now()->format('Y-m-d'),
            'jenis_pelanggaran' => 'Tidak Memakai Seragam',
            'keterangan' => 'Siswa tidak menggunakan seragam sekolah',
            'sanksi' => 'Peringatan dan pembinaan',
            'poin' => 3,
        ],
        [
            'id_siswa' => $siswa->id_siswa,
            'id_guru' => $guru->id_guru,
            'tanggal' => now()->format('Y-m-d'),
            'jenis_pelanggaran' => 'Mengganggu Teman',
            'keterangan' => 'Siswa terlibat mengganggu teman di kelas',
            'sanksi' => 'Panggilan orang tua',
            'poin' => 10,
        ],
    ];

    foreach ($pelanggaranData as $data) {
        Pelanggaran::create($data);
        echo "  Added: {$data['jenis_pelanggaran']} - {$data['poin']} poin\n";
    }
}

echo "\nAdding sample jadwal piket data...\n";
$jadwalPiketData = [
    [
        'id_guru' => $guru->id_guru,
        'hari' => 'Monday',
        'jam_mulai' => '07:00:00',
        'jam_selesai' => '15:00:00',
        'semester' => 'Ganjil',
        'tahun_ajaran' => 2026,
        'is_active' => true,
    ],
    [
        'id_guru' => $guru->id_guru,
        'hari' => 'Tuesday',
        'jam_mulai' => '07:00:00',
        'jam_selesai' => '15:00:00',
        'semester' => 'Ganjil',
        'tahun_ajaran' => 2026,
        'is_active' => true,
    ],
    [
        'id_guru' => $guru->id_guru,
        'hari' => 'Wednesday',
        'jam_mulai' => '07:00:00',
        'jam_selesai' => '15:00:00',
        'semester' => 'Ganjil',
        'tahun_ajaran' => 2026,
        'is_active' => true,
    ],
    [
        'id_guru' => $guru->id_guru,
        'hari' => 'Thursday',
        'jam_mulai' => '07:00:00',
        'jam_selesai' => '15:00:00',
        'semester' => 'Ganjil',
        'tahun_ajaran' => 2026,
        'is_active' => true,
    ],
    [
        'id_guru' => $guru->id_guru,
        'hari' => 'Friday',
        'jam_mulai' => '07:00:00',
        'jam_selesai' => '15:00:00',
        'semester' => 'Ganjil',
        'tahun_ajaran' => 2026,
        'is_active' => true,
    ],
];

foreach ($jadwalPiketData as $data) {
    JadwalPiket::create($data);
    echo "  Added: {$data['hari']} - {$data['jam_mulai']} s/d {$data['jam_selesai']}\n";
}

echo "\n=== SAMPLE DATA ADDED SUCCESSFULLY ===\n";
echo "Pelanggaran: " . Pelanggaran::count() . " records\n";
echo "Jadwal Piket: " . JadwalPiket::count() . " records\n";
