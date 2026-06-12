@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola semua order masuk</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.orders.supplier-queue') }}" class="inline-flex items-center gap-x-2 py-2 px-3 rounded-lg text-sm font-medium bg-purple-100 text-purple-700 hover:bg-purple-200">
            Antrian Supplier
        </a>
        <a href="{{ route('admin.orders.export', request()->query()) }}" class="inline-flex items-center gap-x-2 py-2 px-3 rounded-lg text-sm font-medium bg-teal-600 text-white hover:bg-teal-700 shadow-md shadow-teal-500/20 transition-all duration-200 hover:-translate-y-0.5">
            Export CSV
        </a>
    </div>
</div>

<div class="bg-white border-none rounded-2xl shadow-soft p-5 mb-6">
    <form method="GET" class="grid grid-cols-2 md:grid-cols-6 gap-3 items-end">
        <div>
            <label class="block text-xs text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama/order/WA..." class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Status</label>
            <select name="status" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Semua</option>
                @foreach($statuses as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Dari</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Sampai</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="flex gap-2">
            <button class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-brand-600 text-white hover:bg-brand-700 shadow-md shadow-brand-500/20 transition-all duration-200 hover:-translate-y-0.5">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-surface-100 text-gray-700 hover:bg-surface-200 transition-colors">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white border-none rounded-2xl shadow-soft overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-surface-50 border-b border-surface-100">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Metode</th>
                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bayar</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-brand-50/50 transition-colors duration-200">
                    <td class="px-6 py-3 text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-brand-600 hover:text-brand-700 hover:underline font-medium transition-colors">#{{ $order->order_number }}</a>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-700">
                        <div>{{ $order->customer_name }}</div>
                        <div class="text-xs text-gray-400">{{ $order->customer_phone }}</div>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $order->product->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-center">
                        @if($order->is_cod)
                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-orange-100 text-orange-800">COD</span>
                        @else
                        <span class="text-xs text-gray-400">Transfer</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm text-end font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm text-center">
                        @php $pc = $order->payment_status === 'paid' ? 'teal' : ($order->payment_status === 'expired' ? 'red' : 'amber'); @endphp
                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-{{$pc}}-100 text-{{$pc}}-800">{{ $order->payment_status }}</span>
                    </td>
                    <td class="px-6 py-3 text-sm text-center">
                        @php $oc = ['pending_payment'=>'amber','paid'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'teal','cancelled'=>'red']; $c = $oc[$order->order_status] ?? 'gray'; @endphp
                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-{{$c}}-100 text-{{$c}}-800">{{ ucfirst(str_replace('_', ' ', $order->order_status)) }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">Tidak ada order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection

