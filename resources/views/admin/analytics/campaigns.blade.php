@extends('layouts.admin')

@section('title', 'Campaign ROAS')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Campaign ROAS</h1>
        <p class="text-sm text-gray-500 mt-1">Analisis performa campaign iklan</p>
    </div>
    <form method="GET" class="flex gap-2">
        <input type="date" name="date_from" value="{{ $dateFrom }}" class="py-2 px-3 block border-gray-200 rounded-lg text-sm">
        <input type="date" name="date_to" value="{{ $dateTo }}" class="py-2 px-3 block border-gray-200 rounded-lg text-sm">
        <button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Filter</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    @php
    $r=$totals['roas']>=2?'teal':($totals['roas']>=1?'amber':'red');
    $p=$totals['profit']>=0?'teal':'red';
    @endphp
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Ad Spend</p><p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($totals['ad_spend'],0,',','.') }}</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Revenue</p><p class="mt-2 text-2xl font-bold text-teal-600">Rp {{ number_format($totals['total_revenue'],0,',','.') }}</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">ROAS</p><p class="mt-2 text-2xl font-bold text-{{$r}}-600">{{ $totals['roas'] }}x</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Profit</p><p class="mt-2 text-2xl font-bold text-{{$p}}-600">Rp {{ number_format($totals['profit'],0,',','.') }}</p></div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5"><p class="text-xs font-medium text-gray-500 uppercase">Order</p><p class="mt-2 text-2xl font-bold text-gray-900">{{ $totals['paid_orders'] }}</p></div>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200"><h3 class="text-sm font-semibold text-gray-900">Performa per Campaign</h3></div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Campaign</th>
                    <th class="px-4 py-3 text-end text-xs font-medium text-gray-500 uppercase">Ad Spend</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Sukses</th>
                    <th class="px-4 py-3 text-end text-xs font-medium text-gray-500 uppercase">Revenue</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">ROAS</th>
                    <th class="px-4 py-3 text-end text-xs font-medium text-gray-500 uppercase">Profit</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($data as $row)
                @php $ro=$row['roas']>=2?'teal':($row['roas']>=1?'amber':'red'); $pr=$row['profit']>=0?'teal':'red'; @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $row['campaign']->name }}<div class="text-xs text-gray-400">{{ $row['campaign']->utm_source?:'-' }} / {{ $row['campaign']->utm_campaign?:'-' }}</div></td>
                    <td class="px-4 py-3 text-sm text-end">Rp {{ number_format($row['ad_spend'],0,',','.') }}</td>
                    <td class="px-4 py-3 text-sm text-center">{{ $row['total_orders'] }}</td>
                    <td class="px-4 py-3 text-sm text-center">{{ $row['paid_orders'] }}</td>
                    <td class="px-4 py-3 text-sm text-end">Rp {{ number_format($row['total_revenue'],0,',','.') }}</td>
                    <td class="px-4 py-3 text-sm text-center"><span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-{{$ro}}-100 text-{{$ro}}-800">{{ $row['roas'] }}x</span></td>
                    <td class="px-4 py-3 text-sm text-end font-medium text-{{$pr}}-600">Rp {{ number_format($row['profit'],0,',','.') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">Belum ada campaign. <a href="{{ route('admin.campaigns.index') }}" class="text-blue-600 hover:underline">Tambah campaign</a> dulu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

