<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address', 255);
            $table->string('department', 255);
            $table->string('position', 255);
            $table->string('office_in_timing', 10);
            $table->string('office_out_timing', 10);
            $table->enum('status', ['terminate', 'active'])->default('active');
            $table->date('date_of_joining');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
