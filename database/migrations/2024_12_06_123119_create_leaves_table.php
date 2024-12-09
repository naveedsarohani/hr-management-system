<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->references('id')->on('employees')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->date('leave_date');
            $table->text('leave_reason');
            $table->enum('leave_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('leave_approved_by')->references('id')->on('employees')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
