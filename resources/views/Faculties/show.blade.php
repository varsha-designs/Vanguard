@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Faculty Details</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Faculty ID:</strong> {{ $faculty->faculty_id }}</li>
        <li class="list-group-item"><strong>Name:</strong> {{ $faculty->name }}</li>
        <li class="list-group-item"><strong>Email ID:</strong> {{ $faculty->email_id }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $faculty->phone_number }}</li>
        <li class="list-group-item"><strong>Father's Name:</strong> {{ $faculty->father_name }}</li>
        <li class="list-group-item"><strong>Mother's Name:</strong> {{ $faculty->mother_name }}</li>
    </ul>

    <div class="mt-3">
        <a href="{{ route('faculties.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection
