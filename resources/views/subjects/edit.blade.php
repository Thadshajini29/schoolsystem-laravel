@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-pencil-square me-2 text-primary"></i>Edit Subject
            </h1>
            <p class="text-muted small mb-0">Update subject: <strong>{{ $subject->subject_name }}</strong></p>
        </div>
        <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Subjects
        </a>
    </div>

    <div class="card shadow border-0 fade-in">
        <div class="card-header py-3 bg-white border-bottom">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-book-fill me-2"></i>Subject Information
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

            <form action="{{ route('subjects.update', $subject) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="subject_name" class="form-label fw-semibold">
                            Subject Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="subject_name" 
                               id="subject_name" 
                               class="form-control @error('subject_name') is-invalid @enderror" 
                               placeholder="e.g., Mathematics, English, Science"
                               value="{{ old('subject_name', $subject->subject_name) }}"
                               required>
                        @error('subject_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="subject_index" class="form-label fw-semibold">Subject Index/Code</label>
                        <input type="text" 
                               name="subject_index" 
                               id="subject_index" 
                               class="form-control @error('subject_index') is-invalid @enderror" 
                               placeholder="e.g., MATH, ENG, SCI"
                               value="{{ old('subject_index', $subject->subject_index) }}">
                        @error('subject_index')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Short code to identify this subject</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="subject_number" class="form-label fw-semibold">Subject Number</label>
                        <input type="text" 
                               name="subject_number" 
                               id="subject_number" 
                               class="form-control @error('subject_number') is-invalid @enderror" 
                               placeholder="e.g., SUB001, SUB002"
                               value="{{ old('subject_number', $subject->subject_number) }}">
                        @error('subject_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Unique identifier number for this subject</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="subject_order" class="form-label fw-semibold">Display Order</label>
                        <input type="number" 
                               name="subject_order" 
                               id="subject_order" 
                               class="form-control @error('subject_order') is-invalid @enderror" 
                               placeholder="e.g., 1, 2, 3"
                               value="{{ old('subject_order', $subject->subject_order) }}"
                               min="1">
                        @error('subject_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Order in which this subject appears in lists</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="subject_color" class="form-label fw-semibold">
                            <i class="bi bi-palette-fill me-1"></i>Subject Color
                        </label>
                        <div class="input-group">
                            <input type="color" 
                                   name="subject_color" 
                                   id="subject_color" 
                                   class="form-control form-control-color" 
                                   value="{{ old('subject_color', $subject->subject_color ?? '#667eea') }}"
                                   title="Choose subject color"
                                   style="min-width: 60px; height: 42px;">
                            <input type="text" 
                                   id="subject_color_text" 
                                   class="form-control" 
                                   value="{{ old('subject_color', $subject->subject_color ?? '#667eea') }}"
                                   placeholder="#RRGGBB"
                                   pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                        </div>
                        <div class="form-text">Select a color to identify this subject</div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-2"></i>Update Subject
                    </button>
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary px-4">
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
        const colorPicker = document.getElementById('subject_color');
        const colorText = document.getElementById('subject_color_text');
        
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
