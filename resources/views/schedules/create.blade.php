@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Create Student Schedule</h2>
  <!-- Tailwind CSS via CDN -->
<script src="https://cdn.tailwindcss.com"></script>


    <form action="{{ route('schedules.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Student -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Select Student</label>
            <select name="studentid" class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-300">
                <option disabled selected>-- Choose Student --</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Day -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Day</label>
            <select name="day" class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-300">
                <option disabled selected>-- Select Day --</option>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <option value="{{ $day }}">{{ $day }}</option>
                @endforeach
            </select>
        </div>

        <!-- Date -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Date</label>
            <input type="date" name="date" class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-300">
        </div>

        <!-- Time -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Time</label>
            <input type="text" name="time" placeholder="e.g. 9-10 AM" class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-300">
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow">
                Save Schedule
            </button>
            <a href="{{ route('schedules.index') }}" class="text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection
