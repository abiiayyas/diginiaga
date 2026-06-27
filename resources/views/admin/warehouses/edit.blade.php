@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-slate-100">Edit Gudang</h1>
        <a href="{{ route('admin.warehouses.index') }}" class="text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-100 font-medium text-sm">Kembali</a>
    </div>

    <form action="{{ route('admin.warehouses.update', $warehouse) }}" method="POST" class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 overflow-hidden">
        @csrf
        @method('PUT')
        <div class="p-6 md:p-8 space-y-6">
            <!-- Nama Gudang -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama Gudang *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $warehouse->name) }}" required
                       class="w-full rounded-xl border-gray-200 dark:border-slate-700 focus:border-brand-500 focus:ring focus:ring-brand-500 focus:ring-opacity-50">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Cari Area (Mengantar Integration) -->
            <div class="relative" x-data="areaSearch()">
                <label for="area_search" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Ubah Area / Kota (Opsional)</label>
                <input type="text" id="area_search" x-model="query" @input.debounce.500ms="search" @focus="isOpen = true" @click.away="isOpen = false"
                       autocomplete="off"
                       class="w-full rounded-xl border-gray-200 dark:border-slate-700 focus:border-brand-500 focus:ring focus:ring-brand-500 focus:ring-opacity-50"
                       placeholder="Ketik nama kota atau kecamatan jika ingin mengubah area...">
                <div x-show="loading" class="absolute right-3 top-9 text-gray-400 dark:text-slate-500">
                    <svg class="animate-spin size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>

                <!-- Dropdown -->
                <div x-show="isOpen && results.length > 0" class="absolute z-10 w-full mt-1 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl shadow-lg max-h-60 overflow-auto">
                    <ul class="py-1">
                        <template x-for="area in results" :key="area.id">
                            <li @click="selectArea(area)" class="px-4 py-2 hover:bg-brand-50 cursor-pointer">
                                <div class="text-sm font-medium text-gray-900 dark:text-slate-100" x-text="area.name"></div>
                                <div class="text-xs text-gray-500 dark:text-slate-400" x-text="area.administrative_division_level_2_name + ', ' + area.administrative_division_level_1_name"></div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Area Details (Readonly) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kota / Kabupaten</label>
                    <input type="text" name="city" id="city" value="{{ old('city', $warehouse->city) }}" readonly
                           class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-slate-400">
                </div>
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Provinsi</label>
                    <input type="text" name="province" id="province" value="{{ old('province', $warehouse->province) }}" readonly
                           class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-slate-400">
                </div>
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Kode Pos</label>
                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $warehouse->postal_code) }}" readonly
                           class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-slate-400">
                </div>
                <div>
                    <label for="mengantar_area_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Mengantar Area ID</label>
                    <input type="text" name="mengantar_area_id" id="mengantar_area_id" value="{{ old('mengantar_area_id', $warehouse->mengantar_area_id) }}" readonly
                           class="w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 text-gray-500 dark:text-slate-400">
                </div>
            </div>

            <!-- Alamat Lengkap -->
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Alamat Lengkap Jalan *</label>
                <textarea name="address" id="address" rows="3" required
                          class="w-full rounded-xl border-gray-200 dark:border-slate-700 focus:border-brand-500 focus:ring focus:ring-brand-500 focus:ring-opacity-50">{{ old('address', $warehouse->address) }}</textarea>
                @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

        </div>
        <div class="px-6 py-4 bg-gray-50 dark:bg-slate-800/50 border-t border-gray-100 dark:border-slate-800 flex justify-end">
            <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white font-medium py-2 px-6 rounded-xl text-sm transition-colors shadow-sm shadow-brand-500/30">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function areaSearch() {
        return {
            query: '',
            results: [],
            loading: false,
            isOpen: false,
            search() {
                if (this.query.length < 3) {
                    this.results = [];
                    this.isOpen = false;
                    return;
                }
                this.loading = true;
                fetch(`/admin/warehouses/search-area?q=${this.query}`)
                    .then(res => res.json())
                    .then(data => {
                        this.results = data;
                        this.isOpen = true;
                        this.loading = false;
                    })
                    .catch(err => {
                        console.error(err);
                        this.loading = false;
                    });
            },
            selectArea(area) {
                this.query = area.name + ', ' + area.administrative_division_level_2_name;
                document.getElementById('city').value = area.administrative_division_level_2_name;
                document.getElementById('province').value = area.administrative_division_level_1_name;
                document.getElementById('postal_code').value = area.postal_code;
                document.getElementById('mengantar_area_id').value = area.id;
                this.isOpen = false;
            }
        }
    }
</script>
@endpush
@endsection
