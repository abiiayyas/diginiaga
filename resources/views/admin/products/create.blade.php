@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-xl font-semibold mb-6">Tambah Produk</h2>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">SKU Supplier</label>
            <input type="text" name="sku_supplier" value="{{ old('sku_supplier') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp)</label>
                <input type="number" name="sell_price" value="{{ old('sell_price') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('sell_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal (Rp)</label>
                <input type="number" name="cost_price" value="{{ old('cost_price') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('cost_price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
            <input type="file" name="images[]" multiple accept="image/*" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Aktif</span>
            </label>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
