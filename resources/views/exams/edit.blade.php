@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Examination</h1>
                    <p class="text-muted mb-0">Update exam parameters and configuration</p>
                </div>
                <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Exams
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('exams.update', $exam) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Exam Title <span class="text-danger">*</span></label>
                            <input type="text" name="exam_name" class="form-control @error('exam_name') is-invalid @enderror" value="{{ old('exam_name', $exam->exam_name) }}" required>
                            @error('exam_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Exam Type <span class="text-danger">*</span></label>
                                <select name="exam_type" class="form-select @error('exam_type') is-invalid @enderror" required>
                                    @php $type = old('exam_type', $exam->exam_type); @endphp
                                    <option value="Term Exam" {{ $type == 'Term Exam' ? 'selected' : '' }}>Term Examination</option>
                                    <option value="Midterm" {{ $type == 'Midterm' ? 'selected' : '' }}>Midterm Assessment</option>
                                    <option value="Unit Test" {{ $type == 'Unit Test' ? 'selected' : '' }}>Unit Test</option>
                                    <option value="Final Exam" {{ $type == 'Final Exam' ? 'selected' : '' }}>Final Examination</option>
                                    <option value="Quiz / Assignment" {{ $type == 'Quiz / Assignment' ? 'selected' : '' }}>Quiz / Assignment</option>
                                </select>
                                @error('exam_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $exam->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">Set as Active Examination</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Start Date</label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $exam->start_date?->toDateString()) }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">End Date</label>
                                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $exam->end_date?->toDateString()) }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Description / Instructions</label>
                            <textarea name="description" rows="3" class="form-control">{{ old('description', $exam->description) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('exams.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Update Exam</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
