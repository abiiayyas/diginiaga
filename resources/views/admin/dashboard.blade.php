@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8" id="stats-grid">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Order Hari Ini</div>
        <div class="text-3xl font-bold text-gray-900">{{ $stats['total_orders_today'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Revenue Hari Ini</div>
        <div class="text-3xl font-bold text-green-600">Rp {{ number_format($stats['total_revenue_today'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Menunggu Bayar</div>
        <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending_orders'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Perlu Diproses</div>
        <div class="text-3xl font-bold text-blue-600">{{ $stats['need_processing'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-500">Recovery Rate</div>
        <div class="text-3xl font-bold {{ $stats['recovery_rate'] >= 10 ? 'text-green-600' : 'text-gray-600' }}">{{ $stats['recovery_rate'] }}%</div>
        <div class="text-xs text-gray-400 mt-1">dari WA reminder</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Order (7 Hari Terakhir)</h3>
        <canvas id="ordersChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Revenue (7 Hari Terakhir)</h3>
        <canvas id="revenueChart" height="200"></canvas>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold">Order Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline">
                            #{{ $order->order_number }}
                        </a>
                    </td>
                    <td class="px-6 py-3 text-sm">{{ $order->customer_name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $order->product->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full @if($order->order_status === 'pending_payment') bg-yellow-100 text-yellow-800
                            @elseif($order->order_status === 'paid') bg-blue-100 text-blue-800
                            @elseif($order->order_status === 'processing') bg-purple-100 text-purple-800
                            @elseif($order->order_status === 'shipped') bg-indigo-100 text-indigo-800
                            @elseif($order->order_status === 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $order->created_at->format('d M H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($charts);

    new Chart(document.getElementById('ordersChart'), {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Order',
                data: chartData.orders,
                backgroundColor: '#3b82f6',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Revenue',
                data: chartData.revenue,
                backgroundColor: '#10b981',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k' }
                }
            }
        }
    });

    setInterval(() => {
        fetch('{{ route('admin.dashboard.stats') }}')
            .then(r => r.json())
            .then(data => {
                document.querySelector('#stats-grid').innerHTML = `
                    <div class="bg-white rounded-lg shadow p-6"><div class="text-sm text-gray-500">Order Hari Ini</div><div class="text-3xl font-bold text-gray-900">${data.total_orders_today}</div></div>
                    <div class="bg-white rounded-lg shadow p-6"><div class="text-sm text-gray-500">Revenue Hari Ini</div><div class="text-3xl font-bold text-green-600">Rp ${data.total_revenue_today.toLocaleString('id-ID')}</div></div>
                    <div class="bg-white rounded-lg shadow p-6"><div class="text-sm text-gray-500">Menunggu Pembayaran</div><div class="text-3xl font-bold text-yellow-600">${data.pending_orders}</div></div>
                    <div class="bg-white rounded-lg shadow p-6"><div class="text-sm text-gray-500">Perlu Diproses</div><div class="text-3xl font-bold text-blue-600">${data.need_processing}</div></div>
                `;
            });
    }, 30000);
});
</script>
@endpush
