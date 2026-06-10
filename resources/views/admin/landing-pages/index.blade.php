@extends('layouts.admin')

@section('title', 'Landing Pages')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Landing Pages</h2>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.landing-pages.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
        + Buat LP Baru
    </a>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">LP</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Slug</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($landingPages as $lp)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $lp->headline ?: 'Tanpa Judul' }}</div>
                    @if($lp->variant_name)
                        <span class="text-xs text-gray-500">Varian: {{ $lp->variant_name }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm">{{ $lp->product->name ?? '-' }}</td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ url('/p/' . $lp->slug) }}" target="_blank" class="text-blue-600 hover:underline">
                        /p/{{ $lp->slug }}
                    </a>
                </td>
                <td class="px-6 py-4 text-sm text-center">{{ $lp->orders_count }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 text-xs rounded-full {{ $lp->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $lp->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center text-sm">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.landing-pages.edit', $lp) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                    <a href="{{ route('admin.landing-pages.toggle', $lp) }}" class="text-gray-600 hover:underline mr-3">
                        {{ $lp->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </a>
                    @endif
                    <a href="{{ url('/p/' . $lp->slug) }}" target="_blank" class="text-gray-600 hover:underline">Lihat</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada landing page.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $landingPages->links() }}</div>
