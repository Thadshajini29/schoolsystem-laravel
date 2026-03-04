@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-5 fw-bold text-primary">Welcome to School Management System</h1>
                <p class="text-muted">Manage your school efficiently with our comprehensive system</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Students</h6>
                                <h2 class="mb-0 fw-bold text-primary">{{ \App\Models\Student::count() }}</h2>
                            </div>
                            <div class="stat-icon bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people-fill text-primary fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Teachers</h6>
                                <h2 class="mb-0 fw-bold text-success">{{ \App\Models\Teacher::count() }}</h2>
                            </div>
                            <div class="stat-icon bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-person-workspace text-success fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Subjects</h6>
                                <h2 class="mb-0 fw-bold text-info">{{ \App\Models\Subject::count() }}</h2>
                            </div>
                            <div class="stat-icon bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-book-fill text-info fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Today Attendance</h6>
                                <h2 class="mb-0 fw-bold text-warning">
                                    {{ \App\Models\Attendance::whereDate('date', now())->where('status', 'present')->count() }}
                                </h2>
                            </div>
                            <div class="stat-icon bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-calendar-check-fill text-warning fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('students.create') }}" class="btn btn-primary w-100 py-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-plus-fill me-2 fs-5"></i>
                                    <span class="fw-semibold">Add New Student</span>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('grades.create') }}" class="btn btn-success w-100 py-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-bookmark-plus-fill me-2 fs-5"></i>
                                    <span class="fw-semibold">Add New Grade</span>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('subjects.create') }}" class="btn btn-info w-100 py-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-book-half me-2 fs-5"></i>
                                    <span class="fw-semibold">Add New Subject</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Activity -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Recent Students</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $recentStudents = \App\Models\Student::with('grade')->latest()->take(5)->get();
                        @endphp
                        @if($recentStudents->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentStudents as $student)
                                    <a href="{{ route('students.show', $student) }}" class="list-group-item list-group-item-action border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            @if($student->file_path)
                                                <img src="/storage/{{ $student->file_path }}" alt="{{ $student->student_name }}" class="rounded-circle me-3" width="40" height="40">
                                            @else
                                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $student->student_name }}</h6>
                                                <small class="text-muted">{{ $student->grade->grade_name }} - {{ $student->admission_no }}</small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-4">No students added yet</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">System Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Logged in as:</span>
                                <span class="fw-semibold">{{ auth()->user()->user_name }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Role:</span>
                                <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">Email:</span>
                                <span class="fw-semibold">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Welcome!</strong> You can manage students, grades, and subjects from the sidebar menu.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
