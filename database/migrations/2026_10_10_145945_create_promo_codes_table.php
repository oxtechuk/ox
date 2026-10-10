<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('discount_type', 20)->default('percentage'); // percentage, fixed
            $table->decimal('discount_value', 10, 2);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable(); // Expiration date & duration
            $table->integer('max_uses')->nullable();
            $table->integer('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('description')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('digital_products')->nullOnDelete();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('promo_code', 50)->nullable()->after('currency');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('promo_code');
        });

        // Insert initial promo codes with clear expiration dates / duration
        DB::table('promo_codes')->insert([
            [
                'code' => 'OX50',
                'discount_type' => 'percentage',
                'discount_value' => 50.00,
                'valid_from' => now(),
                'valid_until' => now()->addDays(14), // Valid for 14 days
                'max_uses' => 500,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'خصم الافتتاح الحصري 50% لفترة محدودة',
                'product_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'SCRIP50',
                'discount_type' => 'percentage',
                'discount_value' => 50.00,
                'valid_from' => now(),
                'valid_until' => now()->addDays(7), // Valid for 7 days
                'max_uses' => 200,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'خصم 50% خاص بعملاء ScripOx لمدة أسبوع',
                'product_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'LAUNCH20',
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'valid_from' => now(),
                'valid_until' => now()->addDays(30), // Valid for 30 days
                'max_uses' => 1000,
                'used_count' => 0,
                'is_active' => true,
                'description' => 'خصم عام 20% لكافة المنتجات',
                'product_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['promo_code', 'discount_amount']);
        });

        Schema::dropIfExists('promo_codes');
    }
};
