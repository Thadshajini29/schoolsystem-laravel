@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Students</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Student Name</th>
                        <th>Admission No</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>
                                @if($student->file_path)
                                    <img src="{{ asset('storage/' . $student->file_path) }}" alt="Student Image" width="50" height="50" class="rounded-circle">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->admission_no }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->phone_no }}</td>
                            <td>{{ $student->grade->grade_name }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info text-white">View</a>
                                <a href="{{ route('students.add_subjects', $student) }}" class="btn btn-sm btn-success">Add Subject</a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $students->links() }}
            </div>
        </div>
    </div>
@endsection
