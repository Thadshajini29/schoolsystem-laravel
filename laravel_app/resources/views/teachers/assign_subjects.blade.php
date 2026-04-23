@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-journal-check me-2 text-primary"></i>Assign Subjects
            </h1>
            <p class="text-muted small mb-0">Assign grades and subjects to {{ $teacher->name }}</p>
        </div>
        
        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card shadow border-0 fade-in">
        <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-person-badge me-2"></i>Teacher: {{ $teacher->name }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('teachers.store_subjects', $teacher) }}" method="POST">
                @csrf
                
                <div class="row">
                    @foreach($grades as $grade)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0 fw-bold">{{ $grade->grade_name }}</h6>
                                </div>
                                <div class="card-body">
                                    @forelse($grade->subjects as $subject)
                                        <div class="form-check mb-2">
                                            @php $value = $grade->id . '-' . $subject->id; @endphp
                                            <input class="form-check-input" type="checkbox" name="assignments[]" value="{{ $value }}" id="asgn-{{ $value }}" {{ in_array($value, $assigned) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="asgn-{{ $value }}">
                                                {{ $subject->subject_name }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-muted small mb-0">No subjects linked to this grade.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="bi bi-save me-2"></i>Save Assignments
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
