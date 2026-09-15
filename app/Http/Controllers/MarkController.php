<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    /**
     * Bulk Marks Entry Grid
     */
    public function entry(Request $request)
    {
        $exams = Exam::orderBy('created_at', 'desc')->get();
        $grades = Grade::orderBy('grade_order')->get();
        $subjects = Subject::orderBy('subject_name')->get();

        $selectedExamId = $request->get('exam_id', $exams->first()?->id);
        $selectedGradeId = $request->get('grade_id', $grades->first()?->id);
        $selectedSubjectId = $request->get('subject_id', $subjects->first()?->id);

        $students = collect();
        $existingMarks = collect();

        if ($selectedGradeId && $selectedExamId && $selectedSubjectId) {
            $students = Student::where('grade_id', $selectedGradeId)
                ->orderBy('student_name')
                ->get();

            $existingMarks = Mark::where('exam_id', $selectedExamId)
                ->where('grade_id', $selectedGradeId)
                ->where('subject_id', $selectedSubjectId)
                ->get()
                ->keyBy('student_id');
        }

        return view('marks.entry', compact(
            'exams',
            'grades',
            'subjects',
            'selectedExamId',
            'selectedGradeId',
            'selectedSubjectId',
            'students',
            'existingMarks'
        ));
    }

    /**
     * Store bulk marks
     */
    public function store(Request $request)
    {
        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'total_marks' => 'required|numeric|min:1|max:1000',
            'marks' => 'required|array',
            'marks.*.marks_obtained' => 'nullable|numeric|min:0',
            'marks.*.remarks' => 'nullable|string|max:255',
        ]);

        $examId = $request->input('exam_id');
        $gradeId = $request->input('grade_id');
        $subjectId = $request->input('subject_id');
        $totalMarks = (float)$request->input('total_marks', 100);
        $marksData = $request->input('marks', []);

        $savedCount = 0;
        foreach ($marksData as $studentId => $data) {
            if (!isset($data['marks_obtained']) || $data['marks_obtained'] === '') {
                continue;
            }

            $obtained = (float)$data['marks_obtained'];
            $gradeLetter = Mark::calculateGradeLetter($obtained, $totalMarks);

            Mark::updateOrCreate(
                [
                    'exam_id' => $examId,
                    'student_id' => $studentId,
                    'subject_id' => $subjectId,
                ],
                [
                    'grade_id' => $gradeId,
                    'marks_obtained' => $obtained,
                    'total_marks' => $totalMarks,
                    'grade_letter' => $gradeLetter,
                    'remarks' => $data['remarks'] ?? null,
                ]
            );
            $savedCount++;
        }

        return redirect()->route('marks.entry', [
            'exam_id' => $examId,
            'grade_id' => $gradeId,
            'subject_id' => $subjectId,
        ])->with('success', "Marks saved successfully for {$savedCount} students.");
    }

    /**
     * Official Student Report Card
     */
    public function reportCard(Student $student, Exam $exam)
    {
        $student->load(['grade']);
        
        $marks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->get();

        $totalObtained = $marks->sum('marks_obtained');
        $totalMax = $marks->sum('total_marks');
        $overallPercentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 1) : 0;
        $overallGrade = Mark::calculateGradeLetter($totalObtained, $totalMax);

        return view('marks.report_card', compact(
            'student',
            'exam',
            'marks',
            'totalObtained',
            'totalMax',
            'overallPercentage',
            'overallGrade'
        ));
    }
}
