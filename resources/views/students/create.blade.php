@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="h3 mb-4">Create Student</h1>

    <!-- 🟢 IMPORTANT: enctype added for file uploads -->
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 🔹 Student Fields -->
        <div class="card mb-4">
            <div class="card-header">Personal Details</div>
            <div class="card-body">
                <div class="row g-3">
                 <div class="col-md-6">
                <label class="form-label">Student ID</label>
                <input type="text" class="form-control" value="{{ old('studentid', 'STU' . str_pad($student, 3, '0', STR_PAD_LEFT)) }}" readonly>
                </div>
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" class="form-control" maxlength="10" minlength="10">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔹 Education Details -->
        <div class="card mb-4">
            <div class="card-header">Education Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">College / University</label>
                        <input type="text" name="college" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Degree / Branch</label>
                        <input type="text" name="degree" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Year of Passing</label>
                        <input type="text" name="year_of_passing" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🔹 Professional Details -->
        <div class="card mb-4">
            <div class="card-header">Professional Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <input type="text" name="company" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <input type="text" name="role" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Years of Experience</label>
                        <input type="text" name="experience" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
    <div class="card-header">Course Selection</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">Select Courses</label>
                <select name="courses[]" class="form-control" multiple required>
                    @foreach($courses as $course)
                         <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->course_name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Hold CTRL (Windows) or Command (Mac) to select multiple courses.</small>
            </div>
        </div>
    </div>
</div>


        <!-- 🔹 Submit -->
        <button type="submit" class="btn btn-primary">Save Student</button>
    </form>
</div>



@endsection
