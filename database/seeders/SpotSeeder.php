<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spot;

class SpotSeeder extends Seeder
{
    public function run(): void
    {
        $spots = [
            // BLOK A: Area Reguler & Kanopi
            [
                'kode_jemuran' => 'RAK-A01',
                'harga' => 25000,
                'kapasitas' => '15 KG (Pakaian Ringan / Daily Wear)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Area penjemuran premium di sayap barat. Mendapatkan sinar matahari pagi maksimal dari jam 07.00 - 11.00 WIB. Sangat cocok untuk pakaian harian, kemeja, dan katun.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-A02',
                'harga' => 30000,
                'kapasitas' => '25 KG (Pakaian Sedang / Jaket & Denim)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Posisi rak strategis tepat di bawah kanopi transparan anti-UV. Memberikan efek panas optimal sekaligus melindungi warna kain sensitif Anda agar tidak cepat pudar.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-A03',
                'harga' => 25000,
                'kapasitas' => '15 KG (Pakaian Ringan)',
                'status_ketersediaan' => 'maintenance', // <-- Diperbaiki dari 'penuh' menjadi 'maintenance'
                'deskripsi' => 'Rak standar di area lorong utama. Memiliki sirkulasi udara yang baik namun saat ini sedang dalam masa perbaikan dan tidak dapat digunakan sementara waktu.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-A04',
                'harga' => 35000,
                'kapasitas' => '30 KG (Pakaian Keluarga)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Area semi-indoor dengan bantuan kipas exhaust raksasa. Direkomendasikan untuk musim hujan karena pakaian tetap kering tanpa bau apek.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],

            // BLOK B: Area Heavy Duty (Beban Berat)
            [
                'kode_jemuran' => 'RAK-B01',
                'harga' => 50000,
                'kapasitas' => '50 KG (Beban Berat / Bedcover & Selimut)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Rak jemuran ukuran jumbo berkekuatan ekstra baja ringan. Dikhususkan untuk menjemur bedcover ukuran king-size, selimut tebal, sprei, atau handuk dalam jumlah banyak.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-B02',
                'harga' => 25000,
                'kapasitas' => '15 KG (Pakaian Ringan)',
                'status_ketersediaan' => 'maintenance',
                'deskripsi' => 'Area penjemuran sisi timur. Saat ini sedang ditutup sementara untuk dilakukan perawatan engsel pengunci dan pengecatan ulang struktur demi keselamatan pakaian Anda.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-B03',
                'harga' => 40000,
                'kapasitas' => '40 KG (Full Stainless Steel)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Rak 100% Stainless Steel SUS304 anti karat. Sangat aman untuk pakaian putih karena tidak akan meninggalkan noda karat meskipun digunakan bertahun-tahun.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-B04',
                'harga' => 45000,
                'kapasitas' => '45 KG (Tinggi Ekstra)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Rak khusus dengan tinggi 2.5 meter. Didesain secara khusus untuk menjemur gaun panjang, gamis, jas, atau gorden agar ujungnya tidak menyentuh lantai.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],

            // BLOK C: Area Rooftop (Atap Terbuka)
            [
                'kode_jemuran' => 'RAK-C01',
                'harga' => 35000,
                'kapasitas' => '30 KG (Super Windy Area)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Berada di area rooftop paling atas yang memiliki sirkulasi angin (airflow) sangat kencang. Menjamin pakaian Anda kering 2x lebih cepat meskipun cuaca sedang berawan.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-C02',
                'harga' => 35000,
                'kapasitas' => '30 KG (Super Windy Area)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Posisi di rooftop sisi selatan. Mendapatkan terpaan matahari sejak matahari terbit hingga sore hari. Sangat direkomendasikan untuk sterilisasi alami pakaian bayi.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-C03',
                'harga' => 20000,
                'kapasitas' => '10 KG (Pakaian Dalam / Kaos Kaki)',
                'status_ketersediaan' => 'maintenance', // <-- Diperbaiki dari 'penuh' menjadi 'maintenance'
                'deskripsi' => 'Rak jepit model gantung khusus barang-barang kecil. Dilengkapi dengan jaring pengaman agar pakaian tidak terbang tertiup angin kencang.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
            [
                'kode_jemuran' => 'RAK-C04',
                'harga' => 60000,
                'kapasitas' => '60 KG (VIP Private Area)',
                'status_ketersediaan' => 'tersedia',
                'deskripsi' => 'Satu ruangan rooftop tertutup penuh kaca kaca tempered. Fasilitas VIP yang menjamin kebersihan maksimal dari debu jalanan, asap, maupun gangguan burung.',
                'foto' => null, 'foto_2' => null, 'foto_3' => null,
            ],
        ];

        foreach ($spots as $spot) {
            Spot::create($spot);
        }
    }
}
