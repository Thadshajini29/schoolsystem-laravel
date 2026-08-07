@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Grade
            </h1>
            <p class="text-muted small mb-0">Update grade: <strong>{{ $grade->grade_name }}</strong></p>
        </div>
        <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Grades
        </a>
    </div>

    <div class="card shadow border-0 fade-in">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-bookmark-fill me-2"></i>Grade Information
            </h6>
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

            <form action="{{ route('grades.update', $grade) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="grade_name" class="form-label fw-semibold">
                            Grade Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="grade_name" 
                               id="grade_name" 
                               class="form-control @error('grade_name') is-invalid @enderror" 
                               placeholder="e.g., Grade 1, Grade 2"
                               value="{{ old('grade_name', $grade->grade_name) }}"
                               required>
                        @error('grade_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="grade_group" class="form-label fw-semibold">Grade Group</label>
                        <select name="grade_group" id="grade_group" class="form-select @error('grade_group') is-invalid @enderror">
                            <option value="">Select Group</option>
                            <option value="Primary" {{ old('grade_group', $grade->grade_group) == 'Primary' ? 'selected' : '' }}>Primary</option>
                            <option value="Middle" {{ old('grade_group', $grade->grade_group) == 'Middle' ? 'selected' : '' }}>Middle School</option>
                            <option value="High" {{ old('grade_group', $grade->grade_group) == 'High' ? 'selected' : '' }}>High School</option>
                            <option value="Senior" {{ old('grade_group', $grade->grade_group) == 'Senior' ? 'selected' : '' }}>Senior Secondary</option>
                        </select>
                        @error('grade_group')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="grade_color" class="form-label fw-semibold">
                            <i class="bi bi-palette-fill me-1"></i>Grade Color
                        </label>
                        <div class="input-group">
                            <input type="color" 
                                   name="grade_color" 
                                   id="grade_color" 
                                   class="form-control form-control-color" 
                                   value="{{ old('grade_color', $grade->grade_color ?? '#4e73df') }}"
                                   title="Choose grade color"
                                   style="min-width: 60px; height: 42px;">
                            <input type="text" 
                                   id="grade_color_text" 
                                   class="form-control" 
                                   value="{{ old('grade_color', $grade->grade_color ?? '#4e73df') }}"
                                   placeholder="#RRGGBB"
                                   pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                        </div>
                        <div class="form-text">Select a color to identify this grade</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="grade_order" class="form-label fw-semibold">Display Order</label>
                        <input type="number" 
                               name="grade_order" 
                               id="grade_order" 
                               class="form-control @error('grade_order') is-invalid @enderror" 
                               placeholder="e.g., 1, 2, 3"
                               value="{{ old('grade_order', $grade->grade_order) }}"
                               min="1">
                        @error('grade_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Order in which this grade appears in lists</div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-2"></i>Update Grade
                    </button>
                    <a href="{{ route('grades.add_subjects', $grade) }}" class="btn btn-success px-4">
                        <i class="bi bi-book me-2"></i>Manage Subjects
                    </a>
                    <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-x-lg me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Sync color picker with text input
    document.addEventListener('DOMContentLoaded', function() {
        const colorPicker = document.getElementById('grade_color');
        const colorText = document.getElementById('grade_color_text');
        
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });
        
        colorText.addEventListener('input', function() {
            if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(this.value)) {
                colorPicker.value = this.value;
            }
        });
    });
</script>
@endpush
