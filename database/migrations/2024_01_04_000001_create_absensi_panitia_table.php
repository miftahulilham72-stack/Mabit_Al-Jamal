<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi_panitia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('panitia_id')->constrained('panitia')->onDelete('cascade');
            $table->foreignId('sesi_id')->constrained('sesi_panitia')->onDelete('cascade');
            $table->time('jam_masuk');
            $table->enum('status', ['Hadir', 'Tidak Hadir']);
            $table->enum('keterangan', ['Hadir', 'Sakit', 'Izin', 'Alpa'])->default('Hadir');
            $table->text('ttd_image');
            $table->boolean('absen_manual')->default(false);
            $table->string('diabsensi_oleh', 100)->nullable();
            $table->timestamps();
            
            $table->unique(['panitia_id', 'sesi_id'], 'unique_absensi_panitia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_panitia');
    }
};