@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-book-fill me-2" style="color: {{ $subject->subject_color ?? '#667eea' }};"></i>{{ $subject->subject_name }}
            </h1>
            <p class="text-muted small mb-0">Subject Details and Information</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning text-white">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="card shadow border-0 mb-4 fade-in">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-info-circle me-2"></i>Subject Information
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width: 40%;">Name:</td>
                            <td class="fw-semibold">{{ $subject->subject_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Index/Code:</td>
                            <td>
                                <span class="badge bg-secondary">{{ $subject->subject_index ?? 'N/A' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Number:</td>
                            <td>{{ $subject->subject_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Color:</td>
                            <td>
                                <span class="badge rounded-pill" style="background-color: {{ $subject->subject_color ?? '#667eea' }};">
                                    {{ $subject->subject_color ?? '#667eea' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Order:</td>
                            <td>{{ $subject->subject_order ?? '0' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td>{{ $subject->created_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-lg-7">
            <!-- Assigned Grades Card -->
            <div class="card shadow border-0 mb-4 fade-in">
                <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="bi bi-bookmark-fill me-2"></i>Grades Using This Subject
                    </h6>
                    <span class="badge bg-success">{{ $subject->grades->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @if($subject->grades->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($subject->grades as $grade)
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="rounded-circle me-2" 
                                              style="width: 10px; height: 10px; background-color: {{ $grade->grade_color ?? '#4e73df' }}; display: inline-block;"></span>
                                        <span>{{ $grade->grade_name }}</span>
                                    </div>
                                    <div>
                                        <span class="badge bg-light text-dark border me-2">{{ $grade->grade_group ?? 'N/A' }}</span>
                                        <a href="{{ route('grades.show', $grade) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-bookmark-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">This subject is not assigned to any grades yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
