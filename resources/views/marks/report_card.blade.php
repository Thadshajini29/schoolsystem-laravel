@extends('layouts.app')

@section('content')
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <a href="{{ route('marks.entry', ['exam_id' => $exam->id, 'grade_id' => $student->grade_id]) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to Marks Entry
        </a>
        <button onclick="window.print()" class="btn btn-primary shadow-sm">
            <i class="bi bi-printer-fill me-1"></i> Print / Download PDF
        </button>
    </div>

    <!-- Official Report Card Sheet -->
    <div class="card shadow-sm border-0 report-sheet p-4 p-md-5">
        <!-- School Header -->
        <div class="text-center border-bottom pb-4 mb-4">
            <div class="d-flex justify-content-center align-items-center mb-2">
                <i class="bi bi-mortarboard-fill text-primary fs-1 me-3"></i>
                <div>
                    <h2 class="fw-bold mb-0 text-dark">SPRINGFIELD ACADEMY</h2>
                    <p class="text-muted mb-0 small">Official Academic Progress & Performance Report</p>
                </div>
            </div>
            <span class="badge bg-primary px-3 py-2 text-uppercase fs-6 mt-2">{{ $exam->exam_name }}</span>
        </div>

        <!-- Student Profile Metadata -->
        <div class="row g-3 mb-4 p-3 bg-light rounded-3">
            <div class="col-sm-6 col-md-3">
                <span class="text-muted small d-block">Student Name:</span>
                <strong class="text-dark fs-6">{{ $student->student_name }}</strong>
            </div>
            <div class="col-sm-6 col-md-3">
                <span class="text-muted small d-block">Admission No:</span>
                <strong class="text-dark fs-6">{{ $student->admission_no }}</strong>
            </div>
            <div class="col-sm-6 col-md-3">
                <span class="text-muted small d-block">Grade / Class:</span>
                <strong class="text-dark fs-6">{{ $student->grade->grade_name ?? 'N/A' }}</strong>
            </div>
            <div class="col-sm-6 col-md-3">
                <span class="text-muted small d-block">Assessment Date:</span>
                <strong class="text-dark fs-6">{{ \Carbon\Carbon::now()->format('M d, Y') }}</strong>
            </div>
        </div>

        <!-- Marks Table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-uppercase small text-muted">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Subject</th>
                        <th class="text-center" style="width: 120px;">Max Marks</th>
                        <th class="text-center" style="width: 140px;">Marks Obtained</th>
                        <th class="text-center" style="width: 120px;">Percentage</th>
                        <th class="text-center" style="width: 100px;">Grade</th>
                        <th>Teacher Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($marks as $index => $mark)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold text-dark">
                                {{ $mark->subject->subject_name ?? 'Subject' }}
                                <small class="text-muted d-block fw-normal">Code: {{ $mark->subject->subject_index ?? 'SUB' }}</small>
                            </td>
                            <td class="text-center">{{ number_format($mark->total_marks, 0) }}</td>
                            <td class="text-center fw-bold fs-6">{{ number_format($mark->marks_obtained, 1) }}</td>
                            <td class="text-center">{{ $mark->percentage }}%</td>
                            <td class="text-center">
                                <span class="badge {{ $mark->grade_badge }} px-2 py-1 fs-6">
                                    {{ $mark->grade_letter }}
                                </span>
                            </td>
                            <td><small class="text-muted">{{ $mark->remarks ?? 'Satisfactory' }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No marks records available for this exam.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($marks->isNotEmpty())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="2" class="text-end">Summary Totals:</td>
                            <td class="text-center">{{ number_format($totalMax, 0) }}</td>
                            <td class="text-center fs-6 text-primary">{{ number_format($totalObtained, 1) }}</td>
                            <td class="text-center fs-6 text-primary">{{ $overallPercentage }}%</td>
                            <td class="text-center">
                                <span class="badge bg-primary px-3 py-1 fs-6">{{ $overallGrade }}</span>
                            </td>
                            <td class="text-success">
                                {{ $overallGrade != 'F' ? 'PASSED' : 'NEEDS IMPROVEMENT' }}
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        <!-- Performance Summary & Scale Legend -->
        <div class="row g-4 mt-2">
            <div class="col-md-7">
                <h6 class="fw-bold text-muted small text-uppercase mb-2">Grading System Reference</h6>
                <div class="d-flex flex-wrap gap-2 small">
                    <span class="badge bg-success">A+ (85-100% Distinction)</span>
                    <span class="badge bg-success">A (75-84% Excellent)</span>
                    <span class="badge bg-primary">B (65-74% Very Good)</span>
                    <span class="badge bg-info text-dark">C (50-64% Credit)</span>
                    <span class="badge bg-warning text-dark">S (35-49% Pass)</span>
                    <span class="badge bg-danger">F (< 35% Fail)</span>
                </div>
            </div>
            <div class="col-md-5">
                <div class="border rounded p-3 text-center bg-light">
                    <div class="text-muted small text-uppercase">Overall Performance</div>
                    <div class="display-6 fw-bold text-primary my-1">{{ $overallPercentage }}%</div>
                    <div class="fw-semibold">Grade: <span class="badge bg-dark">{{ $overallGrade }}</span></div>
                </div>
            </div>
        </div>

        <!-- Signatures Block -->
        <div class="row mt-5 pt-4 border-top">
            <div class="col-4 text-center">
                <div class="border-bottom pb-4 mb-2 mx-4"></div>
                <small class="text-muted fw-bold">Class Teacher's Signature</small>
            </div>
            <div class="col-4 text-center">
                <div class="border-bottom pb-4 mb-2 mx-4"></div>
                <small class="text-muted fw-bold">Principal / Headmaster</small>
            </div>
            <div class="col-4 text-center">
                <div class="border-bottom pb-4 mb-2 mx-4"></div>
                <small class="text-muted fw-bold">Parent / Guardian Signature</small>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body {
        background: white !important;
        color: black !important;
    }
    .sidebar, .topbar, .btn, .d-print-none {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card.report-sheet {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>
@endsection
