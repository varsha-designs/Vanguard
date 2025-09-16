@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Edit Course</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" name="course_name" class="form-control" value="{{ old('course_name', $course->course_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="course_code" class="form-label">Course Code</label>
            <input type="text" name="course_code" class="form-control" value="{{ old('course_code', $course->course_code) }}" required>
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select name="level" class="form-control" required>
                <option value="beginner" {{ $course->level == 'beginner' ? 'selected' : '' }}>Beginner</option>
                <option value="intermediate" {{ $course->level == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="advanced" {{ $course->level == 'advanced' ? 'selected' : '' }}>Advanced</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="section" class="form-label">Section</label>
            <input type="text" name="section" class="form-control" value="{{ old('section', $course->section) }}">
        </div>

        <div class="mb-3">
            <label for="concepts" class="form-label">Concepts</label>
            <textarea name="concepts" class="form-control">{{ old('concepts', $course->concepts) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="projects" class="form-label">Projects</label>
            <textarea name="projects" class="form-control">{{ old('projects', $course->project ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Course</button>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
