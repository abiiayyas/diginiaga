@extends('layouts.admin')

@section('title', 'Analytics: ' . ($landingPage->headline ?: $landingPage->product->name))

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('admin.analytics.index') }}" class="text-blue-600 hover:underline text-sm">← Kembali ke Analytics</a>
        <h2 class="text-xl font-semibold mt-1">{{ $landingPage->headline ?: $landingPage->product->name }}</h2>
        <p class="text-sm text-gray-500">/p/{{ $landingPage->slug }} @if($landingPage->variant_name) · Varian: {{ $landingPage->variant_name }} @endif</p>
    </div>
    <form method="GET" class="flex gap-2">
        <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded-lg border-gray-300 text-sm">
        <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded-lg border-gray-300 text-sm">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Filter</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Kunjungan</div>
        <div class="text-2xl font-bold">{{ number_format($stats['visits'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Order</div>
        <div class="text-2xl font-bold">{{ $stats['total_orders'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Conv. Rate</div>
        <div class="text-2xl font-bold {{ $stats['conversion_rate'] >= 5 ? 'text-green-600' : 'text-yellow-600' }}">
            {{ $stats['conversion_rate'] }}%
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Revenue</div>
        <div class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Rata2 Order</div>
        <div class="text-2xl font-bold">Rp {{ number_format($stats['avg_order_value'], 0, ',', '.') }}</div>
    </div>
</div>

<div class="grid grid-cols-1 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Order Harian</h3>
        <canvas id="lpOrdersChart" height="200"></canvas>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Daftar Order ({{ $dateFrom }} - {{ $dateTo }})</h3>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">#{{ $order->order_number }}</a>
                    </td>
                    <td class="px-6 py-3 text-sm">{{ $order->customer_name }}</td>
                    <td class="px-6 py-3 text-sm text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-center">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($order->payment_status === 'paid') bg-green-100 text-green-800
                            @elseif($order->payment_status === 'expired') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $order->payment_status }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $order->created_at->format('d M H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada order dalam periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
const dailyOrders = @json($dailyOrders);

new Chart(document.getElementById('lpOrdersChart'), {
    type: 'bar',
    data: {
        labels: dailyOrders.labels || [],
        datasets: [{ label: 'Order', data: dailyOrders.orders || [], backgroundColor: '#3b82f6' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});
</script>
@endpush
