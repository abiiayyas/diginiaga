<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ $landingPage->headline ?: $landingPage->product->name }}</title>

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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --brand-color: {{ $landingPage->cta_color ?: '#ea580c' }};
        }
        .bg-brand { background-color: var(--brand-color) !important; }
        .text-brand { color: var(--brand-color) !important; }
        .border-brand { border-color: var(--brand-color) !important; }
        
        .stripe-border {
            height: 3px;
            background-image: repeating-linear-gradient(45deg, #6fa6d6, #6fa6d6 33px, transparent 0, transparent 41px, #f18d9b 0, #f18d9b 74px, transparent 0, transparent 82px);
            background-position-x: -1.875rem;
            background-size: 7.25rem .1875rem;
        }

        /* Custom radio buttons */
        .custom-radio:checked + label {
            border-color: var(--brand-color);
            background-color: #fffaf9;
        }
        .custom-radio:checked + label .radio-indicator {
            border-color: var(--brand-color);
            border-width: 5px;
        }
        
        /* Disable arrows on number input */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800 pb-24">

    <!-- Top Nav -->
    <div class="sticky top-0 z-50 bg-brand text-white shadow-sm">
        <div class="max-w-md mx-auto px-4 h-14 flex items-center justify-between">
            <a href="{{ route('lp.show', $landingPage->slug) }}" class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-lg font-semibold">Checkout</h1>
            <div class="w-6"></div> <!-- spacer -->
        </div>
    </div>

    <div class="max-w-md mx-auto mt-3 space-y-3 px-3">
        <form id="order-form" method="POST" action="{{ route('lp.order.create') }}">
            @csrf
            <input type="hidden" name="landing_page_id" value="{{ $landingPage->id }}">
            @if(isset($variant) && $variant)
            <input type="hidden" name="product_variant_id" value="{{ $variant->id }}">
            @endif
            <input type="hidden" name="shipping_cost" value="0">
            @if($utmQuery)
            <input type="hidden" name="utm_source" value="{{ request()->query('utm_source') }}">
            <input type="hidden" name="utm_medium" value="{{ request()->query('utm_medium') }}">
            <input type="hidden" name="utm_campaign" value="{{ request()->query('utm_campaign') }}">
            <input type="hidden" name="utm_content" value="{{ request()->query('utm_content') }}">
            @endif

            <!-- Alamat Pengiriman -->
            <div class="bg-white rounded-t-xl shadow-sm overflow-hidden relative">
                <div class="p-4">
                    <div class="flex items-center text-brand mb-3">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <h2 class="font-semibold text-sm">Alamat Pengiriman</h2>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Nama Lengkap</label>
                                <input type="text" name="customer_name" required placeholder="Nama Anda" class="w-full text-sm py-2 px-3 border border-gray-200 rounded-lg focus:border-brand focus:ring focus:ring-brand focus:ring-opacity-20 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">No. WhatsApp</label>
                                <input type="tel" name="customer_phone" required placeholder="0812..." class="w-full text-sm py-2 px-3 border border-gray-200 rounded-lg focus:border-brand focus:ring focus:ring-brand focus:ring-opacity-20 outline-none transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Alamat Lengkap</label>
                            <textarea name="customer_address" rows="2" required placeholder="Nama Jalan, RT/RW, Kelurahan, Kec." class="w-full text-sm py-2 px-3 border border-gray-200 rounded-lg focus:border-brand focus:ring focus:ring-brand focus:ring-opacity-20 outline-none transition-all"></textarea>
                        </div>
                        <div class="grid grid-cols-6 gap-3">
                            <div class="col-span-3">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Kota/Kabupaten</label>
                                <input type="text" name="customer_city" required placeholder="Kota" class="w-full text-sm py-2 px-3 border border-gray-200 rounded-lg focus:border-brand focus:ring focus:ring-brand focus:ring-opacity-20 outline-none transition-all">
                            </div>
                            <div class="col-span-3">
                                <label class="block text-xs font-medium text-gray-600 mb-1">Provinsi</label>
                                <input type="text" name="customer_province" required placeholder="Provinsi" class="w-full text-sm py-2 px-3 border border-gray-200 rounded-lg focus:border-brand focus:ring focus:ring-brand focus:ring-opacity-20 outline-none transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kode Pos</label>
                            <input type="number" name="customer_postal_code" required placeholder="12345" class="w-full text-sm py-2 px-3 border border-gray-200 rounded-lg focus:border-brand focus:ring focus:ring-brand focus:ring-opacity-20 outline-none transition-all">
                        </div>
                    </div>
                </div>
                <!-- Striped Border for Address -->
                <div class="stripe-border w-full absolute bottom-0"></div>
            </div>

            <!-- Detail Produk -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center space-x-2 mb-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <h2 class="font-semibold text-sm">Produk</h2>
                </div>
                
                <div class="flex gap-3">
                    <!-- Placeholder for Product Image, you can replace with actual image if exists -->
                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 border border-gray-200 flex items-center justify-center overflow-hidden">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between">
                                <h3 class="text-sm font-medium leading-tight text-gray-800">{{ $landingPage->headline ?: $landingPage->product->name }}</h3>
                                <span class="text-xs text-gray-500 font-medium ml-2">x1</span>
                            </div>
                            @if(isset($variant) && $variant)
                                <div class="text-xs text-gray-500 mt-1 bg-gray-100 inline-block px-2 py-0.5 rounded">
                                    Varian: {{ collect($variant->optionValues ?? [])->pluck('value')->join(', ') }}
                                </div>
                            @endif
                        </div>
                        <div class="text-brand font-bold text-sm mt-2">
                            Rp {{ number_format(isset($variant) && $variant ? $variant->sell_price : $landingPage->product->sell_price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opsi Pengiriman -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center mb-3 text-brand">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <h2 class="font-semibold text-sm text-gray-800">Opsi Pengiriman</h2>
                </div>
                
                <div class="mb-3">
                    <select name="shipping_courier" id="courier-select" required onchange="loadShippingOptions()" class="w-full text-sm py-2 px-3 border border-gray-200 rounded-lg focus:border-brand focus:ring focus:ring-brand focus:ring-opacity-20 outline-none transition-all appearance-none bg-gray-50">
                        <option value="">Pilih kurir pengiriman...</option>
                    </select>
                </div>
                
                <div id="shipping-options" class="space-y-2" style="display:none">
                    <!-- JS will populate this -->
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="bg-white rounded-xl shadow-sm p-4">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <h2 class="font-semibold text-sm">Metode Pembayaran</h2>
                </div>
                
                <div class="space-y-2">
                    <div class="relative">
                        <input type="checkbox" name="is_cod" value="1" id="cod-checkbox" class="peer sr-only" onchange="updateTotal()">
                        <label for="cod-checkbox" class="flex items-center justify-between w-full p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-brand peer-checked:bg-orange-50/30 transition-all">
                            <div class="flex items-center">
                                <div class="w-5 h-5 rounded border border-gray-300 mr-3 flex items-center justify-center peer-checked:bg-brand peer-checked:border-brand">
                                    <svg class="w-3.5 h-3.5 text-white opacity-0 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-800">COD (Bayar di Tempat)</div>
                                    <div class="text-xs text-gray-500">Bayar langsung ke kurir saat paket tiba</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Rincian Pembayaran -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <h2 class="font-semibold text-sm">Rincian Pembayaran</h2>
                </div>
                
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal untuk Produk</span>
                        <span>Rp {{ number_format(isset($variant) && $variant ? $variant->sell_price : $landingPage->product->sell_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Pengiriman</span>
                        <span id="summary-shipping">Rp 0</span>
                    </div>
                    <div class="border-t border-gray-100 mt-3 pt-3 flex justify-between items-center">
                        <span class="font-medium text-gray-800">Total Pembayaran</span>
                        <span class="font-bold text-lg text-brand" id="summary-total">Rp {{ number_format(isset($variant) && $variant ? $variant->sell_price : $landingPage->product->sell_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Sticky Bottom Bar -->
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-[0_-2px_10px_rgba(0,0,0,0.05)]">
                <div class="max-w-md mx-auto flex items-center justify-between px-4 py-3">
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500 font-medium">Total Pembayaran</span>
                        <span class="text-lg font-bold text-brand" id="bottom-total">Rp {{ number_format(isset($variant) && $variant ? $variant->sell_price : $landingPage->product->sell_price, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="bg-brand text-white font-semibold py-2.5 px-6 rounded-lg text-sm hover:opacity-90 transition-opacity active:scale-95" onclick="trackCheckout()">
                        Buat Pesanan
                    </button>
                </div>
            </div>
            
        </form>
    </div>

    @if($landingPage->pixel_id)
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $landingPage->pixel_id }}&ev=PageView&noscript=1"/></noscript>
    @endif

    <script>
    const productPrice = {{ isset($variant) && $variant ? $variant->sell_price : $landingPage->product->sell_price }};
    const pixelId = '{{ $landingPage->pixel_id }}';
    let selectedShippingCost = 0;
    let selectedCourier = '';

    // Adding dynamic CSS for checkbox custom color based on brand color
    document.head.insertAdjacentHTML("beforeend", `<style>
        input[type="checkbox"]:checked + label .w-5 {
            background-color: var(--brand-color);
            border-color: var(--brand-color);
        }
        input[type="checkbox"]:checked + label .opacity-0 {
            opacity: 1;
        }
    </style>`);

    async function loadCouriers() {
        const select = document.getElementById('courier-select');
        try {
            const res = await fetch('/lp/shipping-options?destination_city=default');
            const data = await res.json();
            data.couriers.forEach(courier => {
                const option = document.createElement('option');
                option.value = courier.code;
                option.textContent = courier.name.toUpperCase();
                select.appendChild(option);
            });
        } catch(e) {
            select.innerHTML = '<option value="">Pilih kurir pengiriman...</option><option value="jne">JNE</option><option value="jnt">J&T Express</option><option value="sicepat">SiCepat</option>';
        }
    }

    function getCourierLogo(code) {
        code = code.toLowerCase();
        // Maps simple code to CDN URLs or generic text 
        // In real world, replace with actual CDN links or assets
        const logos = {
            'jne': 'https://s3-ap-southeast-1.amazonaws.com/biteship-storage/jne.png',
            'jnt': 'https://s3-ap-southeast-1.amazonaws.com/biteship-storage/jnt.png',
            'sicepat': 'https://s3-ap-southeast-1.amazonaws.com/biteship-storage/sicepat.png',
            'ninja': 'https://s3-ap-southeast-1.amazonaws.com/biteship-storage/ninja.png',
            'anteraja': 'https://s3-ap-southeast-1.amazonaws.com/biteship-storage/anteraja.png'
        };
        
        if (logos[code]) {
            return `<img src="${logos[code]}" alt="${code}" class="h-6 object-contain" onerror="this.outerHTML='<span class=\\'font-bold text-gray-700\\'>${code.toUpperCase()}</span>'">`;
        }
        return `<span class="font-bold text-gray-700">${code.toUpperCase()}</span>`;
    }

    async function loadShippingOptions() {
        const courier = document.getElementById('courier-select').value;
        const container = document.getElementById('shipping-options');
        if (!courier) { container.style.display = 'none'; return; }

        container.innerHTML = '<div class="text-center py-4 text-sm text-gray-500">Memuat tarif ongkos kirim...</div>';
        container.style.display = 'block';

        try {
            const res = await fetch('/lp/shipping-options?destination_city=default');
            const data = await res.json();
            const courierData = data.couriers.find(c => c.code === courier);
            if (courierData) {
                container.innerHTML = courierData.services.map((s, i) => `
                    <div class="relative">
                        <input type="radio" name="shipping_service" id="ship-${i}" value="${s.name}" class="custom-radio sr-only" onchange="selectShipping('${courierData.code}', '${s.name}', ${s.cost}, '${s.etd}')">
                        <label for="ship-${i}" class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-8 flex items-center justify-center bg-white rounded border border-gray-100">
                                    ${getCourierLogo(courierData.code)}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-800">${s.name} <span class="font-normal text-gray-500">(${s.description})</span></div>
                                    <div class="text-xs text-gray-500 mt-0.5">Estimasi sampai ${s.etd}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-sm font-bold text-gray-800">Rp ${s.cost.toLocaleString('id-ID')}</div>
                                <div class="w-4 h-4 rounded-full border border-gray-300 radio-indicator transition-all"></div>
                            </div>
                        </label>
                    </div>
                `).join('');
                
                // auto select first
                if (courierData.services.length > 0) {
                    const firstOption = document.getElementById('ship-0');
                    if (firstOption) {
                        firstOption.checked = true;
                        selectShipping(courierData.code, courierData.services[0].name, courierData.services[0].cost, courierData.services[0].etd);
                    }
                }
            }
        } catch(e) {
            container.innerHTML = `
                <div class="relative">
                    <input type="radio" name="shipping_service" id="ship-default" value="REG" class="custom-radio sr-only" onchange="selectShipping('${courier}', 'REG', 9000, '2-3 hari')" checked>
                    <label for="ship-default" class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer transition-all hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-8 flex items-center justify-center bg-white rounded border border-gray-100">
                                ${getCourierLogo(courier)}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-800">Reguler</div>
                                <div class="text-xs text-gray-500 mt-0.5">Estimasi 2-3 hari</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-sm font-bold text-gray-800">Rp 9.000</div>
                            <div class="w-4 h-4 rounded-full border border-gray-300 radio-indicator transition-all"></div>
                        </div>
                    </label>
                </div>
            `;
            selectShipping(courier, 'REG', 9000, '2-3 hari');
        }
    }

    function selectShipping(courierCode, service, cost, etd) {
        selectedShippingCost = cost;
        selectedCourier = courierCode;
        document.querySelector('input[name="shipping_cost"]').value = cost;
        updateTotal();
    }

    function updateTotal() {
        const total = productPrice + selectedShippingCost;
        const totalStr = 'Rp ' + total.toLocaleString('id-ID');
        
        document.getElementById('summary-shipping').textContent = 'Rp ' + selectedShippingCost.toLocaleString('id-ID');
        document.getElementById('summary-total').textContent = totalStr;
        document.getElementById('bottom-total').textContent = totalStr;
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
