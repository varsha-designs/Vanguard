@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-900 ">Daily Activities</h1>
    <a href="{{ route('daily_activities.create') }}" class="btn btn-primary mb-2">New</a>

    @if(session('success'))
        <div class="bg-green-300 border border-green-300 text-green-800 px-4 py-3 rounded-md mb-6 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('daily_activities.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow-md mb-6 inline-block transition duration-200">
       + Add Activity
    </a>

    <div class="overflow-x-auto rounded-lg shadow border border-gray-200">
        <table class="w-full table-auto text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm font-medium">
                <tr>
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Student</th>
                    <th class="p-3 border-b">Faculty</th>
                    <th class="p-3 border-b">Date</th>
                    <th class="p-3 border-b">In Time</th>
                    <th class="p-3 border-b">Out Time</th>
                    <th class="p-3 border-b">Hours Spent</th>
                    <th class="p-3 border-b">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach($activities as $activity)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="p-3 border-b">{{ $activity->id }}</td>
                        <td class="p-3 border-b">{{ $activity->student->full_name }}</td>
                        <td class="p-3 border-b">{{ $activity->faculty->name }}</td>
                        <td class="p-3 border-b">{{ $activity->date }}</td>
                        <td class="p-3 border-b">{{ $activity->in_time }}</td>
                        <td class="p-3 border-b">{{ $activity->out_time }}</td>
                        <td class="p-3 border-b font-medium">{{ $activity->hours_spent }}</td>
                        <td>
    <a href="{{ route('daily_activities.show', $activity) }}" class="btn btn-info btn-sm">View</a>
    <a href="{{ route('daily_activities.edit', $activity->id) }}" class="btn btn-warning btn-sm">Edit</a>
    <form action="{{ route('daily_activities.destroy', $activity->id) }}" method="POST" style="display:inline"
          onsubmit="return confirm('Are you sure you want to delete this activity?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">Delete</button>
    </form>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
