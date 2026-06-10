@extends('layouts.admin')

@section('title', 'Tambah Campaign')

@section('content')
<div class="max-w-lg">
    <h2 class="text-xl font-semibold mb-6">Tambah Campaign</h2>
    <form action="{{ route('admin.campaigns.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Campaign</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 shadow-sm" placeholder="Contoh: Iklan Lebaran 2025">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">UTM Source</label>
            <input type="text" name="utm_source" value="{{ old('utm_source') }}" class="w-full rounded-lg border-gray-300 shadow-sm" placeholder="facebook, instagram, tiktok">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">UTM Medium</label>
            <input type="text" name="utm_medium" value="{{ old('utm_medium') }}" class="w-full rounded-lg border-gray-300 shadow-sm" placeholder="cpc, banner, video">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">UTM Campaign</label>
            <input type="text" name="utm_campaign" value="{{ old('utm_campaign') }}" class="w-full rounded-lg border-gray-300 shadow-sm" placeholder="lebaran2025, flashsale">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Total Ad Spend (Rp)</label>
            <input type="number" name="ad_spend" value="{{ old('ad_spend', 0) }}" class="w-full rounded-lg border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('admin.campaigns.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
