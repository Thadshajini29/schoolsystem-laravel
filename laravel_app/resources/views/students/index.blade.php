@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="bi bi-people-fill me-2 text-primary"></i>Students Management
        </h1>
        @if(Auth::user()->isAdmin())
            <button type="button" class="btn btn-primary shadow-sm" onclick="openCreateModal()">
                <i class="bi bi-person-plus-fill me-2"></i>Add New Student
            </button>
        @endif
    </div>

    <div class="card shadow mb-4 fade-in">
        <div class="card-body">
            <form action="{{ route('students.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="search" class="form-label small fw-bold">Search Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="grade_id" class="form-label small fw-bold">Filter Grade</label>
                    <select name="grade_id" id="grade_id" class="form-select">
                        <option value="">All Grades</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}" {{ request('grade_id') == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="gender" class="form-label small fw-bold">Gender</label>
                    <select name="gender" id="gender" class="form-select">
                        <option value="">All</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-filter me-2"></i>Filter
                    </button>
                    @if(request()->anyFilled(['search', 'grade_id', 'gender']))
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4 fade-in">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul me-2"></i>Student List
            </h6>
            <span class="badge bg-primary rounded-pill">{{ $students->total() }} Total</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-center" style="width: 8%;">Image</th>
                            <th style="width: 20%;">Student Name</th>
                            <th style="width: 12%;">Admission No</th>
                            <th class="text-center" style="width: 10%;">Gender</th>
                            <th style="width: 12%;">Phone</th>
                            <th class="text-center" style="width: 10%;">Grade</th>
                            <th class="text-center" style="width: 23%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td class="text-center fw-semibold">{{ $student->id }}</td>
                                <td class="text-center">
                                    @if($student->file_path)
                                        <img src="/storage/{{ $student->file_path }}" 
                                             alt="Student Image" 
                                             width="50" 
                                             height="50" 
                                             class="rounded-circle border border-2 shadow-sm"
                                             style="object-fit: cover; cursor: pointer;"
                                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($student->student_name) }}&background=random';"
                                             onclick="showImageModal('/storage/{{ $student->file_path }}', '{{ $student->student_name }}')">
                                    @else
                                        <div class="bg-gradient-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center border border-2" 
                                             style="width: 50px; height: 50px; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                                            <i class="bi bi-person-fill fs-5"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-semibold">
                                    <i class="bi bi-person me-2 text-primary"></i>{{ $student->student_name }}
                                </td>
                                <td><span class="badge bg-secondary">{{ $student->admission_no }}</span></td>
                                <td class="text-center">
                                    @if($student->gender == 'Male')
                                        <span class="badge bg-info text-dark">
                                            <i class="bi bi-gender-male me-1"></i>Male
                                        </span>
                                    @elseif($student->gender == 'Female')
                                        <span class="badge bg-danger text-white">
                                            <i class="bi bi-gender-female me-1"></i>Female
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->phone_no)
                                        <i class="bi bi-telephone-fill me-2 text-success"></i>{{ $student->phone_no }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">{{ $student->grade->grade_name }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                                        <a href="{{ route('students.show', $student) }}" 
                                           class="btn btn-sm btn-info text-white" 
                                           title="View Details">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        
                                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                                            <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    onclick="window.location='{{ route('students.add_subjects', $student) }}'"
                                                    title="Manage Subjects">
                                                <i class="bi bi-book-fill"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning text-white" 
                                                    onclick="openEditModal({{ $student->id }})"
                                                    title="Edit Student">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        @endif
                                        
                                        @if(Auth::user()->isAdmin())
                                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger delete-btn" 
                                                        title="Delete Student">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                                    <p class="text-muted">No students found.</p>
                                    <button type="button" class="btn btn-primary btn-sm mt-2" onclick="openCreateModal()">
                                        <i class="bi bi-plus-circle me-1"></i>Add First Student
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $students->links() }}
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus-fill me-2"></i>Add New Student
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="createStudentContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-fill me-2"></i>Edit Student
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="editStudentContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalTitle">Student Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="imageModalSrc" class="img-fluid rounded" alt="Student Image">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openCreateModal() {
        $('#createStudentContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);
        
        $('#createStudentModal').modal('show');
        
        $.ajax({
            url: '{{ route('students.create') }}',
            method: 'GET',
            success: function(response) {
                $('#createStudentContent').html($(response).find('.card-body').html());
                setupImagePreview('image', 'imagePreview');
            },
            error: function() {
                $('#createStudentContent').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Failed to load form. Please try again.
                    </div>
                `);
            }
        });
    }

    function openEditModal(studentId) {
        $('#editStudentContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);
        
        $('#editStudentModal').modal('show');
        
        $.ajax({
            url: '/students/' + studentId + '/edit',
            method: 'GET',
            success: function(response) {
                $('#editStudentContent').html($(response).find('.card-body').html());
                setupImagePreview('image', 'imagePreview');
            },
            error: function() {
                $('#editStudentContent').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Failed to load form. Please try again.
                    </div>
                `);
            }
        });
    }

    function showImageModal(src, title) {
        $('#imageModalSrc').attr('src', src);
        $('#imageModalTitle').text(title + ' - Photo');
        $('#imageModal').modal('show');
    }

    // Handle form submissions in modals
    $(document).on('submit', '#createStudentContent form, #editStudentContent form', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const url = $(this).attr('action');
        const method = $(this).find('input[name="_method"]').val() || 'POST';

        $('#loadingSpinner').addClass('active');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#loadingSpinner').removeClass('active');
                $('.modal').modal('hide');
                showNotification('Student saved successfully!', 'success');
                setTimeout(() => window.location.reload(), 1000);
            },
            error: function(xhr) {
                $('#loadingSpinner').removeClass('active');
                let errors = '';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errors += '<li>' + value[0] + '</li>';
                    });
                    showNotification('<ul class="mb-0 ps-3">' + errors + '</ul>', 'danger');
                } else {
                    showNotification('An error occurred. Please try again.', 'danger');
                }
            }
        });
    });
</script>
@endpush

