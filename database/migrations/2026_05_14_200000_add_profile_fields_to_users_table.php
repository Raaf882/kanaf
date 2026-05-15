<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('college')->nullable();
            $table->string('major')->nullable();
            $table->string('department')->nullable();
            $table->string('job_number')->nullable();
            $table->unsignedTinyInteger('academic_level')->nullable();
            $table->decimal('gpa', 4, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['college', 'major', 'department', 'job_number', 'academic_level', 'gpa']);
        });
    }
};
