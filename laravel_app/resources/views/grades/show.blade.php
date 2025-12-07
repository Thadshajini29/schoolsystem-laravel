@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-bookmark-fill me-2" style="color: {{ $grade->grade_color ?? '#4e73df' }};"></i>{{ $grade->grade_name }}
            </h1>
            <p class="text-muted small mb-0">Grade Details and Information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('grades.edit', $grade) }}" class="btn btn-warning text-white">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <a href="{{ route('grades.add_subjects', $grade) }}" class="btn btn-success">
                <i class="bi bi-book me-2"></i>Manage Subjects
            </a>
            <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow border-0 mb-4 fade-in">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-info-circle me-2"></i>Grade Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 40%;">Name:</td>
                            <td class="fw-semibold">{{ $grade->grade_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Group:</td>
                            <td>
                                <span class="badge bg-secondary">{{ $grade->grade_group ?? 'N/A' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Color:</td>
                            <td>
                                <span class="badge rounded-pill" style="background-color: {{ $grade->grade_color ?? '#4e73df' }};">
                                    {{ $grade->grade_color ?? '#4e73df' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Order:</td>
                            <td>{{ $grade->grade_order ?? '0' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td>{{ $grade->created_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Assigned Subjects Card -->
            <div class="card shadow border-0 mb-4 fade-in">
                <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="bi bi-book-fill me-2"></i>Assigned Subjects
                    </h6>
                    <span class="badge bg-success">{{ $grade->subjects->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($grade->subjects->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($grade->subjects as $subject)
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="rounded-circle me-2" 
                                          style="width: 10px; height: 10px; background-color: {{ $subject->subject_color ?? '#6c757d' }}; display: inline-block;"></span>
                                    <span class="flex-grow-1">{{ $subject->subject_name }}</span>
                                    <small class="text-muted">{{ $subject->subject_index }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-bookmark-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-3">No subjects assigned</p>
                            <a href="{{ route('grades.add_subjects', $grade) }}" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i>Add Subjects
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card shadow border-0 fade-in">
                <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-people-fill me-2"></i>Students in this Grade
                    </h6>
                    <span class="badge bg-primary">{{ $grade->students->count() }} students</span>
                </div>
                <div class="card-body p-0">
                    @if($grade->students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center py-3" style="width: 10%;">ID</th>
                                        <th class="py-3" style="width: 35%;">Student Name</th>
                                        <th class="py-3" style="width: 25%;">Admission No</th>
                                        <th class="text-center py-3" style="width: 30%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grade->students as $student)
                                        <tr>
                                            <td class="text-center fw-bold text-secondary">{{ $student->id }}</td>
                                            <td class="fw-semibold">
                                                <i class="bi bi-person-fill me-2 text-primary"></i>
                                                {{ $student->student_name }}
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">{{ $student->admission_no }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-info" title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-people fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-3">No students found in this grade</p>
                            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>Add Student
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
