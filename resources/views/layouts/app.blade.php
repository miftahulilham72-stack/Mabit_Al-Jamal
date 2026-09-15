<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MABIT Panitia SDI Al-Jamal')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f5f7fb;
            color: #1e293b;
        }
        
        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 270px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            z-index: 40;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: 4px 0 30px rgba(0,0,0,0.2);
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 8px 24px 8px;
            margin-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-logo .icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 8px 24px rgba(59,130,246,0.4);
        }
        .sidebar-logo .icon i { color: #fff; font-size: 24px; }
        .sidebar-logo .text h3 { font-size: 15px; font-weight: 800; color: #fff; letter-spacing: -0.3px; }
        .sidebar-logo .text p { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 600; }
        
        .menu-section {
            font-size: 10px;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            padding: 20px 12px 10px 12px;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            border: none;
            background: transparent;
            cursor: pointer;
            margin-bottom: 3px;
            position: relative;
        }
        .menu-item i { font-size: 19px; width: 22px; text-align: center; transition: transform 0.25s; }
        .menu-item:hover { 
            background: rgba(255,255,255,0.06); 
            color: #e2e8f0;
            transform: translateX(3px);
        }
        .menu-item:hover i { transform: scale(1.1); }
        .menu-item.active { 
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            box-shadow: 0 8px 20px rgba(59,130,246,0.35);
        }
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: -16px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 28px;
            background: #3b82f6;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 12px #3b82f6;
        }
        .menu-item.badge-admin { color: #f87171; }
        .menu-item.badge-admin:hover { background: rgba(248,113,113,0.1); }
        .menu-item.badge-admin.active { 
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            box-shadow: 0 8px 20px rgba(239,68,68,0.35);
        }
        .badge-label {
            font-size: 8px;
            background: #ef4444;
            color: #fff;
            padding: 3px 8px;
            border-radius: 20px;
            margin-left: auto;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(239,68,68,0.4);
        }
        
        .sidebar-footer {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-footer .version {
            text-align: center;
            font-size: 9px;
            color: #475569;
            padding-top: 8px;
            font-weight: 500;
        }
        
        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0;
            left: 270px;
            right: 0;
            height: 72px;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 30;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            border-bottom: 1px solid #e2e8f0;
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-title { font-size: 17px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px; }
        .topbar-subtitle { font-size: 12px; color: #64748b; font-weight: 500; margin-top: 1px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        
        .topbar-btn {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s;
            position: relative;
        }
        .topbar-btn:hover {
            background: #f8fafc;
            color: #3b82f6;
            border-color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59,130,246,0.15);
        }
        .topbar-btn i { font-size: 19px; pointer-events: none; }
        
        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 6px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.25s;
        }
        .topbar-profile:hover { background: #f1f5f9; transform: translateY(-1px); }
        .topbar-profile .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
        }
        .topbar-profile .info { display: flex; flex-direction: column; }
        .topbar-profile .info .name { font-size: 12px; font-weight: 700; color: #0f172a; }
        .topbar-profile .info .role { font-size: 10px; color: #64748b; font-weight: 500; }
        
        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 270px;
            padding: 96px 28px 28px 28px;
            min-height: 100vh;
        }
        
        /* ===== MODAL & DROPDOWN ===== */
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 52px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            border: 1px solid #e2e8f0;
            z-index: 9999;
            overflow: hidden;
            animation: dropdownIn 0.2s ease;
        }
        .dropdown-menu.show { display: block; }
        
        @keyframes dropdownIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .search-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.6);
            backdrop-filter: blur(8px);
            z-index: 10000;
            align-items: flex-start;
            justify-content: center;
            padding: 80px 20px;
        }
        .search-modal.show { display: flex; }
        
        /* ===== MOBILE ===== */
        .menu-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #0f172a;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }
        
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; z-index: 50; width: 290px; }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15,23,42,0.5);
                z-index: 45;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
                backdrop-filter: blur(4px);
            }
            .sidebar-overlay.open { opacity: 1; pointer-events: all; }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .menu-toggle { display: flex; }
        }
        
        @media (max-width: 640px) {
            .topbar { padding: 0 16px; height: 64px; }
            .main-content { padding: 84px 16px 16px 16px; }
            .topbar-title { font-size: 15px; }
            .topbar-subtitle { display: none; }
            .topbar-profile .info { display: none; }
        }
        
        /* ===== CARD MODERN ===== */
        .card-modern {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-modern:hover {
            box-shadow: 0 12px 32px rgba(0,0,0,0.08);
            transform: translateY(-3px);
        }
        
        /* ===== BUTTON MODERN ===== */
        .btn-modern {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
        }
        .btn-modern:hover { transform: translateY(-2px); }
        .btn-modern:active { transform: scale(0.97); }
        .btn-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; box-shadow: 0 4px 16px rgba(59,130,246,0.3); }
        .btn-primary:hover { box-shadow: 0 8px 24px rgba(59,130,246,0.4); }
        .btn-success { background: linear-gradient(135deg, #10b981, #059669); color: #fff; box-shadow: 0 4px 16px rgba(16,185,129,0.3); }
        .btn-success:hover { box-shadow: 0 8px 24px rgba(16,185,129,0.4); }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; box-shadow: 0 4px 16px rgba(239,68,68,0.3); }
        .btn-danger:hover { box-shadow: 0 8px 24px rgba(239,68,68,0.4); }
        .btn-outline { background: #fff; color: #475569; border: 2px solid #e2e8f0; }
        .btn-outline:hover { border-color: #3b82f6; color: #3b82f6; }
        
        .spinner { animation: spin 0.8s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <!-- Overlay Mobile -->
    <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <div class="icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div class="text">
                <h3>SDI Al-Jamal</h3>
                <p>MABIT PANITIA</p>
            </div>
        </div>

        <div class="menu-section">Menu Utama</div>
        <nav>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Beranda
            </a>
            <a href="{{ route('panitia.index') }}" class="menu-item {{ request()->routeIs('panitia.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Data Panitia
            </a>
            <a href="{{ route('sesi.index') }}" class="menu-item {{ request()->routeIs('sesi.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event-fill"></i> Jadwal Kegiatan
            </a>
            <a href="{{ route('absensi.log') }}" class="menu-item {{ request()->routeIs('absensi.log') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Kehadiran
            </a>
        </nav>

        <div class="menu-section">Khusus Admin</div>
        <nav>
            <a href="{{ route('absensi.manual') }}" class="menu-item badge-admin {{ request()->routeIs('absensi.manual*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Absen Manual
                <span class="badge-label">Admin</span>
            </a>
        </nav>

        <div class="menu-section">Mode Kiosk</div>
        <nav>
            <a href="{{ route('kiosk') }}" target="_blank" class="menu-item" style="color:#10b981;">
                <i class="bi bi-display"></i> Buka Kiosk
                <i class="bi bi-box-arrow-up-right" style="font-size:14px;margin-left:auto;"></i>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-item" style="color:#f87171;">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
            <div class="version">v1.0.0 | MABIT SDI Al-Jamal</div>
        </div>
    </aside>

    <!-- Topbar -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list" style="font-size:22px;"></i>
            </button>
            <div>
                <div class="topbar-title">@yield('page-title', 'Beranda')</div>
                <div class="topbar-subtitle">@yield('page-subtitle', 'Selamat datang kembali, Admin!')</div>
            </div>
        </div>
        <div class="topbar-right">
            <!-- SEARCH BUTTON -->
            <button class="topbar-btn" onclick="openSearch()" title="Pencarian">
                <i class="bi bi-search"></i>
            </button>
            
            <!-- NOTIFICATION BUTTON -->
            <div style="position:relative;">
                <button class="topbar-btn" onclick="toggleNotif(event)" title="Notifikasi">
                    <i class="bi bi-bell"></i>
                    <span id="notifBadge" style="position:absolute;top:8px;right:8px;width:8px;height:8px;background:#ef4444;border-radius:50%;border:2px solid #fff;"></span>
                </button>
                
                <!-- Notification Dropdown -->
                <div id="notifDropdown" class="dropdown-menu" style="width:360px;">
                    <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-weight:800;font-size:14px;color:#0f172a;display:flex;align-items:center;gap:8px;">
                            <i class="bi bi-bell-fill" style="color:#3b82f6;"></i> Notifikasi
                        </span>
                        <button onclick="tandaiSemuaDibaca(event)" style="background:none;border:none;color:#3b82f6;cursor:pointer;font-size:11px;font-weight:700;padding:4px 8px;border-radius:6px;transition:background 0.2s;" onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='none'">
                            <i class="bi bi-check2-all"></i> Tandai Semua
                        </button>
                    </div>
                    <div id="notifList" style="max-height:360px;overflow-y:auto;">
                        <div class="notif-item" data-id="1" style="padding:14px 20px;border-bottom:1px solid #f1f5f9;position:relative;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                            <div style="display:flex;gap:12px;">
                                <div style="width:38px;height:38px;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(59,130,246,0.3);">
                                    <i class="bi bi-info-circle-fill" style="color:#fff;font-size:16px;"></i>
                                </div>
                                <div style="flex:1;">
                                    <p style="font-size:13px;font-weight:700;color:#0f172a;">Selamat Datang!</p>
                                    <p style="font-size:12px;color:#64748b;margin-top:2px;line-height:1.5;">Sistem absensi MABIT SDI Al-Jamal siap digunakan.</p>
                                    <p style="font-size:10px;color:#94a3b8;margin-top:6px;font-weight:600;"><i class="bi bi-clock"></i> Baru saja</p>
                                </div>
                            </div>
                            <span class="notif-dot" style="position:absolute;top:18px;right:16px;width:8px;height:8px;background:#3b82f6;border-radius:50%;"></span>
                        </div>
                        <div class="notif-item" data-id="2" style="padding:14px 20px;border-bottom:1px solid #f1f5f9;position:relative;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                            <div style="display:flex;gap:12px;">
                                <div style="width:38px;height:38px;background:linear-gradient(135deg,#10b981,#059669);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(16,185,129,0.3);">
                                    <i class="bi bi-people-fill" style="color:#fff;font-size:16px;"></i>
                                </div>
                                <div style="flex:1;">
                                    <p style="font-size:13px;font-weight:700;color:#0f172a;">Data Panitia</p>
                                    <p style="font-size:12px;color:#64748b;margin-top:2px;line-height:1.5;">Terdapat <strong>{{ \App\Models\Panitia::count() }}</strong> panitia terdaftar di sistem.</p>
                                    <p style="font-size:10px;color:#94a3b8;margin-top:6px;font-weight:600;"><i class="bi bi-clock"></i> Baru saja</p>
                                </div>
                            </div>
                            <span class="notif-dot" style="position:absolute;top:18px;right:16px;width:8px;height:8px;background:#3b82f6;border-radius:50%;"></span>
                        </div>
                        @if(\App\Models\SesiPanitia::where('is_active', true)->exists())
                        <div class="notif-item" data-id="3" style="padding:14px 20px;border-bottom:1px solid #f1f5f9;position:relative;transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background=''">
                            <div style="display:flex;gap:12px;">
                                <div style="width:38px;height:38px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(245,158,11,0.3);">
                                    <i class="bi bi-broadcast" style="color:#fff;font-size:16px;"></i>
                                </div>
                                <div style="flex:1;">
                                    <p style="font-size:13px;font-weight:700;color:#0f172a;">Sesi Aktif</p>
                                    <p style="font-size:12px;color:#64748b;margin-top:2px;line-height:1.5;">Sesi <strong>{{ \App\Models\SesiPanitia::where('is_active', true)->first()->nama_sesi }}</strong> sedang berlangsung.</p>
                                    <p style="font-size:10px;color:#94a3b8;margin-top:6px;font-weight:600;"><i class="bi bi-clock"></i> Baru saja</p>
                                </div>
                            </div>
                            <span class="notif-dot" style="position:absolute;top:18px;right:16px;width:8px;height:8px;background:#3b82f6;border-radius:50%;"></span>
                        </div>
                        @endif
                    </div>
                    <div id="notifEmpty" style="display:none;padding:50px 20px;text-align:center;">
                        <i class="bi bi-check2-circle" style="font-size:48px;color:#10b981;display:block;margin-bottom:12px;"></i>
                        <p style="font-size:14px;font-weight:700;color:#0f172a;">Semua sudah dibaca</p>
                        <p style="font-size:12px;color:#94a3b8;margin-top:4px;">Tidak ada notifikasi baru</p>
                    </div>
                    <div id="notifFooter" style="padding:12px 20px;background:#f8fafc;text-align:center;border-top:1px solid #e2e8f0;">
                        <span style="font-size:12px;color:#64748b;font-weight:600;"><i class="bi bi-inbox"></i> <span id="notifCount">{{ \App\Models\SesiPanitia::where('is_active', true)->exists() ? 3 : 2 }}</span> notifikasi belum dibaca</span>
                    </div>
                </div>
            </div>
            
            <!-- PROFILE DROPDOWN (HANYA LOGOUT) -->
            <div style="position:relative;">
                <div class="topbar-profile" onclick="toggleProfile(event)">
                    <div class="avatar">A</div>
                    <div class="info">
                        <span class="name">Admin</span>
                        <span class="role">Administrator</span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size:12px;color:#94a3b8;"></i>
                </div>
                <div id="profileDropdown" class="dropdown-menu" style="width:220px;">
                    <div style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:44px;height:44px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:18px;">A</div>
                            <div style="overflow:hidden;">
                                <p style="font-size:14px;font-weight:800;color:#0f172a;">Admin</p>
                                <p style="font-size:11px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->email ?? 'admin@sdialjamal.sch.id' }}</p>
                            </div>
                        </div>
                    </div>
                    <div style="padding:8px;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="display:flex;align-items:center;gap:10px;padding:12px 14px;border-radius:10px;color:#ef4444;background:none;border:none;font-size:13px;font-weight:700;cursor:pointer;width:100%;text-align:left;transition:all 0.2s;" onmouseover="this.style.background='#fef2f2';this.style.transform='translateX(3px)'" onmouseout="this.style.background='none';this.style.transform='translateX(0)'">
                                <i class="bi bi-box-arrow-right" style="font-size:18px;"></i>
                                <span>Keluar dari Sistem</span>
                            </button>
                        </form>
                    </div>
                    <div style="padding:10px 20px;border-top:1px solid #f1f5f9;text-align:center;">
                        <p style="font-size:10px;color:#94a3b8;font-weight:500;">v1.0.0 | MABIT SDI Al-Jamal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SEARCH MODAL -->
    <div id="searchModal" class="search-modal" onclick="if(event.target===this) closeSearch()">
        <div style="background:#fff;border-radius:20px;max-width:640px;width:100%;box-shadow:0 25px 80px rgba(0,0,0,0.3);overflow:hidden;">
            <div style="padding:20px 24px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:12px;">
                <i class="bi bi-search" style="font-size:20px;color:#64748b;"></i>
                <input type="text" id="searchInput" placeholder="Cari panitia berdasarkan nama atau ID..." 
                       style="flex:1;border:none;outline:none;font-size:16px;font-weight:500;color:#0f172a;background:none;"
                       onkeyup="searchPanitia(this.value)">
                <button onclick="closeSearch()" style="background:none;border:none;color:#94a3b8;cursor:pointer;font-size:12px;font-weight:700;padding:6px 12px;border-radius:8px;border:1px solid #e2e8f0;">ESC</button>
            </div>
            <div id="searchResults" style="max-height:400px;overflow-y:auto;">
                <div style="padding:40px 20px;text-align:center;color:#94a3b8;">
                    <i class="bi bi-search" style="font-size:36px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                    <p style="font-size:13px;font-weight:600;">Ketik untuk mencari panitia...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')

    <script>
        // ================================================================
        // TOGGLE SIDEBAR
        // ================================================================
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }
        
        // ================================================================
        // SEARCH MODAL
        // ================================================================
        function openSearch() {
            document.getElementById('searchModal').classList.add('show');
            setTimeout(() => document.getElementById('searchInput').focus(), 100);
        }
        
        function closeSearch() {
            document.getElementById('searchModal').classList.remove('show');
            document.getElementById('searchInput').value = '';
            document.getElementById('searchResults').innerHTML = `
                <div style="padding:40px 20px;text-align:center;color:#94a3b8;">
                    <i class="bi bi-search" style="font-size:36px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                    <p style="font-size:13px;font-weight:600;">Ketik untuk mencari panitia...</p>
                </div>
            `;
        }
        
        function searchPanitia(query) {
            const resultsDiv = document.getElementById('searchResults');
            
            if (query.length < 2) {
                resultsDiv.innerHTML = `
                    <div style="padding:40px 20px;text-align:center;color:#94a3b8;">
                        <i class="bi bi-search" style="font-size:36px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                        <p style="font-size:13px;font-weight:600;">Ketik minimal 2 karakter...</p>
                    </div>
                `;
                return;
            }
            
            resultsDiv.innerHTML = `
                <div style="padding:20px;text-align:center;color:#94a3b8;">
                    <i class="bi bi-arrow-repeat spinner" style="font-size:24px;"></i>
                    <p style="font-size:13px;margin-top:8px;">Mencari...</p>
                </div>
            `;
            
            fetch(`/panitia?search=${encodeURIComponent(query)}&ajax=1`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.panitia && data.panitia.length > 0) {
                    resultsDiv.innerHTML = data.panitia.map(p => `
                        <a href="/panitia" style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid #f1f5f9;text-decoration:none;color:#0f172a;transition:background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='none'">
                            <div style="width:36px;height:36px;background:#3b82f615;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-person-fill" style="color:#3b82f6;font-size:16px;"></i>
                            </div>
                            <div style="flex:1;">
                                <p style="font-size:13px;font-weight:700;color:#0f172a;">${p.nama_lengkap}</p>
                                <p style="font-size:11px;color:#64748b;">${p.id_panitia} • ${p.jabatan || 'Panitia'}</p>
                            </div>
                            <i class="bi bi-arrow-right" style="color:#94a3b8;"></i>
                        </a>
                    `).join('');
                } else {
                    resultsDiv.innerHTML = `
                        <div style="padding:40px 20px;text-align:center;color:#94a3b8;">
                            <i class="bi bi-inbox" style="font-size:36px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                            <p style="font-size:13px;font-weight:600;">Tidak ada hasil untuk "${query}"</p>
                        </div>
                    `;
                }
            })
            .catch(() => {
                resultsDiv.innerHTML = `
                    <div style="padding:40px 20px;text-align:center;color:#94a3b8;">
                        <i class="bi bi-exclamation-triangle" style="font-size:36px;display:block;margin-bottom:12px;color:#f59e0b;"></i>
                        <p style="font-size:13px;font-weight:600;">Terjadi kesalahan saat mencari</p>
                    </div>
                `;
            });
        }
        
        // ================================================================
        // NOTIFICATION DROPDOWN
        // ================================================================
        function toggleNotif(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('notifDropdown');
            const profileDropdown = document.getElementById('profileDropdown');
            
            profileDropdown.classList.remove('show');
            dropdown.classList.toggle('show');
        }
        
        function closeNotif() {
            document.getElementById('notifDropdown').classList.remove('show');
        }
        
        // ================================================================
        // PROFILE DROPDOWN
        // ================================================================
        function toggleProfile(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            const notifDropdown = document.getElementById('notifDropdown');
            
            notifDropdown.classList.remove('show');
            dropdown.classList.toggle('show');
        }

        // ================================================================
        // NOTIFIKASI - TANDAI SEMUA DIBACA
        // ================================================================
        function tandaiSemuaDibaca(event) {
            document.querySelectorAll('.notif-dot').forEach(dot => {
                dot.style.display = 'none';
            });

            document.getElementById('notifBadge').style.display = 'none';
            document.getElementById('notifList').style.display = 'none';
            document.getElementById('notifEmpty').style.display = 'block';
            document.getElementById('notifFooter').innerHTML = `
                <span style="font-size:12px;color:#10b981;font-weight:700;">
                    <i class="bi bi-check2-circle"></i> Semua notifikasi sudah dibaca
                </span>
            `;

            localStorage.setItem('notifRead', 'true');

            const btn = event?.target.closest('button');
            if (btn) {
                btn.innerHTML = '<i class="bi bi-check2-all"></i> Selesai!';
                btn.style.color = '#10b981';
                setTimeout(() => {
                    btn.innerHTML = '<i class="bi bi-check2-all"></i> Tandai Semua';
                    btn.style.color = '#3b82f6';
                }, 2000);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('notifRead') === 'true') {
                document.querySelectorAll('.notif-dot').forEach(dot => {
                    dot.style.display = 'none';
                });
                document.getElementById('notifBadge').style.display = 'none';
                document.getElementById('notifList').style.display = 'none';
                document.getElementById('notifEmpty').style.display = 'block';
                document.getElementById('notifFooter').innerHTML = `
                    <span style="font-size:12px;color:#10b981;font-weight:700;">
                        <i class="bi bi-check2-circle"></i> Semua notifikasi sudah dibaca
                    </span>
                `;
            }
        });
        
        // ================================================================
        // TUTUP DROPDOWN JIKA KLIK DI LUAR
        // ================================================================
        document.addEventListener('click', function(e) {
            const notifDropdown = document.getElementById('notifDropdown');
            const profileDropdown = document.getElementById('profileDropdown');
            
            if (!e.target.closest('#notifDropdown') && !e.target.closest('[onclick*="toggleNotif"]')) {
                notifDropdown.classList.remove('show');
            }
            if (!e.target.closest('#profileDropdown') && !e.target.closest('[onclick*="toggleProfile"]')) {
                profileDropdown.classList.remove('show');
            }
        });
        
        // ================================================================
        // ESC UNTUK MENUTUP MODAL
        // ================================================================
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearch();
                closeNotif();
                document.getElementById('profileDropdown').classList.remove('show');
            }
        });
        
        console.log('✅ MABIT Admin Loaded');
    </script>
</body>
</html>