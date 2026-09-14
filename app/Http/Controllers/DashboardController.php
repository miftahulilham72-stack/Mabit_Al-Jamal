<?php

namespace App\Http\Controllers;

use App\Models\Panitia;
use App\Models\SesiPanitia;
use App\Models\AbsensiPanitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function index()
    {
        // Total panitia
        $totalPanitia = Panitia::where('is_active', true)->count();
        
        // Sesi aktif
        $sesiAktif = SesiPanitia::where('is_active', true)->first();
        
        // Statistik hari ini
        $today = now()->toDateString();
        $hadir = AbsensiPanitia::whereDate('created_at', $today)
                               ->where('status', 'Hadir')
                               ->count();
        $tidakHadir = $totalPanitia - $hadir;
        
        // Log terbaru
        $logs = AbsensiPanitia::with(['panitia', 'sesi'])
                              ->orderBy('created_at', 'desc')
                              ->limit(10)
                              ->get();
        
        return view('dashboard.index', compact(
            'totalPanitia',
            'sesiAktif',
            'hadir',
            'tidakHadir',
            'logs'
        ));
    }
}