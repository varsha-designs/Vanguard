@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Add New Course</h1>

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" name="course_name" id="course_name"
                   class="form-control" value="{{ old('course_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="course_code" class="form-label">Course Code</label>
            <input type="text" name="course_code" id="course_code"
                   class="form-control" value="{{ old('course_code') }}" required>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select name="level" id="level" class="form-control" required>
                <option value="">-- Select Level --</option>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="section" class="form-label">Section</label>
            <input type="text" name="section" id="section"
                   class="form-control" value="{{ old('section') }}">
        </div>

        <div class="mb-3">
            <label for="concepts" class="form-label">Concepts</label>
            <textarea name="concepts" id="concepts" class="form-control" rows="3">{{ old('concepts') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="project" class="form-label">Project</label>
            <textarea name="project" id="project" class="form-control" rows="3">{{ old('project') }}</textarea>
        </div>

  <div class="mb-3">
        <label for="course_fee" class="form-label">Course Fee (₹)</label>
        <input type="number" name="course_fee" id="course_fee" class="form-control"
               value="{{ old('course_fee') }}" required>
    </div>

           <div class="mb-3">
    <label for="start_date" class="form-label">Start Date</label>
    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
</div>

<div class="mb-3">
    <label for="end_date" class="form-label">End Date</label>
    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}" required>
</div>




        <button type="submit" class="btn btn-primary">Save Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
