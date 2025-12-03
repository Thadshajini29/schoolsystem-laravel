@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2>Manage Subjects for {{ $grade->grade_name }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('grades.store_subjects', $grade) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Select Subjects</label>
                    <div class="row">
                        @foreach($subjects as $subject)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}"
                                        {{ $grade->subjects->contains($subject->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="subject_{{ $subject->id }}">
                                        {{ $subject->subject_name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
