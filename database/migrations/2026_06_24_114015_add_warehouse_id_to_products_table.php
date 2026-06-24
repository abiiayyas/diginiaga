<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add a default warehouse so we can attach existing products to it
        $warehouseId = DB::table('warehouses')->insertGetId([
            'name' => 'Gudang Utama (Default)',
            'address' => 'Jakarta',
            'city' => 'Jakarta Pusat',
            'biteship_area_id' => 'IDCGK101', // Default biteship area
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::table('products', function (Blueprint $table) use ($warehouseId) {
            $table->foreignId('warehouse_id')->default($warehouseId)->constrained('warehouses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['warehouse_id']);
            $table->dropColumn('warehouse_id');
        });
    }
};
