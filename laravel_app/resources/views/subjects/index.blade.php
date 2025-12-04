@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-book-fill me-2 text-primary"></i>Subjects Management
        </h1>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('subjects.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Add New Subject
            </a>
        @endif
    </div>

    <div class="card shadow mb-4 fade-in">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul me-2"></i>Subjects List
            </h6>
            <span class="badge bg-primary rounded-pill">{{ $subjects->count() }} Total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 6%;">ID</th>
                            <th style="width: 22%;">Subject Name</th>
                            <th class="text-center" style="width: 12%;">Index</th>
                            <th class="text-center" style="width: 12%;">Number</th>
                            <th class="text-center" style="width: 15%;">Color</th>
                            <th class="text-center" style="width: 10%;">Order</th>
                            <th class="text-center" style="width: 23%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr>
                                <td class="text-center fw-semibold">{{ $subject->id }}</td>
                                <td class="fw-semibold">
                                    <i class="bi bi-book-fill me-2" style="color: {{ $subject->subject_color }};"></i>
                                    {{ $subject->subject_name }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $subject->subject_index }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $subject->subject_number }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-2" 
                                          style="background-color: {{ $subject->subject_color }}; color: #fff; text-shadow: 1px 1px 1px rgba(0,0,0,0.3);">
                                        <i class="bi bi-palette-fill me-1"></i>{{ $subject->subject_color }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark">{{ $subject->subject_order }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                                        <a href="{{ route('subjects.show', $subject) }}" 
                                           class="btn btn-sm btn-info text-white" 
                                           title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        
                                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                            <a href="{{ route('subjects.edit', $subject) }}" 
                                               class="btn btn-sm btn-warning text-white" 
                                               title="Edit Subject">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endif
                                        
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-btn" 
                                                        title="Delete Subject">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted">No subjects found.</p>
                                    <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>Add First Subject
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
