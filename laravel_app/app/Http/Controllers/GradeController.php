<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::orderBy('grade_order')->paginate(15);
        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        return view('grades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_name' => 'required|unique:grades,grade_name',
            'grade_group' => 'nullable|string',
            'grade_color' => 'nullable|string',
            'grade_order' => 'nullable|integer',
        ]);

        Grade::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade created successfully.');
    }

    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        return view('grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'grade_name' => 'required|unique:grades,grade_name,' . $grade->id,
            'grade_group' => 'nullable|string',
            'grade_color' => 'nullable|string',
            'grade_order' => 'nullable|integer',
        ]);

        $grade->update($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }

    public function addSubjects(Grade $grade)
    {
        $subjects = \App\Models\Subject::all();
        return view('grades.add_subjects', compact('grade', 'subjects'));
    }

    public function storeSubjects(Request $request, Grade $grade)
    {
        $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $grade->subjects()->sync($request->subjects);

        return redirect()->route('grades.show', $grade)->with('success', 'Subjects updated successfully.');
    }
}
