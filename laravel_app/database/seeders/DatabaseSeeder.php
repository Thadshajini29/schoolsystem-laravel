<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'user_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample teacher
        User::create([
            'user_name' => 'teacher1',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Create sample grades
        $grades = [
            ['grade_name' => 'Grade 1', 'grade_group' => 'Primary', 'grade_color' => '#FF6B6B', 'grade_order' => 1],
            ['grade_name' => 'Grade 2', 'grade_group' => 'Primary', 'grade_color' => '#4ECDC4', 'grade_order' => 2],
            ['grade_name' => 'Grade 3', 'grade_group' => 'Primary', 'grade_color' => '#45B7D1', 'grade_order' => 3],
            ['grade_name' => 'Grade 4', 'grade_group' => 'Primary', 'grade_color' => '#96CEB4', 'grade_order' => 4],
            ['grade_name' => 'Grade 5', 'grade_group' => 'Primary', 'grade_color' => '#FFEAA7', 'grade_order' => 5],
        ];

        foreach ($grades as $grade) {
            Grade::create($grade);
        }

        // Create sample subjects
        $subjects = [
            ['subject_name' => 'Mathematics', 'subject_index' => 'MATH', 'subject_order' => 1, 'subject_color' => '#667eea', 'subject_number' => 'SUB001'],
            ['subject_name' => 'English', 'subject_index' => 'ENG', 'subject_order' => 2, 'subject_color' => '#764ba2', 'subject_number' => 'SUB002'],
            ['subject_name' => 'Science', 'subject_index' => 'SCI', 'subject_order' => 3, 'subject_color' => '#f093fb', 'subject_number' => 'SUB003'],
            ['subject_name' => 'History', 'subject_index' => 'HIST', 'subject_order' => 4, 'subject_color' => '#4facfe', 'subject_number' => 'SUB004'],
            ['subject_name' => 'Geography', 'subject_index' => 'GEO', 'subject_order' => 5, 'subject_color' => '#43e97b', 'subject_number' => 'SUB005'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
