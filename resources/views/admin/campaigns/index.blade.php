@extends('layouts.admin')

@section('title', 'Campaigns')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Campaigns</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola campaign iklan & ad spend</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.analytics.campaigns') }}" class="py-2 px-3 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-purple-100 text-purple-700 hover:bg-purple-200">ROAS Dashboard</a>
        <a href="{{ route('admin.campaigns.create') }}" class="py-2 px-3 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">+ Tambah</a>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Source</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Campaign</th>
                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Ad Spend</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($campaigns as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $c->name }}</td>
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $c->utm_source?:'-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $c->utm_campaign?:'-' }}</td>
                    <td class="px-6 py-3 text-sm text-end">Rp {{ number_format($c->ad_spend,0,',','.') }}</td>
                    <td class="px-6 py-3 text-sm text-center">
                        <a href="{{ route('admin.campaigns.edit', $c) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.campaigns.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Hapus campaign?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">Belum ada campaign.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $campaigns->links() }}</div>
@endsection

