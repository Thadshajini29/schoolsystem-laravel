@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-box-arrow-up me-2 text-primary"></i>Student Promotion System
            </h1>
            <p class="text-muted small mb-0">Batch promote students to the next academic grade</p>
        </div>
        <a href="{{ route('promotions.history') }}" class="btn btn-outline-info">
            <i class="bi bi-clock-history me-2"></i>Promotion History
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 fade-in">
        <div class="card-body">
            <form action="{{ route('promotions.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-9">
                    <label for="grade_id" class="form-label small fw-bold">Current Grade</label>
                    <select name="grade_id" id="grade_id" class="form-select border-primary" onchange="this.form.submit()">
                        <option value="">Select Grade to Promote From...</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-person-lines-fill me-2"></i>Load Students
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedGrade && $students->count() > 0)
        <div class="card shadow-sm border-0 fade-in">
            <form action="{{ route('promotions.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="from_grade_id" value="{{ $selectedGrade->id }}">

                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h6 class="m-0 fw-bold text-dark">
                                Students in {{ $selectedGrade->grade_name }} 
                                <span class="badge bg-light text-primary border ms-2 small">{{ $students->count() }} total</span>
                            </h6>
                        </div>
                        <div class="col-md-8">
                            <div class="d-flex align-items-center justify-content-md-end gap-2 mt-md-0 mt-3">
                                <label class="small fw-bold text-nowrap mb-0 me-1">Target Grade:</label>
                                <select name="to_grade_id" class="form-select form-select-sm border-success w-auto" required>
                                    <option value="">Choose...</option>
                                    @foreach($grades as $grade)
                                        @if($grade->id != $selectedGrade->id)
                                            <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <label class="small fw-bold text-nowrap mb-0 ms-2 me-1">Target Session:</label>
                                <input type="text" name="academic_year" class="form-control form-control-sm border-info w-auto" placeholder="e.g. 2024/2025" required>
                                <button type="submit" class="btn btn-success btn-sm px-3 fw-bold ms-2">
                                    <i class="bi bi-check-circle-fill me-1"></i> Start
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th>Student Name</th>
                                    <th>Admission No</th>
                                    <th>Latest Avg Mark</th>
                                    <th>Eligibility</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="form-check">
                                                <input class="form-check-input student-checkbox" type="checkbox" name="student_ids[]" value="{{ $student->id }}" {{ $student->can_promote ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-dark">{{ $student->student_name }}</td>
                                        <td><code>{{ $student->admission_no }}</code></td>
                                        <td>
                                            <span class="fw-bold {{ $student->average_mark >= 40 ? 'text-success' : 'text-danger' }}">
                                                {{ number_format($student->average_mark, 1) }}%
                                            </span>
                                        </td>
                                        <td>
                                            @if($student->can_promote)
                                                <span class="badge bg-success-soft text-success border border-success px-2 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Recommended
                                                </span>
                                            @else
                                                <span class="badge bg-warning-soft text-warning border border-warning px-2 py-1">
                                                    <i class="bi bi-exclamation-triangle me-1"></i> Check Results
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    @elseif($selectedGrade)
        <div class="text-center py-5 fade-in bg-white rounded shadow-sm">
            <i class="bi bi-person-x fs-1 text-muted opacity-25"></i>
            <p class="text-muted mt-3">No students found in {{ $selectedGrade->grade_name }}.</p>
        </div>
    @else
        <div class="text-center py-5 fade-in bg-white rounded shadow-sm">
            <i class="bi bi-lightning-charge-fill fs-1 text-primary opacity-25"></i>
            <p class="text-muted mt-3 h5">Please select a Current Grade to begin promotion.</p>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    document.querySelectorAll('.student-checkbox').forEach(cb => {
                        cb.checked = this.checked;
                    });
                });
            }
        });
    </script>

    <style>
        .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
        .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    </style>
@endsection
