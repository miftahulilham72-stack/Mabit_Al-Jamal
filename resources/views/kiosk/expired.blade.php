<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Tidak Valid</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 24px;
            padding: 48px 32px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 80px rgba(0,0,0,0.4);
        }
        .icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .icon i { color: #ef4444; font-size: 50px; }
        h1 { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        p { color: #64748b; font-size: 14px; line-height: 1.6; }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 24px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #00236f, #3b82f6);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon"><i class="bi bi-x-circle-fill"></i></div>
        <h1>QR Code Tidak Valid</h1>
        <p>{{ $message ?? 'QR Code sudah tidak berlaku. Silakan scan ulang di kiosk.' }}</p>
        <a href="/kiosk" class="btn"><i class="bi bi-arrow-clockwise"></i> Kembali ke Kiosk</a>
    </div>
</body>
</html>