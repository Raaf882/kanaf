<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('semester');

            // Theory grades
            $table->unsignedTinyInteger('quiz1_theory')->default(0);   // /4
            $table->unsignedTinyInteger('quiz2_theory')->default(0);   // /4
            $table->unsignedTinyInteger('quiz3_theory')->default(0);   // /4
            $table->unsignedTinyInteger('mid_theory')->default(0);     // /20
            $table->unsignedTinyInteger('final_theory')->default(0);   // /20

            // Practical grades
            $table->unsignedTinyInteger('quiz1_practical')->default(0); // /4
            $table->unsignedTinyInteger('quiz2_practical')->default(0); // /4
            $table->unsignedTinyInteger('quiz3_practical')->default(0); // /4
            $table->unsignedTinyInteger('mid_practical')->default(0);
            $table->unsignedTinyInteger('final_practical')->default(0);

            $table->timestamps();
            $table->unique(['user_id', 'course_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
