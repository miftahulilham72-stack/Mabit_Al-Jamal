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
                                    <button onclick="konfirmasiHapus({{ $s->id }}, '{{ addslashes($s->nama_sesi) }}')" title="Hapus"
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

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapus" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);backdrop-filter:blur(8px);z-index:1000;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#fff;border-radius:20px;padding:32px;max-width:440px;width:100%;box-shadow:0 25px 80px rgba(0,0,0,0.3);animation:modalIn 0.3s ease;">
        <div style="text-align:center;margin-bottom:20px;">
            <div style="width:72px;height:72px;margin:0 auto 16px;background:linear-gradient(135deg,#fef2f2,#fee2e2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;font-size:36px;"></i>
            </div>
            <h3 style="font-size:20px;font-weight:800;color:#0f172a;margin-bottom:6px;">Konfirmasi Hapus Sesi</h3>
            <p style="font-size:13px;color:#64748b;font-weight:500;">Tindakan ini tidak bisa dibatalkan!</p>
        </div>

        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:14px 18px;margin-bottom:20px;">
            <p style="font-size:12px;color:#991b1b;font-weight:600;margin-bottom:4px;">⚠️ Anda akan menghapus sesi:</p>
            <p id="namaSesiHapus" style="font-size:15px;font-weight:800;color:#dc2626;"></p>
            <p style="font-size:11px;color:#991b1b;margin-top:6px;">
                <i class="bi bi-info-circle"></i> Data absensi terkait juga akan terhapus permanen!
            </p>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:8px;">
                <i class="bi bi-shield-lock-fill" style="color:#3b82f6;"></i> Masukkan Password Admin
            </label>
            <input type="password" id="passwordHapus" placeholder="Masukkan password Anda"
                   style="width:100%;padding:14px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:15px;outline:none;font-family:'JetBrains Mono',monospace;font-weight:600;background:#f8fafc;transition:all 0.2s;"
                   onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                   onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';"
                   onkeypress="if(event.key==='Enter') prosesHapus()">
            <div id="errorHapus" style="display:none;color:#ef4444;font-size:12px;font-weight:600;margin-top:8px;">
                <i class="bi bi-x-circle-fill"></i> Password salah!
            </div>
        </div>

        <div style="display:flex;gap:12px;">
            <button onclick="tutupModalHapus()" style="flex:1;padding:14px;border:2px solid #e2e8f0;border-radius:12px;font-weight:700;cursor:pointer;background:#fff;color:#64748b;font-size:14px;transition:all 0.2s;" onmouseover="this.style.background='#f8fafc';" onmouseout="this.style.background='#fff';">
                <i class="bi bi-x-lg"></i> Batal
            </button>
            <button onclick="prosesHapus()" id="btnProsesHapus" style="flex:2;padding:14px;border:none;border-radius:12px;font-weight:700;cursor:pointer;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;font-size:14px;box-shadow:0 4px 16px rgba(239,68,68,0.3);transition:all 0.2s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(239,68,68,0.4)';" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(239,68,68,0.3)';">
                <i class="bi bi-trash-fill"></i> Hapus Sesi
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.9) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

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
    
    let hapusId = null;

    function konfirmasiHapus(id, namaSesi) {
        hapusId = id;
        document.getElementById('namaSesiHapus').textContent = '"' + namaSesi + '"';
        document.getElementById('passwordHapus').value = '';
        document.getElementById('errorHapus').style.display = 'none';
        document.getElementById('modalHapus').style.display = 'flex';
        setTimeout(() => document.getElementById('passwordHapus').focus(), 100);
    }

    function tutupModalHapus() {
        document.getElementById('modalHapus').style.display = 'none';
        hapusId = null;
        document.getElementById('passwordHapus').value = '';
        document.getElementById('errorHapus').style.display = 'none';
    }

    function prosesHapus() {
        const password = document.getElementById('passwordHapus').value;
        const error = document.getElementById('errorHapus');

        if (!password) {
            error.style.display = 'block';
            error.innerHTML = '<i class="bi bi-x-circle-fill"></i> Password harus diisi!';
            return;
        }

        const btn = document.getElementById('btnProsesHapus');
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Menghapus...';

        fetch(`/sesi/${hapusId}/hapus-dengan-password`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ password: password })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            } else {
                error.style.display = 'block';
                error.innerHTML = '<i class="bi bi-x-circle-fill"></i> ' + data.message;
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-trash-fill"></i> Hapus Sesi';
            }
        })
        .catch(errorResponse => {
            alert('⚠️ Terjadi kesalahan: ' + errorResponse.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-trash-fill"></i> Hapus Sesi';
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupModalHapus();
    });

    document.getElementById('modalHapus')?.addEventListener('click', function(e) {
        if (e.target === this) tutupModalHapus();
    });
</script>
@endpush
@endsection