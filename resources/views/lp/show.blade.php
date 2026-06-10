<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $landingPage->headline ?: $landingPage->product->name }}</title>
    <meta name="description" content="{{ $landingPage->subheadline ?: $landingPage->product->description }}">

    @if($landingPage->pixel_id)
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $landingPage->pixel_id }}');
    fbq('track', 'PageView');
    </script>
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #1f2937; }
        .container { max-width: 640px; margin: 0 auto; padding: 0 20px; }
        .hero { padding: 60px 0 40px; text-align: center; }
        .hero h1 { font-size: 2rem; font-weight: 800; margin-bottom: 16px; line-height: 1.2; }
        .hero p { font-size: 1.1rem; color: #6b7280; margin-bottom: 32px; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 40px; }
        .feature { padding: 20px; border-radius: 12px; text-align: center; }
        .feature .icon { font-size: 2rem; margin-bottom: 8px; }
        .feature .title { font-weight: 600; font-size: 0.9rem; }
        .price-box { background: #f9fafb; border-radius: 16px; padding: 32px; text-align: center; margin-bottom: 40px; }
        .price-box .original { text-decoration: line-through; color: #9ca3af; font-size: 1.1rem; }
        .price-box .current { font-size: 2.5rem; font-weight: 800; color: #059669; }
        .form-section { padding-bottom: 60px; }
        .form-section h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 24px; text-align: center; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 4px; color: #374151; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 1rem; font-family: inherit; transition: border-color 0.2s; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn-submit { width: 100%; padding: 16px; font-size: 1rem; font-weight: 700; border: none; border-radius: 12px; cursor: pointer; color: white; transition: opacity 0.2s; }
        .btn-submit:hover { opacity: 0.9; }
        .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }
        .shipping-options { margin-top: 8px; padding: 12px; background: #f9fafb; border-radius: 8px; }
        .shipping-option { padding: 10px 12px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 8px; cursor: pointer; transition: all 0.2s; display: flex; justify-content: space-between; align-items: center; }
        .shipping-option:hover { border-color: #2563eb; background: #eff6ff; }
        .shipping-option.selected { border-color: #2563eb; background: #eff6ff; }
        .shipping-option:last-child { margin-bottom: 0; }
        .total-display { margin-top: 20px; padding: 20px; background: #f0fdf4; border-radius: 12px; }
        .total-display .label { font-size: 0.875rem; color: #059669; }
        .total-display .amount { font-size: 1.5rem; font-weight: 800; color: #059669; }
        .footer { text-align: center; padding: 24px; color: #9ca3af; font-size: 0.8rem; }
        .error { color: #dc2626; font-size: 0.8rem; margin-top: 4px; }
        .loading { text-align: center; padding: 20px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero">
            <h1>{{ $landingPage->headline ?: $landingPage->product->name }}</h1>
            <p>{{ $landingPage->subheadline ?: $landingPage->product->description }}</p>
        </div>

        @if($landingPage->body_content)
        <div class="features">
            @foreach(explode("\n", trim($landingPage->body_content)) as $line)
                @if(trim($line))
                <div class="feature">
                    <div class="icon">✅</div>
                    <div class="title">{{ trim($line) }}</div>
                </div>
                @endif
            @endforeach
        </div>
        @endif

        <div class="price-box">
            <div class="current">Rp {{ number_format($landingPage->product->sell_price, 0, ',', '.') }}</div>
        </div>

        <div class="form-section">
            <h2>Isi Form Pemesanan</h2>
            <form id="order-form" method="POST" action="{{ route('lp.order.create') }}">
                @csrf
                <input type="hidden" name="landing_page_id" value="{{ $landingPage->id }}">
                <input type="hidden" name="shipping_cost" value="0">

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="customer_name" required placeholder="Nama lengkap Anda">
                </div>
                <div class="form-group">
                    <label>Nomor WhatsApp</label>
                    <input type="tel" name="customer_phone" required placeholder="0812xxxxxxxx">
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="customer_address" rows="2" required placeholder="Jalan, nomor rumah, RT/RW, kelurahan"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Kota</label>
                        <input type="text" name="customer_city" required placeholder="Kota/Kabupaten">
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <input type="text" name="customer_province" required placeholder="Provinsi">
                    </div>
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" name="customer_postal_code" required placeholder="12345">
                </div>
                <div class="form-group">
                    <label>Pilih Kurir</label>
                    <select name="shipping_courier" id="courier-select" required onchange="loadShippingOptions()">
                        <option value="">Pilih kurir...</option>
                    </select>
                    <div id="shipping-options" class="shipping-options" style="display:none"></div>
                </div>

                <div class="form-group" style="margin-top: 12px">
                    <label style="display: flex; align-items: center; cursor: pointer">
                        <input type="checkbox" name="is_cod" value="1" id="cod-checkbox" onchange="toggleCod()" style="width: auto; margin-right: 8px;">
                        <span>COD (Bayar di Tempat)</span>
                    </label>
                    <small id="cod-note" style="display: none; color: #92400e">Order akan diproses tanpa pembayaran di muka. Bayar saat paket diterima.</small>
                </div>

                <div class="total-display" id="total-display">
                    <div class="label">Total Pembayaran</div>
                    <div class="amount" id="total-amount">Rp {{ number_format($landingPage->product->sell_price, 0, ',', '.') }}</div>
                </div>

                <div style="margin-top: 16px">
                    <button type="submit" class="btn-submit" style="background-color: {{ $landingPage->cta_color }}"
                        onclick="trackCheckout()">
                        {{ $landingPage->cta_text ?: 'Pesan Sekarang' }}
                    </button>
                </div>
            </form>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>

    @if($landingPage->pixel_id)
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $landingPage->pixel_id }}&ev=PageView&noscript=1"/></noscript>
    @endif

    <script>
    const productPrice = {{ $landingPage->product->sell_price }};
    const pixelId = '{{ $landingPage->pixel_id }}';
    let selectedShippingCost = 0;
    let selectedCourier = '';

    async function loadCouriers() {
        const select = document.getElementById('courier-select');
        try {
            const res = await fetch('/lp/shipping-options?destination_city=default');
            const data = await res.json();
            data.couriers.forEach(courier => {
                const option = document.createElement('option');
                option.value = courier.code;
                option.textContent = courier.name;
                select.appendChild(option);
            });
        } catch(e) {
            select.innerHTML = '<option value="jne">JNE</option><option value="jnt">J&T Express</option><option value="sicepat">SiCepat</option>';
        }
    }

    async function loadShippingOptions() {
        const courier = document.getElementById('courier-select').value;
        const container = document.getElementById('shipping-options');
        if (!courier) { container.style.display = 'none'; return; }

        container.innerHTML = '<div class="loading">Memuat ongkir...</div>';
        container.style.display = 'block';

        try {
            const res = await fetch('/lp/shipping-options?destination_city=default');
            const data = await res.json();
            const courierData = data.couriers.find(c => c.code === courier);
            if (courierData) {
                container.innerHTML = courierData.services.map((s, i) => `
                    <div class="shipping-option" onclick="selectShipping(this, '${courierData.name}', '${s.name}', ${s.cost}, '${s.etd}')">
                        <div>
                            <strong>${s.name}</strong> (${s.description})
                            <br><small style="color:#6b7280">Estimasi ${s.etd}</small>
                        </div>
                        <div style="font-weight:600">Rp ${s.cost.toLocaleString('id-ID')}</div>
                    </div>
                `).join('');
            }
        } catch(e) {
            container.innerHTML = `
                <div class="shipping-option" onclick="selectShipping(this, '${courier.toUpperCase()}', 'REG', 9000, '2-3 hari')">
                    <div><strong>Reguler</strong><br><small style="color:#6b7280">Estimasi 2-3 hari</small></div>
                    <div style="font-weight:600">Rp 9.000</div>
                </div>
            `;
        }
    }

    function selectShipping(el, courierName, service, cost, etd) {
        document.querySelectorAll('.shipping-option').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        selectedShippingCost = cost;
        selectedCourier = courierName;
        document.querySelector('input[name="shipping_cost"]').value = cost;
        updateTotal();
    }

    function updateTotal() {
        const total = productPrice + selectedShippingCost;
        document.getElementById('total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    function toggleCod() {
        const codNote = document.getElementById('cod-note');
        const isChecked = document.getElementById('cod-checkbox').checked;
        codNote.style.display = isChecked ? 'block' : 'none';
    }

    function trackCheckout() {
        if (pixelId) {
            fbq('track', 'InitiateCheckout');
        }
    }

    loadCouriers();
    </script>
</body>
</html>
