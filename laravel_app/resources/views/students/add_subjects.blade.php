@extends('layouts.app')
@section('title', 'Manage Subjects')
@section('content')
    <div class="mb-4">
        <h2>Manage Subjects for {{ $student->student_name }}</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('students.store_subjects', $student) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Select Subjects</label>
                    <div class="row">
                        @foreach($subjects as $subject)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}"
                                        {{ $student->subjects->contains($subject->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="subject_{{ $subject->id }}">
                                        {{ $subject->subject_name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('students.show', $student) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
