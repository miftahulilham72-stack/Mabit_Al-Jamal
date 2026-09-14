<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kiosk Absensi Panitia - MABIT SDI Al-Jamal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }
        
        .bg-blob {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.1;
            z-index: 0;
            animation: floatBlob 15s ease-in-out infinite;
        }
        .bg-blob-1 { background: #3b82f6; top: -200px; left: -200px; }
        .bg-blob-2 { background: #8b5cf6; bottom: -200px; right: -200px; animation-delay: -5s; }
        .bg-blob-3 { background: #10b981; top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: -10s; }
        
        @keyframes floatBlob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -50px) scale(1.1); }
            66% { transform: translate(-50px, 50px) scale(0.9); }
        }
        
        .kiosk-container {
            max-width: 520px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.4);
            padding: 36px 32px;
            position: relative;
            z-index: 1;
        }
        
        .kiosk-header { text-align: center; margin-bottom: 28px; }
        .kiosk-header .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, #00236f, #3b82f6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 32px rgba(0,35,111,0.3);
        }
        .kiosk-header .logo i { color: #fff; font-size: 40px; }
        .kiosk-header h1 { font-size: 24px; font-weight: 800; color: #00236f; letter-spacing: -0.5px; }
        .kiosk-header p { font-size: 13px; color: #64748B; margin-top: 4px; font-weight: 500; }
        
        .session-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1px solid #e2e8f0;
        }
        .session-card .icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
        }
        .session-card .icon i { color: #fff; font-size: 22px; }
        .session-card .info p { font-size: 10px; font-weight: 800; color: #3b82f6; text-transform: uppercase; letter-spacing: 1px; }
        .session-card .info h3 { font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 2px; }
        
        .counter-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .counter-item {
            background: #f8fafc;
            border-radius: 14px;
            padding: 16px 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        .counter-item:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
        .counter-item .number { font-size: 28px; font-weight: 800; letter-spacing: -1px; }
        .counter-item .label { font-size: 10px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }
        .counter-item.hadir .number { color: #10b981; }
        .counter-item.total .number { color: #3b82f6; }
        
        .progress-wrapper { margin-bottom: 20px; }
        .progress-wrapper .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .progress-wrapper .progress-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-wrapper .progress-bar .fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
            background: linear-gradient(90deg, #3b82f6, #10b981);
        }
        
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
            outline: none;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .form-group input:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }
        .form-group .name-display {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            background: #f1f5f9;
            color: #0f172a;
            min-height: 52px;
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        .form-group .name-display.found { border-color: #10b981; background: #f0fdf4; color: #10b981; }
        .form-group .name-display.not-found { border-color: #ef4444; background: #fef2f2; color: #ef4444; }
        .form-group .name-display.loading { border-color: #f59e0b; background: #fffbeb; color: #f59e0b; }
        
        /* Tombol Daftar Cepat */
        .btn-register {
            display: none;
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 4px 16px rgba(245,158,11,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(245,158,11,0.4); }
        
        .signature-wrapper {
            position: relative;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            height: 180px;
        }
        .signature-wrapper canvas {
            width: 100%;
            height: 100%;
            touch-action: none;
            cursor: crosshair;
        }
        .signature-wrapper .hint {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #cbd5e1;
            pointer-events: none;
            transition: opacity 0.3s;
        }
        .signature-wrapper .hint.hidden { opacity: 0; }
        .signature-wrapper .hint i { font-size: 40px; }
        .signature-wrapper .hint p { font-size: 13px; margin-top: 6px; font-weight: 600; }
        .signature-actions { display: flex; justify-content: flex-end; margin-top: 8px; }
        .signature-actions button {
            background: none;
            border: none;
            color: #ef4444;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .signature-actions button:hover { background: #fef2f2; }
        
        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #00236f, #3b82f6);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s;
            box-shadow: 0 8px 24px rgba(0,35,111,0.3);
            margin-top: 12px;
            letter-spacing: 0.5px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,35,111,0.4); }
        .btn-submit:active { transform: scale(0.98); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none !important; }
        
        /* MODALS */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.6);
            backdrop-filter: blur(12px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }
        .modal-overlay.show { display: flex; }
        .modal-content {
            background: #fff;
            border-radius: 24px;
            padding: 40px 32px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            animation: modalIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.9) translateY(20px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-content .icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #10b98115, #10b98125);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .modal-content .icon i { color: #10b981; font-size: 44px; }
        .modal-content h2 { font-size: 24px; font-weight: 800; color: #0f172a; }
        .modal-content p { color: #64748b; font-size: 14px; margin-top: 6px; font-weight: 500; }
        .modal-content .timer { margin-top: 16px; font-size: 14px; color: #94a3b8; font-weight: 600; }
        .modal-content .timer strong { color: #3b82f6; font-size: 20px; font-weight: 800; }
        
        .spinner { animation: spin 0.8s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        
        .password-modal .modal-content { max-width: 400px; }
        .password-modal .modal-content input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            outline: none;
            margin: 16px 0;
            font-family: 'JetBrains Mono', monospace;
        }
        .password-modal .modal-content input:focus { border-color: #3b82f6; }
        
        .register-modal .modal-content {
            max-width: 460px;
            text-align: left;
        }
        .register-modal .modal-content h3 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .register-modal .modal-content .subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 20px;
        }
        .register-modal .modal-content .form-group {
            margin-bottom: 14px;
        }
        .register-modal .modal-content .form-group label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            display: block;
            margin-bottom: 6px;
        }
        .register-modal .modal-content .form-group input,
        .register-modal .modal-content .form-group select {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            background: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            transition: all 0.2s;
        }
        .register-modal .modal-content .form-group input:focus,
        .register-modal .modal-content .form-group select:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.1);
        }
        .register-modal .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .register-modal .btn-group button {
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            font-size: 14px;
            transition: all 0.25s;
        }
        .register-modal .btn-cancel {
            flex: 1;
            background: #f1f5f9;
            color: #64748b;
        }
        .register-modal .btn-cancel:hover { background: #e2e8f0; }
        .register-modal .btn-submit-register {
            flex: 2;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            box-shadow: 0 4px 16px rgba(16,185,129,0.3);
        }
        .register-modal .btn-submit-register:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(16,185,129,0.4); }
        .register-modal .btn-submit-register:disabled { opacity: 0.6; cursor: not-allowed; }
        
        @media (max-width: 480px) {
            .kiosk-container { padding: 24px 20px; }
            .counter-item .number { font-size: 22px; }
            .kiosk-header h1 { font-size: 20px; }
            .kiosk-header .logo { width: 64px; height: 64px; }
            .kiosk-header .logo i { font-size: 32px; }
        }
    </style>
</head>
<body>
    <div class="bg-blob bg-blob-1"></div>
    <div class="bg-blob bg-blob-2"></div>
    <div class="bg-blob bg-blob-3"></div>

    <!-- SUCCESS MODAL -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h2>Absensi Berhasil!</h2>
            <p id="successName">Terima kasih, kehadiran Anda telah tercatat.</p>
            <div class="timer">⏱️ Reset otomatis dalam <strong id="countdownTimer">3</strong> detik</div>
        </div>
    </div>

    <!-- PASSWORD MODAL -->
    <div class="modal-overlay password-modal" id="passwordModal">
        <div class="modal-content">
            <div style="text-align:center;margin-bottom:16px;">
                <i class="bi bi-shield-lock-fill" style="font-size:56px;color:#3b82f6;"></i>
                <h2 style="font-size:20px;font-weight:800;color:#0f172a;margin-top:12px;">Konfirmasi Keluar</h2>
                <p style="color:#64748b;font-size:13px;margin-top:6px;">Masukkan password admin untuk keluar dari mode kiosk</p>
            </div>
            <input type="password" id="exitPassword" placeholder="Masukkan Password">
            <div style="color:#ef4444;font-size:13px;margin-top:4px;display:none;font-weight:600;" id="passwordError">❌ Password salah!</div>
            <div style="display:flex;gap:10px;margin-top:12px;">
                <button onclick="closePasswordModal()" style="flex:1;padding:14px;border:none;border-radius:12px;font-weight:700;cursor:pointer;background:#f1f5f9;color:#64748b;">Batal</button>
                <button onclick="confirmExit()" style="flex:1;padding:14px;border:none;border-radius:12px;font-weight:700;cursor:pointer;background:linear-gradient(135deg,#00236f,#3b82f6);color:#fff;">Konfirmasi</button>
            </div>
        </div>
    </div>

    <!-- REGISTER MODAL -->
    <div class="modal-overlay register-modal" id="registerModal">
        <div class="modal-content">
            <h3>📝 Daftar Panitia Baru</h3>
            <p class="subtitle">ID <strong id="registerIdDisplay" style="color:#3b82f6;"></strong> belum terdaftar. Silakan isi data berikut:</p>
            
            <form id="registerForm">
                <input type="hidden" id="regIdPanitia">
                
                <div class="form-group">
                    <label>Nama Lengkap <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="regNama" placeholder="Masukkan nama lengkap" required>
                </div>
                
                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" id="regJabatan" placeholder="Contoh: Ketua, Sekretaris, dll">
                </div>
                
                <div class="form-group">
                    <label>No Telepon</label>
                    <input type="text" id="regTelepon" placeholder="Contoh: 08123456789">
                </div>
                
                <div class="btn-group">
                    <button type="button" class="btn-cancel" onclick="closeRegisterModal()">Batal</button>
                    <button type="submit" class="btn-submit-register" id="registerSubmitBtn">
                        <i class="bi bi-person-plus-fill"></i> Daftarkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN KIOSK -->
    <div class="kiosk-container">
        <div class="kiosk-header">
            <div class="logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1>Absensi Panitia</h1>
            <p>MABIT SDI Al-Jamal</p>
        </div>

        <div class="session-card">
            <div class="icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="info">
                <p>Sesi Aktif</p>
                <h3 id="sessionName">{{ $sesiAktif ? $sesiAktif->nama_sesi : 'Tidak ada sesi aktif' }}</h3>
            </div>
        </div>

        <div class="counter-grid">
            <div class="counter-item hadir">
                <div class="number" id="counterHadir">0</div>
                <div class="label">Hadir</div>
            </div>
            <div class="counter-item total">
                <div class="number" id="counterTotal">0</div>
                <div class="label">Total Panitia</div>
            </div>
        </div>

        <div class="progress-wrapper">
            <div class="progress-label">
                <span>Progress Kehadiran</span>
                <span id="progressText">0%</span>
            </div>
            <div class="progress-bar">
                <div class="fill" id="progressFill" style="width:0%;"></div>
            </div>
        </div>

        <form id="kioskForm" autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="idPanitiaInput">ID Panitia</label>
                <input type="text" id="idPanitiaInput" placeholder="Contoh: P001" autofocus>
                <div id="loadingIndicator" style="display:none;font-size:13px;color:#f59e0b;margin-top:6px;font-weight:600;">
                    <i class="bi bi-arrow-repeat spinner"></i> Mencari data...
                </div>
                <!-- Tombol Daftar Cepat (muncul saat ID tidak ditemukan) -->
                <button type="button" id="btnRegister" class="btn-register" onclick="openRegisterModal()">
                    <i class="bi bi-person-plus-fill"></i> Daftarkan Panitia Baru
                </button>
            </div>

            <div class="form-group">
                <label>Nama Panitia</label>
                <div class="name-display" id="nameDisplay">Masukkan ID untuk verifikasi...</div>
            </div>

            <div class="form-group">
                <label>Tanda Tangan Digital</label>
                <div class="signature-wrapper">
                    <canvas id="signaturePad"></canvas>
                    <div class="hint" id="signHint">
                        <i class="bi bi-pencil-square"></i>
                        <p>Gunakan jari untuk menandatangani</p>
                    </div>
                </div>
                <div class="signature-actions">
                    <button type="button" id="resetSignature">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset Coretan
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="bi bi-check-circle-fill"></i>
                KONFIRMASI KEHADIRAN
            </button>
        </form>

        <p style="text-align:center;font-size:13px;color:#94a3b8;margin-top:12px;font-weight:500;">
            Pastikan data yang Anda masukkan sudah benar
        </p>

        <div style="text-align:center;margin-top:20px;padding-top:16px;border-top:1px solid #e2e8f0;">
            <button onclick="openPasswordModal()" style="background:none;border:none;color:#64748b;font-size:13px;cursor:pointer;padding:8px 16px;border-radius:8px;font-weight:600;transition:all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='none'">
                <i class="bi bi-shield-lock"></i> Kembali ke Beranda
            </button>
            <div style="margin-top:8px;font-size:10px;color:#cbd5e1;font-weight:500;">
                v1.0.0 | MABIT SDI Al-Jamal © 2026
            </div>
        </div>
    </div>

    <script>
        const ADMIN_PASSWORD = '{{ env("KIOSK_PASSWORD", "panitia123") }}';
        
        const idPanitiaInput = document.getElementById('idPanitiaInput');
        const nameDisplay = document.getElementById('nameDisplay');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const submitBtn = document.getElementById('submitBtn');
        const form = document.getElementById('kioskForm');
        const successModal = document.getElementById('successModal');
        const successName = document.getElementById('successName');
        const countdownTimer = document.getElementById('countdownTimer');
        const counterHadir = document.getElementById('counterHadir');
        const counterTotal = document.getElementById('counterTotal');
        const progressFill = document.getElementById('progressFill');
        const progressText = document.getElementById('progressText');
        const btnRegister = document.getElementById('btnRegister');
        const registerModal = document.getElementById('registerModal');

        // SIGNATURE
        const canvas = document.getElementById('signaturePad');
        const ctx = canvas.getContext('2d');
        const signHint = document.getElementById('signHint');
        let isDrawing = false;
        let hasSignature = false;

        function resizeCanvas() {
            const rect = canvas.parentElement.getBoundingClientRect();
            const ratio = window.devicePixelRatio || 1;
            canvas.width = rect.width * ratio;
            canvas.height = rect.height * ratio;
            canvas.style.width = rect.width + 'px';
            canvas.style.height = rect.height + 'px';
            ctx.scale(ratio, ratio);
            ctx.strokeStyle = '#1E293B';
            ctx.lineWidth = 3;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        function getPos(e) {
            const rect = canvas.getBoundingClientRect();
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
            return { x: clientX - rect.left, y: clientY - rect.top };
        }

        function startDraw(e) {
            e.preventDefault();
            isDrawing = true;
            signHint.classList.add('hidden');
            const pos = getPos(e);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
        }

        function draw(e) {
            if (!isDrawing) return;
            e.preventDefault();
            const pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            hasSignature = true;
        }

        function endDraw() {
            isDrawing = false;
            ctx.beginPath();
        }

        canvas.addEventListener('mousedown', startDraw);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', endDraw);
        canvas.addEventListener('mouseleave', endDraw);
        canvas.addEventListener('touchstart', startDraw, { passive: false });
        canvas.addEventListener('touchmove', draw, { passive: false });
        canvas.addEventListener('touchend', endDraw, { passive: false });

        document.getElementById('resetSignature').addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            signHint.classList.remove('hidden');
            hasSignature = false;
        });

        function clearSignature() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            signHint.classList.remove('hidden');
            hasSignature = false;
        }

        // AUTO-FILL
        let namaDitemukan = false;
        let panitiaData = null;

        idPanitiaInput.addEventListener('input', function() {
            const id = this.value.trim().toUpperCase();

            if (id.length >= 3) {
                loadingIndicator.style.display = 'block';
                btnRegister.style.display = 'none';
                nameDisplay.textContent = 'Mencari...';
                nameDisplay.className = 'name-display loading';

                fetch(`/panitia/cari/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        loadingIndicator.style.display = 'none';
                        if (data.found) {
                            nameDisplay.textContent = data.nama + ' (' + (data.jabatan || 'Panitia') + ')';
                            nameDisplay.className = 'name-display found';
                            namaDitemukan = true;
                            panitiaData = data.data;
                            btnRegister.style.display = 'none';
                        } else {
                            nameDisplay.textContent = '❌ ID Panitia tidak terdaftar!';
                            nameDisplay.className = 'name-display not-found';
                            namaDitemukan = false;
                            panitiaData = null;
                            btnRegister.style.display = 'flex';
                            btnRegister.dataset.id = id;
                        }
                    })
                    .catch(() => {
                        loadingIndicator.style.display = 'none';
                        nameDisplay.textContent = '⚠️ Gagal memuat data';
                        nameDisplay.className = 'name-display not-found';
                        namaDitemukan = false;
                    });
            } else {
                nameDisplay.textContent = 'Masukkan ID untuk verifikasi...';
                nameDisplay.className = 'name-display';
                namaDitemukan = false;
                panitiaData = null;
                btnRegister.style.display = 'none';
            }
        });

        // REGISTER MODAL
        function openRegisterModal() {
            const id = btnRegister.dataset.id || idPanitiaInput.value.trim().toUpperCase();
            if (!id) {
                alert('Silakan masukkan ID Panitia terlebih dahulu!');
                return;
            }
            document.getElementById('registerIdDisplay').textContent = id;
            document.getElementById('regIdPanitia').value = id;
            document.getElementById('regNama').value = '';
            document.getElementById('regJabatan').value = '';
            document.getElementById('regTelepon').value = '';
            registerModal.classList.add('show');
            setTimeout(() => document.getElementById('regNama').focus(), 100);
        }

        function closeRegisterModal() {
            registerModal.classList.remove('show');
        }

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id_panitia = document.getElementById('regIdPanitia').value;
            const nama_lengkap = document.getElementById('regNama').value.trim();
            const jabatan = document.getElementById('regJabatan').value.trim();
            const no_telepon = document.getElementById('regTelepon').value.trim();

            if (!nama_lengkap) {
                alert('⚠️ Nama lengkap harus diisi!');
                return;
            }

            const btn = document.getElementById('registerSubmitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Menyimpan...';

            fetch('/panitia', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id_panitia, nama_lengkap, jabatan, no_telepon })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    closeRegisterModal();
                    idPanitiaInput.value = id_panitia;
                    nameDisplay.textContent = nama_lengkap + ' (' + (jabatan || 'Panitia') + ')';
                    nameDisplay.className = 'name-display found';
                    namaDitemukan = true;
                    panitiaData = data.data;
                    btnRegister.style.display = 'none';
                    updateCounter();
                } else {
                    let msg = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                    alert('❌ ' + msg);
                }
            })
            .catch(error => alert('⚠️ Terjadi kesalahan: ' + error.message))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-person-plus-fill"></i> Daftarkan';
            });
        });

        // SUBMIT
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const idPanitia = idPanitiaInput.value.trim().toUpperCase();

            if (!namaDitemukan || !panitiaData) {
                alert('❌ ID Panitia tidak terdaftar!');
                return;
            }

            if (!hasSignature) {
                alert('⚠️ Silakan isi tanda tangan terlebih dahulu!');
                return;
            }

            const ttdData = canvas.toDataURL('image/png');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Memproses...';

            fetch('{{ route("absensi.kiosk.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id_panitia: idPanitia, ttd: ttdData })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    playBeep();
                    successName.textContent = 'Selamat ' + panitiaData.nama_lengkap + '! Kehadiran Anda telah tercatat.';
                    successModal.classList.add('show');
                    updateCounter();

                    let countdown = 3;
                    countdownTimer.textContent = countdown;
                    const timer = setInterval(() => {
                        countdown--;
                        countdownTimer.textContent = countdown;
                        if (countdown <= 0) {
                            clearInterval(timer);
                            successModal.classList.remove('show');
                            resetForm();
                        }
                    }, 1000);
                } else {
                    alert('❌ ' + data.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> KONFIRMASI KEHADIRAN';
                }
            })
            .catch(error => {
                alert('⚠️ Terjadi kesalahan: ' + error.message);
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> KONFIRMASI KEHADIRAN';
            });
        });

        function resetForm() {
            idPanitiaInput.value = '';
            nameDisplay.textContent = 'Masukkan ID untuk verifikasi...';
            nameDisplay.className = 'name-display';
            clearSignature();
            namaDitemukan = false;
            panitiaData = null;
            btnRegister.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> KONFIRMASI KEHADIRAN';
            idPanitiaInput.focus();
        }

        // COUNTER
        function updateCounter() {
            fetch('{{ route("absensi.counter") }}')
                .then(res => res.json())
                .then(data => {
                    counterHadir.textContent = data.hadir || 0;
                    counterTotal.textContent = data.total || 0;
                    const percent = data.total > 0 ? Math.min(100, Math.round((data.hadir / data.total) * 100)) : 0;
                    progressFill.style.width = percent + '%';
                    progressText.textContent = percent + '%';
                })
                .catch(() => {});
        }

        updateCounter();
        setInterval(updateCounter, 5000);

        // BEEP
        function playBeep() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const osc1 = audioCtx.createOscillator();
                const gain1 = audioCtx.createGain();
                osc1.connect(gain1);
                gain1.connect(audioCtx.destination);
                osc1.frequency.value = 880;
                osc1.type = 'sine';
                gain1.gain.value = 0.3;
                osc1.start();
                osc1.stop(audioCtx.currentTime + 0.15);
                setTimeout(() => {
                    const osc2 = audioCtx.createOscillator();
                    const gain2 = audioCtx.createGain();
                    osc2.connect(gain2);
                    gain2.connect(audioCtx.destination);
                    osc2.frequency.value = 1100;
                    osc2.type = 'sine';
                    gain2.gain.value = 0.3;
                    osc2.start();
                    osc2.stop(audioCtx.currentTime + 0.15);
                }, 200);
            } catch (e) {}
        }

        // PASSWORD MODAL
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.add('show');
            document.getElementById('exitPassword').value = '';
            document.getElementById('passwordError').style.display = 'none';
            setTimeout(() => document.getElementById('exitPassword').focus(), 100);
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.remove('show');
        }

        function confirmExit() {
            const password = document.getElementById('exitPassword').value;
            if (password === ADMIN_PASSWORD) {
                closePasswordModal();
                window.location.href = '{{ route("dashboard") }}';
            } else {
                document.getElementById('passwordError').style.display = 'block';
                document.getElementById('exitPassword').value = '';
                document.getElementById('exitPassword').focus();
            }
        }

        document.getElementById('exitPassword').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') confirmExit();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (successModal.classList.contains('show')) {
                    successModal.classList.remove('show');
                    resetForm();
                }
                closePasswordModal();
                closeRegisterModal();
            }
        });

        successModal.addEventListener('click', function(e) {
            if (e.target === this) {
                successModal.classList.remove('show');
                resetForm();
            }
        });

        registerModal.addEventListener('click', function(e) {
            if (e.target === this) closeRegisterModal();
        });

        console.log('✅ KIOSK MODE ACTIVE - MABIT SDI Al-Jamal');
    </script>
</body>
</html>