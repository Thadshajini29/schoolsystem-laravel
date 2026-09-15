@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800 fw-bold">Create New Examination</h1>
                    <p class="text-muted mb-0">Define an exam session for terms or unit assessments</p>
                </div>
                <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Exams
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('exams.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Exam Title <span class="text-danger">*</span></label>
                            <input type="text" name="exam_name" class="form-control @error('exam_name') is-invalid @enderror" value="{{ old('exam_name') }}" placeholder="e.g. 2026 Term 1 Midterm Examination" required>
                            @error('exam_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Exam Type <span class="text-danger">*</span></label>
                                <select name="exam_type" class="form-select @error('exam_type') is-invalid @enderror" required>
                                    <option value="Term Exam" {{ old('exam_type') == 'Term Exam' ? 'selected' : '' }}>Term Examination</option>
                                    <option value="Midterm" {{ old('exam_type') == 'Midterm' ? 'selected' : '' }}>Midterm Assessment</option>
                                    <option value="Unit Test" {{ old('exam_type') == 'Unit Test' ? 'selected' : '' }}>Unit Test</option>
                                    <option value="Final Exam" {{ old('exam_type') == 'Final Exam' ? 'selected' : '' }}>Final Examination</option>
                                    <option value="Quiz / Assignment" {{ old('exam_type') == 'Quiz / Assignment' ? 'selected' : '' }}>Quiz / Assignment</option>
                                </select>
                                @error('exam_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                    <label class="form-check-label fw-semibold" for="is_active">Set as Active Examination</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Start Date</label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">End Date</label>
                                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Description / Instructions</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Optional details regarding syllabus, schedule, or rules...">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Create Exam</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
