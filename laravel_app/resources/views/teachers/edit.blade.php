@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="bi bi-pencil-fill me-2 text-primary"></i>Edit Teacher
            </h1>
            <p class="text-muted small mb-0">Update faculty record</p>
        </div>
        
        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 fade-in">
                <div class="card-header py-3 bg-white border-bottom">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-person-lines-fill me-2"></i>Teacher Information
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('teachers.update', $teacher) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name" value="{{ old('name', $teacher->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@example.com" value="{{ old('email', $teacher->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+1234567890" value="{{ old('phone', $teacher->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold">Profile Image</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" onchange="setupImagePreview('image', 'imagePreview')">
                            <div id="imagePreview" class="mt-2 text-center">
                                @if($teacher->image_path)
                                    <img src="{{ asset('storage/' . $teacher->image_path) }}" alt="Current Profile" class="img-thumbnail" style="max-height: 150px;">
                                    <p class="small text-muted mt-1">Current Image</p>
                                @endif
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="bi bi-check-lg me-2"></i>Update Teacher
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
