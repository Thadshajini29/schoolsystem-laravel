@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Student</h1>
        <a href="{{ route('students.index') }}" class="btn btn-secondary shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="student_name" class="form-label fw-bold text-secondary">Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="student_name" id="student_name" class="form-control @error('student_name') is-invalid @enderror" value="{{ old('student_name') }}" required>
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="father_name" class="form-label fw-bold text-secondary">Father Name</label>
                        <input type="text" name="father_name" id="father_name" class="form-control @error('father_name') is-invalid @enderror" value="{{ old('father_name') }}">
                        @error('father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="admission_no" class="form-label fw-bold text-secondary">Admission No <span class="text-danger">*</span></label>
                        <input type="text" name="admission_no" id="admission_no" class="form-control @error('admission_no') is-invalid @enderror" value="{{ old('admission_no') }}" required>
                        @error('admission_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="grade_id" class="form-label fw-bold text-secondary">Grade <span class="text-danger">*</span></label>
                        <select name="grade_id" id="grade_id" class="form-select @error('grade_id') is-invalid @enderror" required>
                            <option value="">Select Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>{{ $grade->grade_name }}</option>
                            @endforeach
                        </select>
                        @error('grade_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nic_num" class="form-label fw-bold text-secondary">NIC Number</label>
                        <input type="text" name="nic_num" id="nic_num" class="form-control @error('nic_num') is-invalid @enderror" value="{{ old('nic_num') }}">
                        @error('nic_num')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label fw-bold text-secondary">Birth Date</label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-secondary d-block">
                            <i class="bi bi-gender-ambiguous me-2"></i>Gender
                        </label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="gender" id="genderMale" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }}>
                            <label class="btn btn-outline-info" for="genderMale">
                                <i class="bi bi-gender-male me-2"></i>Male
                            </label>
                            
                            <input type="radio" class="btn-check" name="gender" id="genderFemale" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                            <label class="btn btn-outline-danger" for="genderFemale">
                                <i class="bi bi-gender-female me-2"></i>Female
                            </label>
                            
                            <input type="radio" class="btn-check" name="gender" id="genderOther" value="" {{ old('gender') == '' ? 'checked' : '' }}>
                            <label class="btn btn-outline-secondary" for="genderOther">
                                <i class="bi bi-x-circle me-2"></i>Prefer not to say
                            </label>
                        </div>
                        @error('gender')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_no" class="form-label fw-bold text-secondary">Phone No</label>
                        <input type="text" name="phone_no" id="phone_no" class="form-control @error('phone_no') is-invalid @enderror" value="{{ old('phone_no') }}">
                        @error('phone_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label fw-bold text-secondary">Address</label>
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="image" class="form-label fw-bold text-secondary">
                        <i class="bi bi-image me-2"></i>Student Image
                    </label>
                    <input type="file" 
                           name="image" 
                           id="image" 
                           class="form-control @error('image') is-invalid @enderror" 
                           accept="image/*">
                    <small class="text-muted">Accepted formats: JPG, JPEG, PNG, GIF (Max: 2MB)</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <!-- Image preview will be inserted here by JavaScript -->
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-save me-2"></i>Save Student
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary shadow-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
