@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Subject Details</h2>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Subject Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Subject Name:</strong> {{ $subject->subject_name }}</p>
                    <p><strong>Subject Index:</strong> {{ $subject->subject_index }}</p>
                    <p><strong>Subject Number:</strong> {{ $subject->subject_number }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Subject Order:</strong> {{ $subject->subject_order }}</p>
                    <p><strong>Subject Color:</strong> <span class="badge" style="background-color: {{ $subject->subject_color }};">{{ $subject->subject_color }}</span></p>
                </div>
            </div>
        </div>
    </div>
@endsection
