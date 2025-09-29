@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow mt-6">
    <h2 class="text-2xl font-bold mb-4">Create Faculty Schedule</h2>

    <form action="{{ route('faculty_schedules.store') }}" method="POST">
        @csrf

        <label class="block mb-2">Select Faculty</label>
        <select name="faculty_id" class="w-full border rounded p-2 mb-4">
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
            @endforeach
        </select>

        <label class="block mb-2">Select Student</label>
        <select name="studentid" class="w-full border rounded p-2 mb-4">
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
            @endforeach
        </select>

        <label class="block mb-2">Day</label>
        <select name="day" class="w-full border rounded p-2 mb-4">
            <option>Monday</option>
            <option>Tuesday</option>
            <option>Wednesday</option>
            <option>Thursday</option>
            <option>Friday</option>
            <option>Saturday</option>
            <option>Sunday</option>
        </select>

        <label class="block mb-2">Date</label>
        <input type="date" name="date" class="w-full border rounded p-2 mb-4">

        <label class="block mb-2">Time</label>
        <input type="text" name="time" placeholder="e.g. 9-10 AM" class="w-full border rounded p-2 mb-4">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save
        </button>
    </form>
</div>
@endsection
