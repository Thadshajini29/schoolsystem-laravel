@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Grade Details</h2>
        <a href="{{ route('grades.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Grade Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Grade Name:</strong> {{ $grade->grade_name }}</p>
                    <p><strong>Grade Group:</strong> {{ $grade->grade_group }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Grade Order:</strong> {{ $grade->grade_order }}</p>
                    <p><strong>Grade Color:</strong> <span class="badge" style="background-color: {{ $grade->grade_color }};">{{ $grade->grade_color }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Students in this Grade
        </div>
        <div class="card-body">
            @if($grade->students->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Admission No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grade->students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->student_name }}</td>
                                <td>{{ $student->admission_no }}</td>
                                <td>
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info text-white">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No students found in this grade.</p>
            @endif
        </div>
    </div>
@endsection
