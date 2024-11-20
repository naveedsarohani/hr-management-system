<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->longText('description');
            $table->string('experience');
            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'internship']);
            $table->string('job_location');
            $table->char('salary_range', 3);
            $table->string('qualifications');
            $table->json('benefits');
            $table->json('skills_required');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
