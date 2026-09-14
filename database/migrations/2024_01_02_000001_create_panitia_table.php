<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panitia', function (Blueprint $table) {
            $table->id();
            $table->string('id_panitia', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('jabatan', 100)->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('id_panitia');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panitia');
    }
};