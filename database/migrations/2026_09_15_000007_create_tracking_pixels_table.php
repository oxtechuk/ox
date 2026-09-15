<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tracking_pixels', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->unique(); // google_analytics, google_tag_manager, meta, snapchat, tiktok, linkedin, x_twitter
            $table->string('pixel_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->longText('custom_head_script')->nullable();
            $table->longText('custom_body_script')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracking_pixels');
    }
};
