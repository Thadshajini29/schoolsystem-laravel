@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-person-workspace me-2 text-primary"></i>Teachers Management
            </h1>
            <p class="text-muted small mb-0">Manage school faculty members</p>
        </div>

        <button type="button" class="btn btn-primary shadow-sm" onclick="openTeacherCreate()">
    <i class="bi bi-person-plus-fill me-2"></i>Add New Teacher
</button>
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
                            <th class="text-center py-3" style="width: 5%;">ID</th>
                            <th class="py-3" style="width: 10%;">Image</th>
                            <th class="py-3" style="width: 25%;">Teacher Name</th>
                            <th class="py-3" style="width: 20%;">Email</th>
                            <th class="py-3" style="width: 15%;">Phone</th>
                            <th class="text-center py-3" style="width: 25%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td class="text-center fw-bold text-secondary">{{ $teacher->id }}</td>
                                <td>
                                    <img src="{{ $teacher->image_url }}" alt="{{ $teacher->name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                </td>
                                <td class="fw-semibold">{{ $teacher->name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <button type="button" onclick="openTeacherEdit({{ $teacher->id }})"
                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <a href="{{ route('teachers.assign_subjects', $teacher) }}" class="btn btn-sm btn-outline-primary" title="Assign Subjects">
                                            <i class="bi bi-journal-plus"></i>
                                        </a>
                                        <form action="{{ route('teachers.destroy', $teacher) }}" method="POST"
                                            class="d-inline ms-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"
                                                title="Delete">
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
        @if ($teachers->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $teachers->links() }}
            </div>
        @endif
    </div>
@endsection

    <!-- Teacher Modal -->
    <div class="modal fade" id="teacherModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="teacherModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading…</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openTeacherCreate() {
            $('#teacherModalTitle').html('<i class="bi bi-person-plus-fill me-2"></i>Create Teacher');
            $('#teacherModalBody').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading…</span>
                    </div>
                </div>`);
            $('#teacherModal').modal('show');
            $.ajax({
                url: '{{ route('teachers.create') }}',
                method: 'GET',
                success: function (response) {
                    const html = $(response).find('.card-body').html();
                    $('#teacherModalBody').html(html);
                },
                error: function () { showNotification('Failed to load form.', 'danger'); }
            });
        }
        function openTeacherEdit(id) {
            $('#teacherModalTitle').html('<i class="bi bi-pencil-fill me-2"></i>Edit Teacher');
            $('#teacherModalBody').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading…</span>
                    </div>
                </div>`);
            $('#teacherModal').modal('show');
            $.ajax({
                url: '/teachers/' + id + '/edit',
                method: 'GET',
                success: function (response) {
                    const html = $(response).find('.card-body').html();
                    $('#teacherModalBody').html(html);
                },
                error: function () { showNotification('Failed to load edit form.', 'danger'); }
            });
        }
        // Submit create / edit forms via AJAX
        $(document).on('submit', '#teacherModalBody form', function (e) {
            e.preventDefault();
            const form = $(this);
            const formData = new FormData(this);
            const url = form.attr('action');
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function () { $('#teacherModal').modal('hide'); showNotification('Teacher saved successfully!', 'success'); setTimeout(() => location.reload(), 1200); },
                error: function (xhr) {
                    let errors = '';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, (k, v) => { errors += `<li>${v[0]}</li>`; });
                        showNotification(`<ul class="mb-0 ps-3">${errors}</ul>`, 'danger');
                    } else { showNotification('An error occurred.', 'danger'); }
                }
            });
        });
    </script>
    @endpush
