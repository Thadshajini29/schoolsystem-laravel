<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with('grade');

        // Search by Name
        if ($request->filled('search')) {
            $query->where('student_name', 'like', '%' . $request->search . '%');
        }

        // Filter by Grade
        if ($request->filled('grade_id')) {
            $query->where('grade_id', $request->grade_id);
        }

        // Filter by Gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $students = $query->orderBy('student_name')
            ->paginate(15)
            ->withQueryString();

        $grades = Grade::all();
        
        return view('students.index', compact('students', 'grades'));
    }

    public function create()
    {
        $grades = Grade::all();
        return view('students.create', compact('grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'admission_no' => 'required|unique:students,admission_no|max:255',
            'grade_id' => 'required|exists:grades,id',
            'nic_num' => 'nullable|unique:students,nic_num|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'phone_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'admission_date' => 'nullable|date',
            'academic_year' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('students', 'public');
            $data['file_path'] = $path;
            $data['original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['grade', 'subjects']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $grades = Grade::all();
        return view('students.edit', compact('student', 'grades'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'admission_no' => 'required|max:255|unique:students,admission_no,' . $student->id,
            'grade_id' => 'required|exists:grades,id',
            'nic_num' => 'nullable|max:20|unique:students,nic_num,' . $student->id,
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'phone_no' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'admission_date' => 'nullable|date',
            'academic_year' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($student->file_path) {
                Storage::disk('public')->delete($student->file_path);
            }

            $file = $request->file('image');
            $path = $file->store('students', 'public');
            $data['file_path'] = $path;
            $data['original_name'] = $file->getClientOriginalName();
            $data['file_size'] = $file->getSize();
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->file_path) {
            Storage::disk('public')->delete($student->file_path);
        }
        
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function addSubjects(Student $student)
    {
        $subjects = Subject::all();
        return view('students.add_subjects', compact('student', 'subjects'));
    }

    public function storeSubjects(Request $request, Student $student)
    {
        $request->validate([
            'subjects' => 'array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $student->subjects()->sync($request->subjects);

        return redirect()->route('students.show', $student)->with('success', 'Subjects updated successfully.');
    }

    public function idCard(Student $student)
    {
        return view('students.id_card', compact('student'));
    }
}
