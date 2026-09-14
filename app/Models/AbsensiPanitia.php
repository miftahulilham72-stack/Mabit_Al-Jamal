<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiPanitia extends Model
{
    use HasFactory;

    protected $table = 'absensi_panitia';

    protected $fillable = [
        'panitia_id',
        'sesi_id',
        'jam_masuk',
        'status',
        'keterangan',
        'ttd_image',
        'absen_manual',
        'diabsensi_oleh',
    ];

    protected $casts = [
        'absen_manual' => 'boolean',
    ];

    /**
     * Relasi ke panitia
     */
    public function panitia()
    {
        return $this->belongsTo(Panitia::class, 'panitia_id');
    }

    /**
     * Relasi ke sesi
     */
    public function sesi()
    {
        return $this->belongsTo(SesiPanitia::class, 'sesi_id');
    }
}