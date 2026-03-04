@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-file-earmark-person-fill me-2 text-primary"></i>Student Report Card
            </h1>
            <p class="text-muted small mb-0">Academic performance and summary for {{ $student->student_name }}</p>
        </div>
        
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark no-print">
                <i class="bi bi-printer-fill me-2"></i>Print Report
            </button>
            <a href="{{ route('students.show', $student) }}" class="btn btn-outline-secondary no-print">
                <i class="bi bi-arrow-left me-2"></i>Back to Profile
            </a>
        </div>
    </div>

    <div class="card shadow border-0 mb-4 fade-in">
        <div class="card-body p-5">
            <div class="row mb-5 border-bottom pb-4">
                <div class="col-md-6">
                    <h2 class="fw-bold text-primary mb-3">School Management System</h2>
                    <h5 class="text-muted mb-4">Official Academic Transcript</h5>
                    <div class="student-info">
                        <p class="mb-1"><span class="text-muted me-2">Full Name:</span> <strong>{{ $student->student_name }}</strong></p>
                        <p class="mb-1"><span class="text-muted me-2">Admission No:</span> <strong>{{ $student->admission_no }}</strong></p>
                        <p class="mb-1"><span class="text-muted me-2">Grade:</span> <strong>{{ $student->grade->grade_name }}</strong></p>
                    </div>
                </div>
                <div class="col-md-6 text-md-end">
                    <img src="/storage/{{ $student->file_path }}" alt="Photo" class="rounded border mb-3" width="100" height="100" style="object-fit:cover" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($student->student_name) }}&background=random';">
                    <p class="text-muted small">Generated on: {{ now()->format('d M, Y H:i') }}</p>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center bg-light">
                        <h6 class="text-muted mb-2 small text-uppercase fw-bold">Attendance Share</h6>
                        @php
                            $attCount = \App\Models\Attendance::where('student_id', $student->id)->count();
                            $presentCount = \App\Models\Attendance::where('student_id', $student->id)->where('status', 'present')->count();
                            $attRate = $attCount > 0 ? round(($presentCount / $attCount) * 100, 1) : 0;
                        @endphp
                        <h3 class="mb-0 fw-bold {{ $attRate < 75 ? 'text-danger' : 'text-success' }}">{{ $attRate }}%</h3>
                        @if($attRate < 75)
                            <small class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Below 75% Warning!</small>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center bg-light">
                        <h6 class="text-muted mb-2 small text-uppercase fw-bold">Overall Average</h6>
                        @php
                            $total_marks = $marks->sum('total_marks');
                            $obtained_marks = $marks->sum('obtained_marks');
                            $avg = $total_marks > 0 ? round(($obtained_marks / $total_marks) * 100, 1) : 0;
                        @endphp
                        <h3 class="mb-0 fw-bold text-primary">{{ $avg }}%</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded text-center bg-light">
                        <h6 class="text-muted mb-2 small text-uppercase fw-bold">Promotion Status</h6>
                        <h3 class="mb-0 fw-bold {{ $avg >= 40 ? 'text-success' : 'text-danger' }}">
                            {{ $avg >= 40 ? 'ELIGIBLE' : 'INELIGIBLE' }}
                        </h3>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3"><i class="bi bi-clipboard2-check me-2"></i>Examination Summary</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Subject</th>
                            <th>Exam Type</th>
                            <th class="text-center">Min. Pass</th>
                            <th class="text-center">Total Marks</th>
                            <th class="text-center">Obtained</th>
                            <th class="text-center">Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marks as $mark)
                            <tr>
                                <td class="fw-semibold">{{ $mark->subject->subject_name }}</td>
                                <td class="small">{{ $mark->exam_type }}</td>
                                <td class="text-center">35</td>
                                <td class="text-center">{{ $mark->total_marks }}</td>
                                <td class="text-center fw-bold">{{ $mark->obtained_marks }}</td>
                                <td class="text-center">
                                    @php $p = ($mark->obtained_marks / $mark->total_marks) * 100; @endphp
                                    @if($p >= 35)
                                        <span class="text-success fw-bold">PASS</span>
                                    @else
                                        <span class="text-danger fw-bold">FAIL</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No examination data available for this student.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($marks->count() > 0)
                        <tfoot class="bg-light table-group-divider">
                            <tr>
                                <th colspan="3" class="text-end">OVERALL TOTAL:</th>
                                <th class="text-center">{{ $total_marks }}</th>
                                <th class="text-center">{{ $obtained_marks }}</th>
                                <th class="text-center">{{ $avg }}%</th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <div class="mt-5 row">
                <div class="col-6">
                    <div style="width: 200px; border-bottom: 2px solid #ddd; margin-bottom: 10px;"></div>
                    <p class="text-muted small">Class Teacher Signature</p>
                </div>
                <div class="col-6 text-end">
                    <div style="width: 200px; border-bottom: 2px solid #ddd; margin-bottom: 10px; margin-left: auto;"></div>
                    <p class="text-muted small">Principal Signature</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            .card { box-shadow: none !important; border: 1px solid #eee !important; }
            body { background: white !important; }
            .sidebar { display: none !important; }
            .main-content { margin-left: 0 !important; }
            .topbar { display: none !important; }
            .content-wrapper { padding: 0 !important; }
        }
    </style>
@endsection
