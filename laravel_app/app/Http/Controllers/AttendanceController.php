<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $grades = Grade::all();
        $selectedGrade = null;
        $students = collect();
        $date = $request->get('date', now()->format('Y-m-d'));

        if ($request->filled('grade_id')) {
            $selectedGrade = Grade::findOrFail($request->grade_id);
            $students = Student::where('grade_id', $selectedGrade->id)->get();
            
            // Load existing attendance for these students on this date
            $existingAttendance = Attendance::where('grade_id', $selectedGrade->id)
                ->where('date', $date)
                ->pluck('status', 'student_id')
                ->toArray();

            foreach ($students as $student) {
                $student->current_status = $existingAttendance[$student->id] ?? null;
            }
        }

        return view('attendance.index', compact('grades', 'selectedGrade', 'students', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late',
        ]);

        $gradeId = $request->grade_id;
        $date = $request->date;

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $date,
                ],
                [
                    'grade_id' => $gradeId,
                    'status' => $status,
                ]
            );
        }

        if ($request->ajax()) {
            return response()->json(['success' => 'Attendance updated successfully!']);
        }

        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }

    public function report(Request $request)
    {
        // Admin report view
        $grades = Grade::all();
        $selectedGradeId = $request->get('grade_id');
        $month = $request->get('month', now()->format('m'));
        $year = $request->get('year', now()->format('Y'));

        $query = Attendance::whereMonth('date', $month)->whereYear('date', $year);
        if ($selectedGradeId) {
            $query->where('grade_id', $selectedGradeId);
        }

        $attendanceData = $query->get();

        return view('attendance.report', compact('grades', 'attendanceData', 'month', 'year', 'selectedGradeId'));
    }
}
