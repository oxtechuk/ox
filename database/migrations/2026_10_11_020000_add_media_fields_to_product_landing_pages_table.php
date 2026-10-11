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
            $table->string('laptop_mockup')->nullable()->after('video_url');
            $table->string('window_mockup')->nullable()->after('laptop_mockup');
            $table->string('box_art_image')->nullable()->after('window_mockup');
            $table->string('video_file')->nullable()->after('box_art_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'laptop_mockup',
                'window_mockup',
                'box_art_image',
                'video_file',
            ]);
        });
    }
};
