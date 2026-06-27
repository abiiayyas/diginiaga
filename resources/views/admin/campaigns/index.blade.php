@extends('layouts.admin')

@section('title', 'Campaigns')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Campaigns</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Kelola campaign iklan & ad spend</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.analytics.campaigns') }}" class="py-2 px-3 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-purple-100 text-purple-700 hover:bg-purple-200">ROAS Dashboard</a>
        <a href="{{ route('admin.campaigns.create') }}" class="py-2 px-3 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">+ Tambah</a>
    </div>
</div>

<!-- UTM Generator Widget -->
<div x-data="utmGenerator()" class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm mb-6 p-5">
    <h3 class="text-lg font-bold text-gray-900 dark:text-slate-100 mb-2">🚀 UTM Link Generator</h3>
    <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">Buat link iklan dengan mudah untuk dibagikan atau dipasang di Facebook/TikTok Ads.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="lg:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Landing Page *</label>
            <select x-model="baseUrl" class="block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-brand-500 focus:ring-brand-500">
                <option value="">-- Pilih Landing Page --</option>
                @foreach(\App\Models\LandingPage::where('is_active', true)->get() as $lp)
                <option value="{{ route('lp.show', $lp->slug) }}">{{ $lp->product->name }} ({{ $lp->slug }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Source (Platform) *</label>
            <input type="text" x-model="source" placeholder="contoh: facebook" class="block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-brand-500 focus:ring-brand-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Medium</label>
            <input type="text" x-model="medium" placeholder="contoh: cpc" class="block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-brand-500 focus:ring-brand-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Campaign Name *</label>
            <input type="text" x-model="campaign" placeholder="contoh: promo-merdeka" class="block w-full border-gray-200 dark:border-slate-700 rounded-lg text-sm focus:border-brand-500 focus:ring-brand-500">
        </div>
    </div>
    
    <div x-show="generatedUrl" style="display: none;" class="mt-4 p-4 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-lg flex items-center justify-between gap-4">
        <div class="truncate flex-1 font-mono text-sm text-gray-600 dark:text-slate-400" x-text="generatedUrl"></div>
        <button @click="copyToClipboard" class="shrink-0 py-1.5 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-brand-600 text-white hover:bg-brand-700">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
            <span x-text="copied ? 'Tersalin!' : 'Copy Link'"></span>
        </button>
    </div>
</div>

<script>
function utmGenerator() {
    return {
        baseUrl: '',
        source: '',
        medium: '',
        campaign: '',
        copied: false,
        get generatedUrl() {
            if (!this.baseUrl || !this.source || !this.campaign) return '';
            try {
                let url = new URL(this.baseUrl);
                url.searchParams.set('utm_source', this.source);
                if (this.medium) url.searchParams.set('utm_medium', this.medium);
                url.searchParams.set('utm_campaign', this.campaign);
                return url.toString();
            } catch (e) {
                return '';
            }
        },
        copyToClipboard() {
            if (this.generatedUrl) {
                navigator.clipboard.writeText(this.generatedUrl);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            }
        }
    }
}
</script>

<div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-800/50">
                <tr>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Nama</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Source</th>
                    <th class="px-6 py-3 text-start text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Campaign</th>
                    <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Ad Spend</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($campaigns as $c)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 dark:bg-slate-800/50">
                    <td class="px-6 py-3 text-sm font-medium text-gray-900 dark:text-slate-100">{{ $c->name }}</td>
                    <td class="px-6 py-3 text-sm text-gray-500 dark:text-slate-400">{{ $c->utm_source?:'-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-500 dark:text-slate-400">{{ $c->utm_campaign?:'-' }}</td>
                    <td class="px-6 py-3 text-sm text-end">Rp {{ number_format($c->ad_spend,0,',','.') }}</td>
                    <td class="px-6 py-3 text-sm text-center">
                        <a href="{{ route('admin.campaigns.edit', $c) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                        <form action="{{ route('admin.campaigns.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Hapus campaign?')">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Hapus</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-slate-400">Belum ada campaign.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-4">{{ $campaigns->links() }}</div>
@endsection

