@extends('layouts.admin')

@section('title', 'Edit Campaign')

@section('content')
<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100 mb-6">Edit Campaign</h1>
    <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-6">
        @csrf @method('PUT')
        <div class="mb-4"><label class="block text-sm font-medium mb-2">Nama</label><input type="text" name="name" value="{{ old('name',$campaign->name) }}" required class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">UTM Source</label><input type="text" name="utm_source" value="{{ old('utm_source',$campaign->utm_source) }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">UTM Medium</label><input type="text" name="utm_medium" value="{{ old('utm_medium',$campaign->utm_medium) }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">UTM Campaign</label><input type="text" name="utm_campaign" value="{{ old('utm_campaign',$campaign->utm_campaign) }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">Ad Spend (Rp)</label><input type="number" name="ad_spend" value="{{ old('ad_spend',$campaign->ad_spend) }}" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-medium mb-2">Catatan</label><textarea name="notes" rows="2" class="py-2 px-3 block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes',$campaign->notes) }}</textarea></div>
        <div class="flex gap-3"><button type="submit" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">Update</button><a href="{{ route('admin.campaigns.index') }}" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 hover:bg-gray-200">Batal</a></div>
    </form>
</div>
@endsection

