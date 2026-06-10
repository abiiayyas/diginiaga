@extends('layouts.admin')

@section('title', 'Campaign ROAS')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Campaign ROAS Dashboard</h2>
    <form method="GET" class="flex gap-2">
        <input type="date" name="date_from" value="{{ $dateFrom }}" class="rounded-lg border-gray-300 text-sm">
        <input type="date" name="date_to" value="{{ $dateTo }}" class="rounded-lg border-gray-300 text-sm">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Filter</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Total Ad Spend</div>
        <div class="text-2xl font-bold">Rp {{ number_format($totals['ad_spend'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Revenue</div>
        <div class="text-2xl font-bold text-green-600">Rp {{ number_format($totals['total_revenue'], 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">ROAS</div>
        <div class="text-2xl font-bold {{ $totals['roas'] >= 2 ? 'text-green-600' : 'text-yellow-600' }}">
            {{ $totals['roas'] }}x
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Profit</div>
        <div class="text-2xl font-bold {{ $totals['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
            Rp {{ number_format($totals['profit'], 0, ',', '.') }}
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-5">
        <div class="text-xs text-gray-500 uppercase">Order Sukses</div>
        <div class="text-2xl font-bold">{{ $totals['paid_orders'] }}</div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold">Performa per Campaign</h3>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 uppercase">Campaign</th>
                <th class="text-left px-4 py-3 text-xs font-medium text-gray-500 uppercase">UTM</th>
                <th class="text-right px-4 py-3 text-xs font-medium text-gray-500 uppercase">Ad Spend</th>
                <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase">Sukses</th>
                <th class="text-right px-4 py-3 text-xs font-medium text-gray-500 uppercase">Revenue</th>
                <th class="text-center px-4 py-3 text-xs font-medium text-gray-500 uppercase">ROAS</th>
                <th class="text-right px-4 py-3 text-xs font-medium text-gray-500 uppercase">Profit</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($data as $row)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-4 text-sm font-medium">{{ $row['campaign']->name }}</td>
                <td class="px-4 py-4 text-xs text-gray-500">
                    {{ $row['campaign']->utm_source ?: '-' }} / {{ $row['campaign']->utm_campaign ?: '-' }}
                </td>
                <td class="px-4 py-4 text-sm text-right">Rp {{ number_format($row['ad_spend'], 0, ',', '.') }}</td>
                <td class="px-4 py-4 text-sm text-center">{{ $row['total_orders'] }}</td>
                <td class="px-4 py-4 text-sm text-center">{{ $row['paid_orders'] }}</td>
                <td class="px-4 py-4 text-sm text-right">Rp {{ number_format($row['total_revenue'], 0, ',', '.') }}</td>
                <td class="px-4 py-4 text-sm text-center">
                    <span class="px-2 py-1 text-xs rounded-full {{ $row['roas'] >= 2 ? 'bg-green-100 text-green-800' : ($row['roas'] >= 1 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $row['roas'] }}x
                    </span>
                </td>
                <td class="px-4 py-4 text-sm text-right {{ $row['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    Rp {{ number_format($row['profit'], 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada campaign. Tambah campaign dulu di menu Campaigns.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    <a href="{{ route('admin.campaigns.index') }}" class="text-blue-600 hover:underline text-sm">Kelola Campaign →</a>
</div>
