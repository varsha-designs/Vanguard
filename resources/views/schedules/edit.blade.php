@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-4">Edit Student Schedule</h2>
        <script src="https://cdn.tailwindcss.com"></script>

    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2">Select Student</label>
        <select name="studentid" class="w-full border rounded p-2 mb-4">
            @foreach($students as $student)
                <option value="{{ $student->id }}" {{ $schedule->studentid == $student->id ? 'selected' : '' }}>
                    {{ $student->full_name }}
                </option>
            @endforeach
        </select>

        <label class="block mb-2">Day</label>
        <select name="day" class="w-full border rounded p-2 mb-4">
            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>
                    {{ $day }}
                </option>
            @endforeach
        </select>

        <label class="block mb-2">Date</label>
        <input type="date" name="date" class="w-full border rounded p-2 mb-4" value="{{ $schedule->date }}">

        <label class="block mb-2">Time</label>
        <input type="text" name="time" placeholder="e.g. 9-10 AM" class="w-full border rounded p-2 mb-4" value="{{ $schedule->time }}">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('schedules.index') }}" class="ml-2 text-gray-600">Cancel</a>
    </form>
</div>
@endsection
