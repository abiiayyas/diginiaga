@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="flex flex-wrap justify-between items-start gap-3 mb-6">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline mb-1 inline-block">← Kembali</a>
        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Informasi Order</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Produk:</span> <span class="font-medium text-gray-900">{{ $order->product->name ?? '-' }}</span></div>
                <div><span class="text-gray-500">Qty:</span> <span class="font-medium text-gray-900">{{ $order->qty }}</span></div>
                <div><span class="text-gray-500">Harga:</span> <span class="font-medium text-gray-900">Rp {{ number_format($order->unit_price, 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500">Ongkir:</span> <span class="font-medium text-gray-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500">Total:</span> <span class="font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></div>
                <div><span class="text-gray-500">Metode:</span> @if($order->is_cod) <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-orange-100 text-orange-800">COD</span> @else <span class="font-medium text-gray-900">{{ $order->payment_method ?: '-' }}</span> @endif</div>
                <div><span class="text-gray-500">Kurir:</span> <span class="font-medium text-gray-900">{{ $order->shipping_courier ?: '-' }}</span></div>
                <div><span class="text-gray-500">LP:</span> <a href="{{ url('/p/' . ($order->landingPage->slug ?? '')) }}" target="_blank" class="text-blue-600 hover:underline">{{ $order->landingPage->slug ?? '-' }}</a></div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Customer</h3>
            <div class="grid grid-cols-1 gap-3 text-sm">
                <div><span class="text-gray-500">Nama:</span> <span class="font-medium text-gray-900">{{ $order->customer_name }}</span></div>
                <div><span class="text-gray-500">WA:</span> <span class="font-medium text-gray-900">{{ $order->customer_phone }}</span></div>
                <div><span class="text-gray-500">Alamat:</span> <span class="font-medium text-gray-900">{{ $order->customer_address }}</span></div>
                <div class="grid grid-cols-3 gap-3"><span class="text-gray-500">Kota:</span><span class="font-medium">{{ $order->customer_city }}</span><span class="text-gray-500">Prov:</span><span class="font-medium">{{ $order->customer_province }}</span><span class="text-gray-500">KP:</span><span class="font-medium">{{ $order->customer_postal_code }}</span></div>
            </div>
        </div>

        @if($order->shipment)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Pengiriman</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Kurir:</span> <span class="font-medium">{{ $order->shipment->courier_name }}</span></div>
                <div><span class="text-gray-500">No. Resi:</span> <span class="font-medium text-blue-600">{{ $order->shipment->tracking_number ?: '-' }}</span></div>
                <div><span class="text-gray-500">Status:</span> <span class="font-medium">{{ $order->shipment->status }}</span></div>
                <div><span class="text-gray-500">Dikirim:</span> <span class="font-medium">{{ $order->shipment->shipped_at?->format('d M H:i') ?: '-' }}</span></div>
            </div>
        </div>
        @endif
    </div>

    <div class="space-y-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Status</h3>
            <div class="space-y-2 text-sm">
                <div>
                    @php $oc = ['pending_payment'=>'amber','paid'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'teal','cancelled'=>'red']; $c = $oc[$order->order_status] ?? 'gray'; @endphp
                    <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-{{$c}}-100 text-{{$c}}-800">{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                </div>
            </div>

            <hr class="my-4 border-gray-200">
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <label class="block text-xs text-gray-500 mb-1">Update Status</label>
                <select name="order_status" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm mb-2 focus:border-blue-500 focus:ring-blue-500">
                    <option value="paid" {{ $order->order_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <textarea name="notes" rows="2" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm mb-2" placeholder="Catatan..."></textarea>
                <button type="submit" class="w-full py-2 px-4 inline-flex items-center justify-center gap-x-2 rounded-lg text-sm font-medium bg-gray-800 text-white hover:bg-gray-900">Update</button>
            </form>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Input Resi</h3>
            <form action="{{ route('admin.orders.update-tracking', $order) }}" method="POST">
                @csrf @method('PATCH')
                <label class="block text-xs text-gray-500 mb-1">Kurir</label>
                <input type="text" name="courier_name" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm mb-2" value="{{ $order->shipping_courier }}">
                <label class="block text-xs text-gray-500 mb-1">No. Resi</label>
                <input type="text" name="tracking_number" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm mb-3" placeholder="Masukkan nomor resi...">
                <button type="submit" class="w-full py-2 px-4 inline-flex items-center justify-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Simpan Resi</button>
            </form>
        </div>

        @if(in_array($order->order_status, ['paid', 'processing']))
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Mengantar</h3>
            <form action="{{ route('admin.orders.mengantar', $order) }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 px-4 inline-flex items-center justify-center gap-x-2 rounded-lg text-sm font-medium bg-orange-600 text-white hover:bg-orange-700">Buat Shipment Mengantar</button>
            </form>
        </div>
        @endif

        @if(!$order->supplier_order_status || $order->supplier_order_status === 'pending')
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Supplier</h3>
            <button onclick="copySupplierData()" class="w-full py-2 px-4 inline-flex items-center justify-center gap-x-2 rounded-lg text-sm font-medium bg-purple-600 text-white hover:bg-purple-700 mb-2">Salin Data</button>
            <form action="{{ route('admin.orders.supplier-ordered', $order) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit" class="w-full py-2 px-4 inline-flex items-center justify-center gap-x-2 rounded-lg text-sm font-medium bg-teal-600 text-white hover:bg-teal-700">Tandai Diorder</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection

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
