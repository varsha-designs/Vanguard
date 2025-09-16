@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Courses</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('courses.create') }}" class="btn btn-primary">+ Add New Course</a>
    </div>

    @if($courses->count())
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Course Code</th>
                    <th>Level</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ ucfirst($course->level) }}</td>
                    <td>{{ $course->section ?? '-' }}</td>
                    <td>
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No courses found. Please add one.</p>
    @endif
</div>
@endsection
