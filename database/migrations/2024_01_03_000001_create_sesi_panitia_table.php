<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesi_panitia', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi', 100);
            $table->enum('tipe_sesi', ['Kehadiran Awal', 'Perkegiatan', 'Penutupan']);
            $table->time('jam_mulai');
            $table->time('batas_waktu');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sesi_panitia');
    }
};