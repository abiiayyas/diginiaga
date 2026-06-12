<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('body_content');
            $table->text('list_items')->nullable()->after('cover_image');
            $table->text('faq_items')->nullable()->after('list_items');
            $table->text('testimonials')->nullable()->after('faq_items');
            $table->text('image_slider')->nullable()->after('testimonials');
            $table->text('embed_code')->nullable()->after('image_slider');
            $table->string('button_text')->nullable()->after('cta_color');
            $table->string('button_url')->nullable()->after('button_text');
            $table->string('button_color')->nullable()->default('#6b7280')->after('button_url');
            $table->string('scroll_target')->nullable()->after('button_color');
            $table->text('animation_config')->nullable()->after('scroll_target');
        });
    }

    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'cover_image',
                'list_items',
                'faq_items',
                'testimonials',
                'image_slider',
                'embed_code',
                'button_text',
                'button_url',
                'button_color',
                'scroll_target',
                'animation_config',
            ]);
        });
    }
};
