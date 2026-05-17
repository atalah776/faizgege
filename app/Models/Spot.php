<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi
    protected $fillable = [
        'kode_jemuran',
        'deskripsi',
        'kapasitas',
        'gambar',
        'status_ketersediaan',
        'foto',
        'foto_2', // Tambahkan ini
        'foto_3',
        'harga'
    ];
 
    // Relasi: Satu spot jemuran bisa memiliki banyak riwayat booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}