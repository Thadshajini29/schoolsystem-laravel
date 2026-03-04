@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-bookmark-fill me-2 text-primary"></i>Grades Management
            </h1>
            <p class="text-muted small mb-0">Manage school grades and their attributes</p>
        </div>
        
        @if(Auth::user()->isAdmin())
            <a href="{{ route('grades.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Create New Grade
            </a>
        @endif
    </div>

    <div class="card shadow mb-4 fade-in border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul me-2"></i>All Grades
            </h6>
            <span class="badge bg-primary rounded-pill">{{ $grades->count() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3" style="width: 5%;">ID</th>
                            <th class="py-3" style="width: 25%;">Grade Name</th>
                            <th class="py-3" style="width: 20%;">Group</th>
                            <th class="text-center py-3" style="width: 15%;">Color</th>
                            <th class="text-center py-3" style="width: 10%;">Order</th>
                            <th class="text-center py-3" style="width: 25%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $grade)
                            <tr>
                                <td class="text-center fw-bold text-secondary">{{ $grade->id }}</td>
                                <td class="fw-semibold">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle me-2" style="width: 10px; height: 10px; background-color: {{ $grade->grade_color }};"></div>
                                        {{ $grade->grade_name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $grade->grade_group }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" 
                                          style="background-color: {{ $grade->grade_color }}; color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        {{ $grade->grade_color }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $grade->grade_order }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        {{-- View Button - Visible to Everyone --}}
                                        <a href="{{ route('grades.show', $grade) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           data-bs-toggle="tooltip" 
                                           title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        
                                        {{-- Edit/Add Subject - Admin & Teacher --}}
                                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                            <a href="{{ route('grades.add_subjects', $grade) }}" 
                                               class="btn btn-sm btn-outline-success" 
                                               data-bs-toggle="tooltip" 
                                               title="Manage Subjects">
                                                <i class="bi bi-book"></i>
                                            </a>
                                        @endif
                                        
                                        @if(Auth::user()->isAdmin())
                                            <a href="{{ route('grades.edit', $grade) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit Grade">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        @endif
                                        
                                        {{-- Delete - Admin Only --}}
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('grades.destroy', $grade) }}" method="POST" class="d-inline border-start ms-1 ps-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger delete-btn" 
                                                        data-bs-toggle="tooltip" 
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
                                    <div class="text-muted mb-3">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <p class="mt-2">No grades found in the system.</p>
                                    </div>
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('grades.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle me-1"></i>Add First Grade
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($grades->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $grades->links() }}
            </div>
        @endif
    </div>
@endsection
