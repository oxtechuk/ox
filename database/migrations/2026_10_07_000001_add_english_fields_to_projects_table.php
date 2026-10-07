<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('subtitle_en')->nullable()->after('subtitle');
            $table->string('country_name_en')->nullable()->after('country_name');
            $table->string('sector_name_en')->nullable()->after('sector_name');
            $table->text('short_description_en')->nullable()->after('short_description');
            $table->string('client_name_en')->nullable()->after('client_name');
            $table->string('duration_en')->nullable()->after('duration');
            $table->string('delivery_date_en')->nullable()->after('delivery_date');
            $table->text('summary_en')->nullable()->after('summary');
            $table->text('challenge_en')->nullable()->after('challenge');
            $table->text('solution_en')->nullable()->after('solution');
            $table->json('key_features_en')->nullable()->after('key_features');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'title_en',
                'subtitle_en',
                'country_name_en',
                'sector_name_en',
                'short_description_en',
                'client_name_en',
                'duration_en',
                'delivery_date_en',
                'summary_en',
                'challenge_en',
                'solution_en',
                'key_features_en',
            ]);
        });
    }
};
