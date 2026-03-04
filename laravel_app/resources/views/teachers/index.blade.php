@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-person-workspace me-2 text-primary"></i>Teachers Management
            </h1>
            <p class="text-muted small mb-0">Manage school faculty members</p>
        </div>
        
        <a href="{{ route('teachers.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus-fill me-2"></i>Add New Teacher
        </a>
    </div>

    <div class="card shadow mb-4 fade-in border-0">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul me-2"></i>All Teachers
            </h6>
            <span class="badge bg-primary rounded-pill">{{ $teachers->total() }} Records</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3" style="width: 10%;">ID</th>
                            <th class="py-3" style="width: 30%;">Teacher Name</th>
                            <th class="py-3" style="width: 25%;">Email</th>
                            <th class="py-3" style="width: 15%;">Phone</th>
                            <th class="text-center py-3" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td class="text-center fw-bold text-secondary">{{ $teacher->id }}</td>
                                <td class="fw-semibold">{{ $teacher->name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn" title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="bi bi-inbox fs-1"></i>
                                        <p class="mt-2">No teachers found in the system.</p>
                                    </div>
                                    <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle me-1"></i>Add First Teacher
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($teachers->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
@endsection
