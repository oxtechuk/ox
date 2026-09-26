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
        Schema::create('digital_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->longText('description')->nullable();
            $table->json('features')->nullable();
            $table->json('system_requirements')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('EGP');
            $table->string('version')->default('1.0.0');
            $table->string('demo_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->integer('download_limit')->default(5);
            $table->integer('expiry_days')->default(365);
            $table->boolean('has_license_key')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('active'); // active, draft, archived
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_products');
    }
};
