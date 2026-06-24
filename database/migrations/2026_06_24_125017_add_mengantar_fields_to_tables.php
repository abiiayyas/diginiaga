<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_area_id')->nullable()->after('customer_postal_code');
        });

        Schema::table('warehouses', function (Blueprint $table) {
            $table->string('mengantar_address_id')->nullable()->after('mengantar_area_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('customer_area_id');
        });

        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('mengantar_address_id');
        });
    }
};
