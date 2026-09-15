@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Student Marks Entry</h1>
            <p class="text-muted mb-0">Record exam scores, compute percentage and assign letter grades</p>
        </div>
        <div>
            <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Exams
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Selector Bar -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('marks.entry') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Select Examination</label>
                    <select name="exam_id" class="form-select" onchange="this.form.submit()">
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ $selectedExamId == $exam->id ? 'selected' : '' }}>
                                {{ $exam->exam_name }} ({{ $exam->exam_type }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Select Grade / Class</label>
                    <select name="grade_id" class="form-select" onchange="this.form.submit()">
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ $selectedGradeId == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Select Subject</label>
                    <select name="subject_id" class="form-select" onchange="this.form.submit()">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }} ({{ $subject->subject_index ?? 'SUB' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-repeat me-1"></i> Load Students
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($students->isNotEmpty() && $selectedExamId && $selectedSubjectId)
        <form method="POST" action="{{ route('marks.store') }}">
            @csrf
            <input type="hidden" name="exam_id" value="{{ $selectedExamId }}">
            <input type="hidden" name="grade_id" value="{{ $selectedGradeId }}">
            <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="m-0 fw-bold text-primary">
                            {{ $subjects->firstWhere('id', $selectedSubjectId)?->subject_name }} —
                            {{ $grades->firstWhere('id', $selectedGradeId)?->grade_name }}
                        </h6>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="fw-semibold text-muted small mb-0">Max Total Marks:</label>
                        <input type="number" name="total_marks" class="form-control form-control-sm text-center" style="width: 90px;" value="{{ $existingMarks->first()?->total_marks ?? 100 }}" min="1" required>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th style="width: 170px;">Marks Obtained</th>
                                    <th style="width: 120px;">Grade</th>
                                    <th>Remarks</th>
                                    <th style="width: 130px;" class="text-center">Report Card</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    @php
                                        $mark = $existingMarks->get($student->id);
                                        $obtained = $mark?->marks_obtained;
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="fw-bold">{{ $student->admission_no }}</td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $student->student_name }}</div>
                                        </td>
                                        <td>
                                            <input type="number" step="0.5" min="0" max="1000"
                                                   name="marks[{{ $student->id }}][marks_obtained]" 
                                                   class="form-control mark-input" 
                                                   value="{{ $obtained }}"
                                                   placeholder="Score...">
                                        </td>
                                        <td>
                                            @if($mark)
                                                <span class="badge {{ $mark->grade_badge }} px-3 py-2 fs-6">
                                                    {{ $mark->grade_letter }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-muted border">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   name="marks[{{ $student->id }}][remarks]" 
                                                   class="form-control form-control-sm" 
                                                   value="{{ $mark?->remarks }}"
                                                   placeholder="Optional feedback...">
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('marks.report_card', ['student' => $student->id, 'exam' => $selectedExamId]) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               target="_blank"
                                               title="View Full Report Card">
                                                <i class="bi bi-file-earmark-person me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Letter grades are computed automatically based on percentage scored.</span>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save me-1"></i> Save Marks
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="card shadow-sm p-5 text-center text-muted">
            <i class="bi bi-card-checklist fs-1 text-secondary mb-3"></i>
            <h5>Select an Exam, Grade, and Subject above to begin marks entry</h5>
            <p>Make sure exams and students exist in the system first.</p>
        </div>
    @endif
</div>
@endsection
