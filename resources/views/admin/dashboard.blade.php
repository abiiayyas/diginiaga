@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Dashboard</h1>
    <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Ringkasan order hari ini</p>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8" id="stats-grid">
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-16 h-16 bg-brand-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Order Hari Ini</p>
            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-slate-100">{{ $stats['total_orders_today'] }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-16 h-16 bg-teal-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Revenue Hari Ini</p>
            <p class="mt-2 text-2xl font-bold text-teal-600">Rp {{ number_format($stats['total_revenue_today'], 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-16 h-16 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Menunggu Bayar</p>
            <p class="mt-2 text-2xl font-bold text-amber-600">{{ $stats['pending_orders'] }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-16 h-16 bg-brand-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Perlu Diproses</p>
            <p class="mt-2 text-2xl font-bold text-brand-600">{{ $stats['need_processing'] }}</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-16 h-16 bg-teal-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Recovery Rate</p>
            <p class="mt-2 text-2xl font-bold {{ $stats['recovery_rate'] >= 10 ? 'text-teal-600' : 'text-gray-600 dark:text-slate-400' }}">{{ $stats['recovery_rate'] }}%</p>
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">dari WA reminder</p>
        </div>
    </div>
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 w-16 h-16 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Konversi (All)</p>
            <p class="mt-2 text-2xl font-bold text-blue-600">{{ $stats['conversion_rate'] }}%</p>
            <p class="text-xs text-gray-400 dark:text-slate-500 mt-0.5">dari {{ number_format($stats['total_visits'] ?? 0, 0, ',', '.') }} visit</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4">Order (7 Hari Terakhir)</h3>
        <canvas id="ordersChart" height="200"></canvas>
    </div>
    <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4">Revenue (7 Hari Terakhir)</h3>
        <canvas id="revenueChart" height="200"></canvas>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft overflow-hidden">
    <div class="px-6 py-4 border-b border-surface-100 bg-white dark:bg-slate-900">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Order Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-surface-50 border-b border-surface-100">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Order</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Customer</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Produk</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Total</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-brand-50/50 transition-colors duration-200">
                    <td class="px-6 py-3 text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline font-medium">
                            #{{ $order->order_number }}
                        </a>
                    </td>
                    <td class="px-6 py-3 text-sm text-gray-700 dark:text-slate-300">{{ $order->customer_name }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700 dark:text-slate-300">{{ $order->product->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-900 dark:text-slate-100 font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm">
                        @php $colors = ['pending_payment'=>'amber','paid'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'teal','cancelled'=>'red']; $c = $colors[$order->order_status] ?? 'gray'; @endphp
                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-{{$c}}-100 text-{{$c}}-800">
                            {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-slate-400">Belum ada order.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const chartData = @json($charts);
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#94a3b8';
new Chart(document.getElementById('ordersChart'), { type: 'bar', data: { labels: chartData.labels, datasets: [{ label: 'Order', data: chartData.orders, backgroundColor: '#3b82f6', borderRadius: 4 }] }, options: { responsive: true, plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', padding: 12, cornerRadius: 8 } }, scales: { x: { grid: { display: false } }, y: { beginAtZero: true, border: { dash: [4, 4] }, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } } } } });
new Chart(document.getElementById('revenueChart'), { type: 'line', data: { labels: chartData.labels, datasets: [{ label: 'Revenue', data: chartData.revenue, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4, pointBackgroundColor: '#fff', pointBorderColor: '#10b981', pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6 }] }, options: { responsive: true, plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1e293b', padding: 12, cornerRadius: 8 } }, scales: { x: { grid: { display: false } }, y: { beginAtZero: true, border: { dash: [4, 4] }, grid: { color: '#f1f5f9' }, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k' } } } } });

setInterval(() => { fetch('{{ route('admin.dashboard.stats') }}').then(r => r.json()).then(data => {
    document.getElementById('stats-grid').innerHTML = `
        <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group"><div class="absolute -right-4 -top-4 w-16 h-16 bg-brand-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div><div class="relative z-10"><p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Order Hari Ini</p><p class="mt-2 text-2xl font-bold text-gray-900 dark:text-slate-100">${data.total_orders_today}</p></div></div>
        <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group"><div class="absolute -right-4 -top-4 w-16 h-16 bg-teal-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div><div class="relative z-10"><p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Revenue Hari Ini</p><p class="mt-2 text-2xl font-bold text-teal-600">Rp ${data.total_revenue_today.toLocaleString('id-ID')}</p></div></div>
        <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group"><div class="absolute -right-4 -top-4 w-16 h-16 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div><div class="relative z-10"><p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Menunggu Bayar</p><p class="mt-2 text-2xl font-bold text-amber-600">${data.pending_orders}</p></div></div>
        <div class="bg-white dark:bg-slate-900 border-none rounded-2xl shadow-soft p-5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group"><div class="absolute -right-4 -top-4 w-16 h-16 bg-brand-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out"></div><div class="relative z-10"><p class="text-xs font-semibold text-surface-400 uppercase tracking-wider">Perlu Diproses</p><p class="mt-2 text-2xl font-bold text-brand-600">${data.need_processing}</p></div></div>
    `;
}); }, 30000);
</script>
@endpush
