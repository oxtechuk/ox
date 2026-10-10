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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('license_key')->unique();
            $table->integer('max_devices')->default(1);
            $table->enum('status', ['active', 'revoked', 'expired'])->default('active');
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('license_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained()->cascadeOnDelete();
            $table->string('hardware_id');
            $table->dateTime('last_checked_at')->nullable();
            $table->timestamps();

            $table->unique(['license_id', 'hardware_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_devices');
        Schema::dropIfExists('licenses');
    }
};
