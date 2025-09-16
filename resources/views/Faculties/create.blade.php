@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Faculty</h2>
    <form action="{{ route('faculties.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Faculty ID</label>
            <input type="text" name="faculty_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email ID</label>
            <input type="email" name="email_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Father's Name</label>
            <input type="text" name="father_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mother's Name</label>
            <input type="text" name="mother_name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection

