<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $grades = Grade::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();
        $selectedGrade = null;
        $timetableData = [];

        if ($request->has('grade_id')) {
            $selectedGrade = Grade::findOrFail($request->grade_id);
            $entries = Timetable::with(['subject', 'teacher'])
                ->where('grade_id', $selectedGrade->id)
                ->get();

            // Structure data by day
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                $timetableData[$day] = $entries->where('day', $day)->sortBy('time_start');
            }
        }

        return view('timetables.index', compact('grades', 'teachers', 'subjects', 'selectedGrade', 'timetableData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|string',
            'time_start' => 'required',
            'time_end' => 'required|after:time_start',
        ]);

        Timetable::create($request->all());

        return redirect()->back()->with('success', 'Schedule entry added successfully.');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return redirect()->back()->with('success', 'Schedule entry removed.');
    }
}
