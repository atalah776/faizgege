<?php

namespace Database\Seeders;

use App\Models\Spot;
use Illuminate\Database\Seeder;

class SpotSeeder extends Seeder
{
    public function run(): void
    {
        Spot::create([
            'kode_jemuran' => 'Blok A - Atap Timur',
            'deskripsi' => 'Area jemuran luas, sinar matahari penuh dari pagi sampai sore. Cocok untuk sprei dan selimut.',
            'kapasitas' => 'Besar (Bisa 2 Ember)',
            'status_ketersediaan' => 'tersedia',
        ]);

        Spot::create([
            'kode_jemuran' => 'Blok B - Balkon Lt 2',
            'deskripsi' => 'Area teduh berkanopi. Aman dari hujan tiba-tiba, cocok untuk pakaian dalam atau baju berbahan tipis.',
            'kapasitas' => 'Sedang (1 Ember)',
            'status_ketersediaan' => 'tersedia',
        ]);

        Spot::create([
            'kode_jemuran' => 'Tiang C - Samping Taman',
            'deskripsi' => 'Tali jemuran model memanjang. Sirkulasi udara sangat bagus.',
            'kapasitas' => 'Kecil (Pakaian Harian)',
            'status_ketersediaan' => 'maintenance', // Ceritanya sedang diperbaiki
        ]);
    }
}