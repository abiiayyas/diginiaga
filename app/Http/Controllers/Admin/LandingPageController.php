<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $landingPages = LandingPage::with(['product'])
            ->withCount('orders')
            ->latest()
            ->paginate(20);

        return view('admin.landing-pages.index', compact('landingPages'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.landing-pages.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'slug' => 'required|string|max:255|unique:landing_pages,slug',
            'headline' => 'nullable|string|max:255',
            'subheadline' => 'nullable|string|max:255',
            'body_content' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_color' => 'nullable|string|max:20',
            'pixel_id' => 'nullable|string|max:100',
            'domain' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'variant_name' => 'nullable|string|max:255',
        ]);

        LandingPage::create($validated);

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'Landing page berhasil dibuat.');
    }

    public function edit(LandingPage $landingPage)
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.landing-pages.edit', compact('landingPage', 'products'));
    }

    public function update(Request $request, LandingPage $landingPage)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'slug' => 'required|string|max:255|unique:landing_pages,slug,' . $landingPage->id,
            'headline' => 'nullable|string|max:255',
            'subheadline' => 'nullable|string|max:255',
            'body_content' => 'nullable|string',
            'cta_text' => 'nullable|string|max:100',
            'cta_color' => 'nullable|string|max:20',
            'pixel_id' => 'nullable|string|max:100',
            'domain' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'variant_name' => 'nullable|string|max:255',
        ]);

        $landingPage->update($validated);

        return redirect()->route('admin.landing-pages.index')
            ->with('success', 'Landing page berhasil diperbarui.');
    }

    public function toggle(LandingPage $landingPage)
    {
        $landingPage->update(['is_active' => !$landingPage->is_active]);

        return back()->with('success', 'Status landing page berhasil diubah.');
    }

    public function stats(LandingPage $landingPage)
    {
        $stats = [
            'total_orders' => $landingPage->orders()->count(),
            'total_revenue' => $landingPage->orders()->where('payment_status', 'paid')->sum('total_amount'),
            'conversion_rate' => $landingPage->orders()->count() > 0
                ? round(($landingPage->orders()->count() / max(1, $landingPage->orders()->count())) * 100, 1)
                : 0,
            'orders_today' => $landingPage->orders()->whereDate('created_at', today())->count(),
            'revenue_today' => $landingPage->orders()->whereDate('created_at', today())
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
        ];

        return response()->json($stats);
    }
}
