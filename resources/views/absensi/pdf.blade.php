<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran Panitia</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 12px; 
            color: #1e293b;
            padding: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 3px solid #00236f;
        }
        .header h1 { 
            color: #00236f; 
            font-size: 20px;
            margin-bottom: 4px;
        }
        .header h2 {
            color: #1e293b;
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 8px;
        }
        .header .info {
            color: #64748b;
            font-size: 11px;
            margin-top: 6px;
        }
        .info-box {
            display: flex;
            justify-content: space-between;
            background: #f8fafc;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            border-left: 4px solid #00236f;
        }
        .info-box .item {
            text-align: center;
        }
        .info-box .item .label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
        }
        .info-box .item .value {
            font-size: 16px;
            font-weight: bold;
            color: #00236f;
            margin-top: 4px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        th { 
            background: #00236f; 
            color: white; 
            padding: 10px 8px; 
            text-align: left; 
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td { 
            padding: 8px; 
            border-bottom: 1px solid #e2e8f0; 
            font-size: 11px;
        }
        tr:nth-child(even) { background: #f8fafc; }
        .badge-hadir { 
            background: #10b981; 
            color: white; 
            padding: 2px 10px; 
            border-radius: 20px; 
            font-size: 9px; 
            font-weight: bold;
            display: inline-block;
        }
        .badge-tidak { 
            background: #ef4444; 
            color: white; 
            padding: 2px 10px; 
            border-radius: 20px; 
            font-size: 9px; 
            font-weight: bold;
            display: inline-block;
        }
        .badge-sakit { background: #f59e0b; color: white; padding: 2px 10px; border-radius: 20px; font-size: 9px; font-weight: bold; }
        .badge-izin { background: #3b82f6; color: white; padding: 2px 10px; border-radius: 20px; font-size: 9px; font-weight: bold; }
        .badge-alpa { background: #ef4444; color: white; padding: 2px 10px; border-radius: 20px; font-size: 9px; font-weight: bold; }
        .footer { 
            margin-top: 24px; 
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            text-align: center; 
            color: #64748b; 
            font-size: 10px;
        }
        .footer .ttd {
            margin-top: 40px;
            display: flex;
            justify-content: space-around;
        }
        .footer .ttd .box {
            text-align: center;
        }
        .footer .ttd .box .line {
            margin-top: 60px;
            border-top: 1px solid #1e293b;
            padding-top: 4px;
            width: 150px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>REKAP KEHADIRAN PANITIA</h1>
        <h2>MABIT SDI Al-Jamal</h2>
        <div class="info">
            Dicetak: {{ date('d/m/Y H:i:s') }} WIB
        </div>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <div class="item">
            <div class="label">Total Data</div>
            <div class="value">{{ $absensi->count() }}</div>
        </div>
        <div class="item">
            <div class="label">Hadir</div>
            <div class="value" style="color:#10b981;">{{ $absensi->where('status', 'Hadir')->count() }}</div>
        </div>
        <div class="item">
            <div class="label">Tidak Hadir</div>
            <div class="value" style="color:#ef4444;">{{ $absensi->where('status', 'Tidak Hadir')->count() }}</div>
        </div>
        <div class="item">
            <div class="label">Tanggal</div>
            <div class="value" style="font-size:13px;">{{ date('d/m/Y') }}</div>
        </div>
    </div>

    <!-- Tabel -->
    <table>
        <thead>
            <tr>
                <th style="width:30px;">No</th>
                <th style="width:60px;">ID</th>
                <th>Nama Panitia</th>
                <th>Jabatan</th>
                <th>Sesi</th>
                <th style="width:70px;">Jam Masuk</th>
                <th style="width:80px;">Status</th>
                <th style="width:80px;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $i => $log)
            <tr>
                <td>{{ $i+1 }}</td>
                <td style="font-family:monospace;font-weight:bold;color:#00236f;">{{ $log->panitia->id_panitia ?? '-' }}</td>
                <td style="font-weight:bold;">{{ $log->panitia->nama_lengkap ?? '-' }}</td>
                <td>{{ $log->panitia->jabatan ?? '-' }}</td>
                <td>{{ $log->sesi->nama_sesi ?? '-' }}</td>
                <td style="font-family:monospace;">{{ $log->jam_masuk ?? '-' }}</td>
                <td>
                    @if(($log->status ?? '') == 'Hadir')
                        <span class="badge-hadir">Hadir</span>
                    @else
                        <span class="badge-tidak">Tidak Hadir</span>
                    @endif
                </td>
                <td>
                    @if(($log->keterangan ?? '') == 'Hadir')
                        <span class="badge-hadir">Hadir</span>
                    @elseif(($log->keterangan ?? '') == 'Sakit')
                        <span class="badge-sakit">Sakit</span>
                    @elseif(($log->keterangan ?? '') == 'Izin')
                        <span class="badge-izin">Izin</span>
                    @elseif(($log->keterangan ?? '') == 'Alpa')
                        <span class="badge-alpa">Alpa</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:40px;color:#94a3b8;">
                    Belum ada data kehadiran
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Dicetak dari Sistem Absensi Panitia MABIT SDI Al-Jamal</p>
        <div class="ttd">
            <div class="box">
                <div>Mengetahui,</div>
                <div class="line">Ketua Panitia</div>
            </div>
            <div class="box">
                <div>{{ date('d/m/Y') }}</div>
                <div class="line">Admin</div>
            </div>
        </div>
    </div>
</body>
</html>