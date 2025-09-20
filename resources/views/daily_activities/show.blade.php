@extends('layouts.app')

@section('content')
<div class="container my-10">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-blue-500 to-indigo-600">
            <h2 class="text-2xl font-bold text-white">Activity Details</h2>
        </div>

        <!-- Content -->
        <ul class="divide-y divide-gray-200">
            <li class="px-6 py-4 flex justify-between">
                <strong>Student:</strong>
                <span>{{ $dailyActivity->student->full_name ?? $dailyActivity->student_id ?? 'N/A' }}</span>
            </li>

             <li class="px-6 py-4 flex justify-between">
               <strong>Courses:</strong>
                <span> {{ optional(optional($dailyActivity->student)->courses)->pluck('course_name')->join(', ') ?? 'N/A' }} </span>

            </li>

            <li class="px-6 py-4 flex justify-between">
                <strong>Faculty:</strong>
                <span>{{ $dailyActivity->faculty->name ?? $dailyActivity->faculty_id ?? 'N/A' }}</span>
            </li>

            <li class="px-6 py-4 flex justify-between">
                <strong>Date:</strong>
                <span>{{ $dailyActivity->date }}</span>
            </li>

            <li class="px-6 py-4 flex justify-between">
                <strong>In Time:</strong>
                <span>{{ $dailyActivity->in_time }}</span>
            </li>

            <li class="px-6 py-4 flex justify-between">
                <strong>Out Time:</strong>
                <span>{{ $dailyActivity->out_time }}</span>
            </li>

            <li class="px-6 py-4 flex justify-between">
                <strong>Hours Spent:</strong>
                <span>{{ $dailyActivity->hours_spent ?? '0' }}</span>
            </li>

            <li class="px-6 py-4">
                <strong>Activities:</strong>
                <ul class="list-disc list-inside text-gray-700 mt-2">
                    @foreach(json_decode($dailyActivity->activities, true) ?? [] as $act)
                        <li>{{ $act }}</li>
                    @endforeach
                </ul>
            </li>

            <li class="px-6 py-4">
                <strong>Existing Images:</strong>
                <div class="mt-3 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($dailyActivity->images as $image)
                        <div class="w-full h-40 border rounded-lg bg-gray-50 p-2 flex items-center justify-center overflow-hidden hover:scale-105 transition">
                            <img src="{{ $image->signed_url }}"
                                 class="max-h-full max-w-full object-contain"
                                 alt="Activity Image">
                        </div>
                    @empty
                        <p class="text-gray-500">No images uploaded.</p>
                    @endforelse
                </div>
            </li>
        </ul>

        <!-- Footer -->
        <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50">
            <a href="{{ route('daily_activities.index') }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow-sm transition">
               Back
            </a>
            <a href="{{ route('daily_activities.edit', $dailyActivity->id) }}"
               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg shadow-sm transition">
               Edit
            </a>
        </div>
    </div>
</div>
<script src="https://cdn.tailwindcss.com"></script>

@endsection
