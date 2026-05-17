<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin
        User::create([
            'name' => 'Admin Jemuran',
            'email' => 'admin@jemuranku.com',
            'password' => Hash::make('password123'), // Password default
            'role' => 'admin',
        ]);

        // Membuat akun Pengguna
        User::create([
            'name' => 'Mahasiswa Kos',
            'email' => 'pengguna@jemuranku.com',
            'password' => Hash::make('password123'), // Password default
            'role' => 'pengguna',
        ]);
    }
}