@extends('layouts.admin')

@section('title', 'Campaigns')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Daftar Campaign</h2>
    <div class="flex gap-2">
        <a href="{{ route('admin.analytics.campaigns') }}" class="px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm">ROAS Dashboard</a>
        <a href="{{ route('admin.campaigns.create') }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">+ Tambah</a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">UTM Source</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">UTM Campaign</th>
                <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Ad Spend</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($campaigns as $campaign)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-sm font-medium">{{ $campaign->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $campaign->utm_source ?: '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $campaign->utm_campaign ?: '-' }}</td>
                <td class="px-6 py-4 text-sm text-right">Rp {{ number_format($campaign->ad_spend, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-center text-sm">
                    <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" class="inline" onsubmit="return confirm('Hapus campaign ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada campaign.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $campaigns->links() }}</div>
