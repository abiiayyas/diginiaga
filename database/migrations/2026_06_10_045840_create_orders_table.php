<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('landing_page_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address');
            $table->string('customer_city');
            $table->string('customer_province');
            $table->string('customer_postal_code', 10);
            $table->integer('qty')->default(1);
            $table->decimal('unit_price', 12, 0);
            $table->string('shipping_courier')->nullable();
            $table->string('shipping_service')->nullable();
            $table->decimal('shipping_cost', 12, 0)->default(0);
            $table->decimal('total_amount', 12, 0);
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'expired', 'failed', 'refunded'])->default('pending');
            $table->enum('order_status', ['pending_payment', 'paid', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending_payment');
            $table->string('midtrans_order_id')->nullable()->unique();
            $table->text('notes')->nullable();
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_content')->nullable();
            $table->enum('supplier_order_status', ['pending', 'ordered', 'confirmed'])->nullable();
            $table->timestamp('supplier_ordered_at')->nullable();
            $table->text('supplier_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
