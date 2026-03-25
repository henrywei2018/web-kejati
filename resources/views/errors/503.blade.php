<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">
    <title>Sedang Dalam Pemeliharaan - Kejaksaan Tinggi Kalimantan Utara</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #1a3a5c 0%, #0d2137 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            padding: 1rem;
        }

        .container {
            text-align: center;
            max-width: 520px;
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        p {
            font-size: 1rem;
            line-height: 1.6;
            color: rgba(255,255,255,0.8);
            margin-bottom: 0.5rem;
        }

        .badge {
            display: inline-block;
            margin: 1.5rem 0;
            padding: 0.4rem 1rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 9999px;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .refresh-note {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.5);
            margin-top: 2rem;
        }

        .countdown {
            font-weight: 600;
            color: rgba(255,255,255,0.8);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🔧</div>

        <div class="badge">Pemeliharaan Sistem</div>

        <h1>Layanan Sedang Tidak Tersedia</h1>

        <p>Website Kejaksaan Tinggi Kalimantan Utara sementara tidak dapat diakses karena pemeliharaan rutin.</p>
        <p>Kami akan segera kembali online. Mohon maaf atas ketidaknyamanannya.</p>

        <p class="refresh-note">
            Halaman ini akan otomatis memuat ulang dalam <span class="countdown" id="countdown">30</span> detik.
        </p>
    </div>

    <script>
        var seconds = 30;
        var el = document.getElementById('countdown');
        var interval = setInterval(function() {
            seconds--;
            if (el) el.textContent = seconds;
            if (seconds <= 0) { clearInterval(interval); location.reload(); }
        }, 1000);
    </script>
</body>
</html>
