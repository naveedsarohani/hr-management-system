<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->date('date');
            $table->time('time');
<<<<<<< HEAD
            $table->enum('status', ['present', 'absent', 'on leave']);
=======
            $table->enum('status',['present', 'absent', 'on leave']);
>>>>>>> e5e374504821859c2ca1e7288afb17a8a05d1d6e
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
