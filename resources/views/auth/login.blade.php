@extends('layouts.guest')

@section('title', 'Login Admin - MABIT SDI Al-Jamal')

@section('content')
<div style="width:100%;max-width:440px;">
    <!-- Card -->
    <div style="background:rgba(255,255,255,0.98);border-radius:24px;padding:40px 36px;box-shadow:0 25px 80px rgba(0,0,0,0.4);backdrop-filter:blur(20px);border:1px solid rgba(255,255,255,0.1);">
        
        <!-- Logo & Header -->
        <div style="text-align:center;margin-bottom:32px;">
            <div style="width:80px;height:80px;margin:0 auto 16px;background:linear-gradient(135deg,#00236f,#3b82f6);border-radius:20px;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 32px rgba(0,35,111,0.3);">
                <span class="material-symbols-outlined" style="color:#fff;font-size:40px;font-variation-settings:'FILL' 1;">M</span>
            </div>
            <h1 style="font-size:26px;font-weight:800;color:#0f172a;letter-spacing:-0.5px;">MABIT SDI Al-Jamal</h1>
            <p style="font-size:13px;color:#64748b;margin-top:6px;font-weight:500;">Sistem Absensi Panitia</p>
        </div>

        <!-- Error Alert -->
        @if(session('error'))
            <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
                <i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;font-size:18px;"></i>
                <span style="font-size:13px;color:#991b1b;font-weight:500;">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('status'))
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
                <i class="bi bi-check-circle-fill" style="color:#10b981;font-size:18px;"></i>
                <span style="font-size:13px;color:#065f46;font-weight:500;">{{ session('status') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
            <!-- Email -->
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;">Email Admin</label>
                <div style="position:relative;">
                    <i class="bi bi-envelope" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:18px;"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           style="width:100%;padding:14px 16px 14px 48px;border:2px solid #e2e8f0;border-radius:12px;font-size:15px;outline:none;transition:all 0.2s;background:#f8fafc;color:#0f172a;"
                           placeholder="admin@sdialjamal.sch.id"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 4px rgba(59,130,246,0.1)';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none';">
                </div>
                @error('email')
                    <span style="font-size:12px;color:#ef4444;margin-top:6px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#334155;margin-bottom:8px;">Password</label>
                <div style="position:relative;">
                    <i class="bi bi-lock" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:18px;"></i>
                    <input type="password" name="password" id="password" required
                           style="width:100%;padding:14px 48px 14px 48px;border:2px solid #e2e8f0;border-radius:12px;font-size:15px;outline:none;transition:all 0.2s;background:#f8fafc;color:#0f172a;"
                           placeholder="Masukkan password"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='#fff';this.style.boxShadow='0 0 0 4px rgba(59,130,246,0.1)';"
                           onblur="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc';this.style.boxShadow='none';">
                    <button type="button" onclick="togglePassword()" 
                            style="position:absolute;right:16px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:4px;font-size:18px;">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="submitBtn"
                    style="width:100%;padding:16px;background:linear-gradient(135deg,#00236f,#3b82f6);color:#fff;border:none;border-radius:12px;font-size:16px;font-weight:700;cursor:pointer;transition:all 0.2s;box-shadow:0 8px 24px rgba(0,35,111,0.3);display:flex;align-items:center;justify-content:center;gap:8px;"
                    onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 32px rgba(0,35,111,0.4)';"
                    onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 24px rgba(0,35,111,0.3)';">
                <i class="bi bi-box-arrow-in-right" style="font-size:20px;"></i>
                MASUK
            </button>
        </form>

        <!-- Footer -->
        <div style="text-align:center;margin-top:24px;padding-top:20px;border-top:1px solid #e2e8f0;">
            <p style="font-size:11px;color:#94a3b8;">
                <i class="bi bi-shield-lock-fill"></i> Hanya untuk Admin
            </p>
        </div>
    </div>
    
    <!-- Copyright -->
    <p style="text-align:center;margin-top:20px;font-size:12px;color:rgba(255,255,255,0.5);">
        © 2026 MABIT SDI Al-Jamal. All rights reserved.
    </p>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (password.type === 'password') {
            password.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            password.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
@endsection