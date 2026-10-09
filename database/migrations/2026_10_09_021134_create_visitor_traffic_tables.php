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
        Schema::create('visitor_traffic', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 80)->index();
            $table->string('ip_address', 45)->nullable();
            $table->string('url', 500);
            $table->string('path', 190)->index();
            $table->string('route_name', 80)->nullable()->index();
            $table->unsignedBigInteger('project_id')->nullable()->index();
            $table->text('referer')->nullable();
            $table->string('referer_source', 40)->nullable()->index(); // google, meta, tiktok, snapchat, twitter, whatsapp, direct, other
            $table->string('utm_source', 80)->nullable()->index();
            $table->string('utm_medium', 80)->nullable();
            $table->string('utm_campaign', 80)->nullable();
            $table->string('device_type', 20)->default('desktop')->index(); // mobile, tablet, desktop
            $table->string('browser', 40)->nullable();
            $table->string('platform', 40)->nullable(); // Windows, iOS, Android, macOS, Linux
            $table->string('country_code', 10)->nullable()->index();
            $table->string('country_name', 80)->nullable();
            $table->boolean('is_bot')->default(false)->index();
            $table->timestamps();

            $table->index('created_at');
        });

        Schema::create('traffic_events', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 80)->index();
            $table->string('event_name', 80)->index(); // whatsapp_click, consultation_submit, quote_click, video_play
            $table->string('page_url', 500)->nullable();
            $table->json('event_data')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_events');
        Schema::dropIfExists('visitor_traffic');
    }
};
