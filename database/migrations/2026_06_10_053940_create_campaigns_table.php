<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->unsignedBigInteger('ad_spend')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_cod')->default(false)->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('is_cod');
        });
    }
};
