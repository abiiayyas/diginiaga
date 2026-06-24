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
        Schema::table('warehouses', function (Blueprint $table) {
            $table->renameColumn('biteship_area_id', 'mengantar_area_id');
        });

        \Illuminate\Support\Facades\DB::table('warehouses')->update(['mengantar_area_id' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->renameColumn('mengantar_area_id', 'biteship_area_id');
        });
    }
};
