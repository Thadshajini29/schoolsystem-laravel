@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-book me-2 text-success"></i>Manage Subjects
            </h1>
            <p class="text-muted small mb-0">
                Assign subjects to: 
                <span class="badge" style="background-color: {{ $grade->grade_color ?? '#4e73df' }};">{{ $grade->grade_name }}</span>
            </p>
        </div>
        <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Grades
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow border-0 fade-in">
                <div class="card-header py-3 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-list-check me-2"></i>Available Subjects
                    </h6>
                    <span class="badge bg-info">{{ $subjects->count() }} subjects available</span>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($subjects->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No subjects available. Please create subjects first.</p>
                            <a href="{{ route('subjects.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i>Create Subject
                            </a>
                        </div>
                    @else
                        <form action="{{ route('grades.store_subjects', $grade) }}" method="POST" id="subjectsForm">
                            @csrf
                            
                            <div class="mb-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label fw-semibold" for="selectAll">
                                        Select All / Deselect All
                                    </label>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                @foreach($subjects as $subject)
                                    @php
                                        $assignedSubject = $grade->subjects->find($subject->id);
                                        $assignedTeacherId = $assignedSubject ? $assignedSubject->pivot->teacher_id : null;
                                    @endphp
                                    <div class="col-md-12 mb-3">
                                        <div class="subject-item p-3 rounded border {{ $assignedSubject ? 'border-success bg-success bg-opacity-10' : '' }}">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <div class="form-check">
                                                        <input class="form-check-input subject-checkbox" 
                                                               type="checkbox" 
                                                               name="subjects[]" 
                                                               value="{{ $subject->id }}" 
                                                               id="subject_{{ $subject->id }}"
                                                               {{ $assignedSubject ? 'checked' : '' }}>
                                                        <label class="form-check-label d-block" for="subject_{{ $subject->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <span class="rounded-circle me-2" 
                                                                      style="width: 12px; height: 12px; background-color: {{ $subject->subject_color ?? '#6c757d' }}; display: inline-block;"></span>
                                                                <strong>{{ $subject->subject_name }}</strong>
                                                            </div>
                                                            <small class="text-muted">
                                                                {{ $subject->subject_index ?? 'N/A' }}
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <label class="small text-muted mb-1">Assign Teacher</label>
                                                    <select name="teachers[{{ $subject->id }}]" class="form-select form-select-sm teacher-select" {{ !$assignedSubject ? 'disabled' : '' }}>
                                                        <option value="">Select Teacher</option>
                                                        @foreach($teachers as $teacher)
                                                            <option value="{{ $teacher->id }}" {{ $assignedTeacherId == $teacher->id ? 'selected' : '' }}>
                                                                {{ $teacher->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="my-4">

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-check-lg me-2"></i>Save Subject Assignments
                                </button>
                                <a href="{{ route('grades.show', $grade) }}" class="btn btn-outline-primary px-4">
                                    <i class="bi bi-eye me-2"></i>View Grade
                                </a>
                                <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="bi bi-x-lg me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow border-0 fade-in">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="bi bi-check-circle me-2"></i>Currently Assigned
                    </h6>
                </div>
                <div class="card-body">
                    @if($grade->subjects->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-bookmark-x fs-1 text-muted"></i>
                            <p class="text-muted mt-2 small">No subjects assigned yet</p>
                        </div>
                    @else
                        <ul class="list-group list-group-flush" id="assignedSubjectsList">
                            @foreach($grade->subjects as $subject)
                                <li class="list-group-item d-flex align-items-center">
                                    <span class="rounded-circle me-2" 
                                          style="width: 10px; height: 10px; background-color: {{ $subject->subject_color ?? '#6c757d' }}; display: inline-block;"></span>
                                    {{ $subject->subject_name }}
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-3 text-center">
                            <span class="badge bg-success">{{ $grade->subjects->count() }} subjects assigned</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow border-0 mt-4 fade-in">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-info-circle me-2"></i>Grade Details
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Name:</td>
                            <td class="fw-semibold">{{ $grade->grade_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Group:</td>
                            <td>{{ $grade->grade_group ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Color:</td>
                            <td>
                                <span class="badge" style="background-color: {{ $grade->grade_color ?? '#4e73df' }};">
                                    {{ $grade->grade_color ?? '#4e73df' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Order:</td>
                            <td>{{ $grade->grade_order ?? '0' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const subjectCheckboxes = document.querySelectorAll('.subject-checkbox');
        
        // Select All functionality
        selectAllCheckbox.addEventListener('change', function() {
            subjectCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                updateItemStyle(checkbox);
            });
        });
        
        // Update individual checkbox styles
        subjectCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateItemStyle(this);
                updateSelectAllState();
            });
        });
        
        function updateItemStyle(checkbox) {
            const item = checkbox.closest('.subject-item');
            const teacherSelect = item.querySelector('.teacher-select');
            if (checkbox.checked) {
                item.classList.add('border-success', 'bg-success', 'bg-opacity-10');
                teacherSelect.disabled = false;
                teacherSelect.required = true;
            } else {
                item.classList.remove('border-success', 'bg-success', 'bg-opacity-10');
                teacherSelect.disabled = true;
                teacherSelect.required = false;
                teacherSelect.value = '';
            }
        }
        
        function updateSelectAllState() {
            const allChecked = Array.from(subjectCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(subjectCheckboxes).some(cb => cb.checked);
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
        }
        
        // Initialize state
        updateSelectAllState();
    });
</script>
@endpush
