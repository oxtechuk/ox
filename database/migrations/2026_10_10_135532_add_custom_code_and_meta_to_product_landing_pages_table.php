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
        Schema::table('product_landing_pages', function (Blueprint $table) {
            $table->text('external_css_urls')->nullable()->after('primary_color');
            $table->longText('custom_css')->nullable()->after('external_css_urls');
            $table->longText('custom_head_scripts')->nullable()->after('custom_css');
            $table->longText('custom_body_scripts')->nullable()->after('custom_head_scripts');
            $table->string('meta_pixel_id', 100)->nullable()->after('custom_body_scripts');
            $table->string('google_analytics_id', 100)->nullable()->after('meta_pixel_id');
            $table->string('og_title')->nullable()->after('google_analytics_id');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'external_css_urls',
                'custom_css',
                'custom_head_scripts',
                'custom_body_scripts',
                'meta_pixel_id',
                'google_analytics_id',
                'og_title',
                'og_description',
                'og_image',
            ]);
        });
    }
};
