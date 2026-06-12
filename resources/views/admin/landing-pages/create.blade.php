@extends('layouts.admin')

@section('title', 'Buat LP')

@section('content')
@php
$lpData = [
    'product_id' => old('product_id', ''),
    'headline' => old('headline'),
    'subheadline' => old('subheadline'),
    'body_content' => old('body_content'),
    'list_items' => old('list_items'),
    'embed_code' => old('embed_code'),
    'testimonials' => old('testimonials'),
    'cta_text' => old('cta_text', 'Pesan Sekarang'),
    'cta_color' => old('cta_color', '#2563eb'),
    'button_text' => old('button_text'),
    'button_url' => old('button_url'),
    'button_color' => old('button_color', '#6b7280'),
    'scroll_target' => old('scroll_target'),
    'price' => old('product_id') ? \App\Models\Product::find(old('product_id'))?->sell_price ?? 0 : 0,
    'cover_image_url' => null,
    'sliderPreviews' => [],
    'existingFaqs' => [],
];
@endphp
<div x-data="lpEditor(@json($lpData))" class="flex gap-6" style="height: calc(100vh - 140px);">

    {{-- LEFT: Form --}}
    <div class="flex-1 overflow-y-auto pr-2">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Buat Landing Page</h1>
        <form action="{{ route('admin.landing-pages.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">
            @csrf

            @include('admin.landing-pages.partials._form')
        </form>
    </div>

    {{-- RIGHT: Live Preview --}}
    <div class="w-[380px] flex-shrink-0">
        @include('admin.landing-pages.partials._preview')
    </div>
</div>
@endsection
