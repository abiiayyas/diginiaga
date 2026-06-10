<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: white; border-radius: 16px; padding: 48px 32px; text-align: center; max-width: 420px; width: 90%; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .icon { font-size: 4rem; margin-bottom: 16px; }
        h2 { font-size: 1.5rem; margin-bottom: 8px; }
        p { color: #6b7280; margin-bottom: 24px; }
        .btn { display: inline-block; padding: 12px 32px; background: #2563eb; color: white; border-radius: 10px; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">⚠️</div>
        <h2>Terjadi Kesalahan</h2>
        <p>{{ $message ?? 'Gagal memproses pembayaran. Silakan coba lagi atau hubungi kami.' }}</p>
        <a href="/" class="btn">Kembali</a>
    </div>
</body>
</html>
