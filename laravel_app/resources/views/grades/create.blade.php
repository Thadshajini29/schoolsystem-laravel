@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2>Add Grade</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('grades.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="grade_name" class="form-label">Grade Name</label>
                    <input type="text" name="grade_name" id="grade_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="grade_group" class="form-label">Grade Group</label>
                    <input type="text" name="grade_group" id="grade_group" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="grade_order" class="form-label">Grade Order</label>
                    <input type="number" name="grade_order" id="grade_order" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('grades.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
