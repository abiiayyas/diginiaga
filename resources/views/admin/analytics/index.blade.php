@extends('layouts.admin')

@section('title', 'Analytics LP')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Performa Landing Pages</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Conversion rate & revenue per LP</p>
    </div>
    <form method="GET" class="flex gap-2">
        <input type="date" name="date_from" value="{{ $dateFrom }}" class="py-2 px-3 block border-gray-200 dark:border-slate-700 rounded-lg text-sm">
        <input type="date" name="date_to" value="{{ $dateTo }}" class="py-2 px-3 block border-gray-200 dark:border-slate-700 rounded-lg text-sm">
        <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Filter</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    @php
    $cards = [
        ['label'=>'Kunjungan','value'=>number_format($overallStats['total_visits'],0,',','.'),'color'=>'gray'],
        ['label'=>'Order','value'=>number_format($overallStats['total_orders'],0,',','.'),'color'=>'gray'],
        ['label'=>'Order Sukses','value'=>number_format($overallStats['total_paid_orders'],0,',','.'),'color'=>'teal'],
        ['label'=>'Conv. Rate','value'=>$overallStats['conversion_rate'].'%','color'=>'blue'],
        ['label'=>'Revenue','value'=>'Rp '.number_format($overallStats['total_revenue'],0,',','.'),'color'=>'teal'],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-5">
        <p class="text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">{{ $card['label'] }}</p>
        <p class="mt-2 text-2xl font-bold text-{{$card['color']}}-600">{{ $card['value'] }}</p>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4">Order Harian</h3>
        <canvas id="ordersChart" height="200"></canvas>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-6">
        <h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100 mb-4">Revenue Harian</h3>
        <canvas id="revenueChart" height="200"></canvas>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700"><h3 class="text-sm font-semibold text-gray-900 dark:text-slate-100">Performa per LP</h3></div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-800/50">
                <tr>
                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">LP</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Kunjungan</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Order</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Sukses</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Conv.</th>
                    <th class="px-4 py-3 text-end text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Revenue</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($landingPages as $lp)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 dark:bg-slate-800/50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-slate-100">{{ $lp->headline ?: $lp->product->name }}<div class="text-xs text-gray-400 dark:text-slate-500">/p/{{ $lp->slug }}</div></td>
                    <td class="px-4 py-3 text-sm text-center">{{ number_format($lp->visits,0,',','.') }}</td>
                    <td class="px-4 py-3 text-sm text-center">{{ $lp->total_orders }}</td>
                    <td class="px-4 py-3 text-sm text-center text-teal-600 font-medium">{{ $lp->paid_orders }}</td>
                    <td class="px-4 py-3 text-sm text-center">@php $r=$lp->visits>0?round(($lp->total_orders/$lp->visits)*100,1):0; $rc=$r>=5?'teal':($r>0?'amber':'gray'); @endphp<span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-{{$rc}}-100 text-{{$rc}}-800">{{$r}}%</span></td>
                    <td class="px-4 py-3 text-sm text-end font-medium">Rp {{ number_format($lp->total_revenue??0,0,',','.') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-slate-400">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const d = @json($dailyOrders);
new Chart(document.getElementById('ordersChart'),{type:'bar',data:{labels:d.labels||[],datasets:[{label:'Order',data:d.orders||[],backgroundColor:'#3b82f6'}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}}}}});
new Chart(document.getElementById('revenueChart'),{type:'line',data:{labels:d.labels||[],datasets:[{label:'Revenue',data:@json($dailyRevenue)||[],borderColor:'#10b981',backgroundColor:'rgba(16,185,129,0.1)',fill:true,tension:0.3}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{callback:v=>'Rp '+(v/1000).toFixed(0)+'k'}}}}});
</script>
@endpush
