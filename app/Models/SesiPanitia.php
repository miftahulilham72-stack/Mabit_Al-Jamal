<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SesiPanitia extends Model
{
    use HasFactory;

    protected $table = 'sesi_panitia';

    protected $fillable = [
        'nama_sesi',
        'tipe_sesi',
        'jam_mulai',
        'batas_waktu',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function absensi()
    {
        return $this->hasMany(AbsensiPanitia::class, 'sesi_id');
    }

    /**
     * Cek status berdasarkan jam masuk
     * Toleransi 3 menit setelah batas waktu
     */
    public function getStatus($jamMasuk)
    {
        $jamMulai = Carbon::parse($this->jam_mulai, 'Asia/Jakarta');
        $batasWaktu = Carbon::parse($this->batas_waktu, 'Asia/Jakarta');
        $jamMasukTime = Carbon::parse($jamMasuk, 'Asia/Jakarta');

        if ($jamMasukTime->lte($batasWaktu)) {
            return 'Hadir';
        } else {
            return 'Tidak Hadir';
        }
    }
}