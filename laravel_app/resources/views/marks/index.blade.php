@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-journal-check me-2 text-primary"></i>Enter Exam Marks
            </h1>
            <p class="text-muted small mb-0">Record student marks for exams and subjects</p>
        </div>
    </div>

    <div class="card shadow mb-4 fade-in border-0">
        <div class="card-body">
            <form action="{{ route('marks.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="grade_id" class="form-label small fw-bold">Select Grade</label>
                    <select name="grade_id" id="grade_id" class="form-select">
                        <option value="">Choose Grade...</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="subject_id" class="form-label small fw-bold">Select Subject</label>
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">Choose Subject...</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="exam_type" class="form-label small fw-bold">Exam Type</label>
                    <select name="exam_type" id="exam_type" class="form-select">
                        <option value="Term Test" {{ $examType == 'Term Test' ? 'selected' : '' }}>Term Test</option>
                        <option value="Monthly Test" {{ $examType == 'Monthly Test' ? 'selected' : '' }}>Monthly Test</option>
                        <option value="Final Exam" {{ $examType == 'Final Exam' ? 'selected' : '' }}>Final Exam</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-2"></i>Filter Students
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedGrade && $selectedSubject)
        <div class="card shadow border-0 fade-in">
            <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-table me-2"></i>Marks Sheet
                </h6>
                <div class="small fw-bold text-info">{{ $selectedGrade->grade_name }} | {{ $selectedSubject->subject_name }} | {{ $examType }}</div>
            </div>
            <div class="card-body">
                @if($students->count() > 0)
                    <form action="{{ route('marks.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="grade_id" value="{{ $selectedGrade->id }}">
                        <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">
                        <input type="hidden" name="exam_type" value="{{ $examType }}">
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40%;">Student Name</th>
                                        <th class="text-center" style="width: 25%;">Total Marks</th>
                                        <th class="text-center" style="width: 25%;">Obtained Marks</th>
                                        <th class="text-center" style="width: 10%;">Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        @php
                                            $mark = \App\Models\Mark::where('student_id', $student->id)
                                                ->where('subject_id', $selectedSubject->id)
                                                ->where('exam_type', $examType)
                                                ->first();
                                            $total = $mark ? $mark->total_marks : 100;
                                            $obtained = $mark ? $mark->obtained_marks : '';
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold">{{ $student->student_name }}</td>
                                            <td class="text-center">
                                                <input type="number" name="marks[{{ $student->id }}][total]" value="{{ $total }}" class="form-control form-control-sm mx-auto text-center" style="max-width: 100px;" required>
                                            </td>
                                            <td class="text-center">
                                                <input type="number" name="marks[{{ $student->id }}][obtained]" value="{{ $obtained }}" class="form-control form-control-sm mx-auto text-center obtained-mark" style="max-width: 100px;" required>
                                            </td>
                                            <td class="text-center result-badge">
                                                @if($obtained !== '')
                                                    @php $pct = ($obtained / $total) * 100; @endphp
                                                    <span class="badge {{ $pct >= 35 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $pct >= 35 ? 'PASS' : 'FAIL' }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">
                                <i class="bi bi-save-fill me-2"></i>Save Final Marks Sheet
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-person-x-fill fs-1 text-muted"></i>
                        <p class="text-muted mt-2">No students found associated with this grade.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-5 fade-in">
            <i class="bi bi-card-checklist fs-2 text-primary opacity-25"></i>
            <p class="text-muted mt-2">Please select filters to enter exam marks.</p>
        </div>
    @endif
@endsection
