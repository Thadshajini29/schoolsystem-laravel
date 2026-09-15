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
        if (!Schema::hasTable('exams')) {
            Schema::create('exams', function (Blueprint $table) {
                $table->id();
                $table->string('exam_name');
                $table->string('exam_type')->default('Term Exam'); // Midterm, Final, Unit Test, Quiz
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index('is_active');
            });
        }

        if (Schema::hasTable('marks')) {
            Schema::dropIfExists('marks');
        }

        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->foreignId('grade_id')->constrained('grades')->onDelete('cascade');
            $table->decimal('marks_obtained', 5, 2)->default(0.00);
            $table->decimal('total_marks', 5, 2)->default(100.00);
            $table->string('grade_letter', 5)->nullable(); // A+, A, B, C, S, F
            $table->string('remarks')->nullable();
            $table->timestamps();

            // Composite unique constraint: 1 mark record per student, subject, and exam
            $table->unique(['exam_id', 'student_id', 'subject_id']);

            $table->index(['exam_id', 'grade_id']);
            $table->index(['student_id', 'exam_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
        Schema::dropIfExists('exams');
    }
};
