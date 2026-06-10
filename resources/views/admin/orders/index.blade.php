@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Daftar Order</h2>
    <div class="flex gap-2">
        <a href="{{ route('admin.orders.supplier-queue') }}" class="px-3 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 text-sm">
            Antrian Supplier
        </a>
        <a href="{{ route('admin.orders.export', request()->query()) }}" class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
            Export CSV
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/order/WA..." class="w-full rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <select name="status" class="w-full rounded-lg border-gray-300 text-sm">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border-gray-300 text-sm">
        </div>
        <div>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border-gray-300 text-sm">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Metode</th>
                <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Bayar</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">LP</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Tanggal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline text-sm font-medium">
                        #{{ $order->order_number }}
                    </a>
                </td>
                <td class="px-6 py-4 text-sm">
                    <div>{{ $order->customer_name }}</div>
                    <div class="text-gray-500 text-xs">{{ $order->customer_phone }}</div>
                </td>
                <td class="px-6 py-4 text-sm">{{ $order->product->name ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                    @if($order->is_cod)
                        <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">COD</span>
                    @else
                        <span class="text-xs text-gray-400">Transfer</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 text-xs rounded-full @if($order->payment_status === 'paid') bg-green-100 text-green-800 @elseif($order->payment_status === 'expired') bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $order->payment_status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($order->order_status === 'pending_payment') bg-yellow-100 text-yellow-800
                        @elseif($order->order_status === 'paid') bg-blue-100 text-blue-800
                        @elseif($order->order_status === 'processing') bg-purple-100 text-purple-800
                        @elseif($order->order_status === 'shipped') bg-indigo-100 text-indigo-800
                        @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->landingPage->slug ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d/m H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="9" class="px-6 py-8 text-center text-gray-500">Tidak ada order.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->links() }}</div>
