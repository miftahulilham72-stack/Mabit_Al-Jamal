<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kiosk Absensi Panitia - MABIT SDI Al-Jamal</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #1e293b;
        }
        
        .kiosk-wrapper {
            max-width: 900px;
            width: 100%;
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 25px 80px rgba(0,0,0,0.5);
            padding: 48px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Header */
        .kiosk-logo {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #00236f, #3b82f6);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 12px 32px rgba(0,35,111,0.3);
        }
        .kiosk-logo i { color: #fff; font-size: 44px; }
        
        .kiosk-title {
            font-size: 32px;
            font-weight: 800;
            color: #00236f;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }
        .kiosk-subtitle {
            font-size: 15px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 32px;
        }
        
        /* Session Card */
        .session-info {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 2px solid #bae6fd;
            padding: 14px 28px;
            border-radius: 50px;
            margin-bottom: 40px;
        }
        .session-info .icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(59,130,246,0.3);
        }
        .session-info .icon i { color: #fff; font-size: 18px; }
        .session-info .text { text-align: left; }
        .session-info .text .label {
            font-size: 10px;
            font-weight: 800;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .session-info .text .name {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }
        
        /* QR Code Section */
        .qr-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
            margin-bottom: 32px;
        }
        
        .qr-box {
            background: #ffffff;
            padding: 24px;
            border-radius: 24px;
            border: 4px solid #00236f;
            box-shadow: 0 12px 40px rgba(0,35,111,0.2);
            display: inline-block;
            margin: 0 auto;
            position: relative;
        }
        .qr-box::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 24px;
            background: linear-gradient(135deg, #00236f, #3b82f6, #8b5cf6);
            z-index: -1;
            animation: glowPulse 2s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }
        #qrcode {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #qrcode img {
            border-radius: 12px;
        }
        
        .instruction {
            text-align: left;
        }
        .instruction h3 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .instruction h3 i {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
        }
        
        .step-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .step-list li {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            font-size: 14px;
            color: #475569;
            font-weight: 500;
            line-height: 1.5;
        }
        .step-list li .num {
            width: 28px;
            height: 28px;
            background: #3b82f615;
            color: #3b82f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
            flex-shrink: 0;
        }
        
        /* Counter */
        .counter-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 32px;
        }
        .counter-card {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 20px;
            padding: 24px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }
        .counter-card .number {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1;
        }
        .counter-card .label {
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 8px;
        }
        .counter-card.hadir .number { color: #10b981; }
        .counter-card.total .number { color: #3b82f6; }
        
        /* Progress */
        .progress-section {
            margin-bottom: 32px;
            padding: 0 8px;
        }
        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .progress-bar {
            height: 12px;
            background: #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }
        .progress-bar .fill {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #10b981);
            border-radius: 6px;
            transition: width 0.5s ease;
        }
        
        /* Footer */
        .kiosk-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .kiosk-footer .time {
            font-size: 14px;
            color: #64748b;
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }
        .kiosk-footer .info {
            font-size: 12px;
            color: #94a3b8;
            font-weight: 500;
        }
        
        .no-session {
            padding: 80px 20px;
            text-align: center;
        }
        .no-session i {
            font-size: 80px;
            color: #cbd5e1;
            display: block;
            margin-bottom: 20px;
        }
        .no-session h2 {
            font-size: 24px;
            font-weight: 800;
            color: #64748b;
            margin-bottom: 8px;
        }
        .no-session p {
            font-size: 14px;
            color: #94a3b8;
        }
        
        @media (max-width: 768px) {
            .kiosk-wrapper { padding: 32px 24px; }
            .qr-section { grid-template-columns: 1fr; gap: 24px; }
            .kiosk-title { font-size: 24px; }
            .counter-card .number { font-size: 36px; }
        }
    </style>
</head>
<body>
    <div class="kiosk-wrapper">
        @if($sesiAktif)
            <!-- Header -->
            <div class="kiosk-logo">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h1 class="kiosk-title">Absensi Panitia</h1>
            <p class="kiosk-subtitle">MABIT SDI Al-Jamal</p>
            
            <!-- Session Info -->
            <div class="session-info">
                <div class="icon"><i class="bi bi-calendar-check-fill"></i></div>
                <div class="text">
                    <div class="label">Sesi Aktif</div>
                    <div class="name">
                        {{ $sesiAktif->nama_sesi }}
                        <span style="font-size:13px;font-weight:500;color:#64748b;margin-left:8px;">
                            ({{ \Carbon\Carbon::parse($sesiAktif->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($sesiAktif->batas_waktu)->format('H:i') }} WIB)
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- QR Section -->
            <div class="qr-section">
                <div class="qr-box">
                    <div id="qrcode"></div>
                </div>
                
                <div class="instruction">
                    <h3>
                        <i class="bi bi-phone-fill"></i>
                        Cara Absen:
                    </h3>
                    <ul class="step-list">
                        <li>
                            <span class="num">1</span>
                            <span>Buka <strong>Kamera HP</strong> atau aplikasi <strong>QR Scanner</strong></span>
                        </li>
                        <li>
                            <span class="num">2</span>
                            <span>Arahkan kamera ke <strong>QR Code</strong> di samping</span>
                        </li>
                        <li>
                            <span class="num">3</span>
                            <span>Browser akan <strong>terbuka otomatis</strong></span>
                        </li>
                        <li>
                            <span class="num">4</span>
                            <span>Masukkan <strong>ID Panitia</strong> & tanda tangan</span>
                        </li>
                        <li>
                            <span class="num">5</span>
                            <span>Klik <strong>Konfirmasi Kehadiran</strong> ✅</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Counter -->
            <div class="counter-section">
                <div class="counter-card hadir">
                    <div class="number" id="counterHadir">0</div>
                    <div class="label">✓ Sudah Absen</div>
                </div>
                <div class="counter-card total">
                    <div class="number" id="counterTotal">0</div>
                    <div class="label">Total Panitia</div>
                </div>
            </div>
            
            <!-- Progress -->
            <div class="progress-section">
                <div class="progress-label">
                    <span>Progress Kehadiran</span>
                    <span id="progressText">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="fill" id="progressFill" style="width:0%;"></div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="kiosk-footer">
                <div class="time" id="clock">--:--:--</div>
                <div class="info">v1.0.0 | MABIT SDI Al-Jamal © 2026</div>
            </div>
        @else
            <!-- No Session -->
            <div class="no-session">
                <i class="bi bi-calendar-x"></i>
                <h2>Tidak Ada Sesi Aktif</h2>
                <p>Silakan tunggu admin mengaktifkan sesi absensi</p>
            </div>
        @endif
    </div>
    
    @if($sesiAktif)
    <script>
        // ================================================================
        // GENERATE QR CODE
        // ================================================================
        const token = '{{ $token }}';
        const baseUrl = '{{ url("/") }}';
        const absenUrl = `${baseUrl}/absen/${token}`;
        
        new QRCode(document.getElementById("qrcode"), {
            text: absenUrl,
            width: 280,
            height: 280,
            colorDark: "#00236f",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        
        // ================================================================
        // JAM DIGITAL
        // ================================================================
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds} WIB`;
        }
        updateClock();
        setInterval(updateClock, 1000);
        
        // ================================================================
        // COUNTER REAL-TIME
        // ================================================================
        function updateCounter() {
            fetch('{{ route("kiosk.counter") }}')
                .then(res => res.json())
                .then(data => {
                    document.getElementById('counterHadir').textContent = data.hadir || 0;
                    document.getElementById('counterTotal').textContent = data.total || 0;
                    const percent = data.total > 0 ? Math.min(100, Math.round((data.hadir / data.total) * 100)) : 0;
                    document.getElementById('progressFill').style.width = percent + '%';
                    document.getElementById('progressText').textContent = percent + '%';
                })
                .catch(() => {});
        }
        
        updateCounter();
        setInterval(updateCounter, 5000);
        
        console.log('✅ KIOSK MODE ACTIVE - QR Code Ready');
    </script>
    @endif
</body>
</html>