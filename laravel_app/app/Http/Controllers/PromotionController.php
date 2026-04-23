<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Mark;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        $grades = Grade::all();
        $students = [];
        $selectedGrade = null;

        if ($request->filled('grade_id')) {
            $selectedGrade = Grade::find($request->grade_id);
            
            if (!$selectedGrade) {
                return redirect()->route('grades.index')->with('error', 'The selected grade does not exist. Please select or create a grade first.');
            }

            $students = Student::where('grade_id', $selectedGrade->id)
                ->with(['marks' => function($q) {
                    $q->latest();
                }])
                ->get();
            
            // Calculate average for each student to help admin decide
            foreach($students as $student) {
                $student->average_mark = $student->marks->avg('mark_obtained') ?? 0;
                $student->can_promote = $student->average_mark >= 40; // Simple threshold
            }
        }

        return view('promotions.index', compact('grades', 'students', 'selectedGrade'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'from_grade_id' => 'required|exists:grades,id',
            'to_grade_id' => 'required|exists:grades,id|different:from_grade_id',
            'academic_year' => 'required|string',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $affectedCount = Student::whereIn('id', $request->student_ids)
            ->where('grade_id', $request->from_grade_id)
            ->update([
                'grade_id' => $request->to_grade_id,
                'academic_year' => $request->academic_year
            ]);

        $fromGrade = Grade::find($request->from_grade_id)->grade_name;
        $toGrade = Grade::find($request->to_grade_id)->grade_name;

        ActivityLog::log("Promoted $affectedCount students from $fromGrade to $toGrade ($request->academic_year)", 'Promotion', [
            'from_grade' => $fromGrade,
            'to_grade' => $toGrade,
            'academic_year' => $request->academic_year,
            'student_count' => $affectedCount
        ]);

        return redirect()->route('promotions.index')->with('success', "Successfully promoted $affectedCount students to $toGrade for session $request->academic_year.");
    }

    public function history()
    {
        $logs = ActivityLog::where('action', 'like', 'Promoted%')
            ->latest()
            ->paginate(20);
        return view('promotions.history', compact('logs'));
    }
}
