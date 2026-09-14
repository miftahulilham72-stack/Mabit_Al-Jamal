@extends('layouts.app')

@section('title', 'Data Panitia')
@section('page-title', 'Data Panitia')
@section('page-subtitle', 'Kelola data panitia MABIT SDI Al-Jamal')

@section('content')
<div style="max-width:1200px;margin:0 auto;">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px;">
        <div>
            <h1 style="font-size:24px;font-weight:800;color:#0f172a;letter-spacing:-0.5px;">Data Panitia</h1>
            <p style="color:#64748b;font-size:14px;margin-top:2px;">Kelola data panitia MABIT SDI Al-Jamal</p>
        </div>
        <button onclick="bukaModalTambah()" class="btn-modern btn-success">
            <i class="bi bi-plus-circle-fill"></i> Tambah Panitia
        </button>
    </div>

    @if(request('search'))
        <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;padding:12px 18px;margin-bottom:16px;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:13px;color:#1e40af;font-weight:600;">
                <i class="bi bi-search"></i> Hasil pencarian: <strong>"{{ request('search') }}"</strong>
            </span>
            <a href="{{ route('panitia.index') }}" style="font-size:12px;color:#1e40af;text-decoration:underline;font-weight:600;">Hapus filter</a>
        </div>
    @endif

    <div class="card-modern" style="padding:0;overflow:hidden;">
        <div style="padding:16px 24px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
            <span style="font-size:14px;color:#64748b;font-weight:600;">Total: <strong style="color:#0f172a;font-size:16px;">{{ $total ?? 0 }}</strong> panitia</span>
            <form method="GET" style="display:flex;gap:8px;">
                <div style="position:relative;">
                    <i class="bi bi-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ID atau Nama..." 
                           style="padding:9px 14px 9px 38px;border:2px solid #e2e8f0;border-radius:10px;font-size:13px;outline:none;width:220px;background:#f8fafc;font-weight:500;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <button type="submit" class="btn-modern btn-primary" style="padding:9px 20px;">Cari</button>
            </form>
        </div>
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:13px;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">ID</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Nama Lengkap</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Jabatan</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">No Telepon</th>
                        <th style="padding:14px 20px;text-align:left;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Status</th>
                        <th style="padding:14px 20px;text-align:center;font-size:11px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($panitia ?? [] as $p)
                    <tr style="border-bottom:1px solid #f1f5f9;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                        <td style="padding:14px 20px;"><span style="font-family:monospace;color:#3b82f6;font-weight:700;background:#3b82f610;padding:4px 10px;border-radius:6px;">{{ $p->id_panitia }}</span></td>
                        <td style="padding:14px 20px;font-weight:600;color:#0f172a;">{{ $p->nama_lengkap }}</td>
                        <td style="padding:14px 20px;color:#64748b;">{{ $p->jabatan ?? '-' }}</td>
                        <td style="padding:14px 20px;color:#64748b;font-family:monospace;">{{ $p->no_telepon ?? '-' }}</td>
                        <td style="padding:14px 20px;">
                            @if($p->is_active)
                                <span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:#10b98115;color:#10b981;">Aktif</span>
                            @else
                                <span style="font-size:10px;padding:4px 14px;border-radius:20px;font-weight:800;background:#ef444415;color:#ef4444;">Nonaktif</span>
                            @endif
                        </td>
                        <td style="padding:14px 20px;text-align:center;">
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <button onclick="editPanitia({{ $p->id }})" title="Edit" style="width:34px;height:34px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#3b82f6;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='#3b82f6';this.style.color='#fff';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='#fff';this.style.color='#3b82f6';this.style.borderColor='#e2e8f0';">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button onclick="togglePanitia({{ $p->id }})" title="Aktif/Nonaktif" style="width:34px;height:34px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#f59e0b;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='#f59e0b';this.style.color='#fff';this.style.borderColor='#f59e0b';" onmouseout="this.style.background='#fff';this.style.color='#f59e0b';this.style.borderColor='#e2e8f0';">
                                    <i class="bi bi-power"></i>
                                </button>
                                <button onclick="hapusPanitia({{ $p->id }})" title="Hapus" style="width:34px;height:34px;border-radius:8px;border:1px solid #e2e8f0;background:#fff;color:#ef4444;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='#ef4444';this.style.color='#fff';this.style.borderColor='#ef4444';" onmouseout="this.style.background='#fff';this.style.color='#ef4444';this.style.borderColor='#e2e8f0';">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:60px 20px;text-align:center;color:#94a3b8;">
                            <i class="bi bi-people" style="font-size:48px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                            <p style="font-weight:700;color:#64748b;">Belum ada data panitia</p>
                            <p style="font-size:12px;margin-top:4px;">Klik "Tambah Panitia" untuk menambahkan data</p>
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
</div>

