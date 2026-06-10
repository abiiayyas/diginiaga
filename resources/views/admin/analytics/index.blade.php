@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Analytics Landing Pages</h2>
    <form method="GET" class="flex gap-2">
        <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded-lg border-gray-300 text-sm">
        <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded-lg border-gray-300 text-sm">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Filter</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Total Kunjungan</div>
        <div class="text-2xl font-bold">{{ number_format($overallStats['total_visits'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Total Order</div>
        <div class="text-2xl font-bold">{{ number_format($overallStats['total_orders'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Order Sukses</div>
        <div class="text-2xl font-bold text-green-600">{{ number_format($overallStats['total_paid_orders'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Conversion Rate</div>
        <div class="text-2xl font-bold text-blue-600">{{ $overallStats['conversion_rate'] }}%</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Total Revenue</div>
        <div class="text-2xl font-bold text-green-600">Rp {{ number_format($overallStats['total_revenue'], 0, ',', '.') }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Order Harian</h3>
        <canvas id="ordersChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Revenue Harian</h3>
        <canvas id="revenueChart" height="200"></canvas>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold">Performa per Landing Page</h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Landing Page</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Kunjungan</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Order Sukses</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Conv. Rate</th>
                <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Revenue</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($landingPages as $lp)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="font-medium text-sm">{{ $lp->headline ?: $lp->product->name }}</div>
                    <div class="text-xs text-gray-500">/p/{{ $lp->slug }} @if($lp->variant_name) · {{ $lp->variant_name }} @endif</div>
                </td>
                <td class="px-6 py-4 text-sm text-center">{{ number_format($lp->visits, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-sm text-center">{{ $lp->total_orders }}</td>
                <td class="px-6 py-4 text-sm text-center text-green-600 font-medium">{{ $lp->paid_orders }}</td>
                <td class="px-6 py-4 text-sm text-center">
                    <span class="px-2 py-1 text-xs rounded-full {{ $lp->visits > 0 && ($lp->total_orders / $lp->visits * 100) >= 5 ? 'bg-green-100 text-green-800' : ($lp->visits > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-500') }}">
                        {{ $lp->visits > 0 ? round(($lp->total_orders / $lp->visits) * 100, 1) : 0 }}%
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-right font-medium">Rp {{ number_format($lp->total_revenue ?? 0, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-sm text-center">
                    <a href="{{ route('admin.analytics.lp', $lp) }}" class="text-blue-600 hover:underline text-xs">Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data landing page.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($topLp)
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-sm font-semibold mb-3">🏆 LP Terbanyak Order</h3>
        <div class="text-lg font-bold">{{ $topLp->headline ?: $topLp->product->name }}</div>
        <div class="text-sm text-gray-500">{{ $topLp->total_orders }} order · {{ $topLp->visits }} kunjungan</div>
        <div class="text-xs text-gray-400">Conversion: {{ $topLp->visits > 0 ? round(($topLp->total_orders / $topLp->visits) * 100, 1) : 0 }}%</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-sm font-semibold mb-3">💰 Revenue Tertinggi</h3>
        <div class="text-lg font-bold">{{ $topRevenue->headline ?: $topRevenue->product->name }}</div>
        <div class="text-sm text-gray-500">Rp {{ number_format($topRevenue->total_revenue ?? 0, 0, ',', '.') }}</div>
        <div class="text-xs text-gray-400">{{ $topRevenue->paid_orders }} order sukses</div>
    </div>
</div>
@endif

@push('scripts')
<script>
const dailyOrders = @json($dailyOrders);
const dailyRevenue = @json($dailyRevenue);

new Chart(document.getElementById('ordersChart'), {
    type: 'bar',
    data: {
        labels: dailyOrders.labels || [],
        datasets: [{ label: 'Order', data: dailyOrders.orders || [], backgroundColor: '#3b82f6' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: dailyOrders.labels || [],
        datasets: [{ label: 'Revenue', data: dailyRevenue || [], borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.3 }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k' } } }
    }
});
</script>
@endpush
