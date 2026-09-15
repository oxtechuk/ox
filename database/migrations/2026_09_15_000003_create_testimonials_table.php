<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name'); // e.g. سارة العتيبي
            $table->string('partner_role'); // e.g. CEO، مِرسال
            $table->string('partner_country')->nullable(); // e.g. السعودية
            $table->text('quote'); // نص الاقتباس
            $table->string('video_type')->default('url'); // 'file', 'youtube', 'vimeo', 'url'
            $table->string('video_url')->nullable(); // مسار أو رابط الفيديو
            $table->string('poster_image')->nullable();
            $table->string('number_badge', 10)->nullable(); // e.g. 01, 02
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
