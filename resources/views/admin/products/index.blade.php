@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">Daftar Produk</h2>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
        + Tambah Produk
    </a>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">SKU Supplier</th>
                <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Harga Jual</th>
                <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase">Harga Modal</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">LP</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Order</th>
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                @if(auth()->user()->isAdmin())
                <th class="text-center px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                    <div class="text-sm text-gray-500">{{ Str::limit($product->description, 60) }}</div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $product->sku_supplier ?: '-' }}</td>
                <td class="px-6 py-4 text-sm text-right">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-sm text-right text-gray-500">Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-sm text-center">{{ $product->landing_pages_count }}</td>
                <td class="px-6 py-4 text-sm text-center">{{ $product->orders_count }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2 py-1 text-xs rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                @if(auth()->user()->isAdmin())
                <td class="px-6 py-4 text-center text-sm">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada produk.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
