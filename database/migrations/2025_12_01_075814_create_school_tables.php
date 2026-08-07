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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('grade_name');
            $table->string('grade_group')->nullable();
            $table->string('grade_color')->nullable();
            $table->integer('grade_order')->nullable();
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name');
            $table->string('subject_index')->nullable();
            $table->integer('subject_order')->nullable();
            $table->string('subject_color')->nullable();
            $table->string('subject_number')->nullable();
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('father_name')->nullable();
            $table->string('student_name');
            $table->string('admission_no')->unique();
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->string('nic_num')->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone_no')->nullable();
            $table->text('address')->nullable();
            $table->string('file_path')->nullable();
            $table->string('original_name')->nullable();
            $table->integer('file_size')->nullable();
            $table->timestamps();
        });

        Schema::create('student_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject');
        Schema::dropIfExists('students');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('grades');
    }
};
