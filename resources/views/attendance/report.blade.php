@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Attendance Analytics & Reports</h1>
            <p class="text-muted mb-0">Review student attendance rates across custom date intervals</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-outline-secondary me-2">
                <i class="bi bi-printer me-1"></i> Print Report
            </button>
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-calendar-date me-1"></i> Daily View
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card shadow-sm mb-4 d-print-none">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.report') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Grade / Class</label>
                    <select name="grade_id" class="form-select">
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ $selectedGradeId == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">From Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">To Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Generate
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">
                    Attendance Summary: {{ $grades->firstWhere('id', $selectedGradeId)?->grade_name }} 
                    <span class="text-muted fw-normal">({{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }})</span>
                </h6>
                <span class="badge bg-light text-dark border">{{ $studentsReport->count() }} Students</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Admission No</th>
                            <th>Student Name</th>
                            <th class="text-center">Total Sessions</th>
                            <th class="text-center text-success">Present</th>
                            <th class="text-center text-danger">Absent</th>
                            <th class="text-center text-warning">Late</th>
                            <th class="text-center text-info">Excused</th>
                            <th class="pe-3" style="width: 220px;">Attendance Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($studentsReport as $index => $row)
                            <tr>
                                <td class="ps-3">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $row->student->admission_no }}</td>
                                <td>
                                    <div class="fw-bold">{{ $row->student->student_name }}</div>
                                    <small class="text-muted">{{ $row->student->phone_no ?? '' }}</small>
                                </td>
                                <td class="text-center fw-bold">{{ $row->total_days }}</td>
                                <td class="text-center text-success fw-bold">{{ $row->present }}</td>
                                <td class="text-center text-danger fw-bold">{{ $row->absent }}</td>
                                <td class="text-center text-warning fw-bold">{{ $row->late }}</td>
                                <td class="text-center text-info fw-bold">{{ $row->excused }}</td>
                                <td class="pe-3">
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar {{ $row->attendance_rate >= 80 ? 'bg-success' : ($row->attendance_rate >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $row->attendance_rate }}%">
                                            </div>
                                        </div>
                                        <span class="small fw-bold">{{ $row->attendance_rate }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    No records found for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
