@extends('layouts.admin')

@section('title', 'Antrian Supplier')

@section('content')
<h2 class="text-xl font-semibold mb-6">Order Perlu Diteruskan ke Supplier</h2>

<p class="text-sm text-gray-500 mb-4">Order dengan status paid yang belum diteruskan ke supplier.</p>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 uppercase">Kurir</th>
                <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline text-sm font-medium">
                        #{{ $order->order_number }}
                    </a>
                    <div class="text-xs text-gray-500">{{ $order->created_at->format('d M H:i') }}</div>
                </td>
                <td class="px-4 py-3 text-sm">
                    <div>{{ $order->product->name ?? '-' }}</div>
                    <div class="text-xs text-gray-500">SKU: {{ $order->product->sku_supplier ?? '-' }}</div>
                </td>
                <td class="px-4 py-3 text-sm">
                    <div>{{ $order->customer_name }}</div>
                    <div class="text-xs text-gray-500">{{ $order->customer_city }}, {{ $order->customer_province }}</div>
                </td>
                <td class="px-4 py-3 text-sm">{{ $order->shipping_courier ?: '-' }}</td>
                <td class="px-4 py-3 text-center">
                    <button onclick="copyData({{ $order->id }})" class="px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700 text-xs mr-1">
                        Salin
                    </button>
                    <form action="{{ route('admin.orders.supplier-ordered', $order) }}" method="POST" class="inline">
                        @csrf @method('PATCH')
                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                            Sudah Diorder
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada order yang perlu diteruskan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->links() }}</div>

@push('scripts')
<script>
async function copyData(orderId) {
    const res = await fetch(`/admin/orders/${orderId}/copy-supplier-data`);
    const json = await res.json();
    await navigator.clipboard.writeText(json.data);
    alert('Data order disalin!');
}
</script>
@endpush
