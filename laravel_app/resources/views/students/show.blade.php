@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2>Student Details</h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($student->file_path)
                        <img src="{{ asset('storage/' . $student->file_path) }}" alt="Student Image" class="img-fluid rounded-circle mb-3" style="max-width: 150px;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                            <span>No Image</span>
                        </div>
                    @endif
                    <h4>{{ $student->student_name }}</h4>
                    <p class="text-muted">{{ $student->grade->grade_name }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    Personal Information
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Admission No:</div>
                        <div class="col-sm-8">{{ $student->admission_no }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Father Name:</div>
                        <div class="col-sm-8">{{ $student->father_name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">NIC Number:</div>
                        <div class="col-sm-8">{{ $student->nic_num }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Birth Date:</div>
                        <div class="col-sm-8">{{ $student->birth_date }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Gender:</div>
                        <div class="col-sm-8">{{ $student->gender }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Phone No:</div>
                        <div class="col-sm-8">{{ $student->phone_no }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Address:</div>
                        <div class="col-sm-8">{{ $student->address }}</div>
                    </div>
                    @if($student->original_name)
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">Original File Name:</div>
                        <div class="col-sm-8">{{ $student->original_name }}</div>
                    </div>
                    @endif
                    @if($student->file_size)
                    <div class="row mb-2">
                        <div class="col-sm-4 fw-bold">File Size:</div>
                        <div class="col-sm-8">{{ number_format($student->file_size / 1024, 2) }} KB</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Enrolled Subjects</span>
                    <a href="{{ route('students.add_subjects', $student) }}" class="btn btn-sm btn-primary">Manage Subjects</a>
                </div>
                <div class="card-body">
                    @if($student->subjects->count() > 0)
                        <ul class="list-group">
                            @foreach($student->subjects as $subject)
                                <li class="list-group-item">{{ $subject->subject_name }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No subjects enrolled.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
