<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('headline')->nullable();
            $table->string('subheadline')->nullable();
            $table->text('body_content')->nullable();
            $table->string('cta_text')->default('Pesan Sekarang');
            $table->string('cta_color')->default('#2563eb');
            $table->string('pixel_id')->nullable();
            $table->string('domain')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('variant_name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
