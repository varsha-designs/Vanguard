@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Edit Student</h1>
    @if($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif


    <form id="editStudentForm"action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 1. Personal Details -->
        <div class="card mb-4">
            <div class="card-header">Personal Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $student->whatsapp_number) }}" class="form-control" maxlength="10" minlength="10">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob', $student->dob) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $student->address) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Education Details -->
        <div class="card mb-4">
            <div class="card-header">Education Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">College / University</label>
                        <input type="text" name="college" value="{{ old('college', $student->college) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Degree / Branch</label>
                        <input type="text" name="degree" value="{{ old('degree', $student->degree) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Year of Passing</label>
                        <input type="text" name="year_of_passing" value="{{ old('year_of_passing', $student->year_of_passing) }}" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Professional Details -->
    <div class="card mb-4">
         <div class="card-header">Professional Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <input type="text" name="company" value="{{ old('company', $student->company) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <input type="text" name="role" value="{{ old('role', $student->role) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Years of Experience</label>
                        <input type="text" name="experience" value="{{ old('experience', $student->experience) }}" class="form-control" required>
                    </div>
                </div>
            </div>
         </div>


                    <!-- 4. Course Selection -->
    <div class="card mb-4">
    <div class="card-header">Course Selection</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Select Course(s)</label>
                <select name="courses[]" class="form-control" multiple required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ in_array($course->id, old('courses', $student->courses->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $course->course_code }} - {{ $course->course_name }}
                        </option>
                    @endforeach
                </select>
                <small class="text-muted">Hold CTRL (Windows) or CMD (Mac) to select multiple courses.</small>

                </div>
            </div>
        </div>
        <div class="col-md-6">
                <label class="form-label">Already Enrolled Courses</label>
                <input type="text" class="form-control"
                       value="{{ $student->courses->pluck('course_name')->implode(', ') }}"
                       readonly>
                <small class="text-muted">This shows the courses the student is currently enrolled in.</small>
            </div>
    </div>
            <div class="mb-5">
        <button type="submit" class="btn btn-primary ml-2">Update Student</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
    </form>
</div>
@endsection