<!-- Modal Tambah/Edit -->
<div id="modalPanitia" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.5);backdrop-filter:blur(8px);z-index:1000;align-items:center;justify-content:center;padding:20px;">
    <div style="background:#fff;border-radius:20px;padding:32px;max-width:460px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 25px 80px rgba(0,0,0,0.3);">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <h3 id="modalTitle" style="font-size:20px;font-weight:800;color:#0f172a;">Tambah Panitia</h3>
            <button onclick="tutupModal()" style="width:36px;height:36px;border-radius:10px;border:1px solid #e2e8f0;background:#fff;cursor:pointer;color:#64748b;display:flex;align-items:center;justify-content:center;font-size:18px;">✕</button>
        </div>
        <form id="formPanitia">
            @csrf
            <input type="hidden" id="panitiaId" name="id">
            <div style="display:flex;flex-direction:column;gap:16px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">ID Panitia <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="idPanitia" name="id_panitia" required placeholder="Contoh: P001"
                           style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;font-family:monospace;background:#f8fafc;font-weight:600;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="namaPanitia" name="nama_lengkap" required placeholder="Masukkan nama lengkap"
                           style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;background:#f8fafc;font-weight:500;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">Jabatan</label>
                    <input type="text" id="jabatanPanitia" name="jabatan" placeholder="Contoh: Ketua"
                           style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;background:#f8fafc;font-weight:500;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:700;color:#334155;margin-bottom:6px;">No Telepon</label>
                    <input type="text" id="teleponPanitia" name="no_telepon" placeholder="Contoh: 08123456789"
                           style="width:100%;padding:12px 16px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;outline:none;background:#f8fafc;font-weight:500;transition:all 0.2s;"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';">
                </div>
                <div style="display:flex;gap:12px;padding-top:8px;">
                    <button type="button" onclick="tutupModal()" class="btn-modern btn-outline" style="flex:1;justify-content:center;">Batal</button>
                    <button type="submit" id="btnSimpan" class="btn-modern btn-success" style="flex:2;justify-content:center;">
                        <i class="bi bi-check-circle-fill"></i> Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function bukaModalTambah() {
        document.getElementById('modalPanitia').style.display = 'flex';
        document.getElementById('modalTitle').textContent = 'Tambah Panitia';
        document.getElementById('panitiaId').value = '';
        document.getElementById('formPanitia').reset();
        document.getElementById('idPanitia').focus();
    }

    function tutupModal() {
        document.getElementById('modalPanitia').style.display = 'none';
    }

    function editPanitia(id) {
        fetch(`/panitia/${id}/edit`, {
            headers: { 'Accept': 'application/json' }
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalPanitia').style.display = 'flex';
                document.getElementById('modalTitle').textContent = 'Edit Panitia';
                document.getElementById('panitiaId').value = id;
                document.getElementById('idPanitia').value = data.id_panitia;
                document.getElementById('namaPanitia').value = data.nama_lengkap;
                document.getElementById('jabatanPanitia').value = data.jabatan || '';
                document.getElementById('teleponPanitia').value = data.no_telepon || '';
            })
            .catch(() => alert('❌ Gagal memuat data panitia'));
    }

    document.getElementById('formPanitia').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('panitiaId').value;
        const url = id ? `/panitia/${id}` : '/panitia';
        const method = id ? 'PUT' : 'POST';
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        const btn = document.getElementById('btnSimpan');
        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Menyimpan...';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            } else {
                let msg = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                alert('❌ ' + msg);
            }
        })
        .catch(error => alert('⚠️ Terjadi kesalahan: ' + error.message))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Simpan Data';
        });
    });

    function hapusPanitia(id) {
        if (!confirm('⚠️ Yakin ingin menghapus panitia ini?')) return;
        fetch(`/panitia/${id}`, {
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

    function togglePanitia(id) {
        fetch(`/panitia/${id}/toggle-active`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('✅ ' + data.message);
                location.reload();
            }
        })
        .catch(() => alert('⚠️ Terjadi kesalahan'));
    }

    document.getElementById('modalPanitia').addEventListener('click', function(e) {
        if (e.target === this) tutupModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupModal();
    });
</script>
@endpush
@endsection