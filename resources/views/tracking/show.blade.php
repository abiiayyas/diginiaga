<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracking #{{ $order->order_number }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; min-height: 100vh; }
        .container { max-width: 480px; margin: 0 auto; padding: 40px 20px; }
        .card { background: white; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 16px; }
        .card h2 { font-size: 1.25rem; margin-bottom: 20px; }
        .status-badge { display: inline-block; padding: 6px 16px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; margin-bottom: 16px; }
        .status-pending_payment { background: #fef3c7; color: #92400e; }
        .status-paid { background: #dbeafe; color: #1e40af; }
        .status-processing { background: #ede9fe; color: #6b21a8; }
        .status-shipped { background: #dbeafe; color: #3730a3; }
        .status-delivered { background: #dcfce7; color: #166534; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; font-size: 0.9rem; border-bottom: 1px solid #f3f4f6; }
        .detail-row:last-child { border-bottom: 0; }
        .label { color: #6b7280; }
        .value { font-weight: 500; }
        .tracking-search { text-align: center; padding: 24px; }
        .tracking-search input { width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 1rem; margin-bottom: 12px; }
        .tracking-search button { width: 100%; padding: 14px; background: #2563eb; color: white; border: none; border-radius: 10px; font-size: 1rem; font-weight: 600; cursor: pointer; }
        .error-msg { color: #dc2626; font-size: 0.9rem; margin-bottom: 12px; padding: 8px 12px; background: #fee2e2; border-radius: 8px; }
    </style>
</head>
<body>
    @if(request()->isMethod('post') || request()->routeIs('tracking.show'))
    <div class="container">
        <div class="card">
            <h2>Status Order #{{ $order->order_number }}</h2>
            <span class="status-badge status-{{ $order->order_status }}">{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
            <div class="detail-row"><span class="label">Produk</span><span class="value">{{ $order->product->name ?? '-' }}</span></div>
            <div class="detail-row"><span class="label">Total</span><span class="value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
            <div class="detail-row"><span class="label">Pembayaran</span><span class="value">{{ $order->payment_status }}</span></div>
            @if($order->shipment)
            <div class="detail-row"><span class="label">Kurir</span><span class="value">{{ $order->shipment->courier_name }}</span></div>
            <div class="detail-row"><span class="label">No. Resi</span><span class="value" style="font-weight:700;color:#2563eb">{{ $order->shipment->tracking_number }}</span></div>
            <div class="detail-row"><span class="label">Status Kirim</span><span class="value">{{ $order->shipment->status }}</span></div>
            @endif
            <div class="detail-row"><span class="label">Tanggal Order</span><span class="value">{{ $order->created_at->format('d M Y H:i') }}</span></div>
        </div>
        
        <div class="tracking-search">
            <p style="font-size:0.85rem;color:#6b7280;margin-bottom:12px">Cari order lain</p>
            <form method="POST" action="{{ route('tracking.lookup') }}">
                @csrf
                <input type="text" name="order_number" placeholder="Masukkan nomor order..." required>
                <button type="submit">Cek Status</button>
            </form>
        </div>
    </div>
    @else
    <div class="container">
        <div class="card">
            <h2>Cek Status Order</h2>
            @if(session('error'))
                <div class="error-msg">{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('tracking.lookup') }}">
                @csrf
                <div style="margin-bottom:12px">
                    <input type="text" name="order_number" placeholder="Masukkan nomor order Anda..." required style="width:100%;padding:12px 16px;border:1px solid #d1d5db;border-radius:10px;font-size:1rem;">
                </div>
                <button type="submit" style="width:100%;padding:14px;background:#2563eb;color:white;border:none;border-radius:10px;font-size:1rem;font-weight:600;cursor:pointer;">Cek Status</button>
            </form>
        </div>
    </div>
    @endif
</body>
</html>
