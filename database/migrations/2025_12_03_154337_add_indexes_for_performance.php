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
        // Add indexes to students table for better query performance
        Schema::table('students', function (Blueprint $table) {
            $table->index('grade_id');
            $table->index('student_name');
            $table->index('admission_no');
        });

        // Add indexes to grades table
        Schema::table('grades', function (Blueprint $table) {
            $table->index('grade_name');
            $table->index('grade_order');
        });

        // Add indexes to subjects table
        Schema::table('subjects', function (Blueprint $table) {
            $table->index('subject_name');
            $table->index('subject_order');
        });

        // Add indexes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->index('user_name');
            $table->index('role');
        });

        // Add indexes to pivot tables
        Schema::table('student_subject', function (Blueprint $table) {
            $table->index('student_id');
            $table->index('subject_id');
        });

        Schema::table('grade_subject', function (Blueprint $table) {
            $table->index('grade_id');
            $table->index('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['grade_id']);
            $table->dropIndex(['student_name']);
            $table->dropIndex(['admission_no']);
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->dropIndex(['grade_name']);
            $table->dropIndex(['grade_order']);
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->dropIndex(['subject_name']);
            $table->dropIndex(['subject_order']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['user_name']);
            $table->dropIndex(['role']);
        });

        Schema::table('student_subject', function (Blueprint $table) {
            $table->dropIndex(['student_id']);
            $table->dropIndex(['subject_id']);
        });

        Schema::table('grade_subject', function (Blueprint $table) {
            $table->dropIndex(['grade_id']);
            $table->dropIndex(['subject_id']);
        });
    }
};
