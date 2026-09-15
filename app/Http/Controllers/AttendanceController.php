<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of daily attendance with stats.
     */
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $gradeId = $request->get('grade_id');

        $grades = Grade::orderBy('grade_order')->get();

        $query = Attendance::with(['student', 'grade'])
            ->where('attendance_date', $date);

        if ($gradeId) {
            $query->where('grade_id', $gradeId);
        }

        $attendances = $query->paginate(25)->withQueryString();

        // Summary statistics for selected date/grade
        $statsQuery = Attendance::where('attendance_date', $date);
        if ($gradeId) {
            $statsQuery->where('grade_id', $gradeId);
        }

        $stats = [
            'total' => (clone $statsQuery)->count(),
            'present' => (clone $statsQuery)->where('status', 'present')->count(),
            'absent' => (clone $statsQuery)->where('status', 'absent')->count(),
            'late' => (clone $statsQuery)->where('status', 'late')->count(),
            'excused' => (clone $statsQuery)->where('status', 'excused')->count(),
        ];

        return view('attendance.index', compact('attendances', 'grades', 'date', 'gradeId', 'stats'));
    }

    /**
     * Show form to take or update roll-call attendance for a specific grade.
     */
    public function create(Request $request)
    {
        $grades = Grade::orderBy('grade_order')->get();
        $selectedGradeId = $request->get('grade_id', $grades->first()?->id);
        $date = $request->get('date', Carbon::today()->toDateString());

        $students = collect();
        $existingAttendances = collect();

        if ($selectedGradeId) {
            $students = Student::where('grade_id', $selectedGradeId)
                ->orderBy('student_name')
                ->get();

            $existingAttendances = Attendance::where('grade_id', $selectedGradeId)
                ->where('attendance_date', $date)
                ->get()
                ->keyBy('student_id');
        }

        return view('attendance.create', compact('grades', 'selectedGradeId', 'date', 'students', 'existingAttendances'));
    }

    /**
     * Store or update mass attendance records.
     */
    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'attendance_date' => 'required|date',
            'attendances' => 'required|array',
            'attendances.*.status' => 'required|in:present,absent,late,excused',
            'attendances.*.remarks' => 'nullable|string|max:255',
        ]);

        $gradeId = $request->input('grade_id');
        $date = $request->input('attendance_date');
        $attendancesData = $request->input('attendances', []);
        $userId = Auth::id();

        foreach ($attendancesData as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'attendance_date' => $date,
                ],
                [
                    'grade_id' => $gradeId,
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?? null,
                    'marked_by' => $userId,
                ]
            );
        }

        return redirect()->route('attendance.index', ['date' => $date, 'grade_id' => $gradeId])
            ->with('success', 'Attendance recorded successfully for ' . count($attendancesData) . ' students.');
    }

    /**
     * Attendance Analytics and Reports
     */
    public function report(Request $request)
    {
        $grades = Grade::orderBy('grade_order')->get();
        $selectedGradeId = $request->get('grade_id', $grades->first()?->id);
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', Carbon::now()->toDateString());

        $studentsReport = collect();

        if ($selectedGradeId) {
            $students = Student::where('grade_id', $selectedGradeId)
                ->with(['attendances' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('attendance_date', [$startDate, $endDate]);
                }])
                ->orderBy('student_name')
                ->get();

            $studentsReport = $students->map(function ($student) {
                $attendances = $student->attendances;
                $totalDays = $attendances->count();
                $presentCount = $attendances->where('status', 'present')->count();
                $absentCount = $attendances->where('status', 'absent')->count();
                $lateCount = $attendances->where('status', 'late')->count();
                $excusedCount = $attendances->where('status', 'excused')->count();

                $rate = $totalDays > 0 ? round(($presentCount + $lateCount) / $totalDays * 100, 1) : 0;

                return (object)[
                    'student' => $student,
                    'total_days' => $totalDays,
                    'present' => $presentCount,
                    'absent' => $absentCount,
                    'late' => $lateCount,
                    'excused' => $excusedCount,
                    'attendance_rate' => $rate,
                ];
            });
        }

        return view('attendance.report', compact('grades', 'selectedGradeId', 'startDate', 'endDate', 'studentsReport'));
    }
}
