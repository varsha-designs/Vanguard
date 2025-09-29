@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Students</h1>
        <a href="{{ route('students.create') }}" class="btn btn-primary">New</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->full_name }}</td>
                        <td >{{ $student->email }}</td>
                     <td>
                        <a href="{{ route('students.documents', $student->id) }}" class="btn btn-info btn-sm">Doc</a>
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm" >Edit</a>
                     </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
