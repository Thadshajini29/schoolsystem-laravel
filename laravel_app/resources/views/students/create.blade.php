@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h2>Add Student</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" name="student_name" id="student_name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="father_name" class="form-label">Father Name</label>
                        <input type="text" name="father_name" id="father_name" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="admission_no" class="form-label">Admission No</label>
                        <input type="text" name="admission_no" id="admission_no" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="grade_id" class="form-label">Grade</label>
                        <select name="grade_id" id="grade_id" class="form-select" required>
                            <option value="">Select Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nic_num" class="form-label">NIC Number</label>
                        <input type="text" name="nic_num" id="nic_num" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" name="birth_date" id="birth_date" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_no" class="form-label">Phone No</label>
                        <input type="text" name="phone_no" id="phone_no" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Student Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
