@extends('layouts.admin')

@section('title', 'Detail LP: ' . ($landingPage->headline ?: $landingPage->product->name))

@section('content')
<div class="flex flex-wrap justify-between items-start gap-3 mb-6">
    <div>
        <a href="{{ route('admin.analytics.index') }}" class="text-sm text-blue-600 hover:underline">← Analytics</a>
        <h1 class="text-2xl font-bold text-gray-900">{{ $landingPage->headline ?: $landingPage->product->name }}</h1>
        <p class="text-sm text-gray-500">/p/{{ $landingPage->slug }}</p>
    </div>
    <form method="GET" class="flex gap-2">
        <input type="date" name="date_from" value="{{ $dateFrom }}" class="py-2 px-3 block border-gray-200 rounded-lg text-sm">
        <input type="date" name="date_to" value="{{ $dateTo }}" class="py-2 px-3 block border-gray-200 rounded-lg text-sm">
        <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Filter</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Kunjungan</p><p class="mt-2 text-2xl font-bold text-gray-900">{{ number_format($stats['visits'],0,',','.') }}</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Order</p><p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Conv. Rate</p><p class="mt-2 text-2xl font-bold text-{{$stats['conversion_rate']>=5?'teal':'amber'}}-600">{{$stats['conversion_rate']}}%</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Revenue</p><p class="mt-2 text-2xl font-bold text-teal-600">Rp {{ number_format($stats['total_revenue'],0,',','.') }}</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Rata2 Order</p><p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($stats['avg_order_value'],0,',','.') }}</p></div>
</div>

<div class="grid grid-cols-1 gap-6">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6"><h3 class="text-sm font-semibold text-gray-900 mb-4">Order Harian</h3><canvas id="lpChart" height="200"></canvas></div>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200"><h3 class="text-sm font-semibold text-gray-900">Daftar Order</h3></div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50"><tr><th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Order</th><th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Customer</th><th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Total</th><th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th></tr></thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $o)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 text-sm"><a href="{{route('admin.orders.show',$o)}}" class="text-blue-600 hover:underline font-medium">#{{$o->order_number}}</a></td>
                        <td class="px-6 py-3 text-sm text-gray-700">{{$o->customer_name}}</td>
                        <td class="px-6 py-3 text-sm text-end">Rp {{number_format($o->total_amount,0,',','.')}}</td>
                        <td class="px-6 py-3 text-sm text-center">@php $pc=$o->payment_status==='paid'?'teal':($o->payment_status==='expired'?'red':'amber'); @endphp<span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-{{$pc}}-100 text-{{$pc}}-800">{{$o->payment_status}}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">Tidak ada order.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const d=@json($dailyOrders);
new Chart(document.getElementById('lpChart'),{type:'bar',data:{labels:d.labels||[],datasets:[{label:'Order',data:d.orders||[],backgroundColor:'#3b82f6'}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}}}}});
</script>
@endpush
