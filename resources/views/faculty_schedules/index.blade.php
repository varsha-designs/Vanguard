@extends('layouts.app')

@section('content')
<div class="container mx-auto bg-white p-6 rounded shadow">
    <script src="https://cdn.tailwindcss.com"></script>
    <h2 class="text-2xl font-bold mb-4">Faculty Schedules</h2>

    <a href="{{ route('faculty_schedules.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-blue-700">
       + Add Schedule
    </a>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Faculty</th>
                <th class="border px-4 py-2">Student</th>
                <th class="border px-4 py-2">Day</th>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Time</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td class="border px-4 py-2">{{ $schedule->faculty->name }}</td>
                <td class="border px-4 py-2">{{ $schedule->student->full_name }}</td>
                <td class="border px-4 py-2">{{ $schedule->day }}</td>
                <td class="border px-4 py-2">{{ $schedule->date }}</td>
                <td class="border px-4 py-2">{{ $schedule->time }}</td>
                <td class="border px-4 py-2 flex gap-2">
                    <!-- Edit button -->
                    <a href="{{ route('faculty_schedules.edit', $schedule->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                        Edit
                    </a>

                    <!-- Delete button -->
                    <form action="{{ route('faculty_schedules.destroy', $schedule->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
