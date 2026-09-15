@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Daily Roll Call</h1>
            <p class="text-muted mb-0">Record and update student attendance</p>
        </div>
        <div>
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Attendance
            </a>
        </div>
    </div>

    <!-- Selection Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.create') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Select Grade / Class</label>
                    <select name="grade_id" class="form-select" onchange="this.form.submit()">
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ $selectedGradeId == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Attendance Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-repeat me-1"></i> Load Sheet
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($students->isNotEmpty())
        <form method="POST" action="{{ route('attendance.store') }}">
            @csrf
            <input type="hidden" name="grade_id" value="{{ $selectedGradeId }}">
            <input type="hidden" name="attendance_date" value="{{ $date }}">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="m-0 fw-bold text-primary">
                            Students in {{ $grades->firstWhere('id', $selectedGradeId)?->grade_name }} ({{ $students->count() }})
                        </h6>
                    </div>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-success" onclick="markAll('present')">
                            <i class="bi bi-check-all me-1"></i> Mark All Present
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="markAll('absent')">
                            Mark All Absent
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th style="min-width: 320px;">Attendance Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    @php
                                        $currentStatus = $existingAttendances->get($student->id)?->status ?? 'present';
                                        $currentRemark = $existingAttendances->get($student->id)?->remarks ?? '';
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $student->admission_no }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $student->student_name }}</div>
                                            <small class="text-muted">{{ $student->phone_no }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group w-100 status-group" role="group">
                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="p_{{ $student->id }}" value="present" {{ $currentStatus == 'present' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-success btn-sm" for="p_{{ $student->id }}">Present</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="a_{{ $student->id }}" value="absent" {{ $currentStatus == 'absent' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-danger btn-sm" for="a_{{ $student->id }}">Absent</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="l_{{ $student->id }}" value="late" {{ $currentStatus == 'late' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-warning btn-sm" for="l_{{ $student->id }}">Late</label>

                                                <input type="radio" class="btn-check" name="attendances[{{ $student->id }}][status]" id="e_{{ $student->id }}" value="excused" {{ $currentStatus == 'excused' ? 'checked' : '' }}>
                                                <label class="btn btn-outline-info btn-sm" for="e_{{ $student->id }}">Excused</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" name="attendances[{{ $student->id }}][remarks]" class="form-control form-control-sm" placeholder="Optional note..." value="{{ $currentRemark }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Ensure all selections are accurate before submitting.</span>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save me-1"></i> Save Attendance Records
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="card shadow-sm p-5 text-center text-muted">
            <i class="bi bi-people fs-1 text-secondary mb-3"></i>
            <h5>No students found in this grade</h5>
            <p>Add students to this grade first before recording attendance.</p>
            <div>
                <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Add New Student</a>
            </div>
        </div>
    @endif
</div>

<script>
function markAll(status) {
    document.querySelectorAll(`input[type="radio"][value="${status}"]`).forEach(radio => {
        radio.checked = true;
    });
}
</script>
@endsection
