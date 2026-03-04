<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $grades = Grade::all();
        $subjects = Subject::all();
        $selectedGrade = null;
        $selectedSubject = null;
        $examType = $request->get('exam_type', 'Term Test');
        $students = collect();

        if ($request->has('grade_id') && $request->has('subject_id')) {
            $selectedGrade = Grade::findOrFail($request->grade_id);
            $selectedSubject = Subject::findOrFail($request->subject_id);
            $students = $selectedGrade->students;
        }

        return view('marks.index', compact('grades', 'subjects', 'selectedGrade', 'selectedSubject', 'examType', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|string',
            'marks' => 'required|array',
            'marks.*.total' => 'required|integer',
            'marks.*.obtained' => 'required|integer|lte:marks.*.total',
        ]);

        foreach ($request->marks as $studentId => $markData) {
            Mark::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'exam_type' => $request->exam_type,
                ],
                [
                    'total_marks' => $markData['total'],
                    'obtained_marks' => $markData['obtained'],
                ]
            );
        }

        return redirect()->back()->with('success', 'Marks saved successfully.');
    }

    public function report(Request $request, Student $student)
    {
        $marks = Mark::with('subject')->where('student_id', $student->id)->get();
        return view('marks.report_card', compact('student', 'marks'));
    }
}
