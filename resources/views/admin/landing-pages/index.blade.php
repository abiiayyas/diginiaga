@extends('layouts.admin')

@section('title', 'Landing Pages')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Landing Pages</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola landing page per produk</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.landing-pages.create') }}" class="inline-flex items-center gap-x-2 py-2 px-4 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">+ Buat LP Baru</a>
    @endif
</div>

<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">LP</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Produk</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($landingPages as $lp)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm font-medium text-gray-900">{{ $lp->headline ?: 'Tanpa Judul' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-500">{{ $lp->product->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm">
                        <a href="{{ url('/p/' . $lp->slug) }}" target="_blank" class="text-blue-600 hover:underline">/p/{{ $lp->slug }}</a>
                    </td>
                    <td class="px-6 py-3 text-sm text-center">{{ $lp->orders_count }}</td>
                    <td class="px-6 py-3 text-sm text-center">
                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium {{ $lp->is_active ? 'bg-teal-100 text-teal-800' : 'bg-red-100 text-red-800' }}">{{ $lp->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </td>
                    <td class="px-6 py-3 text-sm text-center">
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.landing-pages.edit', $lp) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                        <a href="{{ route('admin.landing-pages.toggle', $lp) }}" class="text-gray-600 hover:underline mr-2">{{ $lp->is_active ? 'Off' : 'On' }}</a>
                        <form action="{{ route('admin.landing-pages.destroy', $lp) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Landing Page ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline mr-2">Hapus</button>
                        </form>
                        @endif
                        <a href="{{ url('/p/' . $lp->slug) }}" target="_blank" class="text-gray-600 hover:underline">Lihat</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">Belum ada landing page.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $landingPages->links() }}</div>
@endsection

