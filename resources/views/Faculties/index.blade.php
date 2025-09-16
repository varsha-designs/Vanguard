@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Faculty List</h2>

    <a href="{{ route('faculties.create') }}" class="btn btn-primary">Add Faculty</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Faculty ID</th>
                <th>Name</th>
                <th>Email ID</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($faculties as $faculty)
                <tr>
                    <td>{{ $faculty->id }}</td>
                    <td>{{ $faculty->faculty_id }}</td>
                    <td>{{ $faculty->name }}</td>
                    <td>{{ $faculty->email_id }}</td>
                    <td>{{ $faculty->phone_number }}</td>
                    <td>
                        <a href="{{ route('faculties.show', $faculty) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('faculties.edit', $faculty) }}" class="btn btn-warning btn-sm" >Edit</a>
                        <form action="{{ route('faculties.destroy', $faculty) }}" method="POST" style="display:inline"  onsubmit="return confirm('Are you sure you want to delete this faculty?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
