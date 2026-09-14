<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panitia extends Model
{
    use HasFactory;

    protected $table = 'panitia';

    protected $fillable = [
        'id_panitia',
        'nama_lengkap',
        'jabatan',
        'no_telepon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke absensi panitia
     */
    public function absensi()
    {
        return $this->hasMany(AbsensiPanitia::class);
    }

    /**
     * Relasi ke absensi manual
     */
    public function absensi_manual()
    {
        return $this->hasMany(AbsensiPanitia::class)->where('absen_manual', true);
    }
}