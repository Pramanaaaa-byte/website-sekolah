<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@eduspace.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@eduspace.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'kepsek',
        ]);

        User::create([
            'name' => 'Guru Piket',
            'email' => 'guru@eduspace.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'guru',
        ]);
    }
}