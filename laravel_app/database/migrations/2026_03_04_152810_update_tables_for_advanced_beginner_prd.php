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
        // 1. Create Teachers table
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->timestamps();
        });

        // 2. Update Students table
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'admission_date')) {
                $table->date('admission_date')->nullable()->after('admission_no');
            }
            if (!Schema::hasColumn('students', 'academic_year')) {
                $table->string('academic_year')->nullable()->after('admission_date');
            }
        });

        // 3. Create Attendance table
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->enum('status', ['present', 'absent']);
            $table->timestamps();
        });

        // 4. Create Marks table
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('exam_type'); // e.g., Term Test, Monthly Test, Final Exam
            $table->integer('total_marks');
            $table->integer('obtained_marks');
            $table->timestamps();
        });

        // 5. Create Grade-Subject-Teacher mapping table
        Schema::create('grade_subject_teacher', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 6. Create Announcements table
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Admin who posted
            $table->string('title');
            $table->text('message');
            $table->date('date');
            $table->timestamps();
        });

        // 7. Create Activity Logs table
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });

        // 8. Create Timetables table
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->string('day'); // Monday, Tuesday, etc.
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_id')->constrained()->onDelete('cascade');
            $table->time('time_start');
            $table->time('time_end');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetables');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('grade_subject_teacher');
        Schema::dropIfExists('marks');
        Schema::dropIfExists('attendance');
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['admission_date', 'academic_year']);
        });
        Schema::dropIfExists('teachers');
    }
};
