@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Course Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $course->course_name }} ({{ $course->course_code }})</h3>
            <p><strong>Level:</strong> {{ ucfirst($course->level) }}</p>
            <p><strong>Section:</strong> {{ $course->section ?? 'N/A' }}</p>
            <p><strong>Concepts:</strong></p>
            <p>{{ $course->concepts ?? 'N/A' }}</p>
            <p><strong>Projects:</strong></p>
            <p>{{ $course->project ?? 'N/A' }}</p>
            <p><strong>Course Fee:</strong></p>
            <p>{{ $course->course_fee ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
