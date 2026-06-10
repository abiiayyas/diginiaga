<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::withCount('orders')
            ->withCount('landingPages')
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku_supplier' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sell_price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('products', 'public');
            }
            $validated['images'] = $paths;
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku_supplier' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sell_price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('images')) {
            $paths = $product->images ?? [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('products', 'public');
            }
            $validated['images'] = $paths;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
