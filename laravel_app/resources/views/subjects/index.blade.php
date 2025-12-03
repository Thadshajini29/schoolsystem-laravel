@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Subjects</h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">Add Subject</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject Name</th>
                        <th>Index</th>
                        <th>Number</th>
                        <th>Color</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $subject->id }}</td>
                            <td>{{ $subject->subject_name }}</td>
                            <td>{{ $subject->subject_index }}</td>
                            <td>{{ $subject->subject_number }}</td>
                            <td>
                                <span class="badge" style="background-color: {{ $subject->subject_color }}; color: #fff; text-shadow: 1px 1px 1px #000;">
                                    {{ $subject->subject_color }}
                                </span>
                            </td>
                            <td>{{ $subject->subject_order }}</td>
                            <td>
                                <a href="{{ route('subjects.show', $subject) }}" class="btn btn-sm btn-info text-white">Show</a>
                                <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
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
