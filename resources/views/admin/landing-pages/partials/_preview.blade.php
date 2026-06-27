{{-- Live Preview Panel for Landing Page Editor --}}
<div class="flex flex-col h-full bg-gray-100 dark:bg-slate-800 rounded-2xl overflow-hidden border">
    <div class="flex items-center justify-between px-4 py-3 border-b bg-white dark:bg-slate-900">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-slate-300">Preview Landing Page</h3>
        <span class="text-xs font-medium text-gray-500 dark:text-slate-400 bg-gray-100 dark:bg-slate-800 px-2 py-1 rounded-md">Mobile View</span>
    </div>
    <div class="flex-1 p-4 md:p-8 overflow-y-auto flex items-start justify-center">
        <div class="w-full max-w-[380px] bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden border-4 border-gray-800 relative" style="font-family: 'Inter', sans-serif; line-height: 1.5; min-height: 700px;">
            
            {{-- Notch & Status bar mock --}}
            <div class="bg-white dark:bg-slate-900 text-gray-800 dark:text-slate-200 text-[10px] flex justify-between items-center px-6 py-2">
                <span class="font-semibold">9:41</span>
                <div class="w-24 h-5 bg-gray-800 rounded-full absolute top-1.5 left-1/2 -translate-x-1/2"></div>
                <span class="font-medium tracking-wider">📶 🔋</span>
            </div>

            <div class="px-5 pb-8 overflow-y-auto h-[calc(100%-24px)]">

                {{-- Hero --}}
                <div class="text-center pt-6 pb-5">
                    {{-- Cover Image Preview --}}
                    <template x-if="cover_image_url">
                        <img :src="cover_image_url" class="w-full h-40 object-cover rounded-xl mb-4 shadow-sm">
                    </template>
                    <h1 class="text-xl font-extrabold leading-tight text-gray-900 dark:text-slate-100" x-text="headline || 'Headline Produk Utama'"></h1>
                    <p class="text-sm text-gray-500 dark:text-slate-400 mt-2" x-text="subheadline || 'Subheadline deskripsi singkat yang mendukung.'"></p>
                </div>

                {{-- Benefits Grid (Keunggulan) --}}
                <template x-if="listItems().length">
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <template x-for="b in listItems()" :key="b">
                            <div class="bg-blue-50/50 rounded-xl p-3 text-center border border-blue-100/50">
                                <div class="text-lg mb-1">✨</div>
                                <div class="text-xs font-semibold text-blue-900" x-text="b"></div>
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Detail Produk --}}
                <template x-if="body_content">
                    <div class="mb-6 text-left">
                        <h2 class="text-sm font-bold text-gray-800 dark:text-slate-200 mb-2 border-b pb-1">Detail Produk</h2>
                        <div class="text-xs text-gray-600 dark:text-slate-400 whitespace-pre-wrap leading-relaxed" x-text="body_content"></div>
                    </div>
                </template>

                {{-- Image Slider --}}
                <template x-if="sliderPreviews.length">
                    <div class="mb-6 rounded-xl overflow-hidden relative shadow-sm" style="aspect-ratio: 1/1;">
                        <img :src="sliderPreviews[sliderIdx]" class="w-full h-full object-cover">
                        <template x-if="sliderPreviews.length > 1">
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 bg-black/30 px-2 py-1.5 rounded-full backdrop-blur-sm">
                                <template x-for="(s, si) in sliderPreviews" :key="si">
                                    <span class="w-1.5 h-1.5 rounded-full transition-all" :class="si === sliderIdx ? 'bg-white dark:bg-slate-900 scale-110' : 'bg-white dark:bg-slate-900/50'"></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>

                {{-- Embed --}}
                <template x-if="embed_code">
                    <div class="mb-6 rounded-xl overflow-hidden bg-gray-900 shadow-sm" style="aspect-ratio: 16/9;">
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-slate-500">
                            <svg class="w-8 h-8 mb-2 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                            <span class="text-xs font-medium">Video Embed</span>
                        </div>
                    </div>
                </template>

                {{-- FAQ --}}
                <template x-if="faqs.filter(f => f.q && f.a).length">
                    <div class="mb-6">
                        <h2 class="text-sm font-bold text-gray-800 dark:text-slate-200 text-center mb-4">Pertanyaan Umum</h2>
                        <div class="space-y-2">
                            <template x-for="(f, fi) in faqs.filter(f => f.q && f.a)" :key="fi">
                                <div class="bg-gray-50 dark:bg-slate-800/50 rounded-xl overflow-hidden transition-all border border-gray-100 dark:border-slate-800">
                                    <div class="flex justify-between items-center px-4 py-3 text-xs font-semibold text-gray-700 dark:text-slate-300 cursor-pointer" @click="toggleFaq(fi)">
                                        <span x-text="f.q"></span>
                                        <span class="text-[10px] text-gray-400 dark:text-slate-500 transition-transform" :class="fi === 0 ? 'rotate-180' : ''">▼</span>
                                    </div>
                                    <div class="px-4 pb-3 text-xs text-gray-500 dark:text-slate-400 leading-relaxed bg-white dark:bg-slate-900" x-show="fi === 0 || false" x-text="f.a"></div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- Testimonials --}}
                <template x-if="testiItems().length">
                    <div class="mb-6">
                        <h2 class="text-sm font-bold text-gray-800 dark:text-slate-200 text-center mb-4">Apa Kata Mereka</h2>
                        <div class="space-y-3">
                            <template x-for="t in testiItems()" :key="t.name">
                                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm">
                                    <div class="flex text-yellow-400 text-xs mb-2">★★★★★</div>
                                    <div class="text-xs text-gray-700 dark:text-slate-300 mb-3 leading-relaxed" x-text="'\"'+t.quote+'\"'"></div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[10px] font-bold" x-text="t.name.charAt(0)"></div>
                                        <div>
                                            <div class="text-[11px] font-bold text-gray-900 dark:text-slate-100" x-text="t.name"></div>
                                            <div class="text-[10px] text-gray-400 dark:text-slate-500" x-text="t.role"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- Price & CTA --}}
                <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-5 text-center mt-8 shadow-xl">
                    <div class="text-gray-300 text-xs font-medium mb-1">Harga Spesial</div>
                    <div class="text-2xl font-extrabold text-white mb-5" x-text="'Rp ' + formatPrice(price)"></div>
                    
                    <div class="w-full py-3.5 rounded-xl text-white text-sm font-bold shadow-lg transition-transform active:scale-95"
                         :style="'background-color: ' + cta_color + '; box-shadow: 0 10px 15px -3px ' + cta_color + '40'"
                         x-text="cta_text || 'Pesan Sekarang'"></div>
                         
                    <template x-if="button_text && button_url">
                        <div class="mt-3 w-full py-3 rounded-xl text-white text-xs font-semibold border border-gray-600 bg-white dark:bg-slate-900/5 backdrop-blur-sm"
                             x-text="button_text"></div>
                    </template>
                </div>

                {{-- Footer --}}
                <div class="text-center text-[10px] text-gray-400 dark:text-slate-500 pt-6 pb-2">
                    &copy; {{ date('Y') }} {{ config('app.name') }}
                </div>
            </div>
        </div>
    </div>
</div>
