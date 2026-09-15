<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. مِرسال, DRIVE+
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable(); // e.g. واجهة تجارة مرنة
            $table->string('country_code', 10)->default('sa'); // sa, ae, eg, jo, de, se, ru, iq
            $table->string('country_name')->default('السعودية');
            $table->string('sector_slug', 30)->default('commerce'); // commerce, auto, health, marine
            $table->string('sector_name')->default('تجارة إلكترونية');
            $table->string('gradient_class', 50)->default('store'); // store, auto-v, health-v, marine-v, jordan-v, sweden-v, russia-v, iraq-v
            $table->string('custom_gradient')->nullable();
            $table->boolean('is_big')->default(false);
            $table->boolean('is_featured')->default(true);
            $table->integer('order')->default(0);
            
            // Project card & metadata
            $table->string('number_badge', 10)->nullable(); // e.g. 01, 02
            $table->string('short_description')->nullable();
            $table->string('impact_stat')->nullable(); // e.g. +38% في معدل إتمام الطلب خلال 90 يومًا.
            
            // Details page fields
            $table->string('hero_image')->nullable();
            $table->string('client_name')->nullable();
            $table->string('duration')->nullable(); // مدة التنفيذ (e.g. 3 أشهر / 8 أسابيع)
            $table->string('delivery_date')->nullable(); // تاريخ العمل (عملناها امتى e.g. مارس 2024 / الربع الأول 2024)
            $table->string('live_url')->nullable(); // لينك المشروع الحي
            $table->text('summary')->nullable(); // ملخص المشروع
            $table->text('challenge')->nullable(); // التحدي
            $table->text('solution')->nullable(); // الحل
            $table->json('key_features')->nullable(); // الميزات الرئيسية
            $table->json('technologies')->nullable(); // التقنيات المستخدمة
            $table->json('gallery')->nullable(); // معرض الصور
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
