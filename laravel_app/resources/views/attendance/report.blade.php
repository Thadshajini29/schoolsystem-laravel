@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-file-earmark-bar-graph-fill me-2 text-primary"></i>Attendance Reports
            </h1>
            <p class="text-muted small mb-0">Review school attendance data by month and grade</p>
        </div>
        
        <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Mark Attendance
        </a>
    </div>

    <div class="card shadow mb-4 fade-in border-0">
        <div class="card-body">
            <form action="{{ route('attendance.report') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="grade_id" class="form-label small fw-bold">Select Grade</label>
                    <select name="grade_id" id="grade_id" class="form-select">
                        <option value="">All Grades</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ $selectedGradeId == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="month" class="form-label small fw-bold">Month</label>
                    <select name="month" id="month" class="form-select">
                        @for($i = 1; $i <= 12; $i++)
                            @php $m = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label small fw-bold">Year</label>
                    <input type="number" name="year" id="year" class="form-control" value="{{ $year }}">
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Fetch Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4 mb-4 fade-in">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3 h-100 bg-success bg-opacity-10">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Present</h6>
                    <h2 class="mb-0 fw-bold text-success">{{ $attendanceData->where('status', 'present')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3 h-100 bg-danger bg-opacity-10">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Absent</h6>
                    <h2 class="mb-0 fw-bold text-danger">{{ $attendanceData->where('status', 'absent')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-3 h-100 bg-info bg-opacity-10">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Average Attendance Rate</h6>
                    @php
                        $total = $attendanceData->count();
                        $present = $attendanceData->where('status', 'present')->count();
                        $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;
                    @endphp
                    <h2 class="mb-0 fw-bold text-info">{{ $rate }}%</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 fade-in">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-table me-2"></i>Attendance Log
            </h6>
        </div>
        <div class="card-body">
            @if($attendanceData->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceData->sortByDesc('date') as $entry)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($entry->date)->format('d M, Y') }}</td>
                                    <td class="fw-semibold">{{ $entry->student->student_name }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $entry->grade->grade_name }}</span></td>
                                    <td>
                                        <span class="badge {{ $entry->status == 'present' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($entry->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">No attendance data found for the selected filter.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
