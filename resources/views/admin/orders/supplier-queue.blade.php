@extends('layouts.admin')

@section('title', 'Antrian Supplier')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Antrian Supplier</h1>
    <p class="text-sm text-gray-500 mt-1">Order paid yang belum diteruskan ke supplier</p>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Kurir</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline font-medium">#{{ $order->order_number }}</a>
                        <div class="text-xs text-gray-400">{{ $order->created_at->format('d M H:i') }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $order->product->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $order->customer_name }}<div class="text-xs text-gray-400">{{ $order->customer_city }}</div></td>
                    <td class="px-4 py-3 text-sm text-gray-700">{{ $order->shipping_courier ?: '-' }}</td>
                    <td class="px-4 py-3 text-sm text-center">
                        <button onclick="copyData({{ $order->id }})" class="py-1.5 px-3 inline-flex items-center gap-x-1 rounded-lg text-xs font-medium bg-purple-100 text-purple-700 hover:bg-purple-200 mr-1">Salin</button>
                        <form action="{{ route('admin.orders.supplier-ordered', $order) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button class="py-1.5 px-3 inline-flex items-center gap-x-1 rounded-lg text-xs font-medium bg-teal-100 text-teal-700 hover:bg-teal-200">Diorder</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">Tidak ada order yang perlu diteruskan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection

@push('scripts')
<script>async function copyData(id){const r=await fetch('/admin/orders/'+id+'/copy-supplier-data');const j=await r.json();await navigator.clipboard.writeText(j.data);alert('Data disalin!');}</script>
@endpush
