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
        Schema::table('projects', function (Blueprint $table) {
            $table->index('is_featured');
            $table->index('country_code');
            $table->index('sector_slug');
            $table->index('order');
        });

        if (Schema::hasTable('digital_products')) {
            Schema::table('digital_products', function (Blueprint $table) {
                $table->index('status');
                $table->index('is_featured');
            });
        }

        if (Schema::hasTable('product_landing_pages')) {
            Schema::table('product_landing_pages', function (Blueprint $table) {
                $table->index('is_published');
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->index('payment_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['country_code']);
            $table->dropIndex(['sector_slug']);
            $table->dropIndex(['order']);
        });

        if (Schema::hasTable('digital_products')) {
            Schema::table('digital_products', function (Blueprint $table) {
                $table->dropIndex(['status']);
                $table->dropIndex(['is_featured']);
            });
        }

        if (Schema::hasTable('product_landing_pages')) {
            Schema::table('product_landing_pages', function (Blueprint $table) {
                $table->dropIndex(['is_published']);
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropIndex(['payment_status']);
            });
        }
    }
};
