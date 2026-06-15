{{-- Basic Info --}}
<div>
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Info Dasar</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-2">Produk</label>
            <select name="product_id" required
                x-model="product_id"
                @change="updatePrice($el)"
                class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih</option>
                @foreach($products as $p)
                <option value="{{ $p->id }}" data-price="{{ $p->sell_price }}" {{ old('product_id', $landingPage->product_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }} (Rp {{ number_format($p->sell_price,0,',','.') }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Slug</label>
            <div class="flex items-center">
                <span class="text-gray-400 text-sm mr-1">{{config('app.url')}}/p/</span>
                <input type="text" name="slug" value="{{old('slug', $landingPage->slug ?? '')}}" required class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="nama-produk">
            </div>
        </div>
    </div>
</div>

{{-- Hero Section --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Hero Section</h2>
    <div class="space-y-4">
        <div><label class="block text-sm font-medium mb-2">Headline</label><input type="text" name="headline" x-model="headline" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div><label class="block text-sm font-medium mb-2">Subheadline</label><input type="text" name="subheadline" x-model="subheadline" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div>
            <label class="block text-sm font-medium mb-2">Cover Image (max 4MB)</label>
            @if(isset($landingPage) && $landingPage->cover_image)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $landingPage->cover_image) }}" class="w-32 h-20 object-cover rounded-lg border">
            </div>
            @endif
            <input type="file" name="cover_image" accept="image/*"
                @change="cover_image_url = $el.files[0] ? URL.createObjectURL($el.files[0]) : cover_image_url"
                class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm">
            <p class="text-xs text-gray-400 mt-1">{{ isset($landingPage) && $landingPage->cover_image ? 'Biarkan kosong jika tidak ingin mengganti.' : 'Rekomendasi ukuran: 1200x630px.' }}</p>
        </div>
    </div>
</div>

{{-- Content Section --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Konten</h2>
    <div><label class="block text-sm font-medium mb-2">Deskripsi Produk (Teks Lengkap)</label><textarea name="body_content" rows="6" x-model="body_content" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tulis deskripsi lengkap produk di sini..."></textarea></div>
</div>

{{-- List Section --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Keunggulan / List</h2>
    <div>
        <label class="block text-sm font-medium mb-2">Keunggulan Produk (1 per baris)</label>
        <textarea name="list_items" rows="5" x-model="list_items" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Bahan Premium&#10;Tahan Lama&#10;Anti Air"></textarea>
        <p class="text-xs text-gray-400 mt-1">Setiap baris akan ditampilkan di dalam kotak fitur (grid).</p>
    </div>
</div>

{{-- Image Slider --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Gambar Slider</h2>
    @if(!empty($existingSliderImages))
    <div class="mb-3 p-3 bg-gray-50 rounded-lg border">
        <p class="text-sm font-medium mb-2">Gambar Saat Ini:</p>
        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
            @foreach($existingSliderImages as $img)
            <img src="{{ filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/'.$img) }}" class="w-full h-16 object-cover rounded border">
            @endforeach
        </div>
    </div>
    <label class="flex items-center gap-x-2 mb-3 text-sm">
        <input type="checkbox" name="keep_slider_images" value="1" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        Pertahankan gambar slider yang ada
    </label>
    @endif
    <div>
        <label class="block text-sm font-medium mb-2">Upload Gambar {{ !empty($existingSliderImages) ? 'Baru (mengganti semua)' : '(pilih beberapa sekaligus, max 4MB/gambar)' }}</label>
        <input type="file" name="slider_images[]" accept="image/*" multiple
            @change="handleSliderUpload($el)"
            class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm">
        <p class="text-xs text-gray-400 mt-1">{{ !empty($existingSliderImages) ? 'Upload baru akan mengganti slider yang lama.' : 'Upload langsung dari komputer.' }}</p>
    </div>
</div>


{{-- Embed / YouTube --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Embed / YouTube</h2>
    <div>
        <label class="block text-sm font-medium mb-2">Kode Embed atau URL YouTube</label>
        <textarea name="embed_code" rows="3" x-model="embed_code" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="<iframe width='560' height='315' src='https://www.youtube.com/embed/...'></iframe>"></textarea>
        <p class="text-xs text-gray-400 mt-1">Tempel kode embed dari YouTube atau platform lain.</p>
    </div>
</div>

{{-- FAQ Section (Accordion Builder) --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">FAQ</h2>
    <p class="text-xs text-gray-400 mb-3">Tambah Pertanyaan & Jawaban.</p>
    <div class="space-y-3 mb-3">
        <template x-for="(faq, i) in faqs" :key="i">
            <div class="flex gap-2 items-start bg-gray-50 rounded-lg p-3 border">
                <div class="flex-1 space-y-2">
                    <input type="text" x-model="faq.q" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Pertanyaan">
                    <textarea x-model="faq.a" rows="2" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jawaban"></textarea>
                </div>
                <button type="button" @click="faqs.splice(i,1)" class="flex-shrink-0 mt-1 py-1 px-2 text-red-500 hover:bg-red-50 rounded text-sm">✕</button>
            </div>
        </template>
    </div>
    <button type="button" @click="faqs.push({q:'',a:''})" class="py-2 px-4 text-sm font-medium rounded-lg border border-dashed border-gray-300 text-gray-600 hover:bg-gray-50 w-full">
        + Tambah FAQ
    </button>
    <input type="hidden" name="faq_items" :value="JSON.stringify(faqs.filter(f => f.q && f.a))">
</div>

{{-- Testimonials --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Testimoni</h2>
    <div>
        <label class="block text-sm font-medium mb-2">Testimoni (format: Nama | Role | Quote, 1 per baris)</label>
        <textarea name="testimonials" rows="5" x-model="testimonials" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Budi | Pembeli | Produknya keren!&#10;Ani | Pelanggan | Puas"></textarea>
        <p class="text-xs text-gray-400 mt-1">Format: Nama | Role | Quote. Pisahkan dengan pipe (|).</p>
    </div>
</div>

{{-- CTA Buttons --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">CTA Button</h2>
    <div class="grid grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium mb-2">Teks CTA</label><input type="text" name="cta_text" x-model="cta_text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div><label class="block text-sm font-medium mb-2">Warna CTA</label><input type="color" name="cta_color" x-model="cta_color" class="h-10 w-full border-gray-200 rounded-lg"></div>
    </div>
</div>

{{-- Secondary Button --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Tombol Tambahan</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div><label class="block text-sm font-medium mb-2">Teks Tombol</label><input type="text" name="button_text" x-model="button_text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Hubungi WA"></div>
        <div><label class="block text-sm font-medium mb-2">URL Tombol</label><input type="url" name="button_url" x-model="button_url" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://wa.me/62812..."></div>
        <div><label class="block text-sm font-medium mb-2">Warna Tombol</label><input type="color" name="button_color" x-model="button_color" class="h-10 w-full border-gray-200 rounded-lg"></div>
    </div>
</div>

{{-- Scroll Target --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Scroll Target</h2>
    <div>
        <label class="block text-sm font-medium mb-2">Target ID</label>
        <input type="text" name="scroll_target" x-model="scroll_target" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="cta-btn">
        <p class="text-xs text-gray-400 mt-1">ID elemen yang akan di-scroll otomatis.</p>
    </div>
</div>

{{-- Animations --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Animasi</h2>
    <p class="text-xs text-gray-400 mb-3">Pilih animasi yang ingin ditampilkan.</p>

    @php
        $hasArrow = false; $hasPulse = false; $hasBounce = false; $hasShake = false; $hasFade = false;
        $arrowDelay = 2000; $pulseDelay = 1500; $bounceDelay = 2000; $shakeDelay = 3000;
        if (isset($animConfig)) {
            foreach ($animConfig as $anim) {
                if (($anim['type'] ?? '') === 'arrow') { $hasArrow = true; $arrowDelay = $anim['delay'] ?? 2000; }
                if (($anim['type'] ?? '') === 'pulse') { $hasPulse = true; $pulseDelay = $anim['delay'] ?? 1500; }
                if (($anim['type'] ?? '') === 'bounce') { $hasBounce = true; $bounceDelay = $anim['delay'] ?? 2000; }
                if (($anim['type'] ?? '') === 'shake') { $hasShake = true; $shakeDelay = $anim['delay'] ?? 3000; }
                if (($anim['type'] ?? '') === 'fadein') { $hasFade = true; }
            }
        }
    @endphp

    <div class="space-y-3">
        <label class="flex items-start gap-x-3 p-3 bg-gray-50 rounded-lg border cursor-pointer hover:bg-gray-100">
            <input type="checkbox" name="anim_arrow_cta" value="1" {{ $hasArrow ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <div>
                <span class="text-sm font-medium">Panah menunjuk ke CTA</span>
                <input type="number" name="anim_arrow_cta_delay" value="{{ $arrowDelay }}" class="mt-1 py-1 px-2 w-24 border-gray-200 rounded text-sm"> <span class="text-xs text-gray-400">delay (ms)</span>
            </div>
        </label>
        <label class="flex items-start gap-x-3 p-3 bg-gray-50 rounded-lg border cursor-pointer hover:bg-gray-100">
            <input type="checkbox" name="anim_pulse_cta" value="1" {{ $hasPulse ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <div><span class="text-sm font-medium">Efek Pulse (berdenyut)</span>
            <input type="number" name="anim_pulse_cta_delay" value="{{ $pulseDelay }}" class="mt-1 py-1 px-2 w-24 border-gray-200 rounded text-sm"> <span class="text-xs text-gray-400">delay (ms)</span></div>
        </label>
        <label class="flex items-start gap-x-3 p-3 bg-gray-50 rounded-lg border cursor-pointer hover:bg-gray-100">
            <input type="checkbox" name="anim_bounce_cta" value="1" {{ $hasBounce ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <div><span class="text-sm font-medium">Efek Bounce (memantul)</span>
            <input type="number" name="anim_bounce_cta_delay" value="{{ $bounceDelay }}" class="mt-1 py-1 px-2 w-24 border-gray-200 rounded text-sm"> <span class="text-xs text-gray-400">delay (ms)</span></div>
        </label>
        <label class="flex items-start gap-x-3 p-3 bg-gray-50 rounded-lg border cursor-pointer hover:bg-gray-100">
            <input type="checkbox" name="anim_shake_cta" value="1" {{ $hasShake ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <div><span class="text-sm font-medium">Efek Shake (bergetar)</span>
            <input type="number" name="anim_shake_cta_delay" value="{{ $shakeDelay }}" class="mt-1 py-1 px-2 w-24 border-gray-200 rounded text-sm"> <span class="text-xs text-gray-400">delay (ms)</span></div>
        </label>
        <label class="flex items-start gap-x-3 p-3 bg-gray-50 rounded-lg border cursor-pointer hover:bg-gray-100">
            <input type="checkbox" name="anim_fade_sections" value="1" {{ $hasFade ? 'checked' : '' }} class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <div><span class="text-sm font-medium">Fade-in semua section</span></div>
        </label>
    </div>
</div>

{{-- Others --}}
<div class="border-t pt-5">
    <h2 class="text-lg font-semibold text-gray-800 mb-3">Lainnya</h2>
    <div class="space-y-4">
        <div><label class="block text-sm font-medium mb-2">Meta Pixel ID</label><input type="text" name="pixel_id" value="{{old('pixel_id', $landingPage->pixel_id ?? '')}}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div><label class="block text-sm font-medium mb-2">Varian</label><input type="text" name="variant_name" value="{{old('variant_name', $landingPage->variant_name ?? '')}}" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"></div>
        <div class="pt-2"><label class="flex items-center gap-x-2"><input type="checkbox" name="is_active" value="1" {{ (isset($landingPage) && $landingPage->is_active) || !isset($landingPage) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"><span class="text-sm">Aktif</span></label></div>
    </div>
</div>

<div class="flex gap-3 pt-2">
    <button class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700">{{ isset($landingPage) ? 'Update' : 'Simpan' }}</button>
    <a href="{{ route('admin.landing-pages.index') }}" class="py-2 px-4 inline-flex items-center gap-x-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Batal</a>
</div>

@push('scripts')
<script>
function lpEditor(initial) {
    return {
        headline: initial.headline || '',
        subheadline: initial.subheadline || '',
        body_content: initial.body_content || '',
        list_items: initial.list_items || '',
        embed_code: initial.embed_code || '',
        testimonials: initial.testimonials || '',
        cta_text: initial.cta_text || 'Pesan Sekarang',
        cta_color: initial.cta_color || '#2563eb',
        button_text: initial.button_text || '',
        button_url: initial.button_url || '',
        button_color: initial.button_color || '#6b7280',
        scroll_target: initial.scroll_target || '',
        price: initial.price || 0,
        product_id: initial.product_id || '',
        cover_image_url: initial.cover_image_url,
        sliderPreviews: initial.sliderPreviews || [],
        sliderIdx: 0,
        faqs: (initial.existingFaqs && initial.existingFaqs.length)
            ? initial.existingFaqs
            : [{q: '', a: ''}],

        benefits() {
            return (this.body_content || '').split('\n').map(s => s.trim()).filter(Boolean);
        },

        listItems() {
            return (this.list_items || '').split('\n').map(s => s.trim()).filter(Boolean);
        },

        testiItems() {
            return (this.testimonials || '').split('\n').map(s => s.trim()).filter(Boolean).map(line => {
                const p = line.split('|');
                return {name: (p[0]||'').trim(), role: (p[1]||'').trim(), quote: (p[2]||'').trim()};
            }).filter(t => t.name);
        },

        formatPrice(n) {
            return new Intl.NumberFormat('id-ID').format(n || 0);
        },

        updatePrice(el) {
            const opt = el.options[el.selectedIndex];
            if (opt && opt.dataset.price) {
                this.price = parseInt(opt.dataset.price) || 0;
            } else {
                this.price = 0;
            }
        },

        handleSliderUpload(el) {
            this.sliderPreviews = [];
            for (let f of el.files) {
                this.sliderPreviews.push(URL.createObjectURL(f));
            }
            this.sliderIdx = 0;
        },

        toggleFaq(i) {
            this._openFaq = this._openFaq === i ? null : i;
        },
    };
}
</script>
@endpush
