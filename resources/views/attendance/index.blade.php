@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Attendance Management</h1>
            <p class="text-muted mb-0">Track and monitor daily student attendance</p>
        </div>
        <div>
            <a href="{{ route('attendance.create') }}" class="btn btn-primary shadow-sm me-2">
                <i class="bi bi-calendar-check me-1"></i> Take / Edit Roll Call
            </a>
            <a href="{{ route('attendance.report') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-file-earmark-bar-graph me-1"></i> Attendance Reports
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Toolbar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Attendance Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold">Filter by Grade</label>
                    <select name="grade_id" class="form-select">
                        <option value="">All Grades</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ $gradeId == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill me-1"></i> Apply Filter
                    </button>
                    <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Daily Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-bold">Total Marked</div>
                    <div class="h3 mb-0 fw-bold text-gray-800">{{ $stats['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-success border-4">
                <div class="card-body">
                    <div class="text-success small text-uppercase fw-bold">Present</div>
                    <div class="h3 mb-0 fw-bold text-success">{{ $stats['present'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body">
                    <div class="text-danger small text-uppercase fw-bold">Absent</div>
                    <div class="h3 mb-0 fw-bold text-danger">{{ $stats['absent'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm border-start border-warning border-4">
                <div class="card-body">
                    <div class="text-warning small text-uppercase fw-bold">Late / Excused</div>
                    <div class="h3 mb-0 fw-bold text-warning">{{ $stats['late'] + $stats['excused'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary">Attendance Records ({{ \Carbon\Carbon::parse($date)->format('M d, Y') }})</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Admission No</th>
                            <th>Student Name</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Recorded At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td class="ps-3 fw-bold">{{ $attendance->student->admission_no ?? '-' }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width:36px; height:36px;">
                                            <i class="bi bi-person text-secondary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $attendance->student->student_name ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $attendance->student->phone_no ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $attendance->grade->grade_name ?? '-' }}</span></td>
                                <td>
                                    <span class="badge {{ $attendance->status_badge }} px-3 py-2 text-uppercase">
                                        {{ $attendance->status }}
                                    </span>
                                </td>
                                <td><span class="text-muted small">{{ $attendance->remarks ?? '—' }}</span></td>
                                <td><small class="text-muted">{{ $attendance->updated_at->format('h:i A') }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
                                    No attendance recorded for this date and selection.
                                    <div class="mt-2">
                                        <a href="{{ route('attendance.create', ['date' => $date, 'grade_id' => $gradeId]) }}" class="btn btn-sm btn-primary">
                                            Take Attendance Now
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendances->hasPages())
                <div class="p-3">
                    {{ $attendances->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
