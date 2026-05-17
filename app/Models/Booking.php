<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // WAJIB ADA: Daftarkan kolom yang boleh diisi manual
    protected $fillable = [
        'user_id', 
        'spot_id', 
        'waktu_mulai', 
        'waktu_selesai', 
        'status_booking',
        'bukti_pembayaran'
    ];

    public function spot() {
        return $this->belongsTo(Spot::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}