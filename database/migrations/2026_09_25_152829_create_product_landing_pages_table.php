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
        Schema::create('product_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('digital_products')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('headline');
            $table->text('subheadline')->nullable();
            $table->string('hero_badge')->nullable();
            $table->string('video_url')->nullable();
            $table->dateTime('timer_ends_at')->nullable();
            $table->json('key_benefits')->nullable();
            $table->json('social_proof_stats')->nullable();
            $table->json('testimonials')->nullable();
            $table->json('faq_items')->nullable();
            $table->json('comparison_table')->nullable();
            $table->text('guarantee_text')->nullable();
            $table->string('cta_text')->default('اشترِ الآن واحصل على التفعيل الفوري');
            $table->string('primary_color')->default('#0284c7');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_landing_pages');
    }
};
