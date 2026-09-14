@extends('layouts.app')

@section('title', 'Absen Manual')
@section('page-title', 'Absen Manual')
@section('page-subtitle', 'Admin dapat mengabsensi panitia yang izin/sakit/tidak sempat absen digital')

@section('content')
<div style="max-width:1200px;margin:0 auto;">
    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#0f172a;letter-spacing:-0.5px;display:flex;align-items:center;gap:10px;">
                <i class="bi bi-pencil-square" style="color:#3b82f6;"></i> Absen Manual
            </h1>
            <p style="color:#64748b;font-size:14px;margin-top:2px;">Admin dapat mengabsensi panitia yang izin/sakit/tidak sempat absen digital</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <button onclick="simpanSemua()" id="btnSimpanSemua" class="btn-modern btn-success">
                <i class="bi bi-save-fill"></i> Simpan Semua
            </button>
            <a href="{{ route('absensi.log') }}" class="btn-modern btn-primary">
                <i class="bi bi-clock-history"></i> Lihat Riwayat
            </a>
        </div>
    </div>

    <!-- Info Sesi Aktif -->
    <div class="card-modern" style="margin-bottom:20px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;">
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="width:56px;height:56px;background:{{ $sesiAktif ? 'linear-gradient(135deg,#3b82f6,#2563eb)' : 'linear-gradient(135deg,#ef4444,#dc2626)' }};border-radius:16px;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 20px {{ $sesiAktif ? 'rgba(59,130,246,0.3)' : 'rgba(239,68,68,0.3)' }};">
                <i class="bi bi-calendar-check-fill" style="color:#fff;font-size:26px;"></i>
            </div>
            <div>
                <p style="font-size:11px;font-weight:800;color:{{ $sesiAktif ? '#3b82f6' : '#ef4444' }};text-transform:uppercase;letter-spacing:1px;">Sesi Aktif</p>
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

    <!-- Statistik -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:12px;margin-bottom:20px;">
        <div class="card-modern" style="padding:16px;text-align:center;border-left:4px solid #10b981;">
            <div style="font-size:24px;font-weight:800;color:#10b981;">{{ $statistik['hadir'] ?? 0 }}</div>
            <div style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-top:4px;">
                <i class="bi bi-check-circle-fill" style="color:#10b981;"></i> Hadir
            </div>
        </div>
        <div class="card-modern" style="padding:16px;text-align:center;border-left:4px solid #f59e0b;">
            <div style="font-size:24px;font-weight:800;color:#f59e0b;">{{ $statistik['sakit'] ?? 0 }}</div>
            <div style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-top:4px;">
                <i class="bi bi-emoji-frown-fill" style="color:#f59e0b;"></i> Sakit
            </div>
        </div>
        <div class="card-modern" style="padding:16px;text-align:center;border-left:4px solid #3b82f6;">
            <div style="font-size:24px;font-weight:800;color:#3b82f6;">{{ $statistik['izin'] ?? 0 }}</div>
            <div style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-top:4px;">
                <i class="bi bi-envelope-fill" style="color:#3b82f6;"></i> Izin
            </div>
        </div>
        <div class="card-modern" style="padding:16px;text-align:center;border-left:4px solid #ef4444;">
            <div style="font-size:24px;font-weight:800;color:#ef4444;">{{ $statistik['alpa'] ?? 0 }}</div>
            <div style="font-size:11px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-top:4px;">
                <i class="bi bi-x-circle-fill" style="color:#ef4444;"></i> Alpa
            </div>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card-modern" style="padding:0;overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#00236f;">
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">No</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">ID</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">Nama Panitia</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">Jabatan</th>
                        <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">Status</th>
                        <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($panitia ?? [] as $item)
                    @php $absen = $item->absensi_manual->first(); @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''" data-panitia-id="{{ $item->id }}">
                        <td style="padding:14px 16px;color:#94a3b8;font-weight:600;">{{ $loop->iteration }}</td>
                        <td style="padding:14px 16px;">
                            <span style="font-family:monospace;color:#3b82f6;font-weight:700;background:#3b82f610;padding:4px 10px;border-radius:6px;">{{ $item->id_panitia }}</span>
                        </td>
                        <td style="padding:14px 16px;font-weight:600;color:#0f172a;">{{ $item->nama_lengkap }}</td>
                        <td style="padding:14px 16px;color:#64748b;">{{ $item->jabatan ?? '-' }}</td>
                        <td style="padding:14px 16px;">
                            @if($absen)
                                @php
                                    $statusColors = [
                                        'Hadir' => ['bg' => '#10b98115', 'color' => '#10b981', 'icon' => 'check-circle-fill'],
                                        'Sakit' => ['bg' => '#f59e0b15', 'color' => '#f59e0b', 'icon' => 'emoji-frown-fill'],
                                        'Izin' => ['bg' => '#3b82f615', 'color' => '#3b82f6', 'icon' => 'envelope-fill'],
                                        'Alpa' => ['bg' => '#ef444415', 'color' => '#ef4444', 'icon' => 'x-circle-fill'],
                                    ];
                                    $st = $statusColors[$absen->keterangan] ?? $statusColors['Alpa'];
                                @endphp
                                <span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:{{ $st['bg'] }};color:{{ $st['color'] }};display:inline-flex;align-items:center;gap:4px;">
                                    <i class="bi bi-{{ $st['icon'] }}"></i> {{ $absen->keterangan }}
                                </span>
                            @else
                                <span style="color:#94a3b8;font-size:12px;font-weight:600;">
                                    <i class="bi bi-dash-circle"></i> Belum Absen
                                </span>
                            @endif
                        </td>
                        <td style="padding:14px 16px;text-align:center;">
                            <div style="display:flex;gap:4px;justify-content:center;flex-wrap:wrap;">
                                <button onclick="setKeterangan({{ $item->id }}, 'Hadir')" 
                                        style="padding:6px 12px;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;transition:all 0.2s;display:inline-flex;align-items:center;gap:4px;{{ isset($absen) && $absen->keterangan == 'Hadir' ? 'background:#10b981;color:#fff;' : 'background:#10b98115;color:#10b981;' }}">
                                    <i class="bi bi-check-circle-fill"></i> Hadir
                                </button>
                                <button onclick="setKeterangan({{ $item->id }}, 'Sakit')" 
                                        style="padding:6px 12px;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;transition:all 0.2s;display:inline-flex;align-items:center;gap:4px;{{ isset($absen) && $absen->keterangan == 'Sakit' ? 'background:#f59e0b;color:#fff;' : 'background:#f59e0b15;color:#f59e0b;' }}">
                                    <i class="bi bi-emoji-frown-fill"></i> Sakit
                                </button>
                                <button onclick="setKeterangan({{ $item->id }}, 'Izin')" 
                                        style="padding:6px 12px;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;transition:all 0.2s;display:inline-flex;align-items:center;gap:4px;{{ isset($absen) && $absen->keterangan == 'Izin' ? 'background:#3b82f6;color:#fff;' : 'background:#3b82f615;color:#3b82f6;' }}">
                                    <i class="bi bi-envelope-fill"></i> Izin
                                </button>
                                <button onclick="setKeterangan({{ $item->id }}, 'Alpa')" 
                                        style="padding:6px 12px;border:none;border-radius:8px;font-size:11px;font-weight:700;cursor:pointer;transition:all 0.2s;display:inline-flex;align-items:center;gap:4px;{{ isset($absen) && $absen->keterangan == 'Alpa' ? 'background:#ef4444;color:#fff;' : 'background:#ef444415;color:#ef4444;' }}">
                                    <i class="bi bi-x-circle-fill"></i> Alpa
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:60px 20px;text-align:center;color:#94a3b8;">
                            <i class="bi bi-people" style="font-size:48px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                            <p style="font-weight:700;color:#64748b;">Belum ada panitia terdaftar</p>
                            <p style="font-size:12px;margin-top:4px;">Tambahkan panitia terlebih dahulu di menu Data Panitia</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:14px 24px;border-top:1px solid #e2e8f0;background:#f8fafc;">
            {{ isset($panitia) ? $panitia->withQueryString()->links() : '' }}
        </div>
    </div>

    <!-- Catatan -->
    <div style="margin-top:20px;padding:18px 24px;background:linear-gradient(135deg,#fffbeb,#fef3c7);border:1px solid #fcd34d;border-radius:16px;">
        <div style="display:flex;gap:14px;">
            <div style="width:44px;height:44px;background:#f59e0b;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(245,158,11,0.3);">
                <i class="bi bi-info-circle-fill" style="color:#fff;font-size:22px;"></i>
            </div>
            <div style="font-size:13px;color:#92400e;">
                <p style="font-weight:800;font-size:14px;margin-bottom:6px;">📌 Catatan Penting:</p>
                <ul style="list-style:disc;padding-left:20px;margin-top:4px;line-height:1.8;">
                    <li>Absensi manual untuk panitia yang <strong>tidak sempat absen digital</strong></li>
                    <li>Data akan tercatat sebagai <strong>"Absen Manual"</strong> dengan nama pengabsensi</li>
                    <li>Klik <strong>"Simpan Semua"</strong> untuk menyimpan semua perubahan</li>
                    <li>Status: <strong style="color:#10b981;">Hadir</strong>, <strong style="color:#f59e0b;">Sakit</strong>, <strong style="color:#3b82f6;">Izin</strong>, <strong style="color:#ef4444;">Alpa</strong></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.2); }
    }
