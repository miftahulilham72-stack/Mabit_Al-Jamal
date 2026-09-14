@extends('layouts.app')

@section('title', 'Jadwal Kegiatan')
@section('page-title', 'Jadwal Kegiatan')
@section('page-subtitle', 'Atur jadwal dan batas waktu absensi panitia')

@section('content')
<div style="max-width:1200px;margin:0 auto;">
    <div style="margin-bottom:24px;">
        <h1 style="font-size:24px;font-weight:800;color:#0f172a;letter-spacing:-0.5px;">Jadwal Kegiatan</h1>
        <p style="color:#64748b;font-size:14px;margin-top:2px;">Tambahkan, edit, atau atur batas waktu absensi</p>
    </div>

    <div style="display:grid;grid-template-columns:1fr 2fr;gap:20px;">
        <!-- Form Tambah Sesi -->
        <div class="card-modern">
            <h3 style="font-size:16px;font-weight:800;color:#0f172a;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
                <span style="width:36px;height:36px;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-plus-circle-fill" style="color:#fff;font-size:18px;"></i>
                </span>
                Buat Jadwal Baru
            </h3>

            @if(session('success'))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#10b981;padding:12px 16px;border-radius:12px;font-size:13px;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('sesi.store') }}" style="display:flex;flex-direction:column;gap:16px;">
                @csrf
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Nama Kegiatan</label>
                    <input type="text" name="nama_sesi" required placeholder="Contoh: Pembukaan MABIT"
                           style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;background:#f8fafc;font-weight:500;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Kategori</label>
                    <select name="tipe_sesi" required style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;background:#f8fafc;font-weight:500;cursor:pointer;transition:all 0.2s;"
                            onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                            onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                        <option value="Kehadiran Awal">🏁 Kehadiran Awal</option>
                        <option value="Perkegiatan">📚 Perkegiatan</option>
                        <option value="Penutupan">🎉 Penutupan</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Jam Mulai</label>
                    <input type="time" name="jam_mulai" required 
                           style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;background:#f8fafc;font-weight:600;font-family:monospace;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Batas Akhir Absen</label>
                    <input type="time" name="batas_waktu" required 
                           style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;background:#f8fafc;font-weight:600;font-family:monospace;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <button type="submit" class="btn-modern btn-primary" style="justify-content:center;padding:14px;font-size:14px;">
                    <i class="bi bi-save-fill"></i> SIMPAN JADWAL
                </button>
            </form>
        </div>

        <!-- Daftar Sesi -->
        <div class="card-modern" style="padding:0;overflow:hidden;">
            <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
                <h3 style="font-size:16px;font-weight:800;color:#0f172a;display:flex;align-items:center;gap:10px;">
                    <span style="width:36px;height:36px;background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-list-check" style="color:#fff;font-size:18px;"></i>
                    </span>
                    Daftar Jadwal
                </h3>
                <span style="font-size:13px;color:#64748b;font-weight:600;">Total: {{ isset($sesi) ? $sesi->count() : 0 }} jadwal</span>
            </div>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Nama Kegiatan</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Kategori</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Jam Mulai</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Batas Akhir</th>
                            <th style="padding:14px 16px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Status</th>
                            <th style="padding:14px 16px;text-align:center;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sesi ?? [] as $s)
                        <tr style="border-bottom:1px solid #f1f5f9;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                            <td style="padding:14px 16px;font-weight:600;color:#0f172a;">{{ $s->nama_sesi }}</td>
                            <td style="padding:14px 16px;">
                                @php
                                    $kategoriColors = [
                                        'Kehadiran Awal' => ['bg' => '#3b82f615', 'color' => '#3b82f6', 'icon' => 'flag-fill'],
                                        'Perkegiatan' => ['bg' => '#8b5cf615', 'color' => '#8b5cf6', 'icon' => 'book-fill'],
                                        'Penutupan' => ['bg' => '#f59e0b15', 'color' => '#f59e0b', 'icon' => 'star-fill'],
                                    ];
                                    $cat = $kategoriColors[$s->tipe_sesi] ?? ['bg' => '#64748b15', 'color' => '#64748b', 'icon' => 'circle-fill'];
                                @endphp
                                <span style="font-size:10px;padding:4px 12px;border-radius:20px;font-weight:800;background:{{ $cat['bg'] }};color:{{ $cat['color'] }};display:inline-flex;align-items:center;gap:4px;">
                                    <i class="bi bi-{{ $cat['icon'] }}"></i> {{ $s->tipe_sesi }}
                                </span>
                            </td>
                            <td style="padding:14px 16px;font-family:monospace;font-weight:600;">{{ \Carbon\Carbon::parse($s->jam_mulai)->format('H:i') }}</td>
                            <td style="padding:14px 16px;font-family:monospace;font-weight:600;">{{ \Carbon\Carbon::parse($s->batas_waktu)->format('H:i') }}</td>
                            <td style="padding:14px 16px;">
                                @if($s->is_active)
                                    <span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:#10b98115;color:#10b981;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-broadcast"></i> Sedang Berlangsung
                                    </span>
                                @else
                                    <span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:#64748b15;color:#64748b;display:inline-flex;align-items:center;gap:4px;">
                                        <i class="bi bi-pause-circle"></i> Belum Aktif
                                    </span>
                                @endif
                            </td>
                            <td style="padding:14px 16px;text-align:center;">
                                <div style="display:flex;gap:6px;justify-content:center;">
                                    <button onclick="toggleSesi({{ $s->id }})" title="{{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}" 
                                            style="width:34px;height:34px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:{{ $s->is_active ? '#f59e0b' : '#10b981' }};cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;"
                                            onmouseover="this.style.background='{{ $s->is_active ? '#f59e0b' : '#10b981' }}';this.style.color='#fff';this.style.borderColor='{{ $s->is_active ? '#f59e0b' : '#10b981' }}';"
                                            onmouseout="this.style.background='#fff';this.style.color='{{ $s->is_active ? '#f59e0b' : '#10b981' }}';this.style.borderColor='#e2e8f0';">
                                        <i class="bi bi-{{ $s->is_active ? 'pause-fill' : 'play-fill' }}"></i>
                                    </button>
                                    <button onclick="hapusSesi({{ $s->id }})" title="Hapus"
                                            style="width:34px;height:34px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#ef4444;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;"
                                            onmouseover="this.style.background='#ef4444';this.style.color='#fff';this.style.borderColor='#ef4444';"
                                            onmouseout="this.style.background='#fff';this.style.color='#ef4444';this.style.borderColor='#e2e8f0';">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="padding:60px 20px;text-align:center;color:#94a3b8;">
                                <i class="bi bi-calendar-x" style="font-size:48px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                                <p style="font-weight:700;color:#64748b;">Belum ada jadwal kegiatan</p>
                                <p style="font-size:12px;margin-top:4px;">Klik "Buat Jadwal Baru" untuk menambahkan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleSesi(id) {
        fetch(`/sesi/${id}/toggle-active`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            alert(data.success ? '✅ ' + data.message : '❌ ' + data.message);
            if (data.success) location.reload();
        })
        .catch(() => alert('⚠️ Terjadi kesalahan'));
    }
    
    function hapusSesi(id) {
        if (confirm('⚠️ Yakin ingin menghapus jadwal ini?')) {
            fetch(`/sesi/${id}`, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                alert(data.success ? '✅ ' + data.message : '❌ ' + data.message);
                if (data.success) location.reload();
            })
            .catch(() => alert('⚠️ Terjadi kesalahan'));
        }
    }
</script>
@endpush
@endsection