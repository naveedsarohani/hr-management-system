<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->references('id')->on('jobs')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('candidate_name', 255);
            $table->string('email');
            $table->unique(['job_id', 'email']);
            $table->string('contact_number', 13);
            $table->text('cover_letter');
            $table->string('portfolio_link')->nullable();
            $table->string('expected_salary', 10);
            $table->enum('notice_period', ['1 week', '15 days', '1 month']);
            $table->enum('status', ['pending', 'interview', 'hired', 'rejected']);
            $table->string('resume');
            $table->timestamp('applied_at')->default(now());
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
