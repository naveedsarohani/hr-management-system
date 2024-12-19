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
            Schema::create('attendance', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->date('date');
                $table->string('time_in')->nullable();
                $table->string('time_out')->nullable();
                $table->string('location')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->timestamps();
                $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attandence');
    }
};
