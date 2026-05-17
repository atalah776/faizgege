<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spots', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jemuran'); // Contoh: A1, Tali-02
            $table->text('deskripsi')->nullable();
            $table->string('kapasitas'); // Contoh: Besar, 5 Kg
            $table->string('gambar')->nullable(); // Path/Nama file gambar
            $table->enum('status_ketersediaan', ['tersedia', 'rusak', 'maintenance'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spots');
    }
};
