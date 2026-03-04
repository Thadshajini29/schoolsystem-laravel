@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Student Details</h1>
        <a href="{{ route('students.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5">
                    @if($student->file_path)
                        <img src="/storage/{{ $student->file_path }}" 
                             alt="Student Image" 
                             class="img-fluid rounded-circle mb-4 shadow-sm" 
                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($student->student_name) }}&background=random';"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow-sm" style="width: 150px; height: 150px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                            <i class="bi bi-person-fill display-1"></i>
                        </div>
                    @endif
                    <h3 class="font-weight-bold text-dark mb-1">{{ $student->student_name }}</h3>
                    <p class="text-primary mb-3">{{ $student->grade->grade_name }}</p>
                    <div class="d-flex flex-column gap-2 mt-4 px-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-warning text-white btn-sm flex-fill">
                                <i class="bi bi-pencil-fill me-1"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}">
                                <i class="bi bi-trash-fill me-1"></i> Delete
                            </button>
                        </div>
                        <a href="{{ route('students.id_card', $student) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-card-image me-1"></i> Generate ID Card
                        </a>
                        <a href="{{ route('marks.report', $student) }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-file-earmark-person me-1"></i> View Report Card
                        </a>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-start">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $student->id }}">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete student <strong>{{ $student->student_name }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Admission No</div>
                        <div class="col-sm-8 text-dark">{{ $student->admission_no }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Father Name</div>
                        <div class="col-sm-8 text-dark">{{ $student->father_name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">NIC Number</div>
                        <div class="col-sm-8 text-dark">{{ $student->nic_num ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Birth Date</div>
                        <div class="col-sm-8 text-dark">{{ $student->birth_date ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Gender</div>
                        <div class="col-sm-8 text-dark">{{ $student->gender ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Admission Date</div>
                        <div class="col-sm-8 text-dark">{{ $student->admission_date ? \Carbon\Carbon::parse($student->admission_date)->format('d M, Y') : 'N/A' }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Academic Year</div>
                        <div class="col-sm-8 text-dark">{{ $student->academic_year ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Phone No</div>
                        <div class="col-sm-8 text-dark">{{ $student->phone_no ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Address</div>
                        <div class="col-sm-8 text-dark">{{ $student->address ?? 'N/A' }}</div>
                    </div>
                    @if($student->original_name)
                    <div class="row mb-3 border-bottom pb-2">
                        <div class="col-sm-4 fw-bold text-secondary">Original File Name</div>
                        <div class="col-sm-8 text-dark">{{ $student->original_name }}</div>
                    </div>
                    @endif
                    @if($student->file_size)
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold text-secondary">File Size</div>
                        <div class="col-sm-8 text-dark">{{ number_format($student->file_size / 1024, 2) }} KB</div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Enrolled Subjects</h6>
                    <a href="{{ route('students.add_subjects', $student) }}" class="btn btn-sm btn-primary shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Manage Subjects
                    </a>
                </div>
                <div class="card-body">
                    @if($student->subjects->count() > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($student->subjects as $subject)
                                <span class="badge bg-info text-white p-2 fs-6">
                                    <i class="bi bi-book me-1"></i> {{ $subject->subject_name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                            No subjects enrolled yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
