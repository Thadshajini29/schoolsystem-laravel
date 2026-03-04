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
            <form action="{{ route('attendance.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="grade_id" class="form-label small fw-bold">Select Grade</label>
                    <select name="grade_id" id="grade_id" class="form-select" onchange="this.form.submit()">
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
                    <input type="date" name="date" id="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
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
                <div class="small text-muted">{{ \Carbon\Carbon::parse($date)->format('d M, Y') }}</div>
            </div>
            <div class="card-body">
                @if($students->count() > 0)
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="grade_id" value="{{ $selectedGrade->id }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 10%;">Admission No</th>
                                        <th style="width: 50%;">Student Name</th>
                                        <th class="text-center" style="width: 40%;">Attendance Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        @php
                                            $attendance = \App\Models\Attendance::where('student_id', $student->id)->whereDate('date', $date)->first();
                                            $status = $attendance ? $attendance->status : 'present';
                                        @endphp
                                        <tr>
                                            <td class="text-center"><span class="badge bg-secondary">{{ $student->admission_no }}</span></td>
                                            <td class="fw-semibold">{{ $student->student_name }}</td>
                                            <td class="text-center">
                                                <div class="btn-group w-100" role="group">
                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="present_{{ $student->id }}" value="present" {{ $status == 'present' ? 'checked' : '' }} autocomplete="off">
                                                    <label class="btn btn-outline-success btn-sm w-50" for="present_{{ $presentId = 'present_' . $student->id }}">Present</label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" id="absent_{{ $student->id }}" value="absent" {{ $status == 'absent' ? 'checked' : '' }} autocomplete="off">
                                                    <label class="btn btn-outline-danger btn-sm w-50" for="absent_{{ $absentId = 'absent_' . $student->id }}">Absent</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">
                                <i class="bi bi-save me-2"></i>Save Final Attendance
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-person-x fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No students found in this grade.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-5 fade-in">
            <i class="bi bi-info-circle-fill fs-2 text-primary opacity-25"></i>
            <p class="text-muted mt-2">Please select a grade and date to mark attendance.</p>
        </div>
    @endif
@endsection