</style>

@push('scripts')
<script>
    let changes = {};

    function setKeterangan(panitiaId, keterangan) {
        changes[panitiaId] = keterangan;
        const row = document.querySelector(`tr[data-panitia-id="${panitiaId}"]`);
        if (!row) return;

        // Update tombol
        row.querySelectorAll('td:nth-child(6) button').forEach(btn => {
            const text = btn.textContent.trim();
            const key = text.includes('Hadir') ? 'Hadir' : text.includes('Sakit') ? 'Sakit' : text.includes('Izin') ? 'Izin' : 'Alpa';
            
            const colors = {
                'Hadir': { bg: '#10b981', bgHover: '#10b98115', text: '#10b981' },
                'Sakit': { bg: '#f59e0b', bgHover: '#f59e0b15', text: '#f59e0b' },
                'Izin': { bg: '#3b82f6', bgHover: '#3b82f615', text: '#3b82f6' },
                'Alpa': { bg: '#ef4444', bgHover: '#ef444415', text: '#ef4444' }
            };

            if (key === keterangan) {
                btn.style.background = colors[key].bg;
                btn.style.color = '#ffffff';
            } else {
                btn.style.background = colors[key].bgHover;
                btn.style.color = colors[key].text;
            }
        });

        // Update status
        const statusCell = row.querySelector('td:nth-child(5)');
        const statusData = {
            'Hadir': { bg: '#10b98115', color: '#10b981', icon: 'check-circle-fill' },
            'Sakit': { bg: '#f59e0b15', color: '#f59e0b', icon: 'emoji-frown-fill' },
            'Izin': { bg: '#3b82f615', color: '#3b82f6', icon: 'envelope-fill' },
            'Alpa': { bg: '#ef444415', color: '#ef4444', icon: 'x-circle-fill' }
        };
        const st = statusData[keterangan];
        statusCell.innerHTML = `<span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:${st.bg};color:${st.color};display:inline-flex;align-items:center;gap:4px;"><i class="bi bi-${st.icon}"></i> ${keterangan}</span>`;
    }

    function simpanSemua() {
        if (Object.keys(changes).length === 0) {
            alert('⚠️ Tidak ada perubahan yang disimpan.');
            return;
        }

        if (!confirm(`⚠️ Yakin menyimpan ${Object.keys(changes).length} data absensi manual?`)) {
            return;
        }

        const btn = document.getElementById('btnSimpanSemua');
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Menyimpan...';

        fetch('{{ route("absensi.manual.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ changes })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            } else {
                alert('❌ ' + data.message);
            }
        })
        .catch(error => alert('⚠️ Terjadi kesalahan: ' + error.message))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-save-fill"></i> Simpan Semua';
        });
    }
</script>
@endpush
@endsection