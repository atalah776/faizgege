<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat akun Admin
        User::create([
            'name' => 'Admin Jemuran',
            'email' => 'admin@jemuranku.com',
            'password' => Hash::make('password123'), // Password default
            'role' => 'admin',
        ]);

        // 2. Membuat akun Pengguna
        User::create([
            'name' => 'Mahasiswa Kos',
            'email' => 'pengguna@jemuranku.com',
            'password' => Hash::make('password123'), // Password default
            'role' => 'pengguna',
        ]);

        // 3. Memanggil Seeder Rak Jemuran yang berisi 5 data master
        $this->call([
            SpotSeeder::class,
        ]);
    }
}
