<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Form Absensi Panitia - MABIT SDI Al-Jamal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            padding: 20px;
            color: #1e293b;
        }
        
        .form-container {
            max-width: 480px;
            margin: 0 auto;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.4);
            padding: 32px 28px;
        }
        
        /* Header */
        .header { text-align: center; margin-bottom: 24px; }
        .logo {
            width: 72px;
            height: 72px;
            margin: 0 auto 12px;
            background: linear-gradient(135deg, #00236f, #3b82f6);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(0,35,111,0.3);
        }
        .logo i { color: #fff; font-size: 36px; }
        .header h1 { font-size: 22px; font-weight: 800; color: #00236f; }
        .header p { font-size: 13px; color: #64748b; margin-top: 4px; font-weight: 500; }
        
        /* Session */
        .session-card {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 2px solid #bae6fd;
            border-radius: 14px;
            padding: 14px 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .session-card .icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .session-card .icon i { color: #fff; font-size: 20px; }
        .session-card .text .label {
            font-size: 10px;
            font-weight: 800;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .session-card .text .name {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 2px;
        }
        
        /* Form */
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
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
        
        .name-display {
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
        .name-display.found { border-color: #10b981; background: #f0fdf4; color: #10b981; }
        .name-display.not-found { border-color: #ef4444; background: #fef2f2; color: #ef4444; }
        .name-display.loading { border-color: #f59e0b; background: #fffbeb; color: #f59e0b; }
        
        /* TTD */
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
        
        .reset-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-left: auto;
            margin-top: 8px;
            background: none;
            border: none;
            color: #ef4444;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .reset-btn:hover { background: #fef2f2; }
        
        /* Button */
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
            margin-top: 8px;
            letter-spacing: 0.5px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(0,35,111,0.4); }
        .btn-submit:active { transform: scale(0.98); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none !important; }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
        }
        
        /* Success Modal */
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
            max-width: 400px;
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
        
        .spinner { animation: spin 0.8s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Header -->
        <div class="header">
            <div class="logo"><i class="bi bi-mortarboard-fill"></i></div>
            <h1>Form Absensi</h1>
            <p>MABIT SDI Al-Jamal</p>
        </div>
        
        <!-- Session -->
        <div class="session-card">
            <div class="icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="text">
                <div class="label">Sesi Aktif</div>
                <div class="name">{{ $sesiAktif->nama_sesi }}</div>
            </div>
        </div>
        
        <!-- Form -->
        <form id="absenForm">
            @csrf
            <input type="hidden" id="token" value="{{ $token }}">
            
            <div class="form-group">
                <label>ID Panitia</label>
                <input type="text" id="idPanitia" placeholder="Contoh: P001" autofocus>
                <div id="loadingIndicator" style="display:none;font-size:13px;color:#f59e0b;margin-top:6px;font-weight:600;">
                    <i class="bi bi-arrow-repeat spinner"></i> Mencari data...
                </div>
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
                <button type="button" id="resetSignature" class="reset-btn">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset Coretan
                </button>
            </div>
            
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="bi bi-check-circle-fill"></i>
                KONFIRMASI KEHADIRAN
            </button>
        </form>
        
        <div class="footer">
            v1.0.0 | MABIT SDI Al-Jamal © 2026
        </div>
    </div>
    
    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="modal-content">
            <div class="icon"><i class="bi bi-check-circle-fill"></i></div>
            <h2>Absensi Berhasil!</h2>
            <p id="successName">Terima kasih, kehadiran Anda telah tercatat.</p>
        </div>
    </div>
    
    <script>
        const token = document.getElementById('token').value;
        
        // ================================================================
        // SIGNATURE PAD
        // ================================================================
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
        
        // ================================================================
        // AUTO-FILL NAMA
        // ================================================================
        let namaDitemukan = false;
        let panitiaData = null;
        const idInput = document.getElementById('idPanitia');
        const nameDisplay = document.getElementById('nameDisplay');
        const loadingIndicator = document.getElementById('loadingIndicator');
        
        idInput.addEventListener('input', function() {
            const id = this.value.trim().toUpperCase();
            
            if (id.length >= 3) {
                loadingIndicator.style.display = 'block';
                nameDisplay.textContent = 'Mencari...';
                nameDisplay.className = 'name-display loading';
                
                fetch(`/absen/cari/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        loadingIndicator.style.display = 'none';
                        if (data.found) {
                            nameDisplay.textContent = data.nama + ' (' + (data.jabatan || 'Panitia') + ')';
                            nameDisplay.className = 'name-display found';
                            namaDitemukan = true;
                            panitiaData = data.data;
                        } else {
                            nameDisplay.textContent = '❌ ID Panitia tidak terdaftar!';
                            nameDisplay.className = 'name-display not-found';
                            namaDitemukan = false;
                            panitiaData = null;
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
            }
        });
        
        // ================================================================
        // SUBMIT
        // ================================================================
        document.getElementById('absenForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const idPanitia = idInput.value.trim().toUpperCase();
            
            if (!namaDitemukan || !panitiaData) {
                alert('❌ ID Panitia tidak terdaftar!');
                return;
            }
            
            if (!hasSignature) {
                alert('⚠️ Silakan isi tanda tangan terlebih dahulu!');
                return;
            }
            
            const ttdData = canvas.toDataURL('image/png');
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spinner"></i> Memproses...';
            
            fetch(`/absen/${token}/submit`, {
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
                    document.getElementById('successName').textContent = 'Selamat ' + panitiaData.nama_lengkap + '! Kehadiran Anda telah tercatat.';
                    document.getElementById('successModal').classList.add('show');
                    
                    setTimeout(() => {
                        document.getElementById('successModal').classList.remove('show');
                    }, 5000);
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
        
        // ================================================================
        // SUARA BEEP
        // ================================================================
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
    </script>
</body>
</html>