@extends('layouts.admin')

@section('title', 'Edit Campaign')

@section('content')
<div class="max-w-lg">
    <h2 class="text-xl font-semibold mb-6">Edit Campaign</h2>
    <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Campaign</label>
            <input type="text" name="name" value="{{ old('name', $campaign->name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">UTM Source</label>
            <input type="text" name="utm_source" value="{{ old('utm_source', $campaign->utm_source) }}" class="w-full rounded-lg border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">UTM Medium</label>
            <input type="text" name="utm_medium" value="{{ old('utm_medium', $campaign->utm_medium) }}" class="w-full rounded-lg border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">UTM Campaign</label>
            <input type="text" name="utm_campaign" value="{{ old('utm_campaign', $campaign->utm_campaign) }}" class="w-full rounded-lg border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Total Ad Spend (Rp)</label>
            <input type="number" name="ad_spend" value="{{ old('ad_spend', $campaign->ad_spend) }}" class="w-full rounded-lg border-gray-300 shadow-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="notes" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm">{{ old('notes', $campaign->notes) }}</textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
            <a href="{{ route('admin.campaigns.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
