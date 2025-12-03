@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Grades</h2>
        <a href="{{ route('grades.create') }}" class="btn btn-primary">Add Grade</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Grade Name</th>
                        <th>Grade Group</th>
                        <th>Grade Color</th>
                        <th>Grade Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->id }}</td>
                            <td>{{ $grade->grade_name }}</td>
                            <td>{{ $grade->grade_group }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $grade->grade_color }}; color: #fff; text-shadow: 1px 1px 1px #000;">
                                    {{ $grade->grade_color }}
                                </span>
                            </td>
                            <td>{{ $grade->grade_order }}</td>
                            <td>
                                <a href="{{ route('grades.show', $grade) }}" class="btn btn-sm btn-info text-white">Show</a>
                                <a href="{{ route('grades.add_subjects', $grade) }}" class="btn btn-sm btn-success">Add Subject</a>
                                <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
