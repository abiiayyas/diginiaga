{{-- Live Preview Panel for Landing Page Editor --}}
<div class="flex flex-col h-full">
    <div class="flex items-center justify-between mb-3 px-1">
        <h3 class="text-sm font-semibold text-gray-700">Preview</h3>
        <span class="text-xs text-gray-400">📱 Mobile View</span>
    </div>
    <div class="flex-1 bg-gray-100 rounded-2xl p-3 overflow-hidden flex items-start justify-center">
        <div class="w-[340px] bg-white rounded-2xl shadow-lg overflow-y-auto max-h-full" style="font-family: 'Inter', sans-serif; line-height: 1.5;">
            {{-- Status bar mock --}}
            <div class="bg-gray-900 text-white text-[10px] flex justify-between px-4 py-1 rounded-t-2xl">
                <span>9:41</span>
                <span>📶 🔋</span>
            </div>

            <div class="px-4 pb-6">

                {{-- Hero --}}
                <div class="text-center pt-6 pb-4">
                    {{-- Cover Image Preview --}}
                    <template x-if="cover_image_url">
                        <img :src="cover_image_url" class="w-full max-h-[140px] object-cover rounded-lg mb-3">
                    </template>
                    <h1 class="text-base font-extrabold leading-tight" x-text="headline || 'Headline Produk'"></h1>
                    <p class="text-[11px] text-gray-400 mt-1.5" x-text="subheadline || 'Subheadline deskripsi'"></p>
                </div>

                {{-- Benefits Grid (Keunggulan) --}}
                <template x-if="listItems().length">
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <template x-for="b in listItems()" :key="b">
                            <div class="bg-gray-50 rounded-lg p-2 text-center border border-gray-100">
                                <div class="text-sm">✅</div>
                                <div class="text-[10px] font-semibold mt-0.5" x-text="b"></div>
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Detail Produk --}}
                <template x-if="body_content">
                    <div class="mb-4 text-left">
                        <h2 class="text-xs font-bold mb-2">Detail Produk</h2>
                        <div class="text-[11px] text-gray-700 whitespace-pre-wrap" x-text="body_content"></div>
                    </div>
                </template>

                {{-- Image Slider --}}
                <template x-if="sliderPreviews.length">
                    <div class="mb-4 rounded-lg overflow-hidden relative bg-gray-100" style="aspect-ratio: 16/9;">
                        <img :src="sliderPreviews[sliderIdx]" class="w-full h-full object-cover">
                        <template x-if="sliderPreviews.length > 1">
                            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1">
                                <template x-for="(s, si) in sliderPreviews" :key="si">
                                    <span class="w-2 h-2 rounded-full" :class="si === sliderIdx ? 'bg-blue-600' : 'bg-gray-300'"></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>


                {{-- Embed --}}
                <template x-if="embed_code">
                    <div class="mb-4 rounded-lg overflow-hidden bg-gray-100" style="aspect-ratio: 16/9;">
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                            🎬 Video Embed
                        </div>
                    </div>
                </template>

                {{-- FAQ --}}
                <template x-if="faqs.filter(f => f.q && f.a).length">
                    <div class="mb-4">
                        <h2 class="text-xs font-bold text-center mb-2">Pertanyaan Umum</h2>
                        <template x-for="(f, fi) in faqs.filter(f => f.q && f.a)" :key="fi">
                            <div class="border rounded-lg mb-1 overflow-hidden" :class="fi === 0 ? 'border-gray-300' : 'border-gray-200'">
                                <div class="flex justify-between items-center px-3 py-2 text-[11px] font-semibold cursor-pointer" @click="toggleFaq(fi)">
                                    <span x-text="f.q"></span>
                                    <span class="text-[9px] transition-transform" :class="fi === 0 ? 'rotate-180' : ''">▼</span>
                                </div>
                                <div class="px-3 pb-2 text-[10px] text-gray-500" x-show="fi === 0 || false" x-text="f.a"></div>
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Testimonials --}}
                <template x-if="testiItems().length">
                    <div class="mb-4">
                        <h2 class="text-xs font-bold text-center mb-2">Apa Kata Mereka</h2>
                        <template x-for="t in testiItems()" :key="t.name">
                            <div class="bg-gray-50 rounded-xl p-3 mb-1.5">
                                <div class="text-[10px] italic text-gray-600 mb-1" x-text="'\"'+t.quote+'\"'"></div>
                                <div class="text-[10px] font-bold" x-text="t.name"></div>
                                <div class="text-[9px] text-gray-400" x-text="t.role"></div>
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Price --}}
                <div class="bg-gray-50 rounded-xl p-4 text-center mb-4">
                    <div class="text-lg font-extrabold text-emerald-600" x-text="'Rp ' + formatPrice(price)"></div>
                </div>

                {{-- CTA Button --}}
                <div class="text-center mb-3">
                    <div class="inline-block py-3 px-10 rounded-xl text-white text-xs font-bold"
                         :style="'background-color: ' + cta_color"
                         x-text="cta_text || 'Pesan Sekarang'"></div>
                </div>

                {{-- Secondary Button --}}
                <template x-if="button_text && button_url">
                    <div class="text-center mb-4">
                        <div class="inline-block py-2.5 px-8 rounded-xl text-white text-[11px] font-semibold border-2"
                             :style="'background-color: ' + button_color + '; border-color: ' + button_color"
                             x-text="button_text"></div>
                    </div>
                </template>

                {{-- Footer --}}
                <div class="text-center text-[9px] text-gray-300 pt-2">
                    &copy; {{ date('Y') }} {{ config('app.name') }}
                </div>
            </div>
        </div>
    </div>
</div>
