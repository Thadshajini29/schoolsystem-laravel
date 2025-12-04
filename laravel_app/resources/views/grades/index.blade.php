@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-bookmark-fill me-2 text-primary"></i>Grades Management
        </h1>
        @if(Auth::user()->isAdmin())
            <a href="{{ route('grades.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Add New Grade
            </a>
        @endif
    </div>

    <div class="card shadow mb-4 fade-in">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul me-2"></i>Grades List
            </h6>
            <span class="badge bg-primary rounded-pill">{{ $grades->count() }} Total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 8%;">ID</th>
                            <th style="width: 25%;">Grade Name</th>
                            <th style="width: 18%;">Grade Group</th>
                            <th class="text-center" style="width: 15%;">Color</th>
                            <th class="text-center" style="width: 12%;">Order</th>
                            <th class="text-center" style="width: 22%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $grade)
                            <tr>
                                <td class="text-center fw-semibold">{{ $grade->id }}</td>
                                <td class="fw-semibold">
                                    <i class="bi bi-bookmark-fill me-2" style="color: {{ $grade->grade_color }};"></i>
                                    {{ $grade->grade_name }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $grade->grade_group }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-2" 
                                          style="background-color: {{ $grade->grade_color }}; color: #fff; text-shadow: 1px 1px 1px rgba(0,0,0,0.3);">
                                        <i class="bi bi-palette-fill me-1"></i>{{ $grade->grade_color }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info text-dark">{{ $grade->grade_order }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                                        <a href="{{ route('grades.show', $grade) }}" 
                                           class="btn btn-sm btn-info text-white" 
                                           title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        
                                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                            <a href="{{ route('grades.add_subjects', $grade) }}" 
                                               class="btn btn-sm btn-success" 
                                               title="Manage Subjects">
                                                <i class="bi bi-book-fill"></i>
                                            </a>
                                            <a href="{{ route('grades.edit', $grade) }}" 
                                               class="btn btn-sm btn-warning text-white" 
                                               title="Edit Grade">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endif
                                        
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-btn" 
                                                        title="Delete Grade">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted">No grades found.</p>
                                    <a href="{{ route('grades.create') }}" class="btn btn-primary btn-sm mt-2">
                                        <i class="bi bi-plus-circle me-1"></i>Add First Grade
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
