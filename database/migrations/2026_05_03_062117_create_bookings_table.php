<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users dan spots
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('spot_id')->constrained('spots')->onDelete('cascade');
            
            // Waktu peminjaman
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            
            // Status Booking
            $table->enum('status_booking', ['menunggu', 'aktif', 'selesai', 'batal'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
