@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Produk</h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
        @csrf @method('PUT')
        <div class="mb-4"><label class="block text-sm font-medium mb-2">Nama</label><input type="text" name="name" value="{{ old('name',$product->name) }}" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">SKU Supplier</label><input type="text" name="sku_supplier" value="{{ old('sku_supplier',$product->sku_supplier) }}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">Deskripsi</label><textarea name="description" rows="3" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description',$product->description) }}</textarea></div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-sm font-medium mb-2">Harga Jual (Rp)</label><input type="number" name="sell_price" value="{{ old('sell_price',$product->sell_price) }}" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
            <div><label class="block text-sm font-medium mb-2">Harga Modal (Rp)</label><input type="number" name="cost_price" value="{{ old('cost_price',$product->cost_price) }}" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        </div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">Foto</label><input type="file" name="images[]" multiple accept="image/*" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="flex items-center gap-x-2"><input type="checkbox" name="is_active" value="1" {{ $product->is_active?'checked':'' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"><span class="text-sm">Aktif</span></label></div>
        <div class="flex gap-3"><button class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Update</button><a href="{{ route('admin.products.index') }}" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Batal</a></div>
    </form>
</div>
@endsection

