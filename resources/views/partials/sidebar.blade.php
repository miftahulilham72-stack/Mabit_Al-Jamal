<div class="flex flex-col h-full">
    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="icon"><span class="material-symbols-outlined">school</span></div>
        <div class="text">
            <h3>SDI Al-Jamal</h3>
            <p>MABIT PANITIA</p>
        </div>
    </div>

    <!-- Menu -->
    <nav style="flex:1; display:flex; flex-direction:column; gap:2px;">
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="material-symbols-outlined icon">dashboard</span> Dashboard
        </a>
        <a href="{{ route('panitia.index') }}" class="menu-item {{ request()->routeIs('panitia.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined icon">group</span> Manajemen Panitia
        </a>
        <a href="{{ route('sesi.index') }}" class="menu-item {{ request()->routeIs('sesi.*') ? 'active' : '' }}">
            <span class="material-symbols-outlined icon">event_repeat</span> Manajemen Sesi
        </a>
        <a href="{{ route('absensi.log') }}" class="menu-item {{ request()->routeIs('absensi.log') ? 'active' : '' }}">
            <span class="material-symbols-outlined icon">list_alt</span> Riwayat Absensi
        </a>
        <a href="{{ route('absensi.manual') }}" class="menu-item badge-admin {{ request()->routeIs('absensi.manual*') ? 'active' : '' }}">
            <span class="material-symbols-outlined icon">edit_note</span> Absensi Manual
            <span class="badge-label">ADMIN</span>
        </a>
        <a href="{{ route('absensi.kiosk') }}" target="_blank" class="menu-item" style="color:#10B981;">
            <span class="material-symbols-outlined icon">open_in_new</span> Buka Kiosk
        </a>
    </nav>

    <!-- Footer -->
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}" class="mb-2">
            @csrf
            <button type="submit" class="menu-item" style="color:#dc2626;width:100%;text-align:left;">
                <span class="material-symbols-outlined icon" style="font-size:16px;">logout</span> Keluar
            </button>
        </form>
        <div class="version">v1.0.0 | MABIT SDI Al-Jamal © 2026</div>
    </div>
</div>