<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->string('project_type')->nullable(); // موقع/منصة، متجر إلكتروني، تطبيق جوال، نظام مخصص/SaaS
            $table->string('budget')->nullable();
            $table->text('message');
            $table->enum('status', ['new', 'contacted', 'scheduled', 'completed', 'archived'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
