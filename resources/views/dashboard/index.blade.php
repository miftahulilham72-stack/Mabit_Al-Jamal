@extends('layouts.app')

@section('title', 'Beranda')
@section('page-title', 'Beranda')
@section('page-subtitle', 'Pantau kehadiran panitia secara real-time')

@section('content')
<div style="max-width:1200px;margin:0 auto;">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#0f172a;letter-spacing:-0.5px;">Pantau Kehadiran</h1>
            <p style="color:#64748b;font-size:14px;margin-top:2px;">Monitoring kehadiran panitia MABIT SDI Al-Jamal</p>
        </div>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('absensi.export.excel') }}" class="btn-modern btn-success">
                <i class="bi bi-file-earmark-excel"></i> Unduh Excel
            </a>
            <a href="{{ route('absensi.export.pdf') }}" class="btn-modern btn-danger">
                <i class="bi bi-file-earmark-pdf"></i> Unduh PDF
            </a>
        </div>
    </div>

    <!-- Sesi Aktif -->
    <div class="card-modern" style="margin-bottom:20px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;">
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);border-radius:16px;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px rgba(59,130,246,0.3);">
                <i class="bi bi-calendar-check" style="color:#fff;font-size:26px;"></i>
            </div>
            <div>
                <p style="font-size:11px;font-weight:800;color:#3b82f6;text-transform:uppercase;letter-spacing:1px;">Sesi Aktif</p>
                @if($sesiAktif)
                    <p style="font-weight:800;color:#0f172a;font-size:17px;margin-top:2px;">
                        {{ $sesiAktif->nama_sesi }}
                        <span style="font-size:13px;font-weight:500;color:#64748b;margin-left:8px;">
                            ({{ \Carbon\Carbon::parse($sesiAktif->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesiAktif->batas_waktu)->format('H:i') }} WIB)
                        </span>
                    </p>
                @else
                    <p style="color:#ef4444;font-weight:700;margin-top:2px;">Tidak ada sesi yang aktif</p>
                @endif
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;background:{{ $sesiAktif ? '#f0fdf4' : '#fef2f2' }};padding:8px 16px;border-radius:20px;border:1px solid {{ $sesiAktif ? '#bbf7d0' : '#fecaca' }};">
            <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:{{ $sesiAktif ? '#10b981' : '#ef4444' }};{{ $sesiAktif ? 'animation:pulse 2s infinite;' : '' }}"></span>
            <span style="font-size:13px;color:{{ $sesiAktif ? '#10b981' : '#ef4444' }};font-weight:700;">{{ $sesiAktif ? 'Aktif' : 'Tidak Aktif' }}</span>
        </div>
    </div>

    <!-- KPI Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;margin-bottom:24px;">
        <div class="card-modern" style="border-top:4px solid #10b981;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Hari Ini</span>
                <span style="font-size:10px;color:#10b981;background:#10b98115;padding:4px 12px;border-radius:20px;font-weight:800;">HADIR</span>
            </div>
            <div style="display:flex;align-items:baseline;gap:8px;">
                <span style="font-size:36px;font-weight:800;color:#0f172a;letter-spacing:-1px;">{{ $hadir ?? 0 }}</span>
                <span style="color:#64748b;font-size:13px;font-weight:600;">/ {{ $totalPanitia ?? 0 }} Panitia</span>
            </div>
            <div style="margin-top:14px;background:#f1f5f9;height:6px;border-radius:4px;overflow:hidden;">
                <div style="background:linear-gradient(90deg,#10b981,#059669);height:100%;border-radius:4px;width:{{ $totalPanitia > 0 ? ($hadir/$totalPanitia)*100 : 0 }}%;transition:width 0.8s;"></div>
            </div>
        </div>

        <div class="card-modern" style="border-top:4px solid #f59e0b;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Hari Ini</span>
                <span style="font-size:10px;color:#f59e0b;background:#f59e0b15;padding:4px 12px;border-radius:20px;font-weight:800;">BELUM HADIR</span>
            </div>
            <div style="display:flex;align-items:baseline;gap:8px;">
                <span style="font-size:36px;font-weight:800;color:#0f172a;letter-spacing:-1px;">{{ $tidakHadir ?? 0 }}</span>
                <span style="color:#64748b;font-size:13px;font-weight:600;">Panitia</span>
            </div>
            <div style="margin-top:14px;background:#f1f5f9;height:6px;border-radius:4px;overflow:hidden;">
                <div style="background:linear-gradient(90deg,#f59e0b,#d97706);height:100%;border-radius:4px;width:{{ $totalPanitia > 0 ? ($tidakHadir/$totalPanitia)*100 : 0 }}%;transition:width 0.8s;"></div>
            </div>
        </div>

        <div class="card-modern" style="border-top:4px solid #3b82f6;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Total</span>
                <span style="font-size:10px;color:#3b82f6;background:#3b82f615;padding:4px 12px;border-radius:20px;font-weight:800;">PANITIA</span>
            </div>
            <div style="display:flex;align-items:baseline;gap:8px;">
                <span style="font-size:36px;font-weight:800;color:#0f172a;letter-spacing:-1px;">{{ $totalPanitia ?? 0 }}</span>
                <span style="color:#64748b;font-size:13px;font-weight:600;">Aktif</span>
            </div>
            <div style="margin-top:14px;background:#f1f5f9;height:6px;border-radius:4px;overflow:hidden;">
                <div style="background:linear-gradient(90deg,#3b82f6,#2563eb);height:100%;border-radius:4px;width:100%;"></div>
            </div>
        </div>
    </div>

    <!-- Log Table -->
    <div class="card-modern" style="padding:0;overflow:hidden;">
        <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
            <span style="font-weight:800;font-size:16px;color:#0f172a;display:flex;align-items:center;gap:10px;">
                <i class="bi bi-clock-history" style="color:#3b82f6;font-size:20px;"></i> Riwayat Kehadiran Terkini
            </span>
            <span style="font-size:11px;color:#94a3b8;font-weight:600;display:flex;align-items:center;gap:6px;">
                <i class="bi bi-arrow-repeat"></i> Diperbarui otomatis setiap 30 detik
            </span>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">No</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">ID</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Nama Panitia</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Jabatan</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Sesi</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Jam Masuk</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs ?? [] as $log)
                    <tr style="border-bottom:1px solid #f1f5f9;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                        <td style="padding:14px 20px;color:#94a3b8;font-weight:600;">{{ $loop->iteration }}</td>
                        <td style="padding:14px 20px;"><span style="font-family:monospace;color:#3b82f6;font-weight:700;background:#3b82f610;padding:4px 10px;border-radius:6px;">{{ $log->panitia->id_panitia ?? '-' }}</span></td>
                        <td style="padding:14px 20px;font-weight:600;color:#0f172a;">{{ $log->panitia->nama_lengkap ?? '-' }}</td>
                        <td style="padding:14px 20px;color:#64748b;">{{ $log->panitia->jabatan ?? '-' }}</td>
                        <td style="padding:14px 20px;color:#64748b;">{{ $log->sesi->nama_sesi ?? '-' }}</td>
                        <td style="padding:14px 20px;font-family:monospace;font-weight:600;">{{ $log->jam_masuk ?? '-' }}</td>
                        <td style="padding:14px 20px;">
                            @if(($log->status ?? '') == 'Hadir')
                                <span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:#10b98115;color:#10b981;display:inline-flex;align-items:center;gap:4px;">
                                    <i class="bi bi-check-circle-fill"></i> Hadir
                                </span>
                            @else
                                <span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:#ef444415;color:#ef4444;display:inline-flex;align-items:center;gap:4px;">
                                    <i class="bi bi-x-circle-fill"></i> Tidak Hadir
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:60px 20px;text-align:center;color:#94a3b8;">
                            <i class="bi bi-inbox" style="font-size:48px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                            <p style="font-weight:700;color:#64748b;">Belum ada data kehadiran</p>
                            <p style="font-size:12px;margin-top:4px;">Data akan muncul setelah panitia melakukan absensi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }
</style>
@endsection