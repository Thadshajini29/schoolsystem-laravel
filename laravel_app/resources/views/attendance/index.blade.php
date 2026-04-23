@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-calendar-check-fill me-2 text-primary"></i>Mark Attendance
            </h1>
            <p class="text-muted small mb-0">Record daily student attendance for grades</p>
        </div>
        
        <a href="{{ route('attendance.report') }}" class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Attendance Report
        </a>
    </div>

    <div class="card shadow mb-4 fade-in border-0">
        <div class="card-body">
            <form action="{{ route('attendance.index') }}" method="GET" id="attendanceFilterForm" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="grade_id" class="form-label small fw-bold">Select Grade</label>
                    <select name="grade_id" id="grade_id" class="form-select border-primary" onchange="this.form.submit()">
                        <option value="">Choose Grade...</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="date" class="form-label small fw-bold">Select Date</label>
                    <input type="date" name="date" id="date" class="form-control border-primary" value="{{ $date }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Load
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedGrade)
        <div class="card shadow border-0 fade-in">
            <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-list-check me-2"></i>Students of {{ $selectedGrade->grade_name }} ({{ count($students) }})
                </h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="bulkMark('present')">Mark All Present</button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="bulkMark('absent')">Mark All Absent</button>
                    <span class="badge bg-light text-muted border py-2 px-3">{{ \Carbon\Carbon::parse($date)->format('d M, Y') }}</span>
                </div>
            </div>
            <div class="card-body p-0">
                @if($students->count() > 0)
                    <form action="{{ route('attendance.store') }}" method="POST" id="attendanceForm">
                        @csrf
                        <input type="hidden" name="grade_id" value="{{ $selectedGrade->id }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 15%;">Admission No</th>
                                        <th style="width: 40%;">Student Name</th>
                                        <th class="text-center" style="width: 45%;">Attendance Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        @php
                                            $status = $student->current_status ?? 'present';
                                        @endphp
                                        <tr>
                                            <td class="ps-4"><span class="badge bg-secondary-soft text-secondary border">{{ $student->admission_no }}</span></td>
                                            <td class="fw-semibold text-dark">{{ $student->student_name }}</td>
                                            <td class="text-center">
                                                <div class="btn-group w-75 shadow-sm" role="group">
                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="present_{{ $student->id }}" value="present" {{ $status == 'present' ? 'checked' : '' }} autocomplete="off">
                                                    <label class="btn btn-outline-success btn-sm py-2" for="present_{{ $student->id }}">
                                                        <i class="bi bi-check-circle me-1"></i>Present
                                                    </label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="absent_{{ $student->id }}" value="absent" {{ $status == 'absent' ? 'checked' : '' }} autocomplete="off">
                                                    <label class="btn btn-outline-danger btn-sm py-2" for="absent_{{ $student->id }}">
                                                        <i class="bi bi-x-circle me-1"></i>Absent
                                                    </label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="late_{{ $student->id }}" value="late" {{ $status == 'late' ? 'checked' : '' }} autocomplete="off">
                                                    <label class="btn btn-outline-warning btn-sm py-2" for="late_{{ $student->id }}">
                                                        <i class="bi bi-clock me-1"></i>Late
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-4 bg-light border-top d-flex justify-content-between align-items-center">
                            <p class="text-muted small mb-0">
                                <i class="bi bi-info-circle me-1"></i>Marking attendance automatically saves using AJAX.
                            </p>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm" id="saveBtn">
                                <i class="bi bi-cloud-check me-2"></i>Final Save
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-person-x fs-1 text-muted opacity-25"></i>
                        <p class="text-muted mt-2 h5">No students found in this grade.</p>
                        <a href="{{ route('students.index') }}" class="btn btn-link">Manage Students</a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-5 fade-in bg-white rounded shadow-sm border">
            <i class="bi bi-calendar-event fs-1 text-primary opacity-25"></i>
            <p class="text-muted mt-3 h5">Please select a grade and date to begin.</p>
        </div>
    @endif

    <style>
        .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
        .btn-check:checked + .btn-outline-success { background-color: #198754; color: white; }
        .btn-check:checked + .btn-outline-danger { background-color: #dc3545; color: white; }
        .btn-check:checked + .btn-outline-warning { background-color: #ffc107; color: #000; }
    </style>
@endsection

@push('scripts')
<script>
    function bulkMark(status) {
        $(`.btn-check[value="${status}"]`).prop('checked', true);
        // Optional: trigger AJAX save for all after bulk marking
        saveAttendance();
    }

    // Auto-save on radio change
    $(document).on('change', '.btn-check', function() {
        saveAttendance();
    });

    function saveAttendance() {
        const form = $('#attendanceForm');
        const saveBtn = $('#saveBtn');
        const originalBtnHtml = saveBtn.html();

        saveBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Saving...').prop('disabled', true);

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                showNotification(response.success, 'success');
                saveBtn.html(originalBtnHtml).prop('disabled', false);
            },
            error: function(xhr) {
                showNotification('Error saving attendance.', 'danger');
                saveBtn.html(originalBtnHtml).prop('disabled', false);
            }
        });
    }

    $('#attendanceForm').on('submit', function(e) {
        e.preventDefault();
        saveAttendance();
    });
</script>
@endpush
