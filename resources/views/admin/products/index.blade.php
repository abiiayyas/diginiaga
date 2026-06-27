@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Produk</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Kelola produk yang dijual</p>
    </div>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-x-2 py-2 px-4 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">
        + Tambah Produk
    </a>
    @endif
</div>

<div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-800/50">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Produk</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">SKU</th>
                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Harga Jual</th>
                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Modal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">LP</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Status</th>
                    @if(auth()->user()->isAdmin())<th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Aksi</th>@endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 dark:bg-slate-800/50">
                    <td class="px-6 py-3 text-sm font-medium text-gray-900 dark:text-slate-100">{{ $product->name }}</td>
                    <td class="px-6 py-3 text-sm text-gray-500 dark:text-slate-400">{{ $product->sku_supplier ?: '-' }}</td>
                    <td class="px-6 py-3 text-sm text-end">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm text-end text-gray-500 dark:text-slate-400">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-sm text-center">{{ $product->landing_pages_count }}</td>
                    <td class="px-6 py-3 text-sm text-center">
                        <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-teal-100 text-teal-800' : 'bg-red-100 text-red-800' }}">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </td>
                    @if(auth()->user()->isAdmin())
                    <td class="px-6 py-3 text-sm text-center">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-slate-400">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection

