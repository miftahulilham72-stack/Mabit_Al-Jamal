@extends('layouts.app')

@section('title', 'Riwayat Absensi Panitia')

@section('content')
<div style="max-width:1200px;margin:0 auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
        <div>
            <h1 style="font-size:20px;font-weight:700;color:#0f172a;">Riwayat Kehadiran Panitia</h1>
            <p style="color:#64748b;font-size:13px;">Log seluruh data absensi panitia MABIT SDI Al-Jamal</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <a href="{{ route('absensi.export.excel', request()->query()) }}" style="background:#10b981;color:#fff;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('absensi.export.pdf', request()->query()) }}" style="background:#ef4444;color:#fff;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;padding:14px 16px;margin-bottom:16px;">
        <form method="GET" style="display:flex;flex-wrap:wrap;align-items:flex-end;gap:12px;">
            <div style="flex:1;min-width:160px;">
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="ID atau Nama..." 
                       style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;background:#f8fafc;">
            </div>
            <div style="min-width:150px;">
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Sesi</label>
                <select name="sesi" style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;background:#f8fafc;">
                    <option value="">Semua</option>
                    @foreach($sesiList ?? [] as $s)
                    <option value="{{ $s->id }}" {{ request('sesi') == $s->id ? 'selected' : '' }}>{{ $s->nama_sesi }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:130px;">
                <label style="font-size:11px;font-weight:600;color:#64748b;display:block;margin-bottom:4px;">Status</label>
                <select name="status" style="width:100%;padding:8px 12px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;outline:none;background:#f8fafc;">
                    <option value="">Semua</option>
                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Tidak Hadir" {{ request('status') == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                </select>
            </div>
            <div style="display:flex;gap:6px;padding-bottom:1px;">
                <button type="submit" style="background:#00236f;color:#fff;padding:8px 20px;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;">Filter</button>
                <a href="{{ route('absensi.log') }}" style="padding:8px 16px;border:1px solid #e2e8f0;border-radius:8px;font-size:13px;color:#64748b;text-decoration:none;background:#fff;">Reset</a>
            </div>
        </form>
    </div>

    <!-- Tabel -->
    <div style="background:#fff;border-radius:10px;border:1px solid #e2e8f0;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.04);">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#00236f;color:#fff;">
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">NO</th>
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">ID</th>
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">NAMA PANITIA</th>
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">JABATAN</th>
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">SESI</th>
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">JAM MASUK</th>
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">STATUS</th>
                        <th style="padding:10px 14px;text-align:left;font-size:11px;font-weight:600;">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi ?? [] as $log)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:10px 14px;color:#94a3b8;">{{ $loop->iteration }}</td>
                        <td style="padding:10px 14px;font-family:monospace;color:#00236f;font-weight:600;">{{ $log->panitia->id_panitia ?? '-' }}</td>
                        <td style="padding:10px 14px;font-weight:500;">{{ $log->panitia->nama_lengkap ?? '-' }}</td>
                        <td style="padding:10px 14px;color:#64748b;">{{ $log->panitia->jabatan ?? '-' }}</td>
                        <td style="padding:10px 14px;color:#64748b;">{{ $log->sesi->nama_sesi ?? '-' }}</td>
                        <td style="padding:10px 14px;font-family:monospace;">{{ $log->jam_masuk ?? '-' }}</td>
                        <td style="padding:10px 14px;">
                            <span style="font-size:9px;padding:2px 14px;border-radius:20px;font-weight:700;{{ ($log->status ?? '') == 'Hadir' ? 'background:#10b98115;color:#10b981;' : 'background:#ef444415;color:#ef4444;' }}">
                                {{ $log->status ?? '-' }}
                            </span>
                        </td>
                        <td style="padding:10px 14px;">
                            <span style="font-size:9px;padding:2px 14px;border-radius:20px;font-weight:700;{{ ($log->keterangan ?? '') == 'Hadir' ? 'background:#10b98115;color:#10b981;' : (($log->keterangan ?? '') == 'Sakit' ? 'background:#f59e0b15;color:#f59e0b;' : (($log->keterangan ?? '') == 'Izin' ? 'background:#3b82f615;color:#3b82f6;' : 'background:#ef444415;color:#ef4444;')) }}">
                                {{ $log->keterangan ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding:40px;text-align:center;color:#94a3b8;">
                            <span class="material-symbols-outlined" style="font-size:36px;display:block;margin-bottom:6px;color:#cbd5e1;">inbox</span>
                            Belum ada data kehadiran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:10px 16px;border-top:1px solid #e2e8f0;background:#f8fafc;">
            {{ isset($absensi) ? $absensi->withQueryString()->links() : '' }}
        </div>
    </div>
</div>
@endsection