<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::paginate(15);
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:teachers,email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('teachers', 'public');
        }

        Teacher::create($data);

        if ($request->ajax()) {
            return response()->json(['success' => 'Teacher added successfully.']);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['subjects', 'grades']);
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($teacher->image_path) {
                \Storage::disk('public')->delete($teacher->image_path);
            }
            $data['image_path'] = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update($data);

        if ($request->ajax()) {
            return response()->json(['success' => 'Teacher updated successfully.']);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function assignSubjects(Teacher $teacher)
    {
        $grades = Grade::with('subjects')->get();
        $assigned = \DB::table('grade_subject_teacher')
            ->where('teacher_id', $teacher->id)
            ->get()
            ->map(function($item) {
                return $item->grade_id . '-' . $item->subject_id;
            })->toArray();

        return view('teachers.assign_subjects', compact('teacher', 'grades', 'assigned'));
    }

    public function storeSubjects(Request $request, Teacher $teacher)
    {
        $request->validate([
            'assignments' => 'nullable|array',
        ]);

        \DB::table('grade_subject_teacher')->where('teacher_id', $teacher->id)->delete();

        if ($request->has('assignments')) {
            foreach ($request->assignments as $assignment) {
                [$gradeId, $subjectId] = explode('-', $assignment);
                \DB::table('grade_subject_teacher')->insert([
                    'teacher_id' => $teacher->id,
                    'grade_id' => $gradeId,
                    'subject_id' => $subjectId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('teachers.index')->with('success', 'Subjects assigned successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->image_path) {
            \Storage::disk('public')->delete($teacher->image_path);
        }
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
