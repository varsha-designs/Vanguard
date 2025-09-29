@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow mt-6">
    <script src="https://cdn.tailwindcss.com"></script>
    <h2 class="text-2xl font-bold mb-4">Edit Faculty Schedule</h2>

    <form action="{{ route('faculty_schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2">Select Faculty</label>
        <select name="faculty_id" class="w-full border rounded p-2 mb-4">
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}" {{ $schedule->faculty_id == $faculty->id ? 'selected' : '' }}>
                    {{ $faculty->name }}
                </option>
            @endforeach
        </select>

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
            <option {{ $schedule->day == 'Monday' ? 'selected' : '' }}>Monday</option>
            <option {{ $schedule->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
            <option {{ $schedule->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
            <option {{ $schedule->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
            <option {{ $schedule->day == 'Friday' ? 'selected' : '' }}>Friday</option>
            <option {{ $schedule->day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
            <option {{ $schedule->day == 'Sunday' ? 'selected' : '' }}>Sunday</option>
        </select>

        <label class="block mb-2">Date</label>
        <input type="date" name="date" value="{{ $schedule->date }}" class="w-full border rounded p-2 mb-4">

        <label class="block mb-2">Time</label>
        <input type="text" name="time" value="{{ $schedule->time }}" class="w-full border rounded p-2 mb-4">

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Update
        </button>
    </form>
</div>
@endsection
