@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-2xl font-bold text-center">Faculty Daily Activities</h2>

    <div class="mb-3 text-end">
        <a href="{{ route('faculty_activities.create') }}" class="btn btn-success btn-sm">Add New Activity</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>Faculty Name</th>
                <th>Date</th>
                <th>In-Time</th>
                 <th>Out-Time</th>
                  <th>Hours Spend</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $activity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $activity->faculty->name }}</td>
                    <td>{{ $activity->date->format('d-m-Y') }}</td>
                    <td>{{ $activity->in_time }}</td>
                    <td>{{ $activity->out_time }}</td>
                     <td>{{ $activity->hours_spend}}hrs</td>


                    <td>
                        <a href="{{ route('faculty_activities.edit', $activity->id) }}" class="btn btn-primary btn-sm">Edit</a>
                       <a href="{{ route('faculty_activities.show', $activity->id) }}" class="btn btn-primary btn-sm">Show</a>
                        <form action="{{ route('faculty_activities.destroy', $activity->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure to delete this activity?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No activities found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
