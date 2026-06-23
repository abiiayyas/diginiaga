<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Alter products
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('has_variants')->default(false)->after('is_active');
        });

        // 2. Product Options
        Schema::create('product_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g. Warna, Ukuran
            $table->timestamps();
        });

        // 3. Product Option Values
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_option_id')->constrained('product_options')->cascadeOnDelete();
            $table->string('value'); // e.g. Merah, XL
            $table->timestamps();
        });

        // 4. Product Variants
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku')->unique()->nullable();
            $table->decimal('sell_price', 12, 0);
            $table->decimal('cost_price', 12, 0)->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('images')->nullable();
            $table->timestamps();
        });

        // 5. Product Variant Option Value Pivot
        Schema::create('product_variant_option_value', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->foreignId('product_option_value_id')->constrained('product_option_values')->cascadeOnDelete();
            $table->primary(['product_variant_id', 'product_option_value_id'], 'variant_option_primary');
        });

        // 6. Alter orders
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained('product_variants')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('product_variant_id');
        });

        Schema::dropIfExists('product_variant_option_value');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_option_values');
        Schema::dropIfExists('product_options');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('has_variants');
        });
    }
};
