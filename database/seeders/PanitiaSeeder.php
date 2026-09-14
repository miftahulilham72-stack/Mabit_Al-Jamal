<?php

namespace Database\Seeders;

use App\Models\Panitia;
use Illuminate\Database\Seeder;

class PanitiaSeeder extends Seeder
{
    public function run(): void
    {
        $panitia = [
            ['id_panitia' => 'P001', 'nama_lengkap' => 'Ahmad Fauzi', 'jabatan' => 'Ketua', 'no_telepon' => '081234567890'],
            ['id_panitia' => 'P002', 'nama_lengkap' => 'Siti Aminah', 'jabatan' => 'Sekretaris', 'no_telepon' => '081234567891'],
            ['id_panitia' => 'P003', 'nama_lengkap' => 'Budi Setiawan', 'jabatan' => 'Bendahara', 'no_telepon' => '081234567892'],
            ['id_panitia' => 'P004', 'nama_lengkap' => 'Dewi Lestari', 'jabatan' => 'Koordinator Acara', 'no_telepon' => '081234567893'],
            ['id_panitia' => 'P005', 'nama_lengkap' => 'Rizky Hidayat', 'jabatan' => 'Koordinator Konsumsi', 'no_telepon' => '081234567894'],
        ];

        foreach ($panitia as $p) {
            Panitia::create($p);
        }
    }
}