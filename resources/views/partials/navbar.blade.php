<nav class="navbar">
    <div style="display:flex; align-items:center; gap:12px;">
        <button class="menu-toggle" onclick="toggleSidebar()" style="background:none;border:none;color:#fff;cursor:pointer;font-size:24px;padding:6px 8px;">☰</button>
        <span class="brand">MABIT SDI Al-Jamal</span>
    </div>
    <div class="right">
        <button><span class="material-symbols-outlined" style="font-size:20px;">search</span></button>
        <button><span class="material-symbols-outlined" style="font-size:20px;">notifications</span></button>
        <div class="admin">
            <div class="avatar">A</div>
            <span>Admin</span>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit"><span class="material-symbols-outlined" style="font-size:20px;">logout</span></button>
        </form>
    </div>
</nav>