<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_career_paths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('career_path_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_saved')->default(false);
            $table->timestamps();
            $table->unique(['user_id', 'career_path_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_career_paths');
    }
};
