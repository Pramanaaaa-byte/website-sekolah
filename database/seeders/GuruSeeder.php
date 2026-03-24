<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guru = [
            ['nama' => 'Budi Santoso', 'jabatan' => 'Guru Piket'],
            ['nama' => 'Siti Nurhaliza', 'jabatan' => 'Guru Piket'],
            ['nama' => 'Ahmad Fauzi', 'jabatan' => 'Guru Piket'],
            ['nama' => 'Dewi Lestari', 'jabatan' => 'Guru Piket'],
            ['nama' => 'Eko Prasetyo', 'jabatan' => 'Guru Piket'],
        ];

        foreach ($guru as $data) {
            Guru::create($data);
        }
    }
}
