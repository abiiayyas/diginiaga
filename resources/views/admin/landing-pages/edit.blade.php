@extends('layouts.admin')

@section('title', 'Edit Landing Page')

@section('content')
<div class="max-w-2xl">
    <h2 class="text-xl font-semibold mb-6">Edit Landing Page</h2>
    <form action="{{ route('admin.landing-pages.update', $landingPage) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
            <select name="product_id" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id', $landingPage->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <div class="flex items-center">
                <span class="text-gray-500 mr-1">{{ config('app.url') }}/p/</span>
                <input type="text" name="slug" value="{{ old('slug', $landingPage->slug) }}" required class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Headline</label>
            <input type="text" name="headline" value="{{ old('headline', $landingPage->headline) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Subheadline</label>
            <input type="text" name="subheadline" value="{{ old('subheadline', $landingPage->subheadline) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Body Content</label>
            <textarea name="body_content" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('body_content', $landingPage->body_content) }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teks CTA</label>
                <input type="text" name="cta_text" value="{{ old('cta_text', $landingPage->cta_text) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Warna CTA</label>
                <input type="color" name="cta_color" value="{{ old('cta_color', $landingPage->cta_color) }}" class="w-full h-10 rounded-lg border-gray-300 shadow-sm">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Pixel ID</label>
            <input type="text" name="pixel_id" value="{{ old('pixel_id', $landingPage->pixel_id) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Domain</label>
            <input type="text" name="domain" value="{{ old('domain', $landingPage->domain) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Varian</label>
            <input type="text" name="variant_name" value="{{ old('variant_name', $landingPage->variant_name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div class="mb-4">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ $landingPage->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Aktif</span>
            </label>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.landing-pages.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
