@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Exams Management</h1>
            <p class="text-muted mb-0">Create, organize, and manage examination terms</p>
        </div>
        <div>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('exams.create') }}" class="btn btn-primary shadow-sm me-2">
                    <i class="bi bi-plus-circle me-1"></i> Add New Exam
                </a>
            @endif
            <a href="{{ route('marks.entry') }}" class="btn btn-outline-success shadow-sm">
                <i class="bi bi-pencil-square me-1"></i> Enter Student Marks
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary">All Examinations</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Exam Name</th>
                            <th>Exam Type</th>
                            <th>Date Range</th>
                            <th>Status</th>
                            <th>Marks Entered</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">{{ $exam->exam_name }}</div>
                                    @if($exam->description)
                                        <small class="text-muted">{{ Str::limit($exam->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $exam->exam_type }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $exam->start_date ? $exam->start_date->format('M d, Y') : 'TBD' }}
                                        —
                                        {{ $exam->end_date ? $exam->end_date->format('M d, Y') : 'TBD' }}
                                    </small>
                                </td>
                                <td>
                                    @if($exam->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Closed</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $exam->marks_count }} marks</span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('marks.entry', ['exam_id' => $exam->id]) }}" class="btn btn-outline-success" title="Enter Marks">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                            <a href="{{ route('exams.edit', $exam) }}" class="btn btn-outline-primary" title="Edit Exam">
                                                <i class="bi bi-gear-fill"></i>
                                            </a>
                                        @endif
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this exam and all associated marks?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Delete Exam">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                                    No exams defined yet.
                                    @if(Auth::user()->isAdmin())
                                        <div class="mt-2">
                                            <a href="{{ route('exams.create') }}" class="btn btn-sm btn-primary">Create Your First Exam</a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($exams->hasPages())
                <div class="p-3">
                    {{ $exams->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
