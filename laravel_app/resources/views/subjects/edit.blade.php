@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2>Edit Subject</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('subjects.update', $subject) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name</label>
                    <input type="text" name="subject_name" id="subject_name" class="form-control" value="{{ $subject->subject_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="subject_index" class="form-label">Subject Index</label>
                    <input type="text" name="subject_index" id="subject_index" class="form-control" value="{{ $subject->subject_index }}">
                </div>
                <div class="mb-3">
                    <label for="subject_order" class="form-label">Subject Order</label>
                    <input type="number" name="subject_order" id="subject_order" class="form-control" value="{{ $subject->subject_order }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
