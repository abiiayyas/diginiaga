@extends('layouts.admin')

@section('title', 'Edit LP')

@section('content')
@php
$lpData = [
    'product_id' => old('product_id', (string) $landingPage->product_id),
    'headline' => old('headline', $landingPage->headline),
    'subheadline' => old('subheadline', $landingPage->subheadline),
    'body_content' => old('body_content', $landingPage->body_content),
    'list_items' => old('list_items', $landingPage->list_items),
    'embed_code' => old('embed_code', $landingPage->embed_code),
    'testimonials' => old('testimonials', $landingPage->testimonials),
    'cta_text' => old('cta_text', $landingPage->cta_text),
    'cta_color' => old('cta_color', $landingPage->cta_color),
    'button_text' => old('button_text', $landingPage->button_text),
    'button_url' => old('button_url', $landingPage->button_url),
    'button_color' => old('button_color', $landingPage->button_color),
    'scroll_target' => old('scroll_target', $landingPage->scroll_target),
    'price' => $landingPage->product->sell_price ?? 0,
    'cover_image_url' => $landingPage->cover_image ? asset('storage/'.$landingPage->cover_image) : null,
    'sliderPreviews' => array_values(array_map(function($img) {
        return filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/'.$img);
    }, $existingSliderImages)),
    'existingFaqs' => $existingFaqs,
];
@endphp
<div x-data="lpEditor(@json($lpData))" class="flex gap-6" style="height: calc(100vh - 140px);">

    {{-- LEFT: Form --}}
    <div class="flex-1 overflow-y-auto pr-2">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Landing Page</h1>
        <form action="{{ route('admin.landing-pages.update', $landingPage) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">
            @csrf @method('PUT')

            @include('admin.landing-pages.partials._form')
        </form>
    </div>

    {{-- RIGHT: Live Preview --}}
    <div class="w-[380px] flex-shrink-0">
        @include('admin.landing-pages.partials._preview')
    </div>
</div>
@endsection
