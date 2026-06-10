@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-xl font-semibold">Order #{{ $order->order_number }}</h2>
        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">← Kembali ke daftar</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Informasi Order</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Produk:</span> <span class="font-medium">{{ $order->product->name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Qty:</span> <span class="font-medium">{{ $order->qty }}</span></div>
                <div><span class="text-gray-500">Harga Satuan:</span> <span class="font-medium">Rp {{ number_format($order->unit_price, 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500">Ongkir:</span> <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500">Total:</span> <span class="font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500">Metode Bayar:</span>
                    @if($order->is_cod)
                        <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800 font-medium">COD</span>
                    @else
                        <span class="font-medium">{{ $order->payment_method ?: '-' }}</span>
                    @endif
                </div>
                <div><span class="text-gray-500">Kurir:</span> <span class="font-medium">{{ $order->shipping_courier ?: '-' }}</span></div>
                <div><span class="text-gray-500">LP:</span> <a href="{{ url('/p/' . $order->landingPage->slug) }}" target="_blank" class="text-blue-600 hover:underline">{{ $order->landingPage->slug ?? '-' }}</a></div>
            </div>

            @if($order->utm_source)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <h4 class="text-sm font-medium mb-2">UTM Tracking</h4>
                <div class="grid grid-cols-2 gap-2 text-xs text-gray-500">
                    <div>Source: {{ $order->utm_source ?: '-' }}</div>
                    <div>Medium: {{ $order->utm_medium ?: '-' }}</div>
                    <div>Campaign: {{ $order->utm_campaign ?: '-' }}</div>
                    <div>Content: {{ $order->utm_content ?: '-' }}</div>
                </div>
            </div>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Informasi Customer</h3>
            <div class="grid grid-cols-1 gap-3 text-sm">
                <div><span class="text-gray-500">Nama:</span> <span class="font-medium">{{ $order->customer_name }}</span></div>
                <div><span class="text-gray-500">WhatsApp:</span> <span class="font-medium">{{ $order->customer_phone }}</span></div>
                <div><span class="text-gray-500">Alamat:</span> <span class="font-medium">{{ $order->customer_address }}</span></div>
                <div><span class="text-gray-500">Kota:</span> <span class="font-medium">{{ $order->customer_city }}</span></div>
                <div><span class="text-gray-500">Provinsi:</span> <span class="font-medium">{{ $order->customer_province }}</span></div>
                <div><span class="text-gray-500">Kode Pos:</span> <span class="font-medium">{{ $order->customer_postal_code }}</span></div>
            </div>
        </div>

        @if($order->shipment)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Pengiriman</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Kurir:</span> <span class="font-medium">{{ $order->shipment->courier_name }}</span></div>
                <div><span class="text-gray-500">No. Resi:</span> <span class="font-medium text-blue-600">{{ $order->shipment->tracking_number ?: 'Belum ada' }}</span></div>
                <div><span class="text-gray-500">Status:</span> <span class="font-medium">{{ $order->shipment->status }}</span></div>
                <div><span class="text-gray-500">Dikirim:</span> <span class="font-medium">{{ $order->shipment->shipped_at?->format('d M Y H:i') ?: '-' }}</span></div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Catatan</h3>
            <p class="text-sm text-gray-600">{{ $order->notes ?: 'Tidak ada catatan.' }}</p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Status</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-500">Status Order:</span>
                    <span class="px-2 py-1 ml-2 text-xs rounded-full
                        @if($order->order_status === 'pending_payment') bg-yellow-100 text-yellow-800
                        @elseif($order->order_status === 'paid') bg-blue-100 text-blue-800
                        @elseif($order->order_status === 'processing') bg-purple-100 text-purple-800
                        @elseif($order->order_status === 'shipped') bg-indigo-100 text-indigo-800
                        @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-500">Status Bayar:</span>
                    <span class="px-2 py-1 ml-2 text-xs rounded-full
                        @if($order->payment_status === 'paid') bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $order->payment_status }}
                    </span>
                </div>
                @if($order->supplier_order_status)
                <div>
                    <span class="text-sm text-gray-500">Supplier:</span>
                    <span class="px-2 py-1 ml-2 text-xs rounded-full bg-gray-100 text-gray-800">{{ $order->supplier_order_status }}</span>
                </div>
                @endif
            </div>

            <div class="mt-6 space-y-2">
                <h4 class="text-sm font-medium">Update Status</h4>
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf @method('PATCH')
                    <select name="order_status" class="w-full rounded-lg border-gray-300 text-sm mb-2">
                        <option value="paid" {{ $order->order_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 text-sm mb-2" placeholder="Catatan opsional..."></textarea>
                    <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 text-sm">Update Status</button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Input Resi</h3>
            <form action="{{ route('admin.orders.update-tracking', $order) }}" method="POST">
                @csrf @method('PATCH')
                <div class="mb-2">
                    <label class="block text-xs text-gray-500 mb-1">Kurir</label>
                    <input type="text" name="courier_name" required class="w-full rounded-lg border-gray-300 text-sm" value="{{ $order->shipping_courier }}">
                </div>
                <div class="mb-3">
                    <label class="block text-xs text-gray-500 mb-1">Nomor Resi</label>
                    <input type="text" name="tracking_number" required class="w-full rounded-lg border-gray-300 text-sm" placeholder="Masukkan nomor resi...">
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Input Resi & Update Status</button>
            </form>
        </div>

        @if(in_array($order->order_status, ['paid', 'processing']))
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Biteship</h3>
            <p class="text-xs text-gray-500 mb-3">Buat shipment otomatis via Biteship untuk generate resi.</p>
            <form action="{{ route('admin.orders.biteship', $order) }}" method="POST">
                @csrf
                <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 text-sm">
                    Buat Shipment di Biteship
                </button>
            </form>
        </div>
        @endif

        @if(!$order->supplier_order_status || $order->supplier_order_status === 'pending')
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Supplier</h3>
            <button onclick="copySupplierData()" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm mb-2">
                Salin Data Order
            </button>
            <form action="{{ route('admin.orders.supplier-ordered', $order) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                    Tandai Sudah Diorder
                </button>
            </form>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
async function copySupplierData() {
    const res = await fetch('{{ route('admin.orders.copy-supplier-data', $order) }}');
    const json = await res.json();
    await navigator.clipboard.writeText(json.data);
    alert('Data order disalin ke clipboard!');
}
</script>
@endpush
