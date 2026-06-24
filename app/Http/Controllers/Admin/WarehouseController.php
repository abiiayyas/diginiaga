<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Services\MengantarService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderBy('id', 'desc')->get();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.warehouses.create');
    }

    public function store(Request $request, MengantarService $mengantar)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'mengantar_area_id' => 'required|string|max:255',
        ]);

        $addressId = $mengantar->createAddress(
            $validated['mengantar_area_id'],
            $validated['address'],
            '080000000000', // Default phone
            'Admin', // Default PIC
            $validated['name']
        );

        if ($addressId) {
            $validated['mengantar_address_id'] = $addressId;
        }

        Warehouse::create($validated);

        return redirect()->route('admin.warehouses.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse, MengantarService $mengantar)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'mengantar_area_id' => 'required|string|max:255',
        ]);

        // Sync address if it has changed or doesn't have an address ID
        if ($warehouse->mengantar_area_id !== $validated['mengantar_area_id'] || $warehouse->address !== $validated['address'] || !$warehouse->mengantar_address_id) {
            $addressId = $mengantar->createAddress(
                $validated['mengantar_area_id'],
                $validated['address'],
                '080000000000',
                'Admin',
                $validated['name']
            );

            if ($addressId) {
                $validated['mengantar_address_id'] = $addressId;
            }
        }

        $warehouse->update($validated);

        return redirect()->route('admin.warehouses.index')->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Warehouse $warehouse)
    {
        if ($warehouse->products()->exists()) {
            return redirect()->route('admin.warehouses.index')->with('error', 'Gudang tidak bisa dihapus karena masih digunakan oleh produk.');
        }

        $warehouse->delete();
        return redirect()->route('admin.warehouses.index')->with('success', 'Gudang berhasil dihapus.');
    }

    public function searchArea(Request $request, MengantarService $mengantar)
    {
        $query = $request->input('q');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $areas = $mengantar->searchArea($query);
        return response()->json($areas);
    }
}
