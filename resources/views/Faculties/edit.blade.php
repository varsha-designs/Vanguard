@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Faculty</h2>
    <form action="{{ route('faculties.update', $faculty) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Faculty ID</label>
            <input type="text" name="faculty_id" class="form-control" value="{{ $faculty->faculty_id }}" required>
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $faculty->name }}" required>
        </div>
        <div class="mb-3">
            <label>Email ID</label>
            <input type="email" name="email_id" class="form-control" value="{{ $faculty->email_id }}" required>
        </div>
        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ $faculty->phone_number }}" required>
        </div>
        <div class="mb-3">
            <label>Father's Name</label>
            <input type="text" name="father_name" class="form-control" value="{{ $faculty->father_name }}" required>
        </div>
        <div class="mb-3">
            <label>Mother's Name</label>
            <input type="text" name="mother_name" class="form-control" value="{{ $faculty->mother_name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('faculties.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
s
