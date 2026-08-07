@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-book-fill me-2 text-primary"></i>Subjects Management
            </h1>
           <p class="text-muted small mb-0">Manage core curriculum and subject details</p>
        </div>
        
        @if(Auth::user()->isAdmin())
            <a href="{{ route('subjects.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Create New Subject
            </a>
        @endif
    </div>

    <div class="card shadow mb-4 fade-in border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul me-2"></i>All Subjects
            </h6>
            <span class="badge bg-primary rounded-pill">{{ $subjects->count() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3" style="width: 6%;">ID</th>
                            <th class="py-3" style="width: 22%;">Subject Name</th>
                            <th class="text-center py-3" style="width: 12%;">Index</th>
                            <th class="text-center py-3" style="width: 12%;">Number</th>
                            <th class="text-center py-3" style="width: 15%;">Color</th>
                            <th class="text-center py-3" style="width: 10%;">Order</th>
                            <th class="text-center py-3" style="width: 23%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                            <tr>
                                <td class="text-center fw-bold text-secondary">{{ $subject->id }}</td>
                                <td class="fw-semibold">
                                    <div class="d-flex align-items-center">
                                       <div class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: {{ $subject->subject_color }};"></div>
                                       {{ $subject->subject_name }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">{{ $subject->subject_index }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border">{{ $subject->subject_number }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" 
                                          style="background-color: {{ $subject->subject_color }}; color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        {{ $subject->subject_color }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $subject->subject_order }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('subjects.show', $subject) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           data-bs-toggle="tooltip" 
                                           title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        
                                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                            <a href="{{ route('subjects.edit', $subject) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Subject">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endif
                                        
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline border-start ms-1 ps-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger delete-btn" 
                                                        data-bs-toggle="tooltip" 
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
                                    <div class="text-muted mb-3">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <p class="mt-2">No subjects found.</p>
                                    </div>
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>Add First Subject
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($subjects->hasPages())
             <div class="card-footer bg-white py-3">
                {{ $subjects->links() }}
            </div>
        @endif
    </div>
@endsection
