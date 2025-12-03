@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2>Add Subject</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subject_name" class="form-label">Subject Name</label>
                    <input type="text" name="subject_name" id="subject_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="subject_index" class="form-label">Subject Index</label>
                    <input type="text" name="subject_index" id="subject_index" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="subject_order" class="form-label">Subject Order</label>
                    <input type="number" name="subject_order" id="subject_order" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
