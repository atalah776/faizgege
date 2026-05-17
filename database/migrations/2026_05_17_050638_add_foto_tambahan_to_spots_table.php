<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('spots', function (Blueprint $table) {
        $table->string('foto_2')->nullable()->after('foto');
        $table->string('foto_3')->nullable()->after('foto_2');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spots', function (Blueprint $table) {
            //
        });
    }
};
