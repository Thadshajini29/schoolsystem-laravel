@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-person-badge me-2 text-primary"></i>Teacher Details
            </h1>
            <p class="text-muted small mb-0">Full profile and assigned subjects</p>
        </div>
        
        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row fade-in">
        <div class="col-md-4">
            <div class="card shadow border-0 text-center p-4 mb-4">
                <div class="mb-3">
                    <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}" class="rounded-circle shadow-sm border p-1" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h4 class="fw-bold mb-1">{{ $teacher->name }}</h4>
                <p class="text-muted mb-3">ID: #{{ $teacher->id }}</p>
                
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $teacher->email }}" class="btn btn-light">
                        <i class="bi bi-envelope me-2"></i>{{ $teacher->email }}
                    </a>
                    <a href="tel:{{ $teacher->phone }}" class="btn btn-light">
                        <i class="bi bi-telephone me-2"></i>{{ $teacher->phone ?? 'N/A' }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-journal-text me-2"></i>Assigned Subjects & Grades
                    </h6>
                    <a href="{{ route('teachers.assign_subjects', $teacher) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-pencil-square me-1"></i>Manage
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Grade</th>
                                    <th>Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $assignments = \DB::table('grade_subject_teacher')
                                        ->join('grades', 'grade_subject_teacher.grade_id', '=', 'grades.id')
                                        ->join('subjects', 'grade_subject_teacher.subject_id', '=', 'subjects.id')
                                        ->where('teacher_id', $teacher->id)
                                        ->select('grades.grade_name', 'subjects.subject_name')
                                        ->get();
                                @endphp
                                @forelse($assignments as $assignment)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $assignment->grade_name }}</td>
                                        <td>{{ $assignment->subject_name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted">
                                            No subjects assigned yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
